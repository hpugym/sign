<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/14
 * Time: 11:44
 */
namespace App\Http\Controllers;


use App\Qrcode;
use App\Sign;
use App\Teachs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignController extends Controller{

    /**
     * 发布新的签到
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signPublish(Request $request){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        $teachs_code = $_GET['teachs_code'];
        $course_name = $_GET['course_name'];

        //查询该课程下是否存在学生
        $num = DB::table('mycourses')->where("teachs_code", "=", $teachs_code)->count();
        if($num == 0){
            echo "<script>alert('该课程下没有学生，无法签到'); window.history.back(-1);</script>";
        }else{
            return view("sign/publish",[
                "course_name" => $course_name,
                "teachs_code" => $teachs_code
            ]);
        }
    }

    /**
     * 签到列表
     * @param Request $request
     * @param $teachs_code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signPublished(Request $request,$teachs_code){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        $list = Qrcode::where("teachs_code", '=', $teachs_code)
            ->select("qrcode_code","qrcode_lon","qrcode_lat","qrcode_add","qrcode_time")
            ->orderBy("qrcode_time","desc")
            ->Paginate(20);

        $page = Qrcode::pageAction($list, 7, $request->getUri());
        return view("sign/published",[
            'signlist'=>$list,
            'paging'=>$page,
            'teachs_code' =>$teachs_code,
            'count'=> 1,
        ]);
    }

    /**
     * q签到详情列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signListDetail(Request $request){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        $qrcode_code = $_GET['qrcode_code'];
        if(empty($qrcode_code)){
            header('Refresh:0;url='.url("signmanager/courselist/pushed"));
        }else{
            $list = Sign::where('qrcode_code', '=', $qrcode_code)
                ->join('students','students.stu_openid','=','signs.stu_openid')
                ->select("signs.qrcode_code","students.stu_num","students.stu_name","students.stu_openid","signs.signs_status","signs.qrcode_time","signs.signs_time")
                ->Paginate(20);
            //dd($list);
            $page = Sign::pageAction($list, 7, $request->getUri());
        }

        return view("sign/signlist",[
            'details'=>$list,
            'paging'=>$page,
            'qrcode_code' => $qrcode_code,
            'count'=> 1,
        ]);
    }

    /**
     * 更新考勤状态
     * @param Request $request
     * @return string
     */
    public function signListDetailUpdateAction(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
            //exit(0);
        }

        if($request->isMethod("POST") && !empty($_POST)){
            //dd($_POST);
            $stu_openid = $_POST['stu_openid'];
            $qrcode_code = $_POST['qrcode_code'];
            $signs_status = $_POST['signs_status'];

            $num = DB::table("signs")->whereRaw("stu_openid = ? and qrcode_code = ?", [$stu_openid, $qrcode_code])
                ->update([
                    "signs_status" => $signs_status,
                    "signs_time" => time()
                ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//修改失败
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
        }
    }

    /**获取教师的地理位置，及签到的学生列表
     * @param Request $request
     * @return string
     */
    public function signGetStudent(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
            //exit(0);
        }
        if($request->isMethod("POST")){
            $sign_classRoom = $_POST['sign_classRoom'];
            $teachs_code = $_POST['teachs_code'];

            $res = DB::table("locals")->where('local_id', '=', $sign_classRoom)->first();
            if(empty($res)){
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//未查询到该教室的经纬度
            }else{
                $local_lon = $res->local_lon;//经度
                $local_lat = $res->local_lat;//纬度

                $students = DB::table("mycourses")->where('teachs_code', '=', $teachs_code)
                    ->select("stu_openid")
                    ->get();
                if(empty($students)){
                    return json_encode(array("code"=>"0003"),JSON_UNESCAPED_UNICODE);//未查询到学生的信息
                }else{
                    return json_encode(array("code" => "0000", "local_lon" => $local_lon, "local_lat" => $local_lat, "students" => $students),JSON_UNESCAPED_UNICODE);
                }
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
        }
    }

    /**
     * 二维码的请求
     * @param Request $request
     * @return string
     */
    public function signGetCode(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
            //exit(0);
        }
        if($request->isMethod("POST")){
            $teachs_code = $_POST['teachs_code'];
            $sign_time = $_POST['sign_time'];//二维码失效时间
            $qrcode_add = $_POST['sign_classRoom'];//签到教室
            $qrcode_lon = $_POST['local_lon'];//教室的经度
            $qrcode_lat = $_POST['local_lat'];//教师的纬度
            $access_token = @$this->getAccess_token();
            if(empty($access_token)){
                return json_encode(array("code"=>"0005"),JSON_UNESCAPED_UNICODE);//二维码请求失败
            }
            //echo $access_token;
            $ticket_url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
            $data = array(
                "expire_seconds" => $sign_time,
                "action_name" => "QR_SCENE",
                "action_info" => array(
                    "scene" =>array(
                        "scene_id" => $teachs_code
                    )
                )
            );
            $res = json_decode($this->curl_post($ticket_url,json_encode($data,JSON_UNESCAPED_UNICODE)));
            //var_dump($res);
            if(!empty($res)){
                $ticket = urlencode(@$res->ticket);
                if(!empty($ticket)){
                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
                    $qrcode_time = time();
                    $qrcode_code = md5($teachs_code.$qrcode_time);
                    $teachs_code = $teachs_code;

                    $num = DB::table("qrcode")->insert([
                        "qrcode_code" => $qrcode_code,
                        "teachs_code" => $teachs_code,
                        "qrcode_lon" => $qrcode_lon,
                        "qrcode_lat" => $qrcode_lat,
                        "teach_id" => session()->get("teach_id"),
                        "qrcode_add" => $qrcode_add,
                        "qrcode_time" =>$qrcode_time,
                        "qrcode_end_time" => $qrcode_time+ $sign_time,
                    ]);
                    $endtime_str = $sign_time+$qrcode_time+60;
                    $endtime = date("H:i:s",($sign_time+$qrcode_time+60))."可关闭";
                    if($num > 0){
                        return json_encode(array("code"=>"0000", "imgUrl" => $url,"qrcode_code" => $qrcode_code, "actionTime" => $qrcode_time, "end_time"=>$endtime, "endtime_str" => $endtime_str),JSON_UNESCAPED_UNICODE);
                    }else{
                        return json_encode(array("code"=>"0003"),JSON_UNESCAPED_UNICODE);//二维码数据保存失败
                    }
                }else{
                    return json_encode(array("code"=>"0004"),JSON_UNESCAPED_UNICODE);//二维码ticket获取失败
                }

                //echo "<img src='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket."'>";
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//二维码请求失败
            }

        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
        }
    }

    /**
     * 对要签到的学生进行统一缺勤处理
     * @param Request $request
     * @return string
     */
    public function signDeal(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
            //exit(0);
        }

        if($request->isMethod("POST")){
            $students = $_POST['students'];
            //dd($students);
            $qrcode_code = $_POST['qrcode_code'];
            $teachs_code = $_POST['teachs_code'];
            $actionTime = $_POST['actionTime'];
            foreach ($students as $student){
                $num = DB::table("signs")->whereRaw('qrcode_code = ? and stu_openid = ?',[$qrcode_code,$student['stu_openid']])->count();
                if($num == 0){
                    $res = DB::table("signs")->insert([
                        "stu_openid" => $student['stu_openid'],
                        "teachs_code" => $teachs_code,
                        "qrcode_code" => $qrcode_code,
                        "signs_status" => "缺勤",
                        "qrcode_time" => $actionTime,
                        "signs_time" => $actionTime
                    ]);

                    if($res == 0){
                        return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//数据处理中出现错误
                    }
                }
            }
            return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
        }
    }

    /**
     * 放大展示二维码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ShowCode(){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        $url = $_GET['url'];
        return view("sign/QrCode",['url'=> $url]);
    }
    public function signShowCode($teachs_code){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        $students = DB::table("mycourses")->where('teachs_code', '=', $teachs_code)
            ->select('stu_openid')
            ->get();
        if(empty($students)){
            echo "<script>alert('未查询到学生列表，窗口即将关闭');window.open('','_parent','');window.close();</script>>";
        }else{
            //获取微信二维码

            $access_token = @$this->getAccess_token();
//            dd($access_token);
            $ticket_url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
            $data = array(
                "expire_seconds" => 604800,
                "action_name" => "QR_SCENE",
                "action_info" => array(
                    "scene" =>array(
                        "scene_id" => $teachs_code
                    )
                )
            );

            $res = json_decode($this->curl_post($ticket_url,json_encode($data,JSON_UNESCAPED_UNICODE)));
            //dd($res);
            $ticket = urlencode(@$res->ticket);

            echo "<img src='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket."'>";
        }
    }

    /**
     * 根据action的参数变化，展示发布签到的课程列表和查看签到的课程列表
     * @param Request $request
     * @param $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signCourseList(Request $request, $action){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        //发布签到课程列表 action = push
        if($action == "push"){
            //剔除已经结课的课程
            $list = Teachs::whereRaw('teach_id = ? and teachs_status = ?',[session()->get("teach_id"), 0])
                ->join('courses', 'courses.course_num', '=', 'teachs.course_num')
                ->select('courses.course_num', 'courses.course_name', 'courses.course_type', 'teachs.teachs_time', 'teachs.teachs_grade', 'teachs.teachs_avai', 'teachs.teachs_stu','teachs.teachs_status','teachs.teachs_code')
                ->Paginate(15);
            $page = Teachs::pageAction($list, 7, $request->getUri());
            //dd($list);
            return view("sign/courselist-push",[
                'courses'=>$list,
                'paging'=>$page,
                'count'=> 1
            ]);
        }

        //查看签到课程列表 action =  pushed
        else{
            $list = Teachs::where('teach_id', '=', session()->get("teach_id"))
                ->join('courses', 'courses.course_num', '=', 'teachs.course_num')
                ->select('courses.course_num', 'courses.course_name', 'courses.course_type', 'teachs.teachs_time', 'teachs.teachs_grade', 'teachs.teachs_avai', 'teachs.teachs_stu','teachs.teachs_status','teachs.teachs_code')
                ->Paginate(15);
            $page = Teachs::pageAction($list, 7, $request->getUri());
            //dd($list);
            return view("sign/courselist-pushed",[
                'courses'=>$list,
                'paging'=>$page,
                'count'=> 1
            ]);

        }
    }


    /**
     * 获取access_token
     * @return mixed
     */
    private function getAccess_token(){
//        $info = DB::table('token')->where('name', '=', 'access_token')->first();
        $info = @json_decode(file_get_contents("./data/access_token.json"),true);

//        dd($info);
        if(empty($info)){
            echo "<script>alert('access_token加载失败，窗口即将关闭！');window.open('','_parent','');window.close();</script>";
        }else{
            if($info->expires_in < time()){//如果access_token过期的话，重新获取
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxafa5f3c55b3a7617&secret=bbde89d0d696cee2fb01e3054d1d7ee8";
                $res = json_decode($this->curl_get($url));//发送get请求
                //dd($res);
                $access_token = @$res->access_token;

                if ($access_token) {
                    @$info->expires_in = time() + 7000;
                    @$info->access_token = $access_token;
                    $fp = fopen("./data/access_token.json", "w");
                    fwrite($fp, json_encode($info));
                    fclose($fp);
                }
//                $expires_in = 7000 + time() ;
//
//                $num = DB::table("token")->where('name', '=', 'access_token')->update([
//                    "access_token" => $access_token,
//                    "expires_in" => $expires_in
//                ]);
//
//                if($num == 0){
//                    echo "<script>alert('access_token更新失败，窗口即将关闭！');window.open('','_parent','');window.close();</script>>";
//                }else{
//                    return $access_token;
//                }
            }else{
                $access_token = $info->access_token;
            }
            return $access_token;
        }
    }

    /**
     * 发送post请求
     * @param $url
     * @param $data
     * @return mixed
     */
    private function curl_post($url,$data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);//使用post传送
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//post传送数据
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//这是最大持续时间
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//一字符串形式返回数据，不直接输出
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            var_dump(curl_error($curl));
        }
        curl_close($curl);
        return $result;
    }

    /**
     * 发送get请求
     * @param $url
     * @return mixed
     */
    private function curl_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
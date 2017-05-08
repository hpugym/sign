<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/8
 * Time: 18:49
 */
namespace App\Http\Controllers;
use App\Message;
use App\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalController extends Controller{
    /**
     * 个人中心->我的资料
     *
     */
    public function info(){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            exit(0);
        }

        $person = Person::find("101100000");
        $user = DB::table("users")->where('user_id','=','100000')->first();
        //dd($person);
        //dd($user);
        return view("personal/info",[
            "personinfo" => $person,
            "userinfo" => $user
        ]);
    }

    public function infoEdit(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//加载失败
            //exit(0);
        }

        if($request->isMethod("POST")){
//            dd($_POST);
            $person = Person::find("101100000");

            $person->teach_college = $_POST['teach_college']== "" ? " " : $_POST['teach_college'];
            $person->teach_depart  = $_POST['teach_depart'] == "" ? " " : $_POST['teach_depart'];
            $person->teach_phone   = $_POST['teach_phone'] == "" ? " " : $_POST['teach_phone'];
            $person->teach_add     = $_POST['teach_add'] == "" ? " " : $_POST['teach_add'];
            $bool = $person->save();
            if($bool){
                $code = "0000";
            }else{
                $code = "0002";
            }
        }else{
            $code = "0001";
        }
        return json_encode(array("code"=> $code ,"teach_phone"=>$_POST['teach_phone'], "teach_college"=>$_POST['teach_college'],"teach_depart"=>$_POST['teach_depart'],"teach_add"=>$_POST['teach_add']),JSON_UNESCAPED_UNICODE);
    }

    /**
     * 个人中心->密码修改
     */
    public function edit(){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            exit(0);
        }

        return view("personal/passedit");

    }

    /**
     *  密码修改处理
     */
    public function infoPass(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0004"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $user_id = session()->get("user_id");
            $oldPass = trim($_POST['oldPass']);
            $newPassA = trim($_POST['newPassA']);
            $newPassB = trim($_POST['newPassB']);
            if($newPassA == $newPassB){
                $userinfo = DB::table("users")->where("user_id", "=", $user_id)->first();
                if($userinfo->user_pass == md5($oldPass)){
                    $num = DB::table("users")->where("user_id", "=", $user_id)->update([
                        "user_pass" => md5($newPassA)
                    ]);
                    if($num > 0 ){
                        $code = "0000";//密码修改成功
                        return json_encode(array("code"=>$code),JSON_UNESCAPED_UNICODE);
                    }else{
                        $code = "0003";//密码修改失败
                        return json_encode(array("code"=>$code),JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    $code = "0002";//原来的密码错误
                    return json_encode(array("code"=>$code),JSON_UNESCAPED_UNICODE);
                }

            }else{
                $code = "0001";//两次密码不一致
                return json_encode(array("code"=>$code),JSON_UNESCAPED_UNICODE);
            }
        }else{
            $code = "0004";//加载失败
            return json_encode(array("code"=>$code),JSON_UNESCAPED_UNICODE);
        }
    }
    /**
     * 个人中心->消息中心
     */
    public function message(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0004"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }

        $message = new Message();
        $list = $message->where("message_to", "=", session()->get("user_id"))->orderBy('message_time','desc')->Paginate(5);
        $page = $message->pageAction($list, 7, $request->getUri());
        return view("personal/message",[
            'messages'=>$list,
            'paging'=>$page
        ]);
    }

    /**检查并获取新消息的条目数
     * @param Request $request
     * @return string
     */
    public function getMessageCount(Request $request){
        //全局的身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            if($_POST['username'] == session()->get("user_id")){
                //进行消息检查
                $user_id = session()->get("user_id");
                $messageNum = DB::table("messages")->whereRaw('message_to = ? and message_status = ?',[$user_id, 1])->count();
                return json_encode(array("code"=>"0000", "messageCount"=> $messageNum),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
        }
    }

    public function dealMessageStatus(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $message_id = $_POST['message_id'];

            $num = DB::table("messages")->where("message_id", "=", $message_id)->update([
                "message_status" => 0
            ]);
            if($num > 0){
                //进行消息检查
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
        }
    }
}
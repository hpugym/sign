<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/12
 * Time: 9:42
 */

namespace App\Http\Controllers;


use App\Tc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller{

    /**
     * 非管理员状态   课程列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function courseList(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }

        $nowPage = empty(@$_GET['page'])? 1 : @$_GET['page'];
        $pageSize = 10;

        $num = DB::table('tc')->groupBy("tc_teach_id")->where("tc_teach_id", "=", session()->get("teach_id"))->count();
        //dd($num);
        $nextOffset = ($nowPage) * $pageSize;
        $offset = ($nowPage-1) * $pageSize;
        if($nowPage == 1){
            $prevUrl = "javasctipt:void(0)";
            if($nextOffset >= $num) {
                $nextUrl = "javasctipt:void(0)";
            }else{
                $nextUrl = url("course/list?page=").($nowPage+1);
            }
        }else{
            $prevUrl = url("course/list?page=").($nowPage-1);
            if($nextOffset >= $num) {
                $nextUrl = "javasctipt:void(0)";
            }else{
                $nextUrl = url("course/list?page=").($nowPage+1);
            }
        }
        $course = DB::table("tc")->where("tc_teach_id", "=", session()->get("teach_id"))->skip($offset)->take($pageSize)->get();
        //dd($course);


        return view("course/list",[
            'courses'=>$course,
            'prev'=>$prevUrl,
            'next'=>$nextUrl
        ]);
    }

    /**
     * 非管理员状态 课程编辑
     * @param $id
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function courseEdit($id,$name){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }

        $teachs = DB::table('teachs')->where('teachs_code', '=', $id)->first();
        if(empty($teachs)){
            echo "<script>alert('查询未果'); window.history.back(-1);<script>";
        }else{
            return view("course/edit",[
                'teachs' => $teachs,
                'id'=>$id,
                'name'=>$name
            ]);
        }



    }

    /** 非管理员状态 新增课程
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function courseAdd(){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        return view("course/add");
    }

    /**非管理员状态 课程编辑请求
     * @param Request $request
     * @return string
     */
    public function courseEditAction(Request $request){
        //非管理员状态 身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $num = DB::table("teachs")->where('teachs_code', '=', $_POST['teachs_code'])->update([
                "teachs_time"   => $_POST['teachs_time'],
                "teachs_grade"  =>$_POST['teachs_grade'],
                "teachs_stu"    =>$_POST['teachs_stu'],
                "teachs_avai"   =>$_POST['teachs_avai'],
                "teachs_add"    =>$_POST['teachs_add'],
                "teachs_status" => $_POST['teachs_status']
            ]);

            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);//修改成功
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//修改失败
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求失败
        }
    }

    /**
     * 非管理员状态 课程删除请求
     * @param Request $request
     * @return string
     */
    public function courseDelAction(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求失败
            //exit(0);
        }
        if($request->isMethod("POST")){
            $num = DB::table("teachs")->where('teachs_code', '=', $_POST['teachs_code'])->delete();
            if($num >0 ){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);//删除成功
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//删除失败
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求失败
        }
    }

    /**
     * 课程添加请求
     * @param Request $request
     * @return string
     */
    public function courseAddAction(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求失败
            //exit(0);
        }
        if($request->isMethod("post")){
            //dd($_POST);
            $num = DB::table('teachs')->insert([
                "course_num" => trim($_POST['course_num']),
                "teach_id" => trim($_POST['teach_id']),
                "teachs_time" => trim($_POST['teachs_time']),
                "teachs_grade" => trim($_POST['teachs_grade']),
                "teachs_stu" => trim($_POST['teachs_stu']),
                "teachs_avai" => trim($_POST['teachs_avai']),
                "teachs_add" => trim($_POST['teachs_add']),
                "teachs_status" => trim($_POST['teachs_status'])
            ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);//添加成功
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//添加失败
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求失败
        }
    }

    /**
     * 课程添加时的检查
     * @param Request $request
     * @return string
     */
    public function courseAddCheck(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }
        if($request->isMethod("POST")){
            $num = DB::table("teachs")->whereRaw('teach_id = ? and course_num = ?',[session()->get("teach_id") ,trim($_POST['course_num'])])->count();
            if($num > 0){
                return json_encode(array("code"=>"0003"),JSON_UNESCAPED_UNICODE);//课程已经添加
            }else{
                $course = DB::table("courses")->where('course_num', '=', trim($_POST['course_num']))->first();
                if(empty($course)){
                    return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
                }else{
                    return json_encode(array("code"=>"0000", "course_num"=>$course->course_num, "course_name"=> $course->course_name, "course_type"=>$course->course_type, "course_intro"=> $course->course_intro),JSON_UNESCAPED_UNICODE);
                }
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }
}
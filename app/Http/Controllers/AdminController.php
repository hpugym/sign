<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/19
 * Time: 12:50
 */

namespace App\Http\Controllers;

use App\Course;
use App\Local;
use App\Student;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller{

    public function teacher(Request $request){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
//            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        if(isset($_GET['require']) && $_GET['require'] != ""){
            $list = Teacher::where('teach_id', '=', trim($_GET['require']))->join('users', 'user_num', '=', 'teach_id')->Paginate(20);
            //dd($list);
            $page = Teacher::pageAction($list,7,$request->getUri());
            return view("admin/teachlist",[
                'teachers'=>$list,
                'paging'=>$page,
                'count'=> 1
            ]);
        }
        $list = Teacher::join('users', 'user_num', '=', 'teach_id')->Paginate(20);
        //dd($list);
        $page = Teacher::pageAction($list,7,$request->getUri());
        return view("admin/teachlist",[
            'teachers'=>$list,
            'paging'=>$page,
            'count'=> 1
        ]);
    }

    public function teacherEdit(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $teach_id = $_POST['teach_id'];
            $teach_name = $_POST['teach_name'];
            $teach_sex = $_POST['teach_sex'];
            $teach_level = $_POST['teach_level'];
            $num = DB::table('teachers')->where('teach_id', '=', $teach_id)->update([
                'teach_name' => $teach_name,
                'teach_sex' => $teach_sex,
                'teach_level' => $teach_level
            ]);

            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }

    public function teacherAdd(){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
//            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        $time = time();
        $num = DB::table('users')->insert([
            'user_created' => $time,
            'user_action' => $time
        ]);

        if($num > 0){
            $res = DB::table('users')->where('user_created', '=', $time)->select('user_id')->first();
            //dd($res->user_id);
            return view('admin/teachadd',[
                'user_id' => $res->user_id
            ]);
        }else{
            echo "<script>alert('系统错误');window.history.back(-1)</script>";
        }
    }

    public function teacherAddAction(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $teach_id = $_POST['teach_id'];
            $res = DB::table('teachers')->where('teach_id', '=', $teach_id)->get();
            if(count($res) >0){
                DB::table('teachers')->where('teach_id', '=', $teach_id)->delete();
            }

            $teach_id = $_POST['teach_college'].$_POST['teach_id'];
            $teach_name = trim($_POST['teach_name']);
            $teach_sex = $_POST['teach_sex'];
            $teach_level = trim($_POST['teach_level']);

            $num = DB::table('teachers')->insert([
                'teach_id' => $teach_id,
                'teach_name' => $teach_name,
                'teach_sex' => $teach_sex,
                'teach_level' => $teach_level
            ]);
            if($num > 0){
                //更新user表中的工号
                $mark = DB::table("users")->where('user_id', '=', $_POST['teach_id'])->update([
                    'user_num' => $teach_id
                ]);
                if($mark > 0){
                    return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
                }else{
                    return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
                }
            }
            else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }

    public function teacherDel(Request $request){

        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $teach_id = $_POST['teach_id'];
            $num = DB::table('teachers')->where('teach_id', '=', $teach_id)->delete();
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }
            else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }

    /**设置为管理员账号
     * @param Request $request
     * @return string
     */
    public function adminSet(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }
        if($request->isMethod("POST")){
            $user_id = $_POST['user_id'];
            $num = DB::table('users')->where('user_id', '=', $user_id)->update([
                'user_type' => 1
            ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }


    public function passReset(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }
        if($request->isMethod("POST")){
            $user_id = $_POST['user_id'];
            $pass = md5("123456");
            $num = DB::table('users')->where('user_id', '=', $user_id)->update([
                'user_pass' => $pass
            ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function student(Request $request){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
//            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        if(isset($_GET['require']) && $_GET['require'] != ""){
            $list = Student::where('stu_num', '=',trim($_GET['require']))->orderBy('stu_num','asc')->Paginate(1);
            //dd($list);
            $page = Student::pageAction($list,7,$request->getUri());
            return view("admin/studentlist",[
                'students'=>$list,
                'paging'=>$page,
                'count'=> 1
            ]);
        }
        $list = Student::orderBy('stu_num','asc')->Paginate(50);
        //dd($list);
        $page = Student::pageAction($list,7,$request->getUri());
        return view("admin/studentlist",[
            'students'=>$list,
            'paging'=>$page,
            'count'=> 1
        ]);
    }

    public function studentEdit(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $stu_num = $_POST['stu_num'];
            $stu_name = $_POST['stu_name'];
            $stu_sex = $_POST['stu_sex'];
            $stu_class = $_POST['stu_class'];
            $stu_college = $_POST['stu_college'];
            $stu_openid = $_POST['stu_openid'];
            $num = DB::table('students')->where('stu_num', '=', $stu_num)->update([
                'stu_name' => $stu_name,
                'stu_sex' => $stu_sex,
                'stu_class' => $stu_class,
                'stu_college' => $stu_college,
                'stu_openid' => $stu_openid
            ]);

            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }

    public function studentAdd(){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
//            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        return view("admin/studentadd");
    }

    public function studentAddAction(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $stu_num = $_POST['stu_num'];
            $count = DB::table('students')->where('stu_num', '=', $stu_num)->count();
            if($count > 0){
                return json_encode(array("code"=>"0003"),JSON_UNESCAPED_UNICODE);
            }
            $stu_name = $_POST['stu_name'];
            $stu_sex = $_POST['stu_sex'];
            $stu_class = $_POST['stu_class'];
            $stu_college = $_POST['stu_college'];
            $num = DB::table('students')->insert([
                'stu_num' => $stu_num,
                'stu_name' => $stu_name,
                'stu_sex' => $stu_sex,
                'stu_class' => $stu_class,
                'stu_college' => $stu_college,
            ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }
    public function studentDel(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $stu_num = $_POST['stu_num'];
            $num = DB::table('students')->where('stu_num', '=', $stu_num)->delete();
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }
            else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }

    public function classRoom(Request $request){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
//            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }

        if(isset($_GET['require']) && $_GET['require'] != ""){
            $list = Local::where('local_id', '=', trim($_GET['require']))->orderBy('local_id','asc')->Paginate(1);
            //dd($list);
            $page = Local::pageAction($list,7,$request->getUri());
            return view("admin/classRoomlist",[
                'classrooms'=>$list,
                'paging'=>$page,
                'count'=> 1
            ]);
        }
        $list = Local::orderBy('local_id','asc')->Paginate(50);
        //dd($list);
        $page = Local::pageAction($list,7,$request->getUri());
        return view("admin/classRoomlist",[
            'classrooms'=>$list,
            'paging'=>$page,
            'count'=> 1
        ]);
    }

    public function classRoomEdit(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $local_id = $_POST['local_id'];
            $local_lon = $_POST['local_lon'];
            $local_lat = $_POST['local_lat'];
            $time = time();
            $num = DB::table('locals')->where('local_id', '=', $local_id)->update([
                'local_lon' => $local_lon,
                'local_lat' => $local_lat,
                'local_created' => $time
            ]);

            if($num > 0){
                return json_encode(array("code"=>"0000","time"=>date("Y-m-d H:i:s",$time)),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }
    public function classRoomDel(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $local_id = $_POST['local_id'];
            $num = DB::table('locals')->where('local_id', '=', $local_id)->delete();
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }
            else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }


    public function course(Request $request){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        if(isset($_GET['require']) && $_GET['require'] != ""){
            $list = Course::where('course_num', '=', trim($_GET['require']))->orderBy('course_num','asc')->Paginate(1);
            //dd($list);
            $page = Local::pageAction($list,7,$request->getUri());
            return view("admin/courselist",[
                'courses'=>$list,
                'paging'=>$page,
                'count'=> 1
            ]);
        }
        $list = Course::orderBy('course_num','asc')->Paginate(50);
        //dd($list);
        $page = Local::pageAction($list,7,$request->getUri());
        return view("admin/courselist",[
            'courses'=>$list,
            'paging'=>$page,
            'count'=> 1
        ]);
    }

    public function courseAdd(){

        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
//            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        return view("admin/courseadd");
    }

    public function courseAddAction(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $course_num = $_POST['course_num'];
            $count = DB::table('courses')->where('course_num', '=', $course_num)->count();
            if($count > 0){
                return json_encode(array("code"=>"0003"),JSON_UNESCAPED_UNICODE);
            }
            $course_name = $_POST['course_name'];
            $course_type = $_POST['course_type'];
            $course_intro = $_POST['course_intro'];
            $num = DB::table('courses')->insert([
                'course_num' => $course_num,
                'course_name' => $course_name,
                'course_type' => $course_type,
                'course_intro' => $course_intro,
            ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 课程信息的修改
     * @param Request $request
     * @return string
     */
    public function courseEdit(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $course_num = $_POST['course_num'];
            $course_name = trim($_POST['course_name']);
            $course_type = $_POST['course_type'];
            $course_intro = trim($_POST['course_intro']);
            $num = DB::table('courses')->where('course_num', '=', $course_num)->update([
                'course_name' => $course_name,
                'course_type' => $course_type,
                'course_intro' => $course_intro
            ]);

            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * 课程信息删除
     * @param Request $request
     * @return string
     */
    public function courseDel(Request $request){

        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $course_num = $_POST['course_num'];
            $num = DB::table('courses')->where("course_num", "=", $course_num)->delete();
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }


    public function message(Request $request){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
//            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }

        return view("admin/message");
    }

    public function messagePush(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $user_id = substr($_POST['to'],3,6);
            $title = $_POST['title'];
            $content = $_POST['content'];
            if(strlen($content)>550){
                return json_encode(array("code"=>"0003"),JSON_UNESCAPED_UNICODE);
            }
            $time = time();
            $num = DB::table('messages')->insert([
                'message_to' => $user_id,
                'message_title' => $title,
                'message_content' => $content,
                'message_time' => $time
            ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }
            else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }

    public function messageTo(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }
        if($request->isMethod("POST")){
            $teach_id = trim($_POST['teach_id']);
            $num = DB::table('teachers')->where('teach_id', '=', $teach_id)->count();

            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }
            else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }



    public function notice(){
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
//            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        return view("admin/notice");
    }

    public function noticePush(Request $request){
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $title = $_POST['title'];
            $content = $_POST['content'];
            $time = time();
            $num = DB::table('notices')->insert([
                'notice_title' => $title,
                'notice_content' => $content,
                'notice_time' => $time
            ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }
            else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
        }
    }
}
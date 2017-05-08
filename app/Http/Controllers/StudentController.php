<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/13
 * Time: 10:02
 */
namespace App\Http\Controllers;

use App\CourseStudent;
use App\Teachs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller{

    public function studentCourseList(Request $request){
//        $course = DB::table("teachs")->where('teachs_id', '=', session()->get("teachs_id"))->get();
//        if(empty($course)){
//            echo "<script>alert('加载失败'); window.history.back(-1);<script>";
//        }else{
//            return view("student/courselist");
//        }
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }

        $list = Teachs::where('teach_id', '=', session()->get("teach_id"))
            ->join('courses', 'courses.course_num', '=', 'teachs.course_num')
            ->select('courses.course_num', 'courses.course_name', 'courses.course_type', 'teachs.teachs_time', 'teachs.teachs_grade', 'teachs.teachs_avai', 'teachs.teachs_stu','teachs.teachs_status','teachs.teachs_code')
            ->Paginate(15);
        $page = Teachs::pageAction($list, 7, $request->getUri());
        //dd($list);
        return view("student/courselist",[
            'courses'=>$list,
            'paging'=>$page,
            'count'=> 1
        ]);
    }

    /**
     * 根据该教师该课程的课程标示id来获取该课程的学生列表
     * @param Request $request
     * @param $teachs_code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function studentList(Request $request,$teachs_code){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        $list = CourseStudent::where('teachs_code', '=', $teachs_code)
            ->join('students', 'students.stu_openid', '=', 'mycourses.stu_openid')
            ->select('students.stu_num', 'students.stu_openid', 'students.stu_name', 'students.stu_sex', 'students.stu_class', 'students.stu_college', 'students.stu_image', 'students.stu_phone')
            ->orderBy('students.stu_num')
            ->Paginate(10);
        $page = Teachs::pageAction($list, 7, $request->getUri());
//        dd($list);
        return view("student/list",[
            'students'=>$list,
            'paging'=>$page,
            'count'=> 1,
            'teachs_code'=>$teachs_code
        ]);
    }

    public function studentAdd(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            //return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            exit(0);
        }
        if($request->isMethod("GET")){
            $teachs_code = @$_GET['teachs_code'];
            $num = DB::table('teachs')->where('teachs_code', '=', $teachs_code)->count();

            if($num > 0){
                return view("student/add",[
                    'teachs_code'=>$teachs_code
                ]);
            }else{
                echo "<script>alert('查询不存在')</script>";
                header('Refresh:0;url='.url("login"));
            }
        }else{
            echo "<script>alert('请求错误')</script>";
            header('Refresh:0;url='.url("login"));
        }
    }

    /**
     * 学生增加验证
     * @param Request $request
     * @return string
     */
    public function studentAddCheck(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            //dd($_POST);
            $stu_num = trim($_POST['stu_num']);
            $teachs_code = $_POST['teachs_code'];
            $student = DB::table("students")->where('stu_num', '=', $stu_num)->first();

            //dd($student);
            if(empty($student)){
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//该学生不存在
            }else{
                if(empty($student->stu_openid)){
                    return json_encode(array("code"=>"0003"),JSON_UNESCAPED_UNICODE);//该学生并并未关注微信号
                }else{
                    $num = DB::table("mycourses")->whereRaw('teachs_code = ? and stu_openid = ?',[$teachs_code,$student->stu_openid])->count();
                    if($num > 0){
                        return json_encode(array("code"=>"0004", "student"=> $student),JSON_UNESCAPED_UNICODE);//查找成功,但是该学生已经被添加
                    }else{
                        return json_encode(array("code"=>"0000", "student"=> $student),JSON_UNESCAPED_UNICODE);//查找成功
                    }
                }
            }

        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
        }
    }

    /**
     * 学生增加行为
     * @param Request $request
     * @return string
     */
    public function studentAddAction(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $teachs_code = trim($_POST['teachs_code']);
            $stu_openid = trim($_POST['stu_openid']);
            $num = DB::table("mycourses")->insert([
                'teachs_code'=> $teachs_code,
                'stu_openid'=> $stu_openid
            ]);
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//失败
            }

        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
        }
    }

    public function studentDelAction(Request $request){
        //身份验证
        if(empty(session()->get("user_id"))){
            //header('Refresh:0;url='.url("login"));
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);
            //exit(0);
        }

        if($request->isMethod("POST")){
            $stu_openid = $_POST['stu_openid'];
            $teachs_code = $_POST['teachs_code'];
            $num = DB::table("mycourses")
                ->whereRaw("stu_openid = ? and teachs_code = ?",[$stu_openid, $teachs_code])
                ->delete();
            if($num > 0){
                return json_encode(array("code"=>"0000"),JSON_UNESCAPED_UNICODE);//删除成功
            }else{
                return json_encode(array("code"=>"0001"),JSON_UNESCAPED_UNICODE);//删除失败
            }
        }else{
            return json_encode(array("code"=>"0002"),JSON_UNESCAPED_UNICODE);//请求错误
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/4/1
 * Time: 14:18
 */
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller{
    /**
     * 登陆方法
     */
    public function login(){
        return view("login/login");
    }

    /**
     * 退出登陆方法
     */
    public function logout(){
        Session::flush();
        header('Refresh:0;url='.url("login"));
    }
    public function loginAction(Request $request){

        if($request->isMethod("POST") && !empty($_POST)){
            $name = trim($_POST['username']);
            $pass = trim($_POST['userpass']);
            //$name = "101100000";
            //处理一下登陆的账户
            $user = substr($name,3,9);
            //dd($user);
            $userinfo = DB::table("users")->where('user_id', '=',$user)->first();
            $teacherinfo = DB::table("teachers")->where("teach_id", "=", $name)->first();
            //dd($userinfo);
            if(!empty($userinfo) && !empty($teacherinfo)){
                if($userinfo->user_pass == md5($pass)){
                    $now_time =  time();
//                    更新时间
                    DB::table("users")->where('user_id', '=',$user)->update([
                        'user_action' => $now_time
                    ]);
                    $res = array("code"=>"0000");
                    Session::put("user_id",$user);
                    Session::put("teach_id",$name);
                    Session::put("teach_name", $teacherinfo->teach_name);
                    Session::put("user_type",$userinfo->user_type);
                    Session::put("action_time",$userinfo->user_action);
                    Session::save();//注意不添加save是保存不成功的
//                    $request->session()->put("user_id",$user);
//                    $request->session()->put("teach_id",$name);
                    echo json_encode($res,JSON_UNESCAPED_UNICODE);
                    exit(0);
                }else{
                    $res = array("code"=>"0001");//用户密码错误
                    echo json_encode($res,JSON_UNESCAPED_UNICODE);
                    exit(0);
                }
            }else{
                $res = array("code"=> "0003");//该用户不存在
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
                exit(0);
            }
        }else{
            $res = array("code"=>"0002");//请求错误
            echo json_encode($res,JSON_UNESCAPED_UNICODE);
            exit(0);
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: 不倾国倾城_只倾你
 * Date: 2017/3/12
 * Time: 22:55
 */

namespace App\Http\Controllers;


use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller{

    /**
     * 主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View;
     */
    public function index(Request $request){

        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            exit(0);
        }
        //dd(session()->all());
        $notice = new Notice();
        $list = $notice->orderBy('notice_time','desc')->Paginate(7);
        $page = $notice->pageAction($list, 7, $request->getUri());
        //dd($list);
        //dd($page);
        return view("index/index",[
            'notices'=>$list,
            'paging'=>$page
        ]);
//        $res = DB::select("select * from `sign_notices`");
//        var_dump($res);
//        echo md5("123456");
//        $data = file_get_contents('./data/stu.text');
//        $data = str_replace('\r','5',$data);
//        $arr = explode("\n",$data);
//        foreach ($arr as $tmp){
//            $res[] = explode('|',$tmp);
//        }
//        foreach ($res as $in){
//            $re = DB::insert("INSERT INTO `sign_students` (`stu_num`,`stu_name`,`stu_sex`,`stu_class`,`stu_college`) values('".$in[0]."','".$in[1]."','".$in[2]."','".$in[3]."','".$in[4]."')");
//            if($re){
//                echo $in[0]."插入成功！<br/>";
//            }else{
//                echo $in[0]."插入失败!<br/>";
//                exit(0);
//            }
//        }
    }

    /**
     * 首页公告栏,详情展示
     * @param $nid 公告id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notice($nid){
        //身份验证
        if(empty(session()->get("user_id"))){
            header('Refresh:0;url='.url("login"));
            exit(0);
        }
        //前一个公告
        $prev = Notice::where('notice_id' ,'<',$nid)->orderBy("notice_time",'desc')->first();
        //dd($prev);
        //当前公告
        $now = Notice::where('notice_id' ,'=',$nid)->orderBy("notice_time",'desc')->first();
        //dd($now);
        //下一个公告
        $next = Notice::where('notice_id' ,'>',$nid)->orderBy("notice_time",'asc')->first();
        //dd($prev);
        //处理请求
        if(empty($prev)){
            $prevUrl = "javascript:void(0)";
            $prevTitle = "没有了";
        }else{
            $prevUrl =  asset("notice/detail/".$prev->notice_id);
            $prevTitle = $prev->notice_title;
        }
        if(empty($next)){
            $nextUrl = "javascript:void(0)";
            $nextTitle = "没有了";
        }else{
            $nextUrl = asset("notice/detail/".$next->notice_id);
            $nextTitle = $next->notice_title;
        }
        if(empty($now)){
            echo "<script>alert('加载错误...'); window.history.back(-1);</script>";
        }else{
            return view("index/notice",[
                'prevUrl' => $prevUrl,
                'prevTitle' => $prevTitle,
                'nextUrl' => $nextUrl,
                'nextTitle' => $nextTitle,
                'notice'=> $now
            ]);
        }
    }

}
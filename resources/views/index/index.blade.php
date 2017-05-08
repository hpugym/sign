<style type="text/css">
    .nav-pos{
        border: 0px;
        background: #EDF6FA; width: 100%;
        height: 40px;
        line-height: 40px;
        font-size: 14px;
        font-family: "微软雅黑";
        color:black;
        padding-left: 10px;
    }
    .main-content{
        border: 1px solid transparent;
        width: 100%;
        min-height: 559px;
    }
    .content-top{
        border-bottom: 1px solid silver;
        position: relative;
        width: 96%;
        height: 75px;
        margin-top: 10px;
        margin-left: 2%;
        margin-right: 2%;
        line-height: 30px;
        padding-bottom: 10px;
    }
    .content-top a:hover{
        color: #FE7E22;
        text-decoration: none;
    }
    .content-bottom{
        border: 1px solid transparent;
        position: relative;
        width:96%;
        min-height: 450px;
        margin-left: 2%;
        margin-right: 2%;
        margin-top: 10px;
    }
    .content-bottom-notice{
        border: 1px solid silver;
        width: 92%;
        height: 320px;
        margin-top: 10px;
        margin-left: 4%;
        margin-right: 4%;
        padding-left: 10px;
        padding-top: 10px;
        line-height: 30px;
    }
    .content-bottom-notice li img{
        width: 20px;
        margin-top: -5px;
        margin-right: 5px;
    }
    .content-bottom-notice a{
        color: black;
    }
    .content-bottom-notice a:hover{
        color: #23527c;
        text-decoration: none;
    }
    .content-bottom-page{
        border: 1px solid transparent;
        width: 92%;
        height: 40px;
        margin-left: 4%;
        margin-right: 4%;
        padding-right: 10px;
    }
    .content-bottom-page-contents{
        border: 0;
        width: 360px;
        float: right;
        height: 40px;
    }
    .content-bottom-page-contents a{
        color: gray;
    }
</style>
@extends('common.template')
@section("title")
    首页
@stop
@section("header")
    @include("common.top")
@stop
@section("center_left")
    @include("common.menu")
@stop
@section("center_right")
    <div class="container-fluid" style="background:white; border: 0; height: auto; overflow: hidden; padding: 0; margin: 0;">
       <div class="nav-pos">
           您的位置：首页
       </div>
        <div class="main-content">
            <div class="content-top">
                <img src="{{asset("images/sun.png")}}"><span style="padding-left: 10px;"><b>欢迎您，{{session()->get("teach_name")}}老师</b>&nbsp;&nbsp;欢迎使用签到小微考勤系统</span><br/>
                <img src="{{asset("images/time.png")}}"><span style="padding-left: 10px;">您上次登录的时间：<span style="font-family: Arial">{{date("Y-m-d H:i:s",session()->get("action_time"))}}</span>（不是您登录的？<a href="{{url("personal/passedit")}}">请点这里</a>）</span>
            </div>
            <div class="content-bottom">
                <img  style="width:36px;" src="{{asset("images/notice.png")}}"><span style="padding-left: 10px; font-size: 16px;">公告栏：</span>
                <div class="content-bottom-notice">
                    <ul>
                        @foreach($notices as $list)
                            <li><a href="{{asset("notice/detail/".$list->notice_id)}}"><img src="{{asset("images/notice_title.png")}}">{{$list->notice_title}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="content-bottom-page">
                    <div class="content-bottom-page-contents">@include("common.paging")</div>
                </div>
            </div>
        </div>
    </div>
@stop
@section("footer")
    @include("common.footer")
@stop
<script type="text/javascript">
    window.onload = function () {
        //注意加载新消息的数量
        getNewsCount();
    }
</script>
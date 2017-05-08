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
        min-height: 539px;
        margin-bottom: 20px;
    }
    .notice-title{
        border-top: 1px solid silver;
        border-left: 1px solid silver;
        border-right: 1px solid silver;
        width: 92%;
        height: 40px;
        margin-top: 40px;
        margin-left: 4%;
        margin-right: 4%;
        line-height: 40px;
        padding-left: 10px;
        font-size: 18px;
    }
    .notice-content{
        border: 1px solid silver;
        width: 92%;
        min-height: 320px;
        margin-left: 4%;
        margin-right: 4%;
        line-height: 30px;
        padding-left: 10px;
        padding-right: 10px;
        text-indent: 26px;
        font-size: 16px;
    }
    .notice-navi{
        border: 0;
        width: 92%;
        height: 80px;
        margin-left: 4%;
        margin-right: 4%;
    }
    .cols {
        border-bottom: 1px solid silver;
        border-left: 1px solid silver;
        border-right: 1px solid silver;
        width: 100%;
        height: 40px;
        line-height: 40px;
        text-align: left;
        padding-left: 10px;
        color: black;
    }
    .cols a:hover{
        text-decoration: none;
    }

</style>
@extends('common.template')
@section("title")
    公告详情
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
            您的位置：首页->公告详情
        </div>
        <div class="main-content">
            <div class="notice-title">
                <b>{{$notice->notice_title}}</b>
            </div>
            <div class="notice-content">
                <span><?php echo $notice->notice_content ?></span>
                <p class="text-right" style="margin-right: 10px;">{{date("Y年m月d日 H:i:s",$notice->notice_time)}}</p>
            </div>
            <div class="notice-navi">
                <div class="cols"><a href="{{$prevUrl}}">上一条：{{$prevTitle}}</a></div>
                <div class="cols"><a href="{{$nextUrl}}">下一条：{{$nextTitle}}</a></div>
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
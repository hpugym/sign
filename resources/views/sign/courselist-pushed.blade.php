<style type="text/css">
    /*
    导航栏激活样式
*/
    #onactive-sign-pushed{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-sign-pushed cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-sign-pushed i{
        display:block;
        background:url({{url("images/sj.png")}}) no-repeat;
        background-size: 10px 25px;
        width:10px;
        height:25px;
        position:absolute;
        right:0;
        z-index:1000;
        top:3px;
        right:-1px;
    }
    #onactive-sign-pushed a{
        color:#fff;
        text-decoration: none;
    }
    #onactive-father-sign{
        display: block;
    }
    /*
    主要样式
    */
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
    .content-list{
        position: relative;
        width: 100%;
        min-height: 520px;
        height: auto;
        border: 1px solid transparent;
    }
    .table{
        font-size: 14px;
        text-align: center;
        margin-bottom: 0;
        display: table;
    }
    /*表格中的垂直居中*/
    .table tr td{
        display: table-cell;
        vertical-align: middle !important;
    }
    .content-bottom-page{
        border: 1px solid transparent;
        width: 100%;
        height: 40px;
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
    课程列表
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
            您的位置：签到管理->课程列表
        </div>
        <div class="main-content">
            <div class="content-list">
                <table class="table table-striped table-bordered table-hover table table-condensed table-responsive">
                    <tr>
                        <td width="50">序号</td>
                        <td width="110">课程号</td>
                        <td>课程名</td>
                        <td>类型</td>
                        <td width="80">学分</td>
                        <td width="40">学时</td>
                        <td width="40">容量</td>
                        <td>授课学生</td>
                        <td width="40">状态</td>
                        <td width="120">操作</td>
                    </tr>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{$count ++}}</td>
                            <td>{{$course->course_num}}</td>
                            <td>{{$course->course_name}}</td>
                            <td>{{$course->course_type}}</td>
                            <td>{{$course->teachs_grade}}</td>
                            <td>{{$course->teachs_time}}</td>
                            <td>{{$course->teachs_avai}}</td>
                            <td>{{$course->teachs_stu}}</td>
                            <td style="{{$course->teachs_status  == 0 ? "color: blue" : "color:gray"}}">{{$course->teachs_status  == 0 ? "在教" : "结课"}}</td>
                            <td><a href="{{url("signmanager/published")."/".$course->teachs_code}}">查看签到</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="content-bottom-page">
                <div class="content-bottom-page-contents">@include("common.paging")</div>
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
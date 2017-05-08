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
        height: auto;
    }
    .content-navi{
        position: relative;
        width: 100%;
        height: 40px;
        border:0;
    }
    .content-navi button{
        width: 120px;
        height: 40px;
        margin-left: 0;
        margin-right: 0;
        border: 0;
        float: left;
        font-size: 18px;
        background: #3b95c8;
    }
    .content-list{
        position: relative;
        width: 100%;
        min-height: 470px;
        height: auto;
        border: 1px solid silver;
    }
    .table{
        font-size: 14px;
        text-align: center;
        display: table;
    }
    .table tr th{
        text-align: center;
    }
    /*表格中的垂直居中*/
    .table tr td{
        display: table-cell;
        vertical-align: middle !important;
    }
    .content-page{
        position: relative;
        width: 100%;
        height: 40px;
        border: 0
    }
    .content-page button{
        color: black;
        width: 100px;
        height: 40px;
        float: right;
        font-size: 20px;
        line-height: 40px;
        border: 0;
        background: #f9f9f9;
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
            您的位置：课程管理->课程列表
        </div>
        <div class="main-content">
            <div class="content-navi">
                <a href="{{url("course/list")}}"><button style="color: white;">课程列表</button></a>
                <a href="{{url("course/add")}}"><button style="background: #f9f9f9; ">新增课程</button></a>
            </div>
            <div class="content-list">
                <table class="table table-bordered table-hover table-condensed table-striped table-responsive">
                    <tr>
                        <th width="40">序号</th>
                        <th width="110">课程号</th>
                        <th>课程名</th>
                        <th>类型</th>
                        <th width="40">学分</th>
                        <th width="40">学时</th>
                        <th width="40">容量</th>
                        <th>教学班级</th>
                        <th>教学地点</th>
                        <th width="40">状态</th>
                        <th width="40">备注</th>
                        <th width="80">操作</th>
                    </tr>
                    @foreach($courses as $course)
                        <tr id="list-{{$course->tc_teachs_code}}">
                            <td>{{$course->tc_teachs_code}}</td>
                            <td>{{$course->tc_course_num}}</td>
                            <td>{{$course->tc_course_name}}</td>
                            <td>{{$course->tc_course_type}}</td>
                            <td>{{$course->tc_teachs_grade}}</td>
                            <td>{{$course->tc_teachs_time}}</td>
                            <td>{{$course->tc_teachs_avai}}</td>
                            <td>{{$course->tc_teachs_stu}}</td>
                            <td>{{$course->tc_teachs_add}}</td>
                            <td>{{$course->tc_teachs_status}}</td>
                            <td><span class="add-list" id="{{$course->tc_teachs_code}}" style="cursor:pointer;">查看</span></td>
                            <td><a href="{{url("course/edit")."/".$course->tc_teachs_code."/".urlencode($course->tc_course_name)}}">修改</a>&nbsp;<a href="javascript:del({{$course->tc_teachs_code}})">删除</a></td>
                        </tr>
                        <tr class ="{{$course->tc_teachs_code}}" id="list2-{{$course->tc_teachs_code}}" style="display:none; z-index: 9999; position: absolute; border: 0; background: #D4E7F0; right: 80px; width: 200px; height: auto; word-break: break-all; word-wrap:break-word;">
                            <td>
                                <p style="margin-top: -15px; right: 10px; z-index: 9998; position: absolute; border:0;"><img src="{{url("images/sanjiao.png")}}" style="width: 20px;"></p>
                                {{$course->tc_course_intro}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="content-page">
                <a href="{{$next}}"><button>下一页</button></a>
                <a href="{{$prev}}"><button>上一页</button></a>
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

        $(".add-list").mouseover(function () {
//            var left = $(this).offset().top;
//            var top = $(this).offset().left;
             var id = $(this).attr("id");
             $("."+id).css("display","inline-block");
        });
        $(".add-list").mouseout(function () {
            var id = $(this).attr("id");
            $("."+id).css("display","none");
        });
    }
    function del(teachs_code) {
        if(confirm("即将删除？")){
            $.ajax({
                url:"{{url("course/del-action")}}",
                type:"post",
                data:{
                    "teachs_code": teachs_code,
                    _token: "{{csrf_token()}}"//注意验证_token的添加
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
                    if(data2.code == "0000"){
                        $("#list-"+ teachs_code).remove();
                        $("#list2-"+ teachs_code).remove();
                    }else{
                        alert("删除失败");
                    }

                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);

                }
            });

        }
    }
</script>
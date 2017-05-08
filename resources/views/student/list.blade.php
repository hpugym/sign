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
    学生列表
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
            您的位置：学生管理->学生列表
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="{{url("student/add")."?teachs_code=".$teachs_code}}"><b>新增学生</b></a></span>
        </div>
        <div class="main-content">
            <div class="content-list">
                <table class="table table-striped table-bordered table-hover table table-condensed">
                    <tr>
                        <td width="40">序号</td>
                        <td width="120">学号</td>
                        <td>姓名</td>
                        <td width="40">性别</td>
                        <td>专业班级</td>
                        <td>学院</td>
                        <td width="120">手机号码</td>
                        <td width="80">微信头像</td>
                        <td width="100">操作</td>
                    </tr>
                    @if(count($students) == 0)
                        <tr>
                            <td colspan="9">该课程还未有学生绑定</td>
                        </tr>
                    @else
                        @foreach($students as $student)
                            <tr id="list-{{$student->stu_openid}}">
                                <td>{{$count ++}}</td>
                                <td>{{$student->stu_num}}</td>
                                <td>{{$student->stu_name}}</td>
                                <td>{{$student->stu_sex}}</td>
                                <td>{{$student->stu_class}}</td>
                                <td>{{$student->stu_college}}</td>
                                <td>{{$student->stu_phone}}</td>
                                <td><img src="{{$student->stu_image}}" style="width: 64px; height: 64px; border-radius: 64px; overflow: hidden;"></td>
                                <td><a href="javascript:del('{{$student->stu_openid}}','{{$teachs_code}}')">删除</a></td>
                            </tr>
                        @endforeach
                    @endif
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
    function del(stu_openid,teachs_code){
        if(confirm("继续将删除？")){
            $.ajax({
                url:"{{url("student/del-action")}}",
                type:"post",
                data:{
                    "teachs_code": teachs_code,
                    "stu_openid":  stu_openid,
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
//                            alert('成功！'+typeof(data)+data);
//                            alert(typeof(data2)+"code:"+data2.code);
                    if(data2.code == "0000") {
                        $("#list-"+stu_openid).slideUp(function () {
                            $("#list-"+stu_openid).remove();
                        });
                        alert("删除成功");
                    }else if(data2.code == "0001"){
                        alert("删除失败");
                    }else if(data2.code == "0002"){
                        alert("请求发生错误，请重试");
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    }
</script>
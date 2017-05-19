<style type="text/css">
    /*
   导航栏激活样式
*/
    #onactive-system-course{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-system-course cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-system-course i{
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
    #onactive-system-course a{
        color:#fff;
        text-decoration: none;
    }
    #onactive-father-system{
        display: block;
    }
    /*主要样式*/
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
    .require{
        width: 100%;
        height: 60px;
        border-bottom: 0;
    }
    .require label{
        height: 40px;
        line-height: 40px;
        margin-left: 30px;
        font-size: 20px;
        margin-top: 10px;
        font-size: 18px;
        float: left;
    }
    .require input{
        width: 200px;
        height: 40px;
        margin-top: 10px;
        margin-left: 5px;
        margin-bottom: 10px;
        float: left;
    }
    .require button{
        width: 120px;
        height: 40px;
        font-size: 20px;
        margin-left: 10px;
        margin-top: 10px;
        float: left;
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
    /*ceng*/
    .tools-ceng{
        width: 100%;
        height: 100%;
        position: fixed;
        background: gray;
        opacity: 0.6;
        filter:Alpha(Opacity=60);
        z-index: 999;
        display: none;
    }
    .tools-content{
        width:450px;
        height: 450px;
        border: 0;
        box-shadow: 5px 5px 8px gray;
        position: fixed;
        z-index: 1002;
        background: #fff;
        left:50%;
        top:40%;
        margin-top: -150px;
        margin-left: -225px;
        display: none;
    }
    .tools-top{
        width: 450px;
        border: 0;
        background: silver;
        height: 40px;
        line-height: 40px;
    }
    .tools-top span:hover{
        color: #fff;
    }
    .tools-bottom{
        width: 450px;
        line-height: 30px;
        font-size: 16px;
        margin-top: 20px;
    }
    .tools-bottom label{
        margin-left: 30px;
        font-size: 18px;
    }
    .tools-bottom select{
        width: 220px;
        margin-left: 0px;
        text-align: center;
        height: 30px;
        margin-top: 20px;
    }
    .tools-bottom textarea{
        width:220px;
        height: 150px;
    }
    .tools-bottom input{
        width: 220px;
        height: 30px;
        margin-top: 20px;
    }
    .tools-bottom button{
        display: inline-block;
        width: 220px;
        height: 50px;
        margin: auto;
        background: silver;
        border: 0;
        margin-left: 110px;
        margin-top: 40px;
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
            您的位置：系统管理->课程列表
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="{{url("admin/course/add")}}"><b>新增课程</b></a></span>
        </div>
        <div class="main-content">
            <div class="content-list">
                <div class="require">
                    <label>课程号:</label>
                    <input type="text" name="require">
                    <button id="require_btn">查找</button>
                </div>
                <table class="table table-striped table-bordered table-hover table table-condensed">
                    <tr>
                        <td width="40">序号</td>
                        <td width="90">课程号</td>
                        <td width="200">课程名称</td>
                        <td width="80">课程属性</td>
                        <td>课程简介</td>
                        <td width="120">操作</td>
                    </tr>
                    @if(count($courses) == 0)
                        <tr>
                            <td colspan="9">课程信息不存在</td>
                        </tr>
                    @else
                        @foreach($courses as $course)
                            <tr id="{{$course->course_num}}">
                                <td>{{$count++}}</td>
                                <td>{{$course->course_num}}</td>
                                <td id="{{$course->course_num}}-name">{{$course->course_name}}</td>
                                <td id="{{$course->course_num}}-type">{{$course->course_type}}</td>
                                <td id="{{$course->course_num}}-intro">{{$course->course_intro}}</td>
                                <td>
                                    <a href="javascript:edit({{$course->course_num}})">修改</a>&nbsp;
                                    <a href="javascript:del({{$course->course_num}})">删除</a>
                                </td>
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
<div class="tools-ceng"></div>
<div class="tools-content">
    <div class="tools-top">
        <span id="close" style="display: inline-block; float: right; margin-right: 15px; font-size: 24px; cursor: pointer;">&times;</span>
    </div>
    <div class="tools-bottom">
        <input type="hidden" name="course_num">
        <label>课程名称:</label>
        <input type="text" name="course_name"><br/>
        <label>课程属性:</label>
        <select id="course_type">
            <option value="必修">必修</option>
            <option value="公共选修">公共选修</option>
            <option value="专业选修">专业选修</option>
            <option value="通识教育">通识教育</option>
        </select><br/>
        <label>课程简介:</label>
        <textarea name="course_intro"></textarea>
        <button id = "status_save">保存</button>
    </div>
</div>
<script type="text/javascript">
    window.onload = function () {
        //注意加载新消息的数量
        getNewsCount();

        //条件查询
        $("#require_btn").click(function () {
            var require = $("input[name='require']").val();
            if(require == null || require == ""){
                alert('请输入条件');
            }else{
                window.location.href="{{url("admin/courses?require=")}}"+require;
            }
        });

        $("#status_save").click(function () {
            $("#status_save").html("保存中...")
            $("#status_save").attr("disabled",true);
            $("#status_save").css("cursor","not-allowed");

            var course_name = $("input[name='course_name']").val();
            var course_intro = $("textarea[name='course_intro']").val();
            var course_type = $("#course_type option:selected").val();
            var course_num = $("input[name='course_num']").val();

            $.ajax({
                url:"{{url("admin/course/edit-action")}}",
                type:"post",
                data:{
                    "course_num": course_num,
                    "course_name": course_name,
                    "course_type": course_type,
                    "course_intro": course_intro,
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
                    if(data2.code == "0000") {
                        $("#"+course_num+"-name").html(course_name);
                        $("#"+course_num+"-type").html(course_type);
                        $("#"+course_num+"-intro").html(course_intro);
                        alert("修改成功");

                    }else if(data2.code == "0001"){
                        alert("修改失败");
                    }else if(data2.code == "0002"){
                        alert("请求发生错误，请重试");
                    }
                    $(".tools-ceng").hide();
                    $(".tools-content").hide();
                    $("#status_save").html("保存");
                    $("#status_save").removeAttr("disabled");
                    $("#status_save").css("cursor","pointer");
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                    $(".tools-ceng").hide();
                    $(".tools-content").hide();
                    $("#status_save").html("保存");
                    $("#status_save").removeAttr("disabled");
                    $("#status_save").css("cursor","pointer");
                },
            });
        });


        $("#close").click(function () {
            $(".tools-ceng").hide();
            $(".tools-content").hide();
            $("#status_save").html("保存");
            $("#status_save").removeAttr("disabled");
            $("#status_save").css("cursor","pointer");
        });
    }
    function edit(course_num) {
        var name = $("#"+course_num+"-name").html();
        var type = $("#"+course_num+"-type").html();
        var intro =$("#"+course_num+"-intro").html();

        $("input[name='course_name']").val(name);
        $("input[name='course_num']").val(course_num);
        $("textarea[name='course_intro']").val(intro);
        $("#course_type").find("option[value='"+type+"']").attr("selected",true);
        $(".tools-ceng").show();
        $(".tools-content").show();
    }
    function del(course_num){
        if(confirm("继续将删除？")){
            $.ajax({
                url:"{{url("admin/course/del-action")}}",
                type:"post",
                data:{
                    "course_num": course_num,
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
//                            alert('成功！'+typeof(data)+data);
//                            alert(typeof(data2)+"code:"+data2.code);
                    if(data2.code == "0000") {
                        alert("删除成功");
                        $("#"+course_num).slideUp(function () {
                            $("#"+course_num).remove();
                        });
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
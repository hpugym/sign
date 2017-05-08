<style type="text/css">
    /*
   导航栏激活样式
*/
    #onactive-system-student{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-system-student cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-system-student i{
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
    #onactive-system-student a{
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
        width:500px;
        height: 450px;
        border: 0;
        box-shadow: 5px 5px 8px gray;
        position: fixed;
        z-index: 1002;
        background: #fff;
        left:50%;
        top:40%;
        margin-top: -150px;
        margin-left: -150px;
        display: none;
    }
    .tools-top{
        width: 500px;
        border: 0;
        background: silver;
        height: 40px;
        line-height: 40px;
    }
    .tools-top span:hover{
        color: #fff;
    }
    .tools-bottom{
        width: 500px;
        line-height: 30px;
        font-size: 16px;
        margin-top: 20px;
    }
    .tools-bottom label{
        margin-left: 60px;
        font-size: 18px;
    }
    .tools-bottom select{
        width: 280px;
        margin-left: 0px;
        text-align: center;
        height: 30px;
        margin-top: 20px;
    }
    .tools-bottom input{
        width: 280px;
        height: 30px;
        margin-top: 20px;
    }
    .tools-bottom button{
        display: inline-block;
        width: 120px;
        height: 30px;
        margin: auto;
        background: silver;
        border: 0;
        margin-left: 160px;
        margin-top: 40px;
    }
</style>
@extends('common.template')
@section("title")
    教师列表
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
            您的位置：系统管理->学生列表
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="{{url("admin/students/add")}}"><b>新增学生</b></a></span>
        </div>
        <div class="main-content">
            <div class="require">
                <label>学号:</label>
                <input type="text" name="require">
                <button id="require_btn">查找</button>
            </div>
            <div class="content-list">
                <table class="table table-striped table-bordered table-hover table table-condensed">
                    <tr>
                        <td width="40">序号</td>
                        <td width="90">学号</td>
                        <td>姓名</td>
                        <td width="40">性别</td>
                        <td>专业班级</td>
                        <td>学院</td>
                        <td>手机号</td>
                        <td width="120">openID</td>
                        <td width="80">微信头像</td>
                        <td width="80">操作</td>
                    </tr>
                    @if(count($students) == 0)
                        <tr>
                            <td colspan="9">学生信息不存在</td>
                        </tr>
                    @else
                        @foreach($students as $student)
                            <tr id="{{$student->stu_num}}">
                                <td>{{$count++}}</td>
                                <td>{{$student->stu_num}}</td>
                                <td id="{{$student->stu_num}}-name">{{$student->stu_name}}</td>
                                <td id="{{$student->stu_num}}-sex">{{$student->stu_sex}}</td>
                                <td id="{{$student->stu_num}}-class">{{$student->stu_class}}</td>
                                <td id="{{$student->stu_num}}-college">{{$student->stu_college}}</td>
                                <td>{{$student->stu_phone}}</td>
                                <td id="{{$student->stu_num}}-openid">{{$student->stu_openid}}</td>
                                <td><img src="@if(empty($student->stu_image)){{""}} @else {{url("$student->stu_image")}} @endif" style="width: 64px; height: 64px; border-radius: 64px; overflow: hidden;"></td>
                                <td><a href="javascript:edit({{$student->stu_num}})">修改</a>&nbsp;<a href="javascript:del({{$student->stu_num}})">删除</a></td>
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
        <input type="hidden" name="stu_num">
        <label>学生姓名:</label>
        <input type="text" name="stu_name"><br/>
        <label>学生性别:</label>
        <select id="stu_sex">
            <option value="男">男</option>
            <option value="女">女</option>
        </select><br/>
        <label>专业班级:</label>
        <input type="text" name="stu_class"><br/>
        <label>所在学院:</label>
        <input type="text" name="stu_college"><br/>
        <label style="margin-left: 70px;">openID:</label>
        <input type="text" name="stu_openid"><br/>
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
                window.location.href="{{url("admin/students?require=")}}"+require;
            }
        });


        $("#status_save").click(function () {
            $("#status_save").html("保存中...")
            $("#status_save").attr("disabled",true);
            $("#status_save").css("cursor","not-allowed");

            var stu_num = $("input[name='stu_num']").val();
            var stu_name = $("input[name='stu_name']").val();
            var stu_sex = $("#stu_sex option:selected").val();
            var stu_class = $("input[name='stu_class']").val();
            var stu_college = $("input[name='stu_college']").val();
            var stu_openid = $("input[name='stu_openid']").val();

            $.ajax({
                url:"{{url("admin/students/edit-action")}}",
                type:"post",
                data:{
                    "stu_num": stu_num,
                    "stu_name":  stu_name,
                    "stu_sex": stu_sex,
                    'stu_class': stu_class,
                    'stu_college':stu_college,
                    'stu_openid':stu_openid,
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
                    if(data2.code == "0000") {
                        $("#"+stu_num+"-name").html(stu_name);
                        $("#"+stu_num+"-sex").html(stu_sex);
                        $("#"+stu_num+"-class").html(stu_class);
                        $("#"+stu_num+"-college").html(stu_college);
                        $("#"+stu_num+"-openid").html(stu_openid);
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
    function edit(stu_num) {
        var stu_name = $("#"+stu_num+"-name").html();
        var stu_sex = $("#"+stu_num+"-sex").html();
        var stu_class =$("#"+stu_num+"-class").html();
        var stu_college =$("#"+stu_num+"-college").html();
        var stu_openid =$("#"+stu_num+"-openid").html();

        $("input[name='stu_num']").val(stu_num);
        $("input[name='stu_name']").val(stu_name);
        $("input[name='stu_class']").val(stu_class);
        $("input[name='stu_college']").val(stu_college);
        $("input[name='stu_openid']").val(stu_openid);
        $("#stu_sex").find("option[value='"+stu_sex+"']").attr("selected",true);
        $(".tools-ceng").show();
        $(".tools-content").show();
    }
    function del(stu_num){
        if(confirm("继续将删除？")){
            $.ajax({
                url:"{{url("admin/students/del-action")}}",
                type:"post",
                data:{
                    "stu_num": stu_num,
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
                        $("#"+stu_num).slideUp(function () {
                            $("#"+stu_num).remove();
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
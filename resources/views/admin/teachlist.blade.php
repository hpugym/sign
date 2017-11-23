<style type="text/css">
    /*
   导航栏激活样式
*/
    #onactive-system-teacher{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-system-teacher cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-system-teacher i{
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
    #onactive-system-teacher a{
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
        width:300px;
        height: 350px;
        border: 0;
        box-shadow: 5px 5px 8px gray;
        position: fixed;
        z-index: 1002;
        background: #fff;
        left:50%;
        top:40%;
        margin-top: -100px;
        margin-left: -150px;
        display: none;
    }
    .tools-top{
        width: 300px;
        border: 0;
        background: silver;
        height: 40px;
        line-height: 40px;
    }
    .tools-top span:hover{
        color: #fff;
    }
    .tools-bottom{
        width: 300px;
        line-height: 30px;
        font-size: 16px;
        margin-top: 20px;
    }
    .tools-bottom label{
        margin-left: 30px;
        font-size: 18px;
    }
    .tools-bottom select{
        width: 120px;
        margin-left: 0px;
        text-align: center;
        height: 30px;
        margin-top: 20px;
    }
    .tools-bottom input{
        width: 120px;
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
        margin-left: 90px;
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
            您的位置：系统管理->教师列表
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="{{url("admin/teacher/add")}}"><b>新增教师</b></a></span>
        </div>
        <div class="main-content">
            <div class="content-list">
                <div class="require">
                    <label>教师号:</label>
                    <input type="text" name="require">
                    <button id="require_btn">查找</button>
                </div>
                <table class="table table-striped table-bordered table-hover table table-condensed">
                    <tr>
                        <td width="40">序号</td>
                        <td width="90">工号</td>
                        <td>姓名</td>
                        <td width="40">性别</td>
                        <td width="60">职称</td>
                        <td>学院</td>
                        <td>系别</td>
                        <td width="120">手机号</td>
                        <td>办公地址</td>
                        <td width="80">头像</td>
                        <td width="80">操作</td>
                    </tr>
                    @if(count($teachers) == 0)
                        <tr>
                            <td colspan="9">教师信息不存在</td>
                        </tr>
                    @else
                        @foreach($teachers as $teacher)
                            <tr id="{{$teacher->teach_id}}">
                                <td>{{$count++}}</td>
                                <td>{{$teacher->teach_id}}</td>
                                <td id="{{$teacher->teach_id}}-name">{{$teacher->teach_name}}</td>
                                <td id="{{$teacher->teach_id}}-sex">{{$teacher->teach_sex}}</td>
                                <td id="{{$teacher->teach_id}}-level">{{$teacher->teach_level}}</td>
                                <td>{{$teacher->teach_college}}</td>
                                <td>{{$teacher->teach_depart}}</td>
                                <td>{{$teacher->teach_phone}}</td>
                                <td>{{$teacher->teach_add}}</td>
                                <td><img src="@if(empty($teacher->teach_image)){{url('./upload/uploadfiles/default.jpg')}} @else {{url("$teacher->teach_image")}} @endif" style="width: 64px; height: 64px; border-radius: 64px; overflow: hidden;"></td>
                                <td>
                                    @if($teacher->user_type == 1)
                                        <a href="javascript:void(0)" style="color:silver">已是管理员</a>&nbsp;
                                    @else
                                        <a href="javascript:admin({{$teacher->user_id}})" id="{{$teacher->user_id}}-action">置为管理员</a>&nbsp;
                                    @endif
                                    <a href="javascript:passReset({{$teacher->user_id}})">密码重置</a>&nbsp;
                                    <a href="javascript:edit({{$teacher->teach_id}})">修改</a>&nbsp;
                                    <a href="javascript:del({{$teacher->teach_id}})">删除</a>
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
        <input type="hidden" name="teach_id">
        <label>教师姓名:</label>
        <input type="text" name="teach_name"><br/>
        <label>教师性别:</label>
        <select id="teach_sex">
            <option value="男">男</option>
            <option value="女">女</option>
        </select><br/>
        <label>教师职称:</label>
        <input type="text" name="teach_level"><br/>
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
                window.location.href="{{url("admin/teachers?require=")}}"+require;
            }
        });

        $("#status_save").click(function () {
            $("#status_save").html("保存中...")
            $("#status_save").attr("disabled",true);
            $("#status_save").css("cursor","not-allowed");

            var teach_name = $("input[name='teach_name']").val();
            var teach_level = $("input[name='teach_level']").val();
            var teach_sex = $("#teach_sex option:selected").val();
            var teach_id = $("input[name='teach_id']").val();

            $.ajax({
                url:"{{url("admin/teacher/edit-action")}}",
                type:"post",
                data:{
                    "teach_name": teach_name,
                    "teach_level":  teach_level,
                    "teach_sex": teach_sex,
                    'teach_id': teach_id,
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
                    if(data2.code == "0000") {
                        $("#"+teach_id+"-name").html(teach_name);
                        $("#"+teach_id+"-sex").html(teach_sex);
                        $("#"+teach_id+"-level").html(teach_level);
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
    function edit(teach_id) {
        var name = $("#"+teach_id+"-name").html();
        var sex = $("#"+teach_id+"-sex").html();
        var level =$("#"+teach_id+"-level").html();

        $("input[name='teach_name']").val(name);
        $("input[name='teach_level']").val(level);
        $("input[name='teach_id']").val(teach_id);
        $("#teach_sex").find("option[value='"+sex+"']").attr("selected",true);
        $(".tools-ceng").show();
        $(".tools-content").show();
    }
    function del(teach_id){
        if(confirm("继续将删除？")){
            $.ajax({
                url:"{{url("admin/teacher/del-action")}}",
                type:"post",
                data:{
                    "teach_id": teach_id,
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
                        $("#"+teach_id).slideUp(function () {
                            $("#"+teach_id).remove();
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
    //设置为管理员的操作
    function admin(user_id){
        $.ajax({
            url:"{{url("admin/teacher/admin-action")}}",
            type:"post",
            data:{
                "user_id": user_id,
                _token : "{{csrf_token()}}"
            },
            async:"false",
            dataType:"html",
            success:function (data) {

                var data2=JSON.parse(data);

                if(data2.code == "0000") {
                    alert("操作成功");
                    //更改操作栏的显示
                    $("#"+user_id+"-action").html("已是管理员");
                    $("#"+user_id+"-action").css("color","silver");
                    $("#"+user_id+"-action").attr("href","javascript:void(0)");
                }else if(data2.code == "0001"){
                    alert("操作失败");
                }else if(data2.code == "0002"){
                    alert("请求发生错误，请重试");
                }
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }
    //密码重置操作
    function passReset(user_id){
        $.ajax({
            url:"{{url("admin/teacher/passReset-action")}}",
            type:"post",
            data:{
                "user_id": user_id,
                _token : "{{csrf_token()}}"
            },
            async:"false",
            dataType:"html",
            success:function (data) {

                var data2=JSON.parse(data);

                if(data2.code == "0000") {
                    alert("操作成功");
                }else if(data2.code == "0001"){
                    alert("操作失败");
                }else if(data2.code == "0002"){
                    alert("请求发生错误，请重试");
                }
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }

</script>
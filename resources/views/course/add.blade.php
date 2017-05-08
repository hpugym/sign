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
    .content-top-select{
        width: 100%;
        height: 80px;
        border-bottom: 1px solid silver;
        line-height: 30px;
    }
    .content-top-select label{
        margin-left: 120px;
        margin-top: 20px;
        font-size: 18px;
        display: inline-block;
    }
    .content-top-select input{
        width: 240px;
        height: 40px;
        line-height: 40px;
        margin-left: 20px;
        margin-top: 20px;
        display: inline-block;
    }
    .content-top-select button{
        width: 120px;
        height: 40px;
        display: inline-block;
        margin-left: 20px;
        margin-top: 20px;
        font-size: 18px;
    }
    .content-bottom-content{
        width: 100%;
        min-height: 500px;
        border: 1px solid transparent;
    }
    .course_info{
        width: 100%;
        min-height: 60px;
        height: auto;
        border: 1px solid silver;
        border-top: 0;
    }
    .course_info label{
        line-height: 30px;
        font-size: 16px;
        margin-left: 120px;
    }
    .course_info p{
        line-height: 30px;
        font-size: 14px;
        margin-left: 120px;
        margin-top: 0;
        margin-bottom: 0;
    }
    .input_info label{
        border: 0;
        width: 80px;
        height: 40px;
        line-height: 40px;
        text-align: left;
        font-size: 15px;
        margin-left: 120px;
    }
    .input_info input{
        border: 1px solid #d4e7f0;
        width: 400px;
        height: 40px;
        line-height: 40px;
        font-size: 14px;
        margin-top: 20px;
    }
    #submit_btn{
        background:#3B95C8;
        color: white;
        font-size:24px;
        width: 160px;
        margin-top: 30px;
        margin-bottom: 60px;
        margin-left: 240px;
    }
    #submit_notice{
        height: 30px;
        line-height: 30px;
        font-size: 20px;
        margin-left: 50px;
        color: red;
        text-align: left;
        border:0;
        display: inline-block;
    }
    #submit_btn_notice{
        color: black;
        display: inline-block;
        padding-left: 10px;
    }
</style>
@extends('common.template')
@section("title")
    新增课程
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
            您的位置：课程管理->新增课程
        </div>
        <div class="main-content">
            <div class="content-navi">
                <a href="{{url("course/list")}}"><button style="background: #f9f9f9;">课程列表</button></a>
                <a href="{{url("course/add")}}"><button style="color: white;">新增课程</button></a>
            </div>
            <div class="content-top-select">
                <label>请输入课程号</label>
                <input type="text" name="course_num">
                <button id="check">检查</button>
            </div>
            <div class="content-bottom-content" style="display: none;">
                <div class="course_info">
                    <label>课程号：<span id="course_num">---</span></label>
                    <label>课程名：<span id="course_name">---</span></label>
                    <label>课程类型：<span id="course_type">---</span></label>
                    <p>
                        <b>课程简介:&nbsp;&nbsp;</b><span id="course_intro">---</span>
                    </p>
                </div>
                <div class="input_info">
                    <label>课程学时:</label>
                    <input type="text" name="teachs_time"><br/>
                    <label>课程学分:</label>
                    <input type="text" name="teachs_grade"><br/>
                    <label>上课学生:</label>
                    <input type="text" name="teachs_stu"><br/>
                    <label>课程容量:</label>
                    <input type="text" name="teachs_avai"><br/>
                    <label>授课地点:</label>
                    <input type="text" name="teachs_add"><span style="font-size: 10px; color: red; display: inline-block; margin-left: 10px;">例：周一：第7-8节：计算机102|周二：第3-4节：计算机103</span><br/>
                    <label>授课状态:</label>
                    <input type="text" name="teachs_status"><span style="font-size: 10px; color: red; display: inline-block; margin-left: 10px;">注：课程未结束，填写0，课程结束填写1</span><br/>
                    <input id="submit_btn" type="button" name="submit" value="保存">
                    <span id="submit_notice" style="display: none">Notice:<span id="submit_btn_notice">234234234</span></span>
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

        $("#check").click(function () {
            var course_num = $("input[name='course_num']");
            $.ajax({
                url:"{{url("course/add-checking")}}",
                type:"post",
                data:{
                    "course_num": course_num.val(),
                    _token: "{{csrf_token()}}"//注意验证_token的添加
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
//                    alert('成功！'+typeof(data)+data);
//                    alert(typeof(data2)+"code:"+data2.code);
                    if(data2.code == "0000"){
                        $(".content-bottom-content").show();
                        $("#course_num").html(data2.course_num);
                        $("#course_name").html(data2.course_name);
                        $("#course_type").html(data2.course_type);
                        $("#course_intro").html(data2.course_intro)
                    }else if(data2.code == "0001"){
                        alert("该课程不存在，请检查课程号输入");
                    }else if(data2.code == "0002"){
                        alert("数据加载失败，请重试");
                    }else if(data2.code == "0003"){
                        alert("已经添加过该课程，请重新输入课程号");
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);

                }
            });
        });
        
        $("#submit_btn").click(function () {
            $(this).val("正在保存...");
            $(this).attr("disabled","true");
            $(this).css("cursor","not-allowed");
            $("#submit_notice").css("display","none");
            $("#submit_btn_notice").html("");
            var teachs_time     = $("input[name='teachs_time']");
            var teachs_grade    = $("input[name='teachs_grade']");
            var teachs_stu      = $("input[name='teachs_stu']");
            var teachs_avai     = $("input[name='teachs_avai']");
            var teachs_add      = $("input[name='teachs_add']");
            var teachs_status   = $("input[name='teachs_status']");

            if(teachs_time.val() == ""){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("上课学时不能为空");
            }else if(teachs_grade == ""){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("课程学分不能为空");
            }else if(teachs_stu.val() == ""){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("授课学生不能为空");
            }else if(teachs_avai.val() == ""){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("课程容量不能为空");
            }else if(teachs_add.val() == ""){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("上课时间地点不能为空");
            }else if(teachs_status.val() == ""){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("您目前的课程状态是？");
            }else if(teachs_status.val() !=1 && teachs_status.val() !=0){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("课程状态输入不合法");
            }else{
                $.ajax({
                    url:"{{url("course/add-action")}}",
                    type:"post",
                    data:{
                        "course_num": $("#course_num").html(),
                        "teach_id":  "{{session()->get("teach_id")}}",
                        "teachs_time":  teachs_time.val(),
                        "teachs_grade": teachs_grade.val(),
                        "teachs_stu":   teachs_stu.val(),
                        "teachs_avai":  teachs_avai.val(),
                        "teachs_add":   teachs_add.val(),
                        "teachs_status":teachs_status.val()
                    },
                    async:"false",
                    dataType:"html",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (data) {

                        var data2=JSON.parse(data);
//                            alert('成功！'+typeof(data)+data);
//                            alert(typeof(data2)+"code:"+data2.code);
                        if(data2.code == "0000") {
                            $("#submit_btn").val("保存");//杜绝再次保存
//                            $("#submit_btn").removeAttr("disabled");
//                            $("#submit_btn").css("cursor","pointer");
                            $("#submit_notice").css("display","inline-block");
                            $("#submit_btn_notice").html("添加成功");
                            setTimeout(function () {
                                $("#submit_notice").css("display","none");
                            },1000);
                        }else if(data2.code == "0001"){
                            $("#submit_btn").val("保存");
                            $("#submit_btn").removeAttr("disabled");
                            $("#submit_btn").css("cursor","pointer");
                            $("#submit_notice").css("display","inline-block");
                            $("#submit_btn_notice").html("添加失败");
                        }else if(data2.code == "0002"){
                            $("#submit_btn").val("保存");
                            $("#submit_btn").removeAttr("disabled");
                            $("#submit_btn").css("cursor","pointer");
                            $("#submit_notice").css("display","inline-block");
                            $("#submit_btn_notice").html("请求失败");
                        }
                    },
                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            }
        });
    }
</script>
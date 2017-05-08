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
        border: 0;
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
            <input type="hidden" name="teachs_code" value="{{$teachs_code}}">
            <div class="content-top-select">
                <label>请输入学生学号</label>
                <input type="text" name="stu_num">
                <button id="check">查找学生</button>
            </div>
            <div class="content-bottom-content" style="display: none">
                <div class="input_info">
                    <img id="stu_image" src="" style="width: 64px; border-radius: 64px; overflow: hidden; margin-left: 120px; margin-top: 20px;"><br/>
                    <input type="hidden" name="stu_openid" value="">
                    <label>学生学号:</label>
                    <input type="text" name="stu_num" value="--" readonly><br/>
                    <label>学生姓名:</label>
                    <input type="text" name="stu_name" value="--" readonly><br/>
                    <label>学生性别:</label>
                    <input type="text" name="stu_sex" value="--" readonly><br/>
                    <label>学生班级:</label>
                    <input type="text" name="stu_class" value="--" readonly><br/>
                    <label>学生学院:</label>
                    <input type="text" name="stu_college" value="--" readonly><br/>
                    <label>学生电话:</label>
                    <input type="text" name="stu_phone" value="---" readonly><br/>
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
            var stu_num = $("input[name='stu_num']");
            if(stu_num.val() == ""){
                alert("请输入学号");
            }else{
                $.ajax({
                    url:"{{url("student/add-checking")}}",
                    type:"post",
                    data:{
                        "stu_num": stu_num.val(),
                        "teachs_code": $("input[name='teachs_code']").val(),
                        _token: "{{csrf_token()}}"//注意验证_token的添加
                    },
                    async:"false",
                    dataType:"html",
                    success:function (data) {

                        var data2=JSON.parse(data);
//                    alert('成功！'+typeof(data)+data);
//                    alert(typeof(data2)+"code:"+data2.code);
                        if(data2.code == "0000"){
                            //alert(data2.student['stu_num']);
                            $("input[name='stu_num']").val(data2.student['stu_num']);
                            $("input[name='stu_name']").val(data2.student['stu_name']);
                            $("input[name='stu_sex']").val(data2.student['stu_sex']);
                            $("input[name='stu_class']").val(data2.student['stu_class']);
                            $("input[name='stu_college']").val(data2.student['stu_college']);
                            $("input[name='stu_phone']").val(data2.student['stu_phone']);
                            $("input[name='stu_openid']").val(data2.student['stu_openid']);
                            $("#stu_image").attr("src",data2.student['stu_image']);
                            $(".content-bottom-content").show();
                        }else if(data2.code == "0001"){
                            alert("该学生不存在");
                        }else if(data2.code == "0002"){
                            alert("数据加载失败，请重试");
                        }else if(data2.code == "0003"){
                            alert("该学生未关注微信公众号，请提醒");
                        }else if(data2.code == "0004"){
                            alert("该学生已经被添加");
                        }
                    },
                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);

                    }
                });
            }

        });

        $("#submit_btn").click(function () {
            $(this).val("正在保存...");
            $(this).attr("disabled","true");
            $(this).css("cursor","not-allowed");
            $("#submit_notice").css("display","none");
            $("#submit_btn_notice").html("");
            var teachs_code     = $("input[name='teachs_code']");
            var stu_openid    = $("input[name='stu_openid']");
            if(teachs_code.val() == ""){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("操作错误，数据未正确加载");
            }else if(stu_openid == ""){
                $(this).val("保存");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $("#submit_notice").css("display","inline-block");
                $("#submit_btn_notice").html("操作错误，数据未正确加载");
            }else{
                $.ajax({
                    url:"{{url("student/add-action")}}",
                    type:"post",
                    data:{
                        "teachs_code": teachs_code.val(),
                        "stu_openid":  stu_openid.val(),
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
                            $("#submit_btn").val("保存");
                            $("#submit_btn").removeAttr("disabled");
                            $("#submit_btn").css("cursor","pointer");
                            $("#submit_notice").css("display","inline-block");
                            $("#submit_btn_notice").html("添加成功");
                            window.location.href="{{url("student/list")}}"+"/"+teachs_code.val();//跳转至本课程下的学生列表

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
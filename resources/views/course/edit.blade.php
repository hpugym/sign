<meta name="csrf-token" content="{{ csrf_token() }}">
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
    .content-list label{
        border: 0;
        width: 120px;
        height: 40px;
        line-height: 40px;
        text-align: left;
        font-size: 18px;
        margin-left: 120px;
    }
    .content-list input{
        border: 0;
        width: 400px;
        height: 40px;
        line-height: 40px;
        font-size: 16px;
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
    课程编辑
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
            您的位置：课程管理->课程编辑
        </div>
        <div class="main-content">
            <div class="content-navi">
                <a href="{{url("course/list")}}"><button style="background: #f9f9f9;">课程列表</button></a>
                <a href="{{url("course/add")}}"><button style="background: #f9f9f9;">新增课程</button></a>
            </div>
            <div class="content-list">
                <input type="hidden" name="teachs_code" value="{{$id}}">
                <label style="margin-top: 50px;">课程号:</label>
                <input type="text" name="course_num" value="{{$teachs->course_num}}" readonly style="cursor: not-allowed"><br/>
                <label>课程名:</label>
                <input type="text" name="course_name" value="{{$name}}" readonly style="cursor: not-allowed"><br/>
                <label>课程学时:</label>
                <input type="text" name="teachs_time" value="{{$teachs->teachs_time}}"><br/>
                <label>课程学分:</label>
                <input type="text" name="teachs_grade" value="{{$teachs->teachs_grade}}"><br/>
                <label>上课学生:</label>
                <input type="text" name="teachs_stu" value="{{$teachs->teachs_stu}}"><br/>
                <label>课程容量:</label>
                <input type="text" name="teachs_avai" value="{{$teachs->teachs_avai}}"><br/>
                <label>授课地点:</label>
                <input type="text" name="teachs_add" value="{{$teachs->teachs_add}}"><span style="font-size: 10px; color: red; display: inline-block; margin-left: 10px;">例：周一：第7-8节：计算机102|周二：第3-4节：计算机103</span><br/>
                <label>授课状态:</label>
                <input type="text" name="teachs_status" value="{{$teachs->teachs_status}}"><br/>
                <input id="submit_btn" type="button" name="submit" value="保存">
                <span id="submit_notice" style="display: none">Notice:<span id="submit_btn_notice">234234234</span></span>
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
            }else{
                $.ajax({
                    url:"{{url("course/edit-action")}}",
                    type:"post",
                    data:{
                        "teachs_code":  $("input[name='teachs_code']").val(),
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
                            $("#submit_btn").val("保存");
                            $("#submit_btn").removeAttr("disabled");
                            $("#submit_btn").css("cursor","pointer");
                            $("#submit_notice").css("display","inline-block");
                            $("#submit_btn_notice").html("保存成功");
                            setTimeout(function () {
                                $("#submit_notice").css("display","none");
                            },1000);
                        }else if(data2.code == "0001"){
                            $("#submit_btn").val("保存");
                            $("#submit_btn").removeAttr("disabled");
                            $("#submit_btn").css("cursor","pointer");
                            $("#submit_notice").css("display","inline-block");
                            $("#submit_btn_notice").html("保存失败");
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
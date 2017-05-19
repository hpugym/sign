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
    .main-content label{
        margin-left: 60px;
        font-size: 18px;
        margin-top: 30px;
        line-height: 40px;
    }
    .main-content select{
        width: 280px;
        margin-left: 10px;
        text-align: center;
        height: 40px;
        margin-top: 30px;
    }
    .main-content input{
        width: 280px;
        height: 40px;
        margin-top: 30px;
        margin-left: 10px;
    }
    .main-content button{
        display: inline-block;
        width: 180px;
        height: 40px;
        margin: auto;
        background: silver;
        border: 0;
        margin-left: 150px;
        margin-top: 20px;
        font-size: 20px;
        color: white;
        background: #3C96C8;
    }
    .main-content textarea{
        margin-left: 10px;
        margin-top: 30px;
        width: 400px;
        height: 150px;
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
            您的位置：系统管理->新增课程
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="{{url("admin/course/add")}}"><b>新增课程</b></a></span>
        </div>
        <div class="main-content">
            <label style="margin-top: 60px;">课程编号:</label>
            <input type="text" name="course_num" placeholder="请输入课程编号"  onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"><br/>
            <label>课程名称:</label>
            <input type="text" name="course_name" placeholder="请输入课程名称" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"><br/>
            <label>课程属性:</label>
            <select id="course_type">
                <option value="必修">必修</option>
                <option value="公共选修">公共选修</option>
                <option value="专业选修">专业选修</option>
                <option value="通识教育">通识教育</option>
            </select><br/>
            <label>课程简介:</label>
            <textarea name="course_intro" placeholder="这里输入简介..."  onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"></textarea><br/>
            <button id = "status_save">保存</button>

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

        $("#status_save").click(function(){
            $("#status_save").html("保存中...")
            $("#status_save").attr("disabled", true);
            $("#status_save").css("cursor", "not-allowed");

            var course_num = $("input[name='course_num']").val();
            var course_name = $("input[name='course_name']").val();
            var course_intro = $("textarea[name='course_intro']").val();
            var course_type = $("#course_type option:selected").val();

            if(/[@#￥{}\$%\^&\*]+/g.test(course_num)){
                alert("课程编号非法");
                $("input[name='course_num']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor", "pointer");
            }else if(/[@#￥{}\$%\^&\*]+/g.test(course_name)){
                alert("课程名不能包含非法字符");
                $("input[name='course_name']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor", "pointer");
            }else{
                $.ajax({
                    url: "{{url("admin/course/add-action")}}",
                    type: "post",
                    data: {
                        "course_num": course_num,
                        "course_name": course_name,
                        "course_type": course_type,
                        'course_intro': course_intro,
                        _token: "{{csrf_token()}}"
                    },
                    async: "false",
                    dataType: "html",
                    success: function (data) {

                        var data2 = JSON.parse(data);
                        if (data2.code == "0000") {
                            alert("添加成功");
                            window.location.href="{{url("admin/courses")}}";
                        } else if (data2.code == "0001") {
                            alert("添加失败");
                        } else if (data2.code == "0002") {
                            alert("请求发生错误，请重试");
                        }else if(data2.code == "0003"){
                            alert("该课程已存在");
                        }
                        $("#status_save").html("保存");
                        $("#status_save").removeAttr("disabled");
                        $("#status_save").css("cursor", "pointer");
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                        $("#status_save").html("保存");
                        $("#status_save").removeAttr("disabled");
                        $("#status_save").css("cursor", "pointer");
                    },
                });
            }
        });
    }
</script>
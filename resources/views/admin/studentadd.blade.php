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
        margin-top: 40px;
        font-size: 20px;
        color: white;
        background: #3C96C8;
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
            您的位置：系统管理->新增学生
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="#"><b>新增学生</b></a></span>
        </div>
        <div class="main-content">
            <label style="margin-top: 60px;">学生学号:</label>
            <input type="text" name="stu_num"><br/>
            <label>学生姓名:</label>
            <input type="text" name="stu_name" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"><br/>
            <label>学生性别:</label>
            <select id="stu_sex">
                <option value="男">男</option>
                <option value="女">女</option>
            </select><br/>
            <label>专业班级:</label>
            <input type="text" name="stu_class" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"><br/>
            <label>所在学院:</label>
            <select id="stu_college">
                <option value="安全科学与工程学院">安全科学与工程学院</option>
                <option value="能源科学与工程学院">能源科学与工程学院</option>
                <option value="资源环境学院">资源环境学院</option>
                <option value="机械与动力工程学院">机械与动力工程学院</option>
                <option value="测绘与国土信息学院">测绘与国土信息学院</option>
                <option value="材料科学与工程学院">材料科学与工程学院</option>
                <option value="电器工程与自动化学院">电器工程与自动化学院</option>
                <option value="土木工程学院">土木工程学院</option>
                <option value="计算机科学与技术学院">计算机科学与技术学院</option>
                <option value="工商管理学院">工商管理学院</option>
                <option value="财经学院">财经学院</option>
                <option value="数学与信息科学学院">数学与信息科学学院</option>
                <option value="马克思主义学院学院">马克思主义学院学院</option>
                <option value="物理与电子信息学院学院">物理与电子信息学院学院</option>
                <option value="化学化工学院学院">化学化工学院学院</option>
                <option value="外国语学院">外国语学院</option>
                <option value="建筑与艺术设计学院">建筑与艺术设计学院</option>
                <option value="应急管理学院">应急管理学院</option>
                <option value="文法学院">文法学院</option>
                <option value="体育学院">体育学院</option>
                <option value="音乐学院">音乐学院</option>
                <option value="医学院">医学院</option>
            </select><br/>
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


        $("#status_save").click(function () {
            $("#status_save").html("保存中...")
            $("#status_save").attr("disabled", true);
            $("#status_save").css("cursor", "not-allowed");

            var stu_num = $("input[name='stu_num']").val();
            var stu_name = $("input[name='stu_name']").val();
            var stu_sex = $("#stu_sex option:selected").val();
            var stu_class = $("input[name='stu_class']").val();
            var stu_college = $("#stu_college option:selected").val();

            if(stu_num == ""){
                alert("学号不能为空");
                $("input[name='stu_num']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor", "pointer");
            }else if(stu_num.length != 12){
                alert("学号格式有误，12位学号");
                $("input[name='stu_num']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor", "pointer");
            }else if(!(/^\d{12}$/.test(stu_num))){
                alert("学号格式有误，12位数字");
                $("input[name='stu_num']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor", "pointer");
            }else if(stu_name == ""){
                alert("姓名不能为空");
                $("input[name='stu_name']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor", "pointer");
            }else if(/[@#￥{}\$%\^&\*]+/g.test(stu_name)){
                alert("姓名不能包含非法字符");
                $("input[name='stu_name']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor", "pointer");
            }else if(stu_class == ""){
                alert("专业班级必填");
                $("input[name='stu_class']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor", "pointer");
            }else{
                $.ajax({
                    url: "{{url("admin/students/add-action")}}",
                    type: "post",
                    data: {
                        "stu_num": stu_num,
                        "stu_name": stu_name,
                        "stu_sex": stu_sex,
                        'stu_class': stu_class,
                        'stu_college': stu_college,
                        _token: "{{csrf_token()}}"
                    },
                    async: "false",
                    dataType: "html",
                    success: function (data) {

                        var data2 = JSON.parse(data);
                        if (data2.code == "0000") {
                            alert("添加成功");
                            window.location.href="{{url("admin/students")}}";
                        } else if (data2.code == "0001") {
                            alert("添加失败");
                        } else if (data2.code == "0002") {
                            alert("请求发生错误，请重试");
                        }else if(data2.code == "0003"){
                            alert("该学生已存在");
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
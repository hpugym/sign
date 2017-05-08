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
    .main-content label{
        width: 120px;
        height: 40px;
        line-height: 40px;
        text-align: right;
        font-size: 18px;
        margin-top: 30px;
    }
    .main-content select{
        width: 320px;
        margin-left: 20px;
        text-align: center;
        height: 40px;
        margin-top: 20px;
        font-size: 18px;

    }
    .main-content input{
        width: 320px;
        height: 40px;
        margin-top: 20px;
        font-size: 18px;
        margin-left: 20px;
    }
    .main-content button{
        display: inline-block;
        width: 220px;
        height: 40px;
        margin: auto;
        background: #3D96C9;
        border: 0;
        margin-left: 140px;
        margin-top: 40px;
        font-size: 22px;
        color: white;
    }
</style>
@extends('common.template')
@section("title")
    新增教师
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
            您的位置：系统管理->新增教师
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="{{url("admin/teacher/add")}}"><b>新增教师</b></a></span>
        </div>
        <div class="main-content">
            <label style="margin-top: 60px;">系统ID:</label>
            <input type="text" readonly  name="teach_id" style="border: 0; color: red;" value="{{$user_id}}"><br/>
            <label>教师姓名:</label>
            <input type="text" name="teach_name" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"><br/>
            <label>教师性别:</label>
            <select id="teach_sex">
                <option value="男">男</option>
                <option value="女">女</option>
            </select><br/>
            <label>教师职称:</label>
            <input type="text" name="teach_level" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"><br/>
            <label>教师隶属:</label>
            <select id="teach_college">
                <option value="101">安全科学与工程学院</option>
                <option value="102">能源科学与工程学院</option>
                <option value="103">资源环境学院</option>
                <option value="104">机械与动力工程学院</option>
                <option value="105">测绘与国土信息学院</option>
                <option value="106">材料科学与工程学院</option>
                <option value="107">电器工程与自动化学院</option>
                <option value="108">土木工程学院</option>
                <option value="109">计算机科学与技术学院</option>
                <option value="110">工商管理学院</option>
                <option value="111">财经学院</option>
                <option value="112">数学与信息科学学院</option>
                <option value="113">马克思主义学院学院</option>
                <option value="114">物理与电子信息学院学院</option>
                <option value="115">化学化工学院学院</option>
                <option value="116">外国语学院</option>
                <option value="117">建筑与艺术设计学院</option>
                <option value="118">应急管理学院</option>
                <option value="119">文法学院</option>
                <option value="120">体育学院</option>
                <option value="121">音乐学院</option>
                <option value="122">医学院</option>
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
            $("#status_save").attr("disabled",true);
            $("#status_save").css("cursor","not-allowed");

            var teach_name = $("input[name='teach_name']").val();
            var teach_level = $("input[name='teach_level']").val();
            var teach_sex = $("#teach_sex option:selected").val();
            var teach_college = $("#teach_college option:selected").val();
            var teach_id = $("input[name='teach_id']").val();
            if(teach_name == ""){
                alert("姓名不能为空");
                $("input[name='teach_name']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor","pointer");
            }else if(/[@#￥{}\$%\^&\*]+/g.test(teach_name)){
                alert("姓名不能包含非法字符");
                $("input[name='teach_name']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor","pointer");
            }else if(teach_level == ""){
                alert("职称不能为空");
                $("input[name='teach_level']").focus();
                $("#status_save").html("保存");
                $("#status_save").removeAttr("disabled");
                $("#status_save").css("cursor","pointer");
            }else{
                $.ajax({
                    url:"{{url("admin/teacher/add-action")}}",
                    type:"post",
                    data:{
                        "teach_name": teach_name,
                        "teach_level":  teach_level,
                        "teach_sex": teach_sex,
                        'teach_id': teach_id,
                        'teach_college': teach_college,
                        _token : "{{csrf_token()}}"
                    },
                    async:"false",
                    dataType:"html",
                    success:function (data) {

                        var data2=JSON.parse(data);
                        if(data2.code == "0000") {
                            alert("添加成功");
                            window.location.href = "{{url("admin/teachers")}}";
                        }else if(data2.code == "0001"){
                            alert("添加失败");
                        }else if(data2.code == "0002"){
                            alert("请求发生错误，请重试");
                        }
                        $("#status_save").html("保存");
                        $("#status_save").removeAttr("disabled");
                        $("#status_save").css("cursor","pointer");
                    },
                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                        $("#status_save").html("保存");
                        $("#status_save").removeAttr("disabled");
                        $("#status_save").css("cursor","pointer");
                    },
                });
            }
        });
    }

</script>
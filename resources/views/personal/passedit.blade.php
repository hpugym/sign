<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
    /*
        导航栏激活样式
    */
    #onactive-personal-passedit{
        position:relative;
        background:url(../images/libg.png) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-personal-passedit cite{
        background:url(../images/list1.gif) no-repeat;
    }
    #onactive-personal-passedit i{
        display:block;
        background:url(../images/sj.png) no-repeat;
        background-size: 10px 25px;
        width:10px;
        height:25px;
        position:absolute;
        right:0;
        z-index:1000;
        top:3px;
        right:-1px;
    }
    #onactive-personal-passedit a{
        color:#fff;
        text-decoration: none;
    }
    /* 展开子菜单*/
    #onactive-father-personal{
        display: block;
    }
    /*
        我的资料主要样式
    */
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
        height: 560px;
    }
    .main-content input[name='oldPass']{
        margin-top: 100px;
    }
    .main-content input{
        width: 300px;
        height: 30px;
        margin-top: 30px;
        margin-left: 20px;
        line-height: 30px;
        font-size: 16px;
    }
    .main-content label{
        line-height: 30px;
        font-size: 16px;
        margin-left: 150px;
    }
    #passEditBtn{
        width: 140px;
        height: 40px;
        font-size: 17px;
        color: white;
        background:#3A94C8;
        margin-top: 30px;
        margin-left: 275px;
    }
    .content-notice{
        width: 300px;
        height: 30px;
        font-size: 14px;
        border: 0;
        margin-top: 30px;
        margin-left: 275px;
        line-height: 30px;
        color: red;
    }
</style>
@extends('common.template')
@section("title")
    个人中心
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
            您的位置：个人中心->密码修改
        </div>
        <div class="main-content">
            <label>请输入旧密码:</label>
            <input type="password" name="oldPass"><br/>
            <label>请输入新密码:</label>
            <input type="password" name="newPassA"><br/>
            <label>请确认新密码:</label>
            <input type="password" name="newPassB"><br/>

            <button id="passEditBtn">修改</button>
            <div class="content-notice"></div>
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

        $("#passEditBtn").click(function () {
            $(this).attr("disabled","true");
            $(this).css("cursor","not-allowed");
            $(this).text("正在处理...");
            var oldPass   = $("input[name='oldPass']");
            var newPassA  = $("input[name='newPassA']");
            var newPassB  = $("input[name='newPassB']");

            if(oldPass.val() == ""){
                $(".content-notice").css("color","red");
                $(".content-notice").html("Notice: 旧密码不能为空");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $(this).text("修改");
            }else if(newPassA.val() == ""){
                $(".content-notice").css("color","red");
                $(".content-notice").html("新密码不能为空");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $(this).text("修改");
            }else if(newPassA.val() != newPassB.val()){
                $(".content-notice").css("color","red");
                $(".content-notice").html("新旧密码不一致");
                $(this).removeAttr("disabled");
                $(this).css("cursor","pointer");
                $(this).text("修改");
            }else{

                $.ajax({
                        url:"{{url("./personal/editpass")}}",
                        type:"post",
                        data:{
                            "oldPass" : oldPass.val(),
                            "newPassA": newPassA.val(),
                            "newPassB": newPassB.val()
                        },
                        async:"false",
                        dataType:"html",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function (data) {

                            var data2=JSON.parse(data);
//                                alert('成功！'+typeof(data)+data);
//                                alert(typeof(data2)+"code:"+data2.code);
                            if(data2.code == "0000"){
                                $(".content-notice").css("color","#3a94c8");
                                $(".content-notice").html("修改成功！");
                                $("#passEditBtn").removeAttr("disabled");
                                $("#passEditBtn").css("cursor","pointer");
                                $("#passEditBtn").text("修改");
                                $("input").val("");//清空
                                setTimeout(function () {
                                    $(".content-notice").html("");
                                },1000);
                            }else if(data2.code == "0001"){
                                $(".content-notice").css("color","red");
                                $(".content-notice").html("新旧密码不一致");
                                $("#passEditBtn").removeAttr("disabled");
                                $("#passEditBtn").css("cursor","pointer");
                                $("#passEditBtn").text("修改");
                            }else if(data2.code == "0002"){
                                $(".content-notice").css("color","red");
                                $(".content-notice").html("输入原密码错误");
                                $("#passEditBtn").removeAttr("disabled");
                                $("#passEditBtn").css("cursor","pointer");
                                $("#passEditBtn").text("修改");
                            }else if(data2.code == "0003"){
                                $(".content-notice").css("color","gray");
                                $(".content-notice").html("修改失败，请重试！");
                                $("#passEditBtn").removeAttr("disabled");
                                $("#passEditBtn").css("cursor","pointer");
                                $("#passEditBtn").text("修改");
                                setTimeout(function () {
                                    $(".content-notice").html("");
                                },1000);
                            }else if(data2.code == "0004"){
                                $(".content-notice").css("color","red");
                                $(".content-notice").html("加载数据失败");
                                $("#passEditBtn").removeAttr("disabled");
                                $("#passEditBtn").css("cursor","pointer");
                                $("#passEditBtn").text("修改");
                            }
                        },
                        error:function (XMLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown);
                            $(".content-notice").css("color","black");
                            $(".content-notice").html("网络错误！");
                            $("#passEditBtn").removeAttr("disabled");
                            $("#passEditBtn").css("cursor","pointer");
                            $("#passEditBtn").text("修改");
                            setTimeout(function () {
                                $(".content-notice").html("");
                            },1000);
                        }
                    });
            }
        });
    }
</script>
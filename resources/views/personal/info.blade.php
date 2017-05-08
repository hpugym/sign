<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
    /*
        导航栏激活样式
    */
    #onactive-personal-info{
        position:relative;
        background:url(../images/libg.png) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-personal-info cite{
        background:url(../images/list1.gif) no-repeat;
    }
    #onactive-personal-info i{
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
    #onactive-personal-info a{
        color:#fff;
        text-decoration: none;
    }
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
        height: 729px;
    }
    .content-list{
        border: 0;
        width: 92%;
        height: 729px;
        margin-left: 4%;
        margin-right: 4%;
        font-size: 16px;

    }
    .list-detial{
        border: 1px solid silver;
        width: 600px;
        height: 32px;
        margin-left: 100px;
        margin-top: 10px;
        line-height: 30px;
        border: 0;
    }
    .list-detial input{
        width: 400px;
        height: 30px;
        border: 0;
        margin-left: 10px;

    }
    #list-detail-photo{
        height: 120px;
    }
    #list-detail-photo img{
        height: 120px;
        margin-left: 10px;
        border: 1px solid transparent;
        border-radius: 120px;
        overflow: hidden;
    }
    #edit_btn,#submit_btn{
        width: 100px;
        background: #3A94C8;
        margin-left: 100px;

    }
    #submit_btn{
        display: none;
    }
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
    .photo-upload-banner{
        position: fixed;
        width: 400px;
        height: 200px;
        background: white;
        z-index: 1000;
        left: 50%;
        top: 50%;
        margin-left: -200px;
        margin-top: -100px;
        overflow: hidden;
        box-shadow: gray;
        display: none;
    }
    .photo-upload-banner-top{
        position: relative;
        width: 400px;
        height: 40px;
        border: 1px solid silver;
        background: #3B95C8;
    }
    #photo-upload-close{
        cursor: pointer;
        float: right;
        font-size: 30px;
        line-height: 40px;
        margin-right: 10px;
        color: white;
        border: 0;
    }
    #photo-upload-close:hover{
        color: black;
    }
    .photo-upload-banner-content{
        border: 1px solid silver;
        height: 160px;
        width: 400px;
    }
    #photo-upload-btn-1{
        position: relative;
        border: 0;
        width: 160px;
        height: 40px;
        top:50%;
        left: 50%;
        margin-left: -80px;
        margin-top: -20px;
        background: #3B95C8;
        color: white;
        font-size: 18px;
        line-height: 40px;
    }
    #photo-upload-btn-2,#photo-upload-btn-3{
        position: relative;
        border: 0;
        width: 120px;
        height: 40px;
        top:50%;
        float: left;
        margin-left: 51px;
        margin-top: -20px;
        background: #3B95C8;
        font-size: 18px;
        line-height: 40px;
    }
    #photo-upload-btn-2{
        color: silver;
    }
    #photo-upload-btn-3{
        color: white;
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
            您的位置：个人中心->我的资料
        </div>
        <div class="main-content">
            <div class="content-list">
                <div class="list-detial" style="margin-left: 0; font-size: 18px; border: 0; margin-top: 20px;">
                    <label><b>个人信息：</b></label>
                </div>
                <div class="list-detial" id="list-detail-photo">
                    <img id = "photo-url" src="{{url($personinfo->teach_image == "" ? "./upload/uploadfiles/default.jpg" : $personinfo->teach_image)}}">
                    <span style="margin-left: 10px; display: none;" id="phonto-upload"><a href="javascript:void(0);" id="photo-upload">点击修改</a></span>
                </div>
                <div class="list-detial">
                    <label>我的工号：</label>
                    <input type="text" name="teach_id" class="list-detial-notallowed" readonly="readonly" value="{{$personinfo->teach_id}}">
                </div>
                <div class="list-detial">
                    <label>我的姓名：</label>
                    <input type="text" name="teach_name" class="list-detial-notallowed" readonly="readonly" value="{{$personinfo->teach_name}}">
                </div>
                <div class="list-detial">
                    <label>我的职称：</label>
                    <input type="text" name="teach_level" class="list-detial-notallowed" readonly="readonly" value="{{$personinfo->teach_level}}">
                </div>
                <div class="list-detial">
                    <label>账号类别：</label>
                    <input type="text" name="teach_type" class="list-detial-notallowed" readonly="readonly" value="{{$userinfo->user_type}}">
                </div>

                {{--  可以被修改的输入 --}}
                <div class="list-detial">
                    <label>我的邮箱：</label>
                    <input type="text" name="teach_mail" class="list-detial-notallowed" readonly="readonly" value="{{$userinfo->user_mail}}">
                </div>
                <div class="list-detial">
                    <label>我的电话：</label>
                    <input type="tel" name="teach_phone"  class="list-detial-edit" readonly="readonly" value="{{$personinfo->teach_phone}}">
                </div>
                <div class="list-detial">
                    <label>我的学院：</label>
                    <input type="text" name="teach_college" class="list-detial-edit" readonly="readonly" value="{{$personinfo->teach_college}}">
                </div>
                <div class="list-detial">
                    <label>我的系别：</label>
                    <input type="text" name="teach_depart" class="list-detial-edit" readonly="readonly" value="{{$personinfo->teach_depart}}">
                </div>
                <div class="list-detial">
                    <label>办公地址：</label>
                    <input type="text" name="teach_add" class="list-detial-edit" readonly="readonly" value="{{$personinfo->teach_add}}">
                </div>
                {{--  可以被修改的输入 --}}

                <div class="list-detial">
                    <label>创建时间：</label>
                    <input type="text" name="teach_created" class="list-detial-notallowed" readonly="readonly" value="{{date("Y-m-d H:i:s",$userinfo->user_created)}}">
                </div>
                <div class="list-detial">
                    <label>最近操作：</label>
                    <input type="text" name="teach_action" class="list-detial-notallowed"  readonly="readonly" value="{{date("Y-m-d H:i:s",$userinfo->user_action)}}">
                </div>
                <div class="list-detial">
                    <input type="button"  id="edit_btn" name="teach_edit" value="修改">
                    <input type="button"  id="submit_btn" name="teach_submit" value="保存">
                </div>
            </div>
        </div>
    </div>
@stop
@section("footer")
    @include("common.footer")
@stop
<div class="tools-ceng"></div>
<div class="tools-loading" style="width:200px; height: 200px; border: 0; position: fixed; z-index: 1002; background: url({{url("images/apploading.gif")}}); background-size: contain; left:50%; top:40%; margin-top: -100px; margin-left: -100px; display: none">
    <div class="tools-notice" style="color: #127CC7; border: 0; position: relative; z-index: 1005; margin-top: 180px; width: 100%; text-align: center; height: 40px; line-height: 40px; font-size: 18px;">加载中...</div>
</div>
<div class="photo-upload-banner">
    <div class="photo-upload-banner-top">
            <span id="photo-upload-close">&times;</span>
    </div>
    <div class="photo-upload-banner-content">
        <input type="button" name="photo-upload-btn-1" id="photo-upload-btn-1" value="我要上传">
        <input type="button" name="photo-upload-btn-2" id="photo-upload-btn-2" style="display: none" value="上传失败">
        <input type="button" name="photo-upload-btn-3" id="photo-upload-btn-3" style="display: none" value="上传成功">
    </div>
</div>
<script type="text/javascript">
    window.onload = function () {
        //注意加载新消息的数量
        getNewsCount();


        //表单提交
        $("#submit_btn").click(function () {
            $(".tools-ceng").show();
            $(".tools-loading").show();
            $.ajax({
                url:"{{url("personal/edit")}}",
                type:"post",
                data:{
                    "teach_phone": $("input[name='teach_phone']").val(),
                    "teach_college": $("input[name='teach_college']").val(),
                    "teach_depart": $("input[name='teach_depart']").val(),
                    "teach_add": $("input[name='teach_add']").val()
                },
                async:"false",
                dataType:"html",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (data) {
                    var data2=JSON.parse(data);
//                        alert('成功！'+typeof(data)+data);
//                        alert(typeof(data2)+"code:"+data2.code);
                    var res = "";
                    if(data2.code == "0000"){
                        res = "修改成功";
                    }else if(data2.code == "0002"){
                        res = "修改失败";
                    }else{
                        res = "加载失败";
                    }
                    $(".tools-notice").html(res);
                    setTimeout(function () {
                        $(".tools-ceng").hide();
                        $(".tools-loading").hide();
                        window.location.reload();
                    },1000);
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    $(".tools-ceng").hide();
                    $(".tools-loading").hide();
                    alert(errorThrown);
                }
            });
        });

        $("#edit_btn").click(function () {
            $(".list-detial-edit").removeAttr("readonly");
            $(".list-detial-notallowed").css("cursor","not-allowed");
            $("#phonto-upload").css("display","inline-block");
            $("#submit_btn").css("display","block");
            $("#edit_btn").css("display","none");
        });
        $("#photo-upload").click(function () {
            $(".tools-ceng").css("display","inline-block");
            $(".photo-upload-banner").css("display","inline-block");
        });
        $("#photo-upload-btn-1").click(function () {
            $(this).css("display","none");
            $("#photo-upload-btn-2").css("display","inline-block");
            $("#photo-upload-btn-3").css("display","inline-block");
            window.open("{{url("image-upload")}}");
        });
        $("#photo-upload-btn-2,#photo-upload-btn-3,#photo-upload-close").click(function () {
            $(".tools-ceng").css("display","none");
            $(".photo-upload-banner").css("display","none");
            $("#photo-upload-btn-1").css("display","inline-block");
            $("#photo-upload-btn-2").css("display","none");
            $("#photo-upload-btn-3").css("display","none");
        });
        $("#photo-upload-btn-3,#photo-upload-close").click(function () {
            //为了刷新头像的url地址,刷新整夜页面，不允许在修改其他的
            window.location.reload();
        });

    }
</script>
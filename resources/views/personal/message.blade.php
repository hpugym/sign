<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
    /*
        导航栏激活样式
    */
    #onactive-personal-message{
        position:relative;
        background:url(../images/libg.png) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-personal-message cite{
        background:url(../images/list1.gif) no-repeat;
    }
    #onactive-personal-message i{
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
    #onactive-personal-message a{
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
    .content-banner{
        border: 0;
        position: relative;
        width:88%;
        height: 470px;
        margin-left: 6%;
        margin-right: 6%;
        margin-top: 10px;
    }
    .content-list{
        border: 0;
        width: 100%;
        height: 94px;
    }
    .content-list a:hover{
        text-decoration: none;
    }
    .content-list-title,.content-list-title-a{
        border-bottom: 1px dashed silver;
        width: 100%;
        height: 30px;
        line-height: 30px;
        font-size: 18px;
        overflow: hidden;
        font-weight: bold;
        cursor: pointer;
    }
    .content-list-title:hover,.content-list-title-a:hover,.content-list-content:hover{
        background: #d4e7f0;
    }
    .content-list-content{
        border-bottom: 1px solid silver;
        width: 100%;
        height: 64px;
        line-height: 20px;
        font-size: 15px;
        padding-left: 30px;
        padding-right: 30px;
        text-indent: 30px;
    }
    .content-page{
        border: 0;
        width: 88%;
        height: 40px;
        margin-left: 6%;
        margin-right: 6%;
        padding-right: 10px;
    }
    .content-page-contents{
        border: 0;
        width: 360px;
        float: right;
        height: 40px;
    }
    .content-page-contents a{
        color: gray;
    }
</style>
@extends('common.template')
@section("title")
    消息中心
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
            您的位置：个人中心->消息中心
        </div>
        <div class="main-content">
            <div class="content-banner">
                @foreach($messages as $message)
                    <div class="content-list">

                        @if($message->message_status == 1)
                            <div class="content-list-title-a" id="{{$message->message_id}}">
                                {{$message->message_title}}
                                <span class="idd" style="float: right; font-family: Arial; margin-right: 30px; font-size: 12px; padding-top: 6px;">{{date("Y-m-d H:i:s",$message->message_time)}}</span>
                            </div>

                            <div class="content-list-content {{$message->message_id}}" style="display: none">
                                {{$message->message_content}}
                            </div>
                            <div class="content-list-content {{$message->message_id}}-1" style="line-height: 60px; font-size: 18px; text-align: center;">
                                    点击标题查看
                            </div>
                        @else
                            <div class="content-list-title">
                                {{$message->message_title}}
                                <span class="idd" style="float: right; font-family: Arial; margin-right: 30px; font-size: 12px; padding-top: 6px;">{{date("Y-m-d H:i:s",$message->message_time)}}</span>
                            </div>

                            <div class="content-list-content">
                                {{$message->message_content}}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="content-page">
                <div class="content-page-contents">@include("common.paging")</div>
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
        $(".content-list-title-a").click(function () {
            var message_id = $(this).attr("id");

            //处理消息的状态类型
            $.ajax({
                url:"{{url("personal/newsstatus")}}",
                type:"post",
                data:{
                    "message_id": message_id
                },
                async:"true",
                dataType:"html",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (data) {

                    var data2=JSON.parse(data);
//                    alert('成功！'+typeof(data)+data);
//                    alert(typeof(data2)+"code:"+data2.code);
                    if(data2.code == "0002"){
                        alert("对不起，你没有权限，请登录");
                        window.location.href="{{url("login")}}";
                    }else if(data2.code == "0000"){
                        $("."+message_id+"-1").css("display","none");
                        $("."+message_id).css("display","inline-block");
                    }else{
                        alert("请求失败");
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });

        });
        
    }
</script>
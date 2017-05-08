<style type="text/css">
    /*
   导航栏激活样式
*/
    #onactive-system-message{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-system-message cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-system-message i{
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
    #onactive-system-message a{
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
        margin-bottom: 20px;
    }
    .main-content label{
        line-height: 30px;
        font-size: 17px;
        margin-left: 20px;
        margin-top: 20px;
        width: 90px;
        text-align: right;
        border: 0;
        margin-right: 0;
    }
    .main-content input{
        line-height: 30px;
        height: 30px;
        width: 200px;
        font-size: 16px;
        margin-top: 20px;
        margin-left: -4px;
    }
    .main-content textarea{
        width: 500px;
        height: 200px;
        margin-left: 110px;
    }
    #sub{
        margin-left: 110px;
        width: 200px;
        height: 40px;
        line-height: 40px;
        font-size: 23px;
        background: #3D96C9;
        color: white;
        margin-top: 40px;
        margin-bottom: 20px;
        border: 0;
        box-shadow: 10px 10px 10px #F0F9FD;
    }
</style>
@extends('common.template')
@section("title")
    发送消息
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
            您的位置：系统管理->发送消息
        </div>
        <div class="main-content">
            <label style="margin-top: 60px;">To：</label>
            <input type="text" name="to" id="sendTo">
            <span style="border: 0; margin-left: 5px; font-size: 13px; color: red;" id="to_notice"></span><br/>
            <label>标题：</label>
            <input type="text" name="title"><br/>
            <label>消息内容：</label>
            <span style="color: red; font-size: 13px; margin-left: 5px;">180字以内，不要使用（Enter回车）等换行</span>
            <br/>
            <textarea id="message-content">

            </textarea><br/>
            <button id="sub">发送</button>
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
        var to = $("input[name='to']");
        $(".main-content ul li").click(function () {
            to.val($(this).html());
        });
        $("#sendTo").blur(function () {
            $.ajax({
                url:"{{url("admin/messages-to")}}",
                type:"post",
                data:{
                    "teach_id": to.val(),
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);

                    if(data2.code == "0000") {
                        $("#to_notice").html("该用户可以接收消息");
                        $("#to_notice").css('color','#3D96C9');
                    }else if(data2.code == "0001"){
                        $("#to_notice").html("该用户不存在");
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });

        $("#sub").click(function () {
            $(this).css({'cursor':'not-allowed'});
            $(this).attr('disabled',true);
            $(this).html("正在发送...");
            var to = $("input[name='to']").val();
            var title = $("input[name='title']").val();
            var content = $("#message-content").val();
            if(title.empty || title == ""){
                alert("标题必填");
                $(this).css({'cursor':'pointer'});
                $(this).removeAttr('disabled');
                $(this).html("发送");
            }else if(content.empty || content == ""){
                alert("内容不能为空");
                $(this).css({'cursor':'pointer'});
                $(this).removeAttr('disabled');
                $(this).html("发送");
            }else{
                $.ajax({
                    url:"{{url("admin/messages-push")}}",
                    type:"post",
                    data:{
                        "to": to,
                        "title": title,
                        'content':content,
                        _token : "{{csrf_token()}}"
                    },
                    async:"false",
                    dataType:"html",
                    success:function (data) {

                        var data2=JSON.parse(data);

                        if(data2.code == "0000") {
                            alert("发送成功");
                            window.location.reload();
                        }else if(data2.code == "0001"){
                            alert("发送失败");
                        }else if(data2.code == "0002"){
                            alert("请求发生错误，请重试");;
                        }else if(data2.code == "0003"){
                            alert("内容不要超过180的中文字符");
                        }
                        $("#sub").css({'cursor':'pointer'});
                        $("#sub").removeAttr('disabled');
                        $("#sub").html("发送");
                    },
                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            }
        });


    }
</script>
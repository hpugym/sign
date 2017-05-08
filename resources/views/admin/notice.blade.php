<style type="text/css">
    /*
   导航栏激活样式
*/
    #onactive-system-notice{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-system-notice cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-system-notice i{
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
    #onactive-system-notice a{
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
        line-height: 40px;
        height: 40px;
        margin-left: 30px;
        margin-top: 20px;
        font-size: 18px;
    }
    .main-content input{
        width: 420px;
        height: 40px;
        line-height: 40px;
        font-size: 17px;
        margin-left: 0px;
    }
    #notice-content{
        margin-left: 30px;
    }
    #sub{
        margin-left: 30px;
        width: 200px;
        height: 40px;
        line-height: 40px;
        font-size: 23px;
        background: #3D96C9;
        color: white;
        margin-top: 20px;
        margin-bottom: 20px;
        border: 0;
        box-shadow: 10px 10px 10px #F0F9FD;
    }
</style>
@extends('common.template')
@section("title")
    发布公告
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
            您的位置：系统管理->发布公告
        </div>
        <div class="main-content">
            <label>标题：</label>
            <input type="text" name="title"><br/>
            <label>内容：</label><br/>
            <div id="notice-content">@include("common.edit")</div>
            <button id="sub">提交</button>
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
        $("#sub").click(function () {
            $(this).css({'cursor':'not-allowed'});
            $(this).attr('disabled',true);
            $(this).html("正在发布...");
            var title = $("input[name='title']").val();
            var content = $("#kindEditorContent").val();
            if(title.empty || title == ""){
                alert("标题必填");
                $(this).css({'cursor':'pointer'});
                $(this).removeAttr('disabled');
                $(this).html("发布");
            }else if(content.empty || content == ""){
                alert("内容不能为空");
                $(this).css({'cursor':'pointer'});
                $(this).removeAttr('disabled');
                $(this).html("发布");
            }else{
                $.ajax({
                    url:"{{url("admin/notices-push")}}",
                    type:"post",
                    data:{
                        "title": title,
                        'content':content,
                        _token : "{{csrf_token()}}"
                    },
                    async:"false",
                    dataType:"html",
                    success:function (data) {

                        var data2=JSON.parse(data);

                        if(data2.code == "0000") {
                            alert("发布成功");
                            window.location.href="{{url("index")}}";
                        }else if(data2.code == "0001"){
                            alert("发布失败");
                        }else if(data2.code == "0002"){
                            alert("请求发生错误，请重试");
                        }
                        $("#sub").css({'cursor':'pointer'});
                        $("#sub").removeAttr('disabled');
                        $("#sub").html("发布");
                    },
                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            }
        });
    }
</script>
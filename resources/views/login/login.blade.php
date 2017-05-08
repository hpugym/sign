<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>系统登陆-课堂签到小微</title>
    <meta name="author" content="DeathGhost" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="css/style.css" tppabs="css/style.css" />
    <style>
        body{height:100%;background:#16a085;overflow:hidden;}
        canvas{z-index:-1;position:absolute;}
    </style>
    <script src="js/jquery-1.8.3-min.js"></script>
    <script src="js/verificationNumbers.js" tppabs="js/verificationNumbers.js"></script>
    <script src="js/Particleground.js" tppabs="js/Particleground.js"></script>
    <script>
        $(document).ready(function() {
            //粒子背景特效
            $('body').particleground({
                dotColor: '#5cbdaa',
                lineColor: '#5cbdaa'
            });
            //验证码
            createCode();
            //监听enter操作
            $(document).keyup(function(event){
                if(event.keyCode ==13){
                    $(".submit_btn").trigger("click");
                }
            });
            //点击按钮提交
            $(".submit_btn").click(function(){
//                location.href="javascrpt:;"/*tpa=http://***index.html*/;
                $(this).val("正在登陆...");
                $(this).attr("disabled","disabled");
                $(this).css("cursor","not-allowed")
                if(!validate()){
                    show_err_msg("输入错误");
                    $(this).val("登陆");
                    $(this).attr("disabled",false);
                    $(this).css("cursor","pointer")
                }else{
                    //这里进行验证数据库的验证
                    $.ajax({
                        url:"./action/login",
                        type:"post",
                        data:{
                            "username":$("#J_usertext").val(),
                            "userpass":$("#J_passtext").val()
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
                                show_msg("登陆成功，正在跳转...", "{{url("index")}}");
                            }else if(data2.code == "0001"){
                                show_err_msg("用户名密码错误");
                                $(".submit_btn").val("登陆");
                                $(".submit_btn").attr("disabled",false);
                                $(".submit_btn").css("cursor","pointer")
                            }else if(data2.code == "0002"){
                                show_err_msg("请求错误");
                                $(".submit_btn").val("登陆");
                                $(".submit_btn").attr("disabled",false);
                                $(".submit_btn").css("cursor","pointer")
                            }else if(data2.code == "0003"){
                                show_err_msg("该用户不存在");
                                $(".submit_btn").val("登陆");
                                $(".submit_btn").attr("disabled",false);
                                $(".submit_btn").css("cursor","pointer")
                            }
                        },
                        error:function (XMLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown);
                            $(this).val("登陆");
                            $(this).attr("disabled",false);
                            $(this).css("cursor","pointer")
                        }
                    });

                    //show_msg("登陆成功，正在跳转...","http://www.guoshish.com")
                }
            });
        });
    </script>
</head>
<body>
<dl class="admin_login">
    <dt>
        <strong>课堂签到-小微后台管理系统</strong>
        <em>Management System</em>
    </dt>
    <dd class="user_icon">
        <input type="text" id="J_usertext" placeholder="教工帐号" class="login_txtbx"/>
    </dd>
    <dd class="pwd_icon">
        <input type="password" id="J_passtext" placeholder="教工密码" class="login_txtbx"/>
    </dd>
    <dd class="val_icon">
        <div class="checkcode">
            <input type="text" id="J_codetext" placeholder="验证码" maxlength="4" class="login_txtbx">
            <canvas class="J_codeimg" id="myCanvas" onclick="createCode()">对不起，您的浏览器不支持canvas，请下载最新版浏览器!</canvas>
        </div>
        <input type="button" value="刷新验证码" class="ver_btn" onClick="createCode();">
    </dd>
    <dd>
        <input type="button" value="立即登陆" class="submit_btn"/>
    </dd>
    <dd>
        <p>版权所有：河南理工大学 &nbsp; 郭月盟&nbsp; &copy; 2017</p>
        <p>致力打造完美课堂签到系统</p>
    </dd>
</dl>
</body>
</html>
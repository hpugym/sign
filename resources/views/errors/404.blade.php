<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <style>
        *{
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        body a{
            text-decoration: none;


        }
        .error_content{ position:absolute; left: 50%; top: 50%; width: 1000px; height: 600px; margin-left: -500px; margin-top: -300px; border: 1px solid #cccccc;}
        .error_left{ margin: 120px 0 0 50px; width: 330px ; height: 345px; background: url({{url('images/404.png')}}) no-repeat;     background-size: 100%;float: left;}
        .error_right{ width: 450px; height: 590px;  float: left; }
        .error_detail { margin: 180px 0 0 120px;     width: 400px; height: auto; }
        .error_detail .error_p_title{ font-size: 28px; color: #eb8531;}
        .error_detail .error_p_con{ font-size:14px; margin-top: 10px; line-height: 20px;}
        .sp_con{ margin-left: 128px; color:#1A4EC0;margin-top: 39px;position: absolute;font-size: 18px; }
        .btn_error { margin: 80px 0 0 160px;}
        .btn_error a{  padding: 5px; border: 1px solid  #CCCCCC; }
        .btn_back1{background: dodgerblue; color: #ffffff;}
        .btn_back2{ margin-left:25px;background: #CCCCCC;}

        .btn {
            width: 40px;
            height: 38px;
            cursor: pointer;
            color: #FF813B;
            float: right;
            margin-top: 1px;
            border-left: solid 1px #FF813B;
            font-size: 20px;
            background: no-repeat;
        }


    </style>
</head>
<body >
<div class="error_content">
    <div class="error_left">
        <span class="sp_con"></span>
    </div>
    <div class="error_right">
        <div class="error_detail">
            <p class="error_p_title">哎呦~ 服务器没找到您的东西!</p>
            <p class="error_p_con">●您可致电18336800665,17621096799通知郭月盟等开发人员!</p>
            <p class="error_p_con">●微信考勤系统的进步需要您的反馈,感谢您使用用,请您耐心等待!</p>
        </div>
        <div class="btn_error">
            <a class="btn_back1" href="{{url('./index')}}">返回首页</a>
        </div>

    </div>
</div>
</body>
</html>

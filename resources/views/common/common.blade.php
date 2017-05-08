<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>@yield('title')-课堂签到小微</title>
    <meta name="author" content="DeathGhost" />
    <!--屏幕和设备的屏幕一致，初始缩放为1:1，禁止用户缩放-->
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <!--引入外部的bootstrap中的css文件-->
    <link rel="stylesheet" href="{{asset("bootstrap/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("bootstrap/css/bootstrap-theme.min.css")}}">
    {{-- jQuery文件。务必在bootstrap.min.js 之前引入 --}}
    <script type="text/javascript" src="{{asset("bootstrap/js/jquery.min.js")}}"></script>
    {{--再引入bootstrap.min.js文件--}}
    <script type="text/javascript" src="{{asset("bootstrap/js/bootstrap.min.js")}}"></script>
    <style type="text/css">
        *{
            margin: 0px;
            padding: 0px;
        }
        .header{
            border: 1px solid yellow;
            width: 100%;
            height: 100px;
            text-align: center;
            position: relative;
        }
        .center{
            border: 1px solid red;
            height: 600px;
            width: 100%;
        }
        .center_left{
            border: 1px solid red;
            border-left: none;
            width: 179px;
            height: 600px;
            float: left;
            position: relative;
            /*transition:all 2s;*/
            /*-moz-transition:all 2s; !* Firefox 4 *!*/
            /*-webkit-transition:all 2s; !* Safari and Chrome *!*/
            /*-o-transition:all 2s; !* Opera *!*/
        }
        .center_right{
            border: 1px solid blue;
            border-left: none;
            height: 600px;
            margin-left: 180px;
            background-color: greenyellow;
            /*width: 100%;*/
            /*float: left;*/
            position: relative;
        }
        .footer{
            border: 1px solid black;
            width: 100%;
            height: 60px;
            text-align: center;
            position: relative;
        }
        @media screen and (max-width: 900px){
            .center_left{
                display: none;
            }
            .center_right {
                margin-left: 0px;
            }
        }
        @media screen and (min-width: 900px) and (max-width: 1300px){
            .center_left{
                width:200px ;
            }
        }
        @media screen and (min-width: 1300px){
            .center_left{
                width:240px ;
            }
        }
    </style>
    <script>
        $(document).ready(function() {

        });
    </script>
</head>
<body>
{{-- 头部模板--}}
@section("header")
    头部
@show
{{-- 头部模板--}}

{{-- 中部模板--}}
<div class="center">
    {{-- 中左部模板--}}
    @section("center_left")
        中左
    @show
    {{-- 中左部模板--}}

    {{-- 中右部模板--}}
    <div class="center_right">
        @section("center_right")
            中右
        @show
        {{-- 中右部模板--}}
    </div>
</div>
{{-- 中部模板--}}

{{-- 底部模板--}}
@section("footer")
    底部
@show
{{-- 底部模板--}}
</body>
</html>
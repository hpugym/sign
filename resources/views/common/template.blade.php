<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>@yield('title')-课堂签到小微</title>
    <meta name="author" content="DeathGhost" />
    <!--屏幕和设备的屏幕一致，初始缩放为1:1，禁止用户缩放-->
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <!--引入外部的bootstrap中的css文件-->
    <link rel="stylesheet" href="{{asset("css/template.css")}}">
    <link rel="stylesheet" href="{{asset("bootstrap/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("bootstrap/css/bootstrap-theme.min.css")}}">

    {{-- jQuery文件。务必在bootstrap.min.js 之前引入 --}}
    <script type="text/javascript" src="{{asset("bootstrap/js/jquery.min.js")}}"></script>
    {{--再引入bootstrap.min.js文件--}}
    <script type="text/javascript" src="{{asset("bootstrap/js/bootstrap.min.js")}}"></script>
    <style type="text/css">

    </style>
    <script>
        $(document).ready(function() {

        });
    </script>
</head>
<body style="background: #f0f9fd; width: 100%; min-width: 1200px;">
{{-- 头部模板--}}
@section("header")
    头部
@show
{{-- 头部模板--}}

{{-- 中部模板--}}
<div style="border: 1px solid transparent; height: auto; overflow: hidden; font-family: '微软雅黑'">
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
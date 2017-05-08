<style type="text/css">
    /*
   导航栏激活样式
*/
    #onactive-system-classroom{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-system-classroom cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-system-classroom i{
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
    #onactive-system-classroom a{
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
    .require{
        width: 100%;
        height: 60px;
        border-bottom: 0;
    }
    .require label{
        height: 40px;
        line-height: 40px;
        margin-left: 30px;
        font-size: 20px;
        margin-top: 10px;
        font-size: 18px;
        float: left;
    }
    .require input{
        width: 200px;
        height: 40px;
        margin-top: 10px;
        margin-left: 5px;
        margin-bottom: 10px;
        float: left;
    }
    .require button{
        width: 120px;
        height: 40px;
        font-size: 20px;
        margin-left: 10px;
        margin-top: 10px;
        float: left;
    }
    .content-list{
        position: relative;
        width: 100%;
        min-height: 520px;
        height: auto;
        border: 1px solid transparent;
    }
    .table{
        font-size: 14px;
        text-align: center;
        margin-bottom: 0;
        display: table;
    }
    /*表格中的垂直居中*/
    .table tr td{
        display: table-cell;
        vertical-align: middle !important;
    }
    .content-bottom-page{
        border: 1px solid transparent;
        width: 100%;
        height: 40px;
        padding-right: 10px;
    }
    .content-bottom-page-contents{
        border: 0;
        width: 360px;
        float: right;
        height: 40px;
    }
    .content-bottom-page-contents a{
        color: gray;
    }
    /*ceng*/
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
    .tools-content{
        width:300px;
        height: 300px;
        border: 0;
        box-shadow: 5px 5px 8px gray;
        position: fixed;
        z-index: 1002;
        background: #fff;
        left:50%;
        top:40%;
        margin-top: -100px;
        margin-left: -150px;
        display: none;
    }
    .tools-top{
        width: 300px;
        border: 0;
        background: silver;
        height: 40px;
        line-height: 40px;
    }
    .tools-top span:hover{
        color: #fff;
    }
    .tools-bottom{
        width: 300px;
        line-height: 30px;
        font-size: 16px;
        margin-top: 20px;
    }
    .tools-bottom label{
        margin-left: 30px;
        font-size: 18px;
    }
    .tools-bottom select{
        width: 120px;
        margin-left: 0px;
        text-align: center;
        height: 30px;
        margin-top: 20px;
    }
    .tools-bottom input{
        width: 120px;
        height: 30px;
        margin-top: 20px;
    }
    .tools-bottom button{
        display: inline-block;
        width: 120px;
        height: 30px;
        margin: auto;
        background: silver;
        border: 0;
        margin-left: 90px;
        margin-top: 40px;
    }
</style>
@extends('common.template')
@section("title")
    教室列表
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
            您的位置：系统管理->教室列表
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="javascript:void(0)"; id="add_btn"><b>新增教室</b></a></span>
        </div>
        <div class="main-content">
            <div class="require">
                <label>教室号:</label>
                <input type="text" name="require">
                <button id="require_btn">查找</button>
            </div>
            <div class="content-list">
                <table class="table table-striped table-bordered table-hover table table-condensed">
                    <tr>
                        <td width="40">序号</td>
                        <td width="150">教室号</td>
                        <td>学院</td>
                        <td>经度</td>
                        <td >维度</td>
                        <td>创建时间</td>
                        <td width="80">操作</td>
                    </tr>
                    @if(count($classrooms) == 0)
                        <tr>
                            <td colspan="9">教室信息不存在</td>
                        </tr>
                    @else
                        @foreach($classrooms as $classroom)
                            <tr id="{{$classroom->local_id}}">
                                <td>{{$count++}}</td>
                                <td>{{$classroom->local_id}}</td>
                                <td>{{$classroom->local_college}}</td>
                                <td id="{{$classroom->local_id}}-lon">{{$classroom->local_lon}}</td>
                                <td id="{{$classroom->local_id}}-lat">{{$classroom->local_lat}}</td>
                                <td id="{{$classroom->local_id}}-created">{{date("Y-m-d H:i:s",$classroom->local_created)}}</td>
                                <td><a href="javascript:edit({{$classroom->local_id}})">修改</a>&nbsp;<a href="javascript:del({{$classroom->local_id}})">删除</a></td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
            <div class="content-bottom-page">
                <div class="content-bottom-page-contents">@include("common.paging")</div>
            </div>

        </div>
    </div>
@stop
@section("footer")
    @include("common.footer")
@stop
<div class="tools-ceng"></div>
<div class="tools-content">
    <div class="tools-top">
        <span id="close" style="display: inline-block; float: right; margin-right: 15px; font-size: 24px; cursor: pointer;">&times;</span>
    </div>
    <div class="tools-bottom">
        <input type="hidden" name="local_id">
        <label>教室经度:</label>
        <input type="text" name="local_lon"><br/>
        <label>教室维度:</label>
        <input type="text" name="local_lat"><br/>
        <button id = "status_save">保存</button><br/><br/>
        <a href="http://lbs.qq.com/tool/getpoint/" target="_blank" style="margin-left: 10px;">腾讯地图：经纬度拾取器</a>
    </div>
</div>
<script type="text/javascript">
    window.onload = function () {
        //注意加载新消息的数量
        getNewsCount();

        //条件查询
        $("#require_btn").click(function () {
            var require = $("input[name='require']").val();
            if(require == null || require == ""){
                alert('请输入条件');
            }else{
                window.location.href="{{url("admin/classRooms?require=")}}"+require;
            }
        });

        $("#add_btn").click(function () {
            alert("目前暂不支持添加");
        });

        $("#status_save").click(function () {
            $("#status_save").html("保存中...");
            $("#status_save").attr("disabled",true);
            $("#status_save").css("cursor","not-allowed");

            var local_lon = $("input[name='local_lon']").val();
            var local_lat = $("input[name='local_lat']").val();
            var local_id = $("input[name='local_id']").val();

            $.ajax({
                url:"{{url("admin/classRoom/edit-action")}}",
                type:"post",
                data:{
                    "local_lon": local_lon,
                    "local_lat":  local_lat,
                    "local_id": local_id,
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
                    if(data2.code == "0000") {
                        $("#"+local_id+"-lon").html(local_lon);
                        $("#"+local_id+"-lat").html(local_lat);
                        $("#"+local_id+"-created").html(data2.time);
                        alert("修改成功");

                    }else if(data2.code == "0001"){
                        alert("修改失败");
                    }else if(data2.code == "0002"){
                        alert("请求发生错误，请重试");
                    }
                    $(".tools-ceng").hide();
                    $(".tools-content").hide();
                    $("#status_save").html("保存");
                    $("#status_save").removeAttr("disabled");
                    $("#status_save").css("cursor","pointer");
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                    $(".tools-ceng").hide();
                    $(".tools-content").hide();
                    $("#status_save").html("保存");
                    $("#status_save").removeAttr("disabled");
                    $("#status_save").css("cursor","pointer");
                },
            });
        });


        $("#close").click(function () {
            $(".tools-ceng").hide();
            $(".tools-content").hide();
            $("#status_save").html("保存");
            $("#status_save").removeAttr("disabled");
            $("#status_save").css("cursor","pointer");
        });
    }
    function edit(local_id) {
        var local_lon = $("#"+local_id+"-lon").html();
        var local_lat =$("#"+local_id+"-lat").html();

        $("input[name='local_lon']").val(local_lon);
        $("input[name='local_lat']").val(local_lat);
        $("input[name='local_id']").val(local_id);
        $(".tools-ceng").show();
        $(".tools-content").show();
    }
    function del(local_id){
        if(confirm("继续将删除？")){
            $.ajax({
                url:"{{url("admin/classRoom/del-action")}}",
                type:"post",
                data:{
                    "local_id": local_id,
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
//                            alert('成功！'+typeof(data)+data);
//                            alert(typeof(data2)+"code:"+data2.code);
                    if(data2.code == "0000") {
                        alert("删除成功");
                        $("#"+local_id).slideUp(function () {
                            $("#"+local_id).remove();
                        });
                    }else if(data2.code == "0001"){
                        alert("删除失败");
                    }else if(data2.code == "0002"){
                        alert("请求发生错误，请重试");
                    }
                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    }
</script>
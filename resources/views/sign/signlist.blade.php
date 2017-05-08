<style type="text/css">
    /*
    导航栏激活样式
*/
    #onactive-sign-pushed{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-sign-pushed cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-sign-pushed i{
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
    #onactive-sign-pushed a{
        color:#fff;
        text-decoration: none;
    }
    #onactive-father-sign{
        display: block;
    }
    /*
    主要样式
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
        min-height: 559px;
    }
    .content-list{
        position: relative;
        width: 100%;
        min-height: 520px;
        height: auto;
        border: 1px solid transparent;
    }
    .table{
        font-size: 12px;
        text-align: center;
        margin-bottom: 0;
        display: table;
    }
    .table tr th{
        text-align: center;
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
        width:400px;
        height: 150px;
        border: 0;
        box-shadow: 5px 5px 8px gray;
        position: fixed;
        z-index: 1002;
        background: #fff;
        left:50%;
        top:40%;
        margin-top: -100px;
        margin-left: -200px;
        display: none;
    }
    .tools-top{
        width: 400px;
        border: 0;
        background: silver;
        height: 40px;
        line-height: 40px;
    }
    .tools-top span:hover{
        color: #fff;
    }
    .tools-bottom{
        width: 400px;
        line-height: 40px;
        font-size: 18px;
        margin-top: 20px;
    }
    .tools-bottom label{
        margin-left: 40px;
        font-size: 20px;
    }
    .tools-bottom select{
        width: 60px;
        margin-left: 20px;
        text-align: center;
        height: 40px;
    }
    .tools-bottom button{
        position: relative;
        width: 120px;
        height: 40px;
        margin-left: 20px;
        background: silver;
        border: 0;
    }
</style>
@extends('common.template')
@section("title")
    签到详情
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
            您的位置：签到管理->签到详情
            <span style="display: inline-block; position: relative; float: right; margin-right: 20px; font-size: 17px;"><a href="{{url("detailExport")."/".$qrcode_code}}"><b>导出列表</b></a></span>
        </div>
        <div class="main-content">
            <div class="content-list">
                <table class="table table-striped table-bordered table-hover table table-condensed table-responsive">
                    <tr>
                        <th width="50">序号</td>
                        <th width="150">学号</th>
                        <th>姓名</th>
                        <th>openid</th>
                        <th>签到状态</th>
                        <th>发起时间</th>
                        <th>签到时间</th>
                        <th width="120">操作</th>
                    </tr>
                    @if(count($details) == 0)
                        <tr>
                            <td colspan="8">签到信息不存在</td>
                        </tr>
                    @else
                        @foreach($details as $detail)
                            <tr>
                                <td width="50">{{$count++}}</td>
                                <td width="150">{{$detail->stu_num}}</td>
                                <td>{{$detail->stu_name}}</td>
                                <td>{{$detail->stu_openid}}</td>
                                <td id="{{$detail->stu_openid}}" style="color:@if($detail->signs_status == "缺勤") {{"#c75050"}} @elseif($detail->signs_status == "请假") {{"#C7C27B"}} @else {{"black"}} @endif;">{{$detail->signs_status}}</td>
                                <td>{{date("Y-m-d H:i:s",$detail->qrcode_time)}}</td>
                                <td>{{date("Y-m-d H:i:s",$detail->signs_time)}}</td>
                                <td width="120"><a href="javascript:edit('{{$detail->stu_openid}}','{{$detail->qrcode_code}}')">修改</a></td>
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
        <label>签到状态:</label>
        <input type="hidden" name="stu_openid">
        <input type="hidden" name="qrcode_code">
        <select id="status">
            <option value="出勤">出勤</option>
            <option value="缺勤">缺勤</option>
            <option value="请假">请假</option>
        </select>
        <button id = "status_save">保存</button>
    </div>
</div>
<script type="text/javascript">
    window.onload = function () {
        //注意加载新消息的数量
        getNewsCount();

        $("#status_save").click(function () {
            $("#status_save").html("保存中...")
            $("#status_save").attr("disabled",true);
            $("#status_save").css("cursor","not-allowed");
            var stu_openid = $("input[name='stu_openid']").val();
            var qrcode_code = $("input[name='qrcode_code']").val();
            var signs_status = $("#status option:selected").val();
            $.ajax({
                url:"{{url("signmanager/update-action")}}",
                type:"post",
                data:{
                    "qrcode_code": qrcode_code,
                    "stu_openid":  stu_openid,
                    "signs_status": signs_status,
                    _token : "{{csrf_token()}}"
                },
                async:"false",
                dataType:"html",
                success:function (data) {

                    var data2=JSON.parse(data);
                    if(data2.code == "0000") {
                        if(signs_status == "缺勤"){
                            $("#"+stu_openid).css("color","#c75050");
                        }else if(signs_status == "请假"){
                            $("#"+stu_openid).css("color","#C7C27B");
                        }else{
                            $("#"+stu_openid).css("color","black");
                        }
                        $("#"+stu_openid).html(signs_status);
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
    
    function edit(stu_openid,qrcode_code) {
        $("input[name='stu_openid']").val(stu_openid);
        $("input[name='qrcode_code']").val(qrcode_code);
        $(".tools-ceng").show();
        $(".tools-content").show();
    }

</script>
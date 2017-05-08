<style type="text/css">
    /*
        导航栏激活样式
    */
    #onactive-sign-push{
        position:relative;
        background:url({{url("images/libg.png")}}) repeat-x;
        line-height:30px;
        color:#fff;
    }
    #onactive-personal-sign cite{
        background:url({{url("images/list1.gif")}}) no-repeat;
    }
    #onactive-personal-sign i{
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
    #onactive-sign-push a{
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
        height: auto;
    }
    .content-top-select{
        border-bottom: 1px solid silver;
        width: 100%;
        height: 120px;
        overflow: hidden;
        line-height: 30px;
        margin-bottom: 10px;
    }
    .content-top-select input, .content-top-select label{
        line-height: 30px;
        margin-top: 10px;
    }
    .content-top-select input{
        min-width: 120px;
        height: 30px;
        line-height: 30px;
        font-weight: bold;
    }
    .content-top-select label{
        margin-left: 80px;
        font-weight: normal;
    }
    .content-top-select select{
        min-width: 80px;
        height: 30px;
        line-height: 30px;
    }
    .content-top-select button{
        margin-left: 80px;
        width: 140px;
        height: 34px;
        line-height: 30px;
        font-size: 16px;
        border: 0;
        background: #3d96c9;
        color: white;
        margin-top: 10px;
    }
    #showQrCode{
        width: 440px;
        height: 480px;
        border: 1px solid silver;
        margin: auto;
        overflow: hidden;
        margin-bottom: 10px;
        display: none;
    }
    #showQrCode a{
        display:inline-block;
        background: silver;
        border-bottom: 1px solid silver;
        width: 440px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        font-size: 22px;
        color: white;
    }
    #showQrCode a:hover{
        text-decoration: none;
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
</style>
@extends('common.template')
@section("title")
    签到发布
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
            您的位置：签到管理->签到发布
        </div>
        <div class="main-content">
            <div class="content-top-select">
                <label>课程名称：</label>
                <input type="text" name="course_name" value="{{$course_name}}" style="border: 0; margin-top: 20px;" readonly><br/>
                <input type="hidden" name="teachs_code" id="teachs_code" value="{{$teachs_code}}">
                <label>签到时长：</label>
                <select id="sign_time">
                    <option value="60">1分钟</option>
                    <option value="120">2分钟</option>
                    <option value="180">3分钟</option>
                    <option value="240">4分钟</option>
                    <option value="300">5分钟</option>
                    <option value="600">10分钟</option>
                </select>
                <label>签到地点：</label>
                <select id="sign_college" onchange="Change($('#sign_college option:selected') .val())">
                    <option value="--请选择--">--请选择--</option>
                    <option value="一号教学楼">一号教学楼</option>
                    <option value="二号教学楼">二号教学楼</option>
                    <option value="三号教学楼">三号教学楼</option>
                    <option value="电气综合楼">电气综合楼</option>
                    <option value="理化综合楼">理化综合楼</option>
                    <option value="机械综合楼">机械综合楼</option>
                    <option value="能源综合楼">能源综合楼</option>
                    <option value="资环综合楼">资环综合楼</option>
                    <option value="测绘综合楼">测绘综合楼</option>
                    <option value="土木综合楼">土木综合楼</option>
                    <option value="计算机综合楼">计算机综合楼</option>
                    <option value="文科综合楼">文科综合楼</option>
                    <option value="经管综合楼">经管综合楼</option>
                    <option value="材料综合楼">材料综合楼</option>
                </select>
                <select id="sign_classRoom">
                    <option value="--请选择--">--请选择--</option>
                </select>
                <button name="btn" id="publish_btn">发布签到</button>
                <a style="display: inline-block; margin-left: 80px; display: none" href="#" id="close_btn"></a>
            </div>
            <div id="showQrCode">
                <a href="" target="_block">点击放大</a>
                <img style="width: 430px; height: 430px;" src="">
            </div>
        </div>
    </div>
@stop
@section("footer")
    @include("common.footer")
@stop
<div class="tools-ceng"></div>
<div class="tools-loading" style="width:200px; height: 200px; border: 0; position: fixed; z-index: 1002; background: url({{url("images/apploading.gif")}}); background-size: contain; left:50%; top:40%; margin-top: -100px; margin-left: -100px; display: none">
    <div class="tools-notice" style="color: #127CC7; border: 0; position: relative; z-index: 1005; margin-top: 180px; width: 100%; text-align: center; height: 40px; line-height: 40px; font-size: 18px;">正在查询学生列表...</div>
</div>
<script type="text/javascript">
    window.onload = function () {
        //注意加载新消息的数量
        getNewsCount();

        $("#publish_btn").click(function () {
            //加载动画
            $(".tools-ceng").show();
            $(".tools-loading").show();

            var teachs_code = $("#teachs_code").val();
            var sign_time = $("#sign_time option:selected").val();
            var sign_classRoom = $('#sign_classRoom option:selected').val()

//            alert("teachs_code"+ teachs_code);
//            alert("sign_time"+sign_time);
//            alert("sign_classRoom"+sign_classRoom);

            if(sign_classRoom == "--请选择--"){
                alert("请选择上课教室");
            }else{
                $.ajax({
                    url:"{{url("signmanager/getstudent")}}",
                    type:"post",
                    data:{
                        "sign_classRoom": sign_classRoom,
                        "teachs_code": teachs_code,
                        _token: "{{csrf_token()}}"//注意验证_token的添加
                    },
                    async:"false",
                    dataType:"html",
                    success:function (data) {

                        var data2=JSON.parse(data);
                        if(data2.code == "0000"){
                            var local_lon = data2.local_lon;
                            var local_lat = data2.local_lat;
                            var students = data2.students;
                            $(".tools-notice").html("正在获取二维码...");
                            $.ajax({
                                url:"{{url("signmanager/getcode")}}",
                                type:"post",
                                data:{
                                    "sign_time": sign_time,
                                    "teachs_code": teachs_code,
                                    "local_lon": local_lon,
                                    "local_lat": local_lat,
                                    "sign_classRoom": sign_classRoom,
                                    _token: "{{csrf_token()}}"//注意验证_token的添加
                                },
                                async:"false",
                                dataType:"html",
                                success:function (data) {
                                    var data2=JSON.parse(data);
                                    var imgUrl = data2.imgUrl;
                                    var actionTime = data2.actionTime;
                                    var qrcode_code = data2.qrcode_code;
                                    var end_time = data2.end_time;
                                    var endtime_str = data2.endtime_str
                                    if(data2.code == "0000"){
                                        $(".tools-notice").html("数据处理中,请耐心等候...");
                                        $.ajax({
                                            url:"{{url("signmanager/deal")}}",
                                            type:"post",
                                            data:{
                                                "students": students,
                                                "teachs_code": teachs_code,
                                                "qrcode_code": qrcode_code,
                                                "actionTime": actionTime,
                                                _token: "{{csrf_token()}}"//注意验证_token的添加
                                            },
                                            async:"false",
                                            dataType:"html",
                                            success:function (data) {
                                                var data2=JSON.parse(data);
                                                if(data2.code == "0000"){
                                                    {{--$("#showQrCode").append("<img src='" + imgUrl + "'>");{{url("signmanager/showcode")}}--}}
                                                    var close_time =  parseInt(sign_time) + parseInt(actionTime) - 10;
                                                    // /开启关闭开关
                                                    $("#close_btn").show();
                                                    $("#close_btn").html(end_time);
                                                    $("#close_btn").attr("href","javascript:check_time("+endtime_str+","+teachs_code+")");
                                                    $("#publish_btn").hide();
                                                    $("#showQrCode a").attr("href","{{url("signmanager/showcode")}}?url="+imgUrl);
                                                    $("#showQrCode img").attr("src",imgUrl);
                                                    $("#showQrCode").show();
                                                    $(".tools-ceng").hide();
                                                    $(".tools-loading").hide();
                                                    $(".tools-notice").html("正在查询学生列表...");
                                                }else if(data2.code == "0001"){//数据处理过程中出错
                                                    alert("数据处理过程中出错")
                                                    $(".tools-ceng").hide();
                                                    $(".tools-loading").hide();
                                                    $(".tools-notice").html("正在查询学生列表...");
                                                }else if(data2.code == "0002"){//请求错误
                                                    alert("请求错误");
                                                    $(".tools-ceng").hide();
                                                    $(".tools-loading").hide();
                                                    $(".tools-notice").html("正在查询学生列表...");
                                                }
                                            },
                                            error:function (XMLHttpRequest, textStatus, errorThrown) {
                                                alert(errorThrown);
                                                $(".tools-ceng").hide();
                                                $(".tools-loading").hide();
                                                $(".tools-notice").html("正在查询学生列表...");
                                                $("#close_btn").hide();
                                                $("#publish_btn").show();
                                            }
                                        });
                                    }else if(data2.code == "0001"){//二维码请求失败
                                        alert("二维码请求失败")
                                        $(".tools-ceng").hide();
                                        $(".tools-loading").hide();
                                        $(".tools-notice").html("正在查询学生列表...");
                                    }else if(data2.code == "0004"){//二维码ticket获取失败
                                        alert("二维码ticket获取失败")
                                        $(".tools-ceng").hide();
                                        $(".tools-loading").hide();
                                        $(".tools-notice").html("正在查询学生列表...");
                                    }else if(data2.code == "0005"){//二维码access_token获取失败
                                        alert("二维码access_token获取失败")
                                        $(".tools-ceng").hide();
                                        $(".tools-loading").hide();
                                        $(".tools-notice").html("正在查询学生列表...");
                                    }else if(data2.code == "0002"){//请求错误
                                        alert("请求错误");
                                        $(".tools-ceng").hide();
                                        $(".tools-loading").hide();
                                        $(".tools-notice").html("正在查询学生列表...");
                                    }else if(data2.code == "0003"){//二维码数据保存失败
                                        alert("二维码数据保存失败");
                                        $(".tools-ceng").hide();
                                        $(".tools-loading").hide();
                                        $(".tools-notice").html("正在查询学生列表...");
                                    }
                                },
                                error:function (XMLHttpRequest, textStatus, errorThrown) {
                                    alert(errorThrown);
                                    $("#close_btn").hide();
                                    $("#publish_btn").show();
                                }
                            });
                        }else if(data2.code == "0001"){//为查询到教室的经纬度
                            alert("为查询到教室的经纬度")
                            $(".tools-ceng").hide();
                            $(".tools-loading").hide();
                            $(".tools-notice").html("正在查询学生列表...");
                        }else if(data2.code == "0002"){//请求错误
                            alert("请求错误");
                            $(".tools-ceng").hide();
                            $(".tools-loading").hide();
                            $(".tools-notice").html("正在查询学生列表...");
                        }else if(data2.code == "0003"){//未查询到学生的信息
                            alert("未查询到学生的信息");
                            $(".tools-ceng").hide();
                            $(".tools-loading").hide();
                            $(".tools-notice").html("正在查询学生列表...");
                        }
                    },
                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                        $("#close_btn").hide();
                        $("#publish_btn").show();
                    }
                });
            }
        });
    }
    function check_time(d,id) {
        var timestamp = Date.parse(new Date());
        timestamp = timestamp / 1000;
        if(d < timestamp){
            window.location.href="{{url("signmanager/courselist/pushed")}}";
        }else{
            alert("时间未到，不能关闭");
        }
    }
    function  Change(currentBuild) {
        //alert(currentBuild);
        var list = new Array();
        list[0] = new Array("一号教学楼","1101|1102|1103|1104|1105|1106|1107|" +
            "1201|1202|1203|1204|1205|1206|1207|1209|1210|1211|1212|1213|1214|1215|1216|" +
            "1301|1302|1303|1304|1305|1306|1309|1310|1311|1312|1313|1314|1315|1316|1317|1318|" +
            "1401|1402|1403|1404|1405|1406|1407|1409|1410|1411|1412|1413|1414|1415|1416|1417|1418");
        list[1] = new Array("二号教学楼","2101|2102|2103|2104|2105|2106|2107|2109|2110|2111|2112|2113|2114|2115|" +
            "2201|2202|2203|2204|2205|2206|2207|2209|2210|2211|2212|2213|2214|2215|2216|" +
            "2301|2302|2303|2304|2305|2306|2307|2309|2310|2311|2312|2313|2314|2315|2316|2317|" +
            "2401|2402|2403|2404|2405|2406|2407|2409|2410|2411|2412|2413|2415|2416|2417|2418");
        list[2] = new Array("三号教学楼","3101|3102|3103|3104|3105|3106|3107|3108|" +
            "3201|3203|3204|3205|3206|3207|3208|3211|3212|3213|" +
            "3301|3302|3303|3304|3305|3306|3307|3308|3309|3310|3311|3312|3313|3314|3315|" +
            "3403|3404|3405|3406|3407|3408|3410|3411|" +
            "3501|3502|3503|3504|3505|3506|3507|3508|");
        list[3] = new Array("计算机综合楼","jsj101|jsj102|jsj103|jsj104|jsj105|jsj106|jsj107|jsj110|" +
            "jsj203|jsj205|jsj207");
        list[4] = new Array("文科综合楼","wz108|wz109|wz110|wz111|wz306|wz307|wz406|wz407|wz509|wz510|wz604|wz605");
        list[5] = new Array("经管综合楼","jg1103|jg1104|jg1111|jg1112|jg1201|jg1202|jg1203|jg1204|jg1205|jg1206|jg1211|jg1212");
        list[6] = new Array("电气综合楼","dq201|dq204|dq205|dq301|dq304|dq305|dq401|dq402|dq403|dq404|dq405|dq407|dq501|dq502|dq503|dq504|dq505|dq506");
        list[7] = new Array("理化综合楼","lh201|lh203|lh205|lh207|lh301|lh303|lh305");
        list[8] = new Array("机械综合楼","jx101|jx102|jx105|jx201|jx301|jx303|jx305|jx418")
        list[9] = new Array("能源综合楼","ny102|ny202|ny302|ny401|ny402|ny502");
        list[10] = new Array("资环综合楼","zh103|zh202|zh302|zh402|zh502");
        list[11] = new Array("测绘综合楼","ch102|ch103|ch301|ch302|ch303|ch401|ch402|ch403|ch502|ch503");
        list[12] = new Array("土木综合楼","tm102|tm103|tm202|tm203|tm301|tm302|tm303|tm401");
        list[13] = new Array("材料综合楼","cl1306|cl1405|cl1504|cl1505|cl2103|cl2202|cl2203")
        list[14] = new Array("--请选择--","--请选择--");
       $("#sign_classRoom").empty();
        for(var i = 0; i<list.length; i++){
            if(list[i][0] == currentBuild){
                var roomNum = list[i][1].split("|");
                for(var j = 0; j < roomNum.length; j++){
                    $("#sign_classRoom").append("<option value='"+roomNum[j]+"'>"+roomNum[j]+"</option>")
                }
            }
        }
    }
</script>
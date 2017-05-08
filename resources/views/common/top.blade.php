<meta name="csrf-token" content="{{ csrf_token() }}">
<nav class="navbar" style="margin-bottom:0; height: 80px; background: url('{{asset("images/topbg.gif")}}') repeat-x">
    <div class="container-fluid">
        <!--页面的头部-->
        <div class="navbar-header navbar-logo">
            <img class="img-responsive" src="{{asset("images/logo.png")}}" style="height: 70px; margin-top: 5px;">
        </div>
        <div class="navbar-header pull-right">
            <div class="topright">
                <ul>
                    <li><span><img src="{{url("images/help.png")}}" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
                    <li><a href="#">关于</a></li>
                    <li><a href="javascript:void(0)" id="qiut_btn">退出</a></li>
                </ul>
                <div class="user">
                    <span style=" color: white">{{session()->get("teach_name")}}</span>
                    <i style="padding-right:10px;"><a href="{{url("personal/message")}}" style=" color: white">消息</a></i>
                    <b class="mynews" style="margin-left: -15px;"></b>
                </div>
            </div>
        </div>
    </div>
</nav>
<script type="text/javascript">
    $(function(){
        $("#qiut_btn").click(function () {
           if(confirm("您将推出该系统？")){
               window.location.href="{{url("logout")}}";
           }
        });
    });
    function getNewsCount() {
        $.ajax({
            url:"{{url("personal/newsnum")}}",
            type:"post",
            data:{
                "username": "{{session()->get("user_id")}}"
            },
            async:"true",
            dataType:"html",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function (data) {

                var data2=JSON.parse(data);
//                            alert('成功！'+typeof(data)+data);
//                            alert(typeof(data2)+"code:"+data2.code);
                if(data2.code == "0000"){
                    $(".mynews").html(data2.messageCount);
                }else if(data2.code == "0001"){
                    $(".mynews").hide();
                }else if(data2.code == "0002"){
                    window.location.href="{{url("login")}}";
                }
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
                $(".mynews").hide();
            }
        });
    }
</script>

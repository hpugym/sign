<style type="text/css">
</style>
<script type="text/javascript">
    $(function(){
        //导航切换
        $(".menuson li").click(function(){
            $(".menuson li.active").removeClass("active")
            $(this).addClass("active");
        });

        $('.title').click(function(){
            var $ul = $(this).next('ul');
            $('dd').find('ul').slideUp();
            if($ul.is(':visible')){
                $(this).next('ul').slideUp();
            }else{
                $(this).next('ul').slideDown();
            }
        });
        $('.elem').mouseover(function(){
            var $ul = $(this).find('ul');
            $('dd').find('ul').css("display","none");
            if($ul.is(':visible')){
                $(this).find('ul').css("display","none");
            }else{
                $(this).find('ul').css("display","block");
            }
        });
        $(".elem").mouseout(function () {
            $('dd').find('ul').css("display","none");
        });
        $("#controller-open").click(function(){
            var s = $(".menu");
            s.css("display","block");
            $(".menu2").css("display","none");
        });
        $("#controller-close").click(function(){
            var s = $(".menu");
            s.css("display","none");
            $(".menu2").css("display","block");
        });
    })
</script>
<div class="menu2 pull-left">
    <div class="menu-controll">
        <span id="controller-open"></span>
    </div>
    <dl class="leftmenu2">
        <dd class="elem">
            <div class="title2">
                <a href="{{asset("index")}}" class="index" title="首页"><span><img src="{{asset("images/index.png")}}" /></span></a>
            </div>
        </dd>
        <dd class="elem">
            <div class="title2">
                <span><img src="{{url("images/sign.png")}}"/></span>
            </div>
            <ul class="menuson2" >
                <li><a href="{{url("signmanager/publish")}}">发布新签到</a></li>
                <li><a href="{{url("signmanager/published")}}">已发布签到</a></li>
            </ul>
        </dd>
        <dd class="elem">
            <div class="title2">
                <a href="{{url("course/list")}}" class="index" title="课程管理"><span><img src="{{url("images/course.png")}}" /></span></a>
            </div>
        </dd>
        <dd class="elem">
            <div class="title2">
                <a href="{{url("student/courselist")}}" class="index"><span><img src="{{url("images/stu.png")}}" /></span></a>
            </div>
        </dd>
        <dd class="elem">
            <div class="title2" >
                <span><img src="{{url("images/person.png")}}" /></span>
            </div>
            <ul class="menuson2">
                <li><a href="{{asset("personal/info")}}">我的资料</a></li>
                <li><a href="{{asset("personal/passedit")}}">密码修改</a></li>
                <li><a href="{{asset("personal/message")}}">消息中心</a></li>
            </ul>
        </dd>
        @if(session()->get("user_type") == 1)
            <dd class="elem">
                <div class="title2">
                    <span><img src="{{url("images/manager.png")}}"/></span>
                </div>
                <ul class="menuson2">
                    <li><a href="{{url("admin/teachers")}}">教师管理</a></li>
                    <li><a href="{{url("admin/classRooms")}}">教室管理</a></li>
                    <li><a href="{{url("admin/students")}}">学生管理</a></li>
                    <li><a href="{{url("admin/notices")}}">发布公告</a></li>
                    <li><a href="{{url("admin/messages")}}">发送消息</a></li>
                </ul>
            </dd>
        @endif
    </dl>
</div>
<div class="menu pull-left">
    <div class="lefttop"><span id="controller-close"></span>菜单选项</div>
    <dl class="leftmenu">
        <dd>
            <div class="title">
                <a href="{{asset("index")}}" class="index"><span><img src="{{url("images/index.png")}}" /></span>系统首页</a>
            </div>
        </dd>
        <dd>
            <div class="title">
                <span><img src="{{url("images/sign.png")}}" /></span>签到管理
            </div>
            <ul class="menuson" id="onactive-father-sign">
                <li id="onactive-sign-push"><cite></cite><a href="{{url("signmanager/courselist/push")}}">发布新签到</a><i></i></li>
                <li id="onactive-sign-pushed"><cite></cite><a href="{{url("signmanager/courselist/pushed")}}">已发布签到</a><i></i></li>
            </ul>
        </dd>
        <dd>
            <div class="title">
                <a href="{{url("course/list")}}" class="index"><span><img src="{{url("images/course.png")}}" /></span>课程管理</a>
            </div>
        </dd>
        <dd>
            <div class="title">
                <a href="{{url("student/courselist")}}" class="index"><span><img src="{{url("images/stu.png")}}" /></span>学生管理</a>
            </div>
        </dd>
        <dd><div class="title"><span><img src="{{url("images/person.png")}}" /></span>个人中心</div>
            <ul class="menuson" id="onactive-father-personal">
                <li id="onactive-personal-info"><cite></cite><a href="{{asset("personal/info")}}">我的资料</a><i></i></li>
                <li id="onactive-personal-passedit"><cite></cite><a href="{{asset("personal/passedit")}}">密码修改</a><i></i></li>
                <li id="onactive-personal-message"><cite></cite><a href="{{asset("personal/message")}}">消息中心</a><i></i></li>
            </ul>
        </dd>
        @if(session()->get("user_type") == 1)
            <dd><div class="title"><span><img src="{{url("images/manager.png")}}" /></span>系统管理</div>
                <ul class="menuson" id="onactive-father-system">
                    <li id="onactive-system-teacher"><cite></cite><a href="{{url("admin/teachers")}}">教师管理</a><i></i></li>
                    <li id="onactive-system-classroom"><cite></cite><a href="{{url("admin/classRooms")}}">教室管理</a><i></i></li>
                    <li id="onactive-system-student"><cite></cite><a href="{{url("admin/students")}}">学生管理</a><i></i></li>
                    <li id="onactive-system-course"><cite></cite><a href="{{url("admin/courses")}}">课程管理</a><i></i></li>
                    <li id="onactive-system-notice"><cite></cite><a href="{{url("admin/notices")}}">发布公告</a><i></i></li>
                    <li id="onactive-system-message"><cite></cite><a href="{{url("admin/messages")}}">发送消息</a><i></i></li>
                </ul>
            </dd>
        @endif
    </dl>
</div>
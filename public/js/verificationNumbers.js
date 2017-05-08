function showCheck(a){
	var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
	ctx.clearRect(0,0,1000,1000);
	ctx.font = "80px 'Microsoft Yahei'";
	ctx.fillText(a,0,100);
	ctx.fillStyle = "white";
}
var code ;    
function createCode(){       
    code = "";      
    var codeLength = 4;
    var selectChar = new Array(1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','j','k','l','m','n','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');      
    for(var i=0;i<codeLength;i++) {
       var charIndex = Math.floor(Math.random()*60);      
      code +=selectChar[charIndex];
    }      
    if(code.length != codeLength){      
      createCode();      
    }
    showCheck(code);
}
          
function validate () {
    var inputUser = document.getElementById("J_usertext").value;//用户名
    var inputPass = document.getElementById("J_passtext").value;//用户密码
    var inputCode = document.getElementById("J_codetext").value.toUpperCase();//验证码
    var codeToUp=code.toUpperCase();
    if(inputUser.length <=0){
        document.getElementById("J_usertext").setAttribute("placeholder","请输入工号")
        return false;
    }else if(inputPass.length <=0){
        document.getElementById("J_passtext").setAttribute("placeholder","请输入密码");
        return false;
    }else if(inputCode.length <=0) {
      document.getElementById("J_codetext").setAttribute("placeholder","输入验证码");
      createCode();
      return false;
    }
    else if(inputCode != codeToUp ){
      document.getElementById("J_codetext").value="";
      document.getElementById("J_codetext").setAttribute("placeholder","验证码错误");
      createCode();
      return false;
    }
    else {
      return true;
    }

}
var msgdsq;
function show_err_msg(msg){
    $('.msg_bg').html('');
    clearTimeout(msgdsq);
    $('body').append('<div class="sub_err" style="position:absolute;top:60px;left:0;width:500px;z-index:999999;"></div>');
    var errhtml='<div style="padding:8px 0px;border:1px solid #ff0000;width:100%;margin:0 auto;background-color:#fff;color:#B90802;border:3px #ff0000 solid;text-align:center;font-size:16px;font-family:微软雅黑;"><img style="margin-right:10px;" src="images/error.png">';
    var errhtmlfoot='</div>';
    $('.msg_bg').height($(document).height());
    $('.sub_err').html(errhtml+msg+errhtmlfoot);
    var left=($(document).width()-500)/2;
    $('.sub_err').css({'left':left+'px'});
    var scroll_height=$(document).scrollTop();
    $('.sub_err').animate({'top': scroll_height+120},300);
    msgdsq=setTimeout(function(){
        $('.sub_err').animate({'top': scroll_height+80},300);
        setTimeout(function(){
            $('.msg_bg').remove();
            $('.sub_err').remove();
        },300);
    }, "1000");
}

//正确时：提示调用方法
function show_msg(msg,url){
    $('.msg_bg').html('');
    clearTimeout(msgdsq);
    $('body').append('<div class="sub_err" style="position:absolute;top:60px;left:0;width:500px;z-index:999999;"></div>');
    var htmltop='<div style="padding:8px 0px;border:1px solid #090;width:100%;margin:0 auto;background-color:#FFF2F8;color:#090;border:3px #090 solid;;text-align:center;font-size:16px;"><img style="margin-right:10px;" src="images/success.png">';
    var htmlfoot='</div>';
    $('.msg_bg').height($(document).height());
    var left=($(document).width()-500)/2;
    $('.sub_err').css({'left':left+'px'});
    $('.sub_err').html(htmltop+msg+htmlfoot);
    var scroll_height=$(document).scrollTop();
    $('.sub_err').animate({'top': scroll_height+120},500);
    msgdsq=setTimeout(function(){
        $('.sub_err').animate({'top': scroll_height+80},500);
        setTimeout(function(){
            $('.msg_bg').remove();
            $('.sub_err').remove();
            if(url!='')
            {
                location.href=url;
            }
        },800);

    }, "1200");
}

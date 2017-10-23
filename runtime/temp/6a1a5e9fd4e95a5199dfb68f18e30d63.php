<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"F:\Aaron\GitHub\tp5_o2o\public/../application/admin\view\register\index.html";i:1497952452;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>注册 - 知乎 - Thousands Find</title>
	<meta author="zrong.me 曾荣">
	<link rel="stylesheet" type="text/css" href="__STATIC__/admin/css/admin-register-login.css">
</head>
<body>
<div id="box"></div>
<form method="post" action=<?php echo url('register/index'); ?>>
<div class="cent-box register-box">
	<div class="cent-box-header">
		<h1 class="main-title hide">乎之</h1>
		<h2 class="sub-title">是不是感觉很像某乎的登录后台丫？</h2>
	</div>

	<div class="cont-main clearfix">
		<div class="index-tab">
			<div class="index-slide-nav">
				<a href="<?php echo url('login/index'); ?>">登录</a>
				<a href="<?php echo url('register/index'); ?>" class="active">注册</a>
				<div class="slide-bar slide-bar1"></div>				
			</div>
		</div>

		<div class="login form">
			<div class="group">
				<div class="group-ipt email">
					<input type="email" name="email" id="email" class="ipt" placeholder="邮箱地址/用户名" required>
				</div>
				<div class="group-ipt mobile">
					<input type="mobile" name="mobile" id="mobile" class="ipt" placeholder="联系方式" required>
				</div>
				<div class="group-ipt user">
					<input type="text" name="user" id="user" class="ipt" placeholder="选择一个用户名" required>
				</div>
				<div class="group-ipt password">
					<input type="password" name="password" id="password" class="ipt" placeholder="设置登录密码" required>
				</div>
				<div class="group-ipt password1">
					<input type="password" name="password1" id="password1" class="ipt" placeholder="重复密码" required>
				</div>
				<div class="group-ipt verify">
					<input type="text" name="verify" id="verify" class="ipt" placeholder="请进入邮箱获取验证码" required>
				</div>
			</div>
		</div>

		<div class="button">
			<button type="submit" class="login-btn register-btn" id="button">注册</button>
		</div>
	</div>
</div>
</form>
<script src='__STATIC__/admin/js/admin-register-login/particles.js' type="text/javascript"></script>
<script src='__STATIC__/admin/js/admin-register-login/background.js' type="text/javascript"></script>
<script src='__STATIC__/admin/js/admin-register-login/jquery.min.js' type="text/javascript"></script>
<script src='__STATIC__/admin/js/admin-register-login/layer/layer.js' type="text/javascript"></script>
<script src='__STATIC__/admin/js/admin-register-login/index.js' type="text/javascript"></script>
<script>
	$('.imgcode').hover(function(){
		layer.tips("看不清？点击更换", '.verify', {
        		time: 6000,
        		tips: [2, "#3c3c3c"]
    		})
	},function(){
		layer.closeAll('tips');
	}).click(function(){
		$(this).attr('src','http://zrong.me/home/index/imgcode?id=' + Math.random());
	})

	$(".login-btn").click(function(){
		var email = $("#email").val();
		var password = $("#password").val();
		var verify = $("#verify").val();
		// $.ajax({
		// url: 'http://www.zrong.me/home/index/userLogin',
		// type: 'post',
		// jsonp: 'jsonpcallback',
  //       jsonpCallback: "flightHandler",
		// async: false,
		// data: {
		// 	'email':email,
		// 	'password':password,
		// 	'verify':verify
		// },
		// success: function(data){
		// 	info = data.status;
		// 	layer.msg(info);
		// }
		// })

	})
	$("#remember-me").click(function(){
		var n = document.getElementById("remember-me").checked;
		if(n){
			$(".zt").show();
		}else{
			$(".zt").hide();
		}
	})
</script>
</body>
</html>
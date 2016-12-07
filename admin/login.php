<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>登录</title>
	<style type="text/css">
	body{
		background: url("../images/1357c9994a929d32c485060e121b2552.jpg");
	}
	</style>
</head>
<body>
	<table align="center">
		<caption><h2>登录</h2></caption>
		<form action="login_action.php" method="post">
			<tr>
				<th>用户名</th>
				<td><input type="text" name="userName"></td>
			</tr>
			<tr>
				<th>密码</th>
				<td><input type="password" name="pass"></td>
			</tr>
			<tr>
				<th>验证码：</th>
				<td>
					<input type="text" name="yzm">
				</td>
			</tr>
			<tr>
				<td></td>
				<td><img src="public/yzm.php" onclick="this.src='./public/yzm.php?id='+Math.random();"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="reset" value="重置">
					<input type="submit" value="登录">
				</td>
			</tr>
		</form>
	</table>
	<?php
	//接收返回的错误信息
	switch ($_GET['state']) {
		case '1':
			echo '<center>账号不能为空</center>';
			break;
		
		case '2':
			echo '<center>密码不能为空</center>';
			break;

		case '3':
			echo '<center>验证码不能为空</center>';
			break;

		case '4':
			echo '<center>验证码错误</center>';
			break;

		case '5':
			echo '<center>该用户不存在或不是后台管理员</center>';
			break;

		case '6':
			echo '<center>密码错误</center>';
			break;

		default:
			# code...
			break;
	}
	?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>add</title>
	<style type="text/css">
	body{
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
	}
	.return{
		display: block;
		width: 50px;
		height: 20px;
		line-height: 20px;
		text-align: center;
		background:#2DA4FF;
		color: #fff;
		text-decoration: none;
	}
	.return:hover{
		background:#2D44FF;
	}

	</style>
</head>
<body>
	<a class="return" href="index.php">返回</a>
	<table width="300" align="center">
		<caption><h2>添加用户</h2></caption>
		<form action="add_action.php" method="post">
			<tr>
				<td>账号*</td>
				<td><input type="text" name="userName" placeholder="(以字母开头4-10位)"></td>
			</tr>
			<tr>
				<td>真实姓名</td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td>密码*</td>
				<td><input type="password" name="pass" placeholder="(任意8-20位)"></td>
			</tr>
			<tr>
				<td>确认密码*</td>
				<td><input type="password" name="pass2" placeholder="(任意8-20位)"></td>
			</tr>
			<tr>
				<td>性别*</td>
				<td>
					<input type="radio" name="sex" value="0" checked>男
					<input type="radio" name="sex" value="1">女
				</td>
			</tr>
			<tr>
				<td>电话</td>
				<td><input type="text" name="phone"></td>
			</tr>
			<tr>
				<td>邮箱</td>
				<td><input type="text" name="email"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="reset" value="重置">
					<input type="submit" value="添加">
				</td>
			</tr>
		</form>
	</table>

	<?php
	switch ($_GET['state']) {
		case '1':
			echo '<center>账号不能为空</center>';
			break;
		
		case '2':
			echo '<center>密码不能为空</center>';
			break;

		case '3':
			echo '<center>密码与确认密码不同</center>';
			break;

		case '4':
			echo '<center>该账户已存在</center>';
			break;

		case '5':
			echo '<center>添加错误</center>';
			break;
		
		case '6':
			echo '<center>用户名或密码不符合规则</center>';
			break;

		case '7':
			echo '<center>请输入正确的手机号</center>';
			break;

		case '8':
			echo '<center>请输入正确的邮箱</center>';
			break;

		default:
			# code...
			break;
	}
	?>
</body>
</html>
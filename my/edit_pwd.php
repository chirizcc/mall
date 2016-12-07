<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>修改密码</title>
	<link rel="stylesheet" type="text/css" href="../css/globalStyle.css">
</head>
<body>
	<div class="myinfo-content">
		<div class="title">修改密码</div>
		<div class="gap10"></div>
		<div class="head-line"></div>
		<div class="gap10"></div>
		<div class="edit-pwd">
			<form action="edit_pwd_action.php" method="post">
				<table>
					<tr>
						<td>请输入旧密码:</td>
						<td><input type="password" name="oldpwd"></td>
					</tr>
					<tr>
						<td>请输入新密码:</td>
						<td><input type="password" name="newpwd"></td>
					</tr>
					<tr>
						<td>请确认新密码:</td>
						<td><input type="password" name="newpwd2"></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" value="修改">
						</td>
					</tr>
				</table>
			</form>
		</div>
		<?php
		switch ($_GET['state']) {
			case '1':
				echo '<center>密码不能为空</center>';
				break;

			case '2':
				echo '<center>密码与确认密码不相同</center>';
				break;

			case '3':
				echo '<center>修改失败</center>';
				break;
			
			case '4':
				echo '<center>旧密码错误</center>';
				break;

			case '5':
				echo '<center>密码不符合规则</center>';
				break;

			case '6':
				echo '<center>新旧密码不能相等</center>';
				break;

			default:
				# code...
				break;
		}
		?>
	</div>
</body>
</html>
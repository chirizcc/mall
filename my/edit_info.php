<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>修改信息</title>
	<link rel="stylesheet" type="text/css" href="../css/globalStyle.css">
</head>
<body>
	<div class="myinfo-content">
		<div class="title">修改信息</div>
		<div class="gap10"></div>
		<div class="head-line"></div>
		<div class="gap10"></div>
		<form action="edit_info_action.php" method="post">
			<div class="edit-info">
				<table>
					<?php
					include '../public/db.php';
					session_start();

					$link = connectDB();
					$id = $_SESSION['id'];

					$sql = "select * from users where id = {$id}";
					$res = mysqli_query($link,$sql);
					$row = mysqli_fetch_assoc($res);
					?>
					<tr>
						<td>账号：</td>
						<td><input type="text" name="username" value="<?php echo $row['username']; ?>"></td>
					</tr>
					<tr>
						<td>姓名：</td>
						<td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
					</tr>
					<tr>
						<td>性别：</td>
						<td>
							<input type="radio" name="sex" value="0" <?php echo $row['sex'] == 0 ? 'checked' : ''; ?> >男
							<input type="radio" name="sex" value="1" <?php echo $row['sex'] == 1 ? 'checked' : ''; ?>>女
						</td>
					</tr>
					<tr>
						<td>电话：</td>
						<td><input type="text" name="phone" value="<?php echo $row['phone']; ?>"></td>
					</tr>
					<tr>
						<td>邮箱：</td>
						<td><input type="text" name="email" value="<?php echo $row['email']; ?>"></td>
					</tr>
				</table>
			</div>
			<div class="gap10"></div>
			<div class="button">
				<input type="reset" value="重置">
				<input type="submit" value="修改">
				<div class="clear"></div>
			</div>
		</form>
		<?php
		switch ($_GET['state']) {
			case '1':
				echo '<center>用户名不能为空</center>';
				break;

			case '2':
				echo '<center>该账户已存在</center>';
				break;

			case '3':
				echo '<center>修改失败</center>';
				break;

			case '4':
				echo '<center>请输入正确的手机号</center>';
				break;

			case '5':
				echo '<center>请输入正确的邮箱</center>';
				break;

			case '6':
				echo '<center>用户名不符合规则</center>';
				break;

			default:
				# code...
				break;
		}
		?>
	</div>
</body>
</html>
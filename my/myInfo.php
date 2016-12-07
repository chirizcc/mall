<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>个人中心</title>
	<link rel="stylesheet" type="text/css" href="../css/globalStyle.css">
</head>
<body>
	<div class="myinfo-content">
		<div class="title">账号信息</div>
		<div class="gap10"></div>
		<div class="head-line"></div>
		<div class="gap10"></div>
		<div class="info">
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
					<td colspan="2">
						<a href="edit_image.php" title="修改头像"><img src="../images/usersImages/<?php echo $row['picname']; ?>"></a>
					</td>
				</tr>
				<tr>
					<td>账号：</td>
					<td><?php echo $row['username']; ?></td>
				</tr>
				<tr>
					<td>姓名：</td>
					<td><?php echo $row['name']; ?></td>
				</tr>
				<tr>
					<td>性别：</td>
					<td><?php echo $row['sex'] == 0 ? '男' : '女'; ?></td>
				</tr>
				<tr>
					<td>等级：</td>
					<td>
						<?php 
						if($row['integral'] < 2000){
							$level = 'LV1会员';
						}elseif($row['integral'] < 5000){
							$level = 'LV2会员';
						}elseif($row['integral'] < 10000){
							$level = 'LV3会员';
						}elseif($row['integral'] < 20000){
							$level = 'LV4会员';
						}else{
							$level = 'LV5会员';
						}
						echo $level;
						?>
					</td>
				</tr>
				<tr>
					<td>电话：</td>
					<td><?php echo $row['phone']; ?></td>
				</tr>
				<tr>
					<td>邮箱：</td>
					<td><?php echo $row['email']; ?></td>
				</tr>
			</table>
		</div>
		<div class="gap10"></div>
		<div class="button">
			<a class="floatL" href="edit_pwd.php">修改密码</a>
			<a class="floatL marginL" href="edit_info.php">修改信息</a>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>
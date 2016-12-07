<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>修改头像</title>
	<link rel="stylesheet" type="text/css" href="../css/globalStyle.css">
</head>
<body>
	<div class="myinfo-content">
		<div class="title">修改头像</div>
		<div class="gap10"></div>
		<div class="head-line"></div>
		<div class="gap10"></div>
		<div class="info">
			<?php
			include '../public/db.php';
			session_start();

			$link = connectDB();
			$id = $_SESSION['id'];

			$sql = "select picname from users where id = {$id}";
			$res = mysqli_query($link,$sql);
			$row = mysqli_fetch_assoc($res);
			?>
			<table>
				<form action="edit_image_action.php" method="post" enctype="multipart/form-data">
					<tr>
						<td colspan="2">
							<img src="../images/usersImages/<?php echo $row['picname'] ?>">
						</td>
					</tr>
					<tr>
						<td>新头像</td>
						<td>
							<input type="file" name="file">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input class="filesubmit" type="submit" value="上传">
						</td>
					</tr>
				</form>
			</table>
			<?php
			switch ($_GET['state']) {
				case '1':
					echo '<center>图片不能为空</center>';
					break;

				case '2':
					echo '<center>上传失败</center>';
					break;

				case '3':
					echo '<center>缩放失败</center>';
					break;

				case '4':
					echo '<center>失败</center>';
					break;
					
				default:
					# code...
					break;
			}
		?>
		</div>				
	</div>
</body>
</html>
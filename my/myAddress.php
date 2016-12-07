<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>个人中心</title>
	<link rel="stylesheet" type="text/css" href="../css/globalStyle.css">
</head>
<body>
	<div class="myorder-content">
		<div class="title">我的地址</div>
		<div class="gap10"></div>
		<div class="head-line"></div>
		<div class="gap20"></div>
		<div class="address">
			<a class="newAdd" href="../newAddress.php" target="_top">添加新地址</a>
			<div class="gap10"></div>
			<?php
			include '../public/db.php';
			session_start();

			$link = connectDB();
			$id = $_SESSION['id'];

			$sql = "select * from address where uid = {$id}";
			$res = mysqli_query($link,$sql);
			?>
			<table cellspacing="0">
				<tr>
					<td>详细地址</td>
					<td>联系人</td>
					<td>联系电话</td>
					<td>操作</td>
				</tr>
				<?php

				while($row = mysqli_fetch_assoc($res)){
					
					?>
					<tr class="address-item">
						<td><?php echo $row['address']; ?></td>
						<td><?php echo $row['linkman']; ?></td>
						<td><?php echo $row['phone']; ?></td>
						<td><a href="../editAddress.php?aid=<?php echo $row['id']; ?>" target="_top">编辑</a> <a href="delAddress.php?aid=<?php echo $row['id']; ?>">删除</a></td>
					</tr>

					<?php
				}

				?>
			</table>

		</div>
	</div>
</body>
</html>
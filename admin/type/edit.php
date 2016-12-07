<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>type-edit</title>
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
	<?php

	include '../public/db.php';

	$id = $_GET['id'];
	$link = connectDB();
	$sql = "select * from type where id = {$id}";
	$res = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($res);

	?>
	<a class="return" href="index.php">返回</a>
	<table border="1" width="300" align="center">
		<caption><h2>修改类别</h2></caption>
		<form action="edit_action.php" method="post">
			<tr>
				<th>id</th>
				<td><input type="hidden" name="id" value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></td>
			</tr>
			<tr>
				<th>类别名</th>
				<td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="reset" value="重置">
					<input type="submit" value="修改">
				</td>
			</tr>
		</form>
	</table>

	<?php
	switch ($_GET['state']) {
		case '1':
			echo '<center>类别名不能为空</center>';
			break;

		case '2':
			echo '<center>修改失败</center>';
			break;

		default:
			# code...
			break;
	}
?>

</body>
</html>
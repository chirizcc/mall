<?php

include '../public/db.php';
date_default_timezone_set('PRC');

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$link = connectDB();
if(!$link){
	echo '数据库连接失败';
}

//根据id获取记录
$id = $_GET['id'];
$sql = "select * from users where id = $id";
$res = mysqli_query($link,$sql);

if($res->num_rows != 1){
	header('location:index.php');
}

$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>修改密码</title>
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
	<a class="return" href="<?=$_SERVER['HTTP_REFERER']?>">返回</a>
	<table border="1" width="300" align="center">
		<caption><h2>修改密码</h2></caption>
		<form action="pwd_action.php" method="post">
			<tr>
				<td>id:</td>
				<td>
					<?php echo $row['id']; ?>
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
				</td>
			</tr>
			<tr>
				<td>账号:</td>
				<td><?php echo $row['username']; ?></td>
			</tr>
			<tr>
				<td>真实姓名:</td>
				<td><?php echo $row['name']; ?></td>
			</tr>
			<tr>
				<td>新密码:</td>
				<td><input type="password" name="newpwd"></td>
			</tr>
			<tr>
				<td>确认密码:</td>
				<td><input type="password" name="newpwd2"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="reset" value="重置">
					<input type="submit" value="修改" <?php if($_SESSION['myState'] == 0 && $row['state'] == 0 && $_SESSION['uid'] != $row['id']) echo 'disabled';?>>
				</td>
			</tr>
		</form>
	</table>
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
			echo '<center>密码不符合规则</center>';
			break;
		
		default:
			# code...
			break;
	}
?>
</body>
</html>
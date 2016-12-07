<?php

include '../public/db.php';
date_default_timezone_set('PRC');
session_start();

$name = $_SESSION['userName'];
$id = $_SESSION['uid'];

$link = connectDB();
if(!$link){
	echo '数据库连接失败';
}

$sql = "select * from users where id = '{$id}'";
$res = mysqli_query($link,$sql);

//判断是否有这条记录
if($res->num_rows != 1){
	header('location:index.php');
}

$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>my</title>
	<style type="text/css">
	body{
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
	}
	</style>
</head>
<body>
	<table width="300" align="center" border="1" cellspacing="0">

	<caption><h2>查看用户</h2></caption>
	<tr>
		<td colspan="2">
			<a style="float:left" href="edit.php?id=<?php echo $id; ?>">修改信息</a>
			<a style="float:right" href="editpwd.php?id=<?php echo $id; ?>">修改密码</a>
		</td>
	</tr>
	<tr>
		<td>id</td>
		<td><?php echo $row['id']; ?></td>
	</tr>
	<tr>
		<td>账号</td>
		<td><?php echo $row['username']; ?></td>
	</tr>
	<tr>
		<td>真实姓名</td>
		<td><?php echo $row['name']; ?></td>
	</tr>
	
	<tr>
		<td>性别</td>
		<td>
			<?php
			$sex = $row['sex'] == 0 ? '男' : '女';
			echo $sex;
			?>
		</td>
	</tr>
	<tr>
		<td>电话</td>
		<td><?php echo $row['phone']; ?></td>
	</tr>
	<tr>
		<td>邮箱</td>
		<td><?php echo $row['email']; ?></td>
	</tr>
	<tr>
		<td>注册时间</td>
		<td><?php echo date('Y-m-d H:i:s',$row['addtime']); ?></td>
	</tr>
	<tr>
		<td>权限</td>
		<td>
			<?php
			$state = $row['state'] == 0 ? '管理员' : '超级管理员';
			echo $state;
			?>
		</td>
	</tr>
</table>
</body>
</html>
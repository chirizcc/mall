<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<style type="text/css">
	body{
		background: url("../../images/6087cf9307d720c0130ad9b235ec556c.jpg") center;
	}
	</style>
</head>
<body>
	<?php
	session_start();
	echo '欢迎管理员：'.$_SESSION['userName'].' ';
	?>
	<a href="../logout.php" target="_top">退出</a>
</body>
</html>
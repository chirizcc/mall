<?php

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>首页</title>
</head>
<frameset rows="15%,*" border="0">
	<frame src="include/top.php" noresize></frame>
	<frameset cols="15%,*">
		<frame src="include/left.php" noresize></frame>
		<frame src="include/right.php" name="right"></frame>
	</frameset>
	<!-- <frame src="include/bottom.php" noresize></frame> -->
</frameset>
</html>
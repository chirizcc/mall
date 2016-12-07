<?php

include 'public/db.php';
session_start();

//获取表单内容
$userName = $_POST['userName'];
$pass = $_POST['pass'];
$yzm = $_POST['yzm'];

//表单内容检验
if(empty($userName)){
	header('location:login.php?state=1');
	die;
}

if(empty($pass)){
	header('location:login.php?state=2');
	die;
}

if(empty($yzm)){
	header('location:login.php?state=3');
	die;
}

if(strcasecmp($yzm, $_SESSION['yzm']) !== 0){
	header('location:login.php?state=4');
	die;
}

$link = connectDB();

//仅允许后台管理员登录
$sql = "select id,username,pass,state from users where username = '{$userName}' and state in (0,3)";
$res = mysqli_query($link,$sql);

//判断是否有这条记录
if(!$res->num_rows > 0){
	header('location:login.php?state=5');
}else{
	$row = mysqli_fetch_assoc($res);
	if($row['pass'] == md5($pass)){
		session_start();
		$_SESSION['adminLogin'] = 1;
		$_SESSION['userName'] = $row['username'];
		$_SESSION['uid'] = $row['id'];
		$_SESSION['myState'] = $row['state'];
		header('location:index.php');
		die;
	}else{
		header('location:login.php?state=6');
	}
}

<?php

session_start();
include '../public/db.php';

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "../login.php";</script>';
}

$id = $_SESSION['id'];

$link = connectDB();

$userName = trim($_POST['username']);
$name = trim($_POST['name']);
$sex = $_POST['sex'];
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);

if(empty($userName)){
	header('location:edit_info.php?state=1');//用户名为空
	die;
}

if(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,9}$/", $userName) == 0){
	header('location:edit_info.php?state=6');//不符合正则匹配
	die;
}

if(!empty($phone)){
	if(preg_match("/^1[3|4|5|7|8][0-9]{9}$/", $phone) == 0){
		header('location:edit_info.php?state=4');//不符合正则匹配
		die;
	}
}

if(!empty($email)){
	if(preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$email) == 0){
		header('location:edit_info.php?state=5');//不符合正则匹配
		die;
	}
}

//判断是否已有这个账号的记录
$sql = "select id from users where username = '{$userName}' and id != {$id}";
$res = mysqli_query($link,$sql);
if($res->num_rows != 0){
	header('location:edit_info.php?state=2');//该账户已存在
	die;
}else{

	//更新记录
	$sql = "update users set username = '{$userName}',name='{$name}',sex='{$sex}',phone='{$phone}',email='{$email}' where id = $id";

	$res = mysqli_query($link,$sql);
	if(!$res){
		header('location:edit_info.php?state=3');//添加错误
		die;
	}else{
		header('location:myInfo.php');
	}
}
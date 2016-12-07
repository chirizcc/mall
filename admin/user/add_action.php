<?php

include '../public/db.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$userName = trim($_POST['userName']);
$name = trim($_POST['name']);
$pass = trim($_POST['pass']);
$pass2 = trim($_POST['pass2']);
$sex = $_POST['sex'];
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$addtime = time();

// var_dump(empty($userName));
// die;

if(empty($userName)){
	header('location:add.php?state=1');//用户名为空
	die;
}

if(empty($pass)){
	header('location:add.php?state=2');//密码为空
	die;
}

if($pass != $pass2){
	header('location:add.php?state=3');//密码与确认密码不同
	die;
}

if(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,9}$/", $userName) == 0 || preg_match("/^.{8,20}$/", $pass) == 0){
	header('location:add.php?state=6');//不符合正则匹配
	die;
}

if(!empty($phone)){
	if(preg_match("/^1[3|4|5|7|8][0-9]{9}$/", $phone) == 0){
		header('location:add.php?state=7');//不符合正则匹配
		die;
	}
}

if(!empty($email)){
	if(preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$email) == 0){
		header('location:add.php?state=8');//不符合正则匹配
		die;
	}
}

$userPwd = md5($pass);

$link = connectDB();

//判断账号是否已存在
$sql = "select id from users where username = '{$userName}'";
$res = mysqli_query($link,$sql);
if($res->num_rows != 0){
	header('location:add.php?state=4');//该账户已存在
	die;
}else{
	$sql = "insert into users (username,name,pass,sex,phone,email,addtime) values('{$userName}','{$name}','{$userPwd}','{$sex}','{$phone}','{$email}','{$addtime}')";

	$res = mysqli_query($link,$sql);
	if(!$res){
		header('location:add.php?state=5');//添加错误
		die;
	}else{
		header('location:index.php');
	}
}
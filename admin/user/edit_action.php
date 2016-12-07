<?php

include '../public/db.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

//获取表单内容
$id = $_POST['id'];
$userName = trim($_POST['userName']);
$name = trim($_POST['name']);
$sex = $_POST['sex'];
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$state = $_POST['state'];
$integral = $_POST['integral'];

if(empty($userName)){
	header('location:edit.php?id='.$id.'&state=1');//用户名为空
	die;
}

//正则匹配
if(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,9}$/", $userName) == 0){
	header('location:edit.php?id='.$id.'&state=6');//不符合正则匹配
	die;
}


if(!empty($phone)){
	if(preg_match("/^1[3|4|5|7|8][0-9]{9}$/", $phone) == 0){
		header('location:edit.php?id='.$id.'&state=4');//不符合正则匹配
		die;
	}
}

if(!empty($email)){
	if(preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$email) == 0){
		header('location:edit.php?id='.$id.'&state=5');//不符合正则匹配
		die;
	}
}

$link = connectDB();

//判断是否已有这个账号的记录
$sql = "select id from users where username = '{$userName}' and id != {$id}";
$res = mysqli_query($link,$sql);
if($res->num_rows != 0){
	header('location:edit.php?id='.$id.'&state=2');//该账户已存在
	die;
}else{

	//更新记录
	$sql = "update users set username = '{$userName}',name='{$name}',sex='{$sex}',phone='{$phone}',email='{$email}',state='{$state}',integral={$integral} where id = $id";

	$res = mysqli_query($link,$sql);
	if(!$res){
		header('location:edit.php?id='.$id.'&state=3');//添加错误
		die;
	}else{
		header('location:index.php');
	}
}
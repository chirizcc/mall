<?php

include 'public/db.php';
session_start();

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
	die;
}

$link = connectDB();

$userid = $_SESSION['id'];

$linkman = str_replace("'",'"',trim($_POST['linkman']));
$address = str_replace("'",'"',trim($_POST['address']));
$code = trim($_POST['code']);
$phone = trim($_POST['phone']);

if(empty($linkman) || empty($address) || empty($code) || empty($phone)){
	header('location:newAddress.php?state=1');//不能为空
	die;
}

if(preg_match("/^\d{6}$/", $code) == 0){
	header('location:newAddress.php?state=2');//邮编错误
	die;
}

if(preg_match("/^1[3|4|5|7|8][0-9]{9}$/", $phone) == 0){
	header('location:newAddress.php?state=3');//手机号错误
	die;
}

$sql = "insert into address (uid,address,code,phone,linkman) values ({$userid},'{$address}','{$code}','{$phone}','{$linkman}')";
$res = mysqli_query($link,$sql);
if(!$res){
	header('location:newAddress.php?state=4');//添加失败
	die;
}

header('location:my.php?state=2');//添加成功
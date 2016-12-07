<?php

include 'public/db.php';
session_start();

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
	die;
}

$link = connectDB();

$aid = $_POST['aid'];
$linkman = str_replace("'",'"',trim($_POST['linkman']));
$address = str_replace("'",'"',trim($_POST['address']));
$code = trim($_POST['code']);
$phone = trim($_POST['phone']);

if(empty($linkman) || empty($address) || empty($code) || empty($phone)){
	header('location:editAddress.php?aid='.$aid.'&state=1');//不能为空
	die;
}

if(preg_match("/^\d{6}$/", $code) == 0){
	header('location:editAddress.php?aid='.$aid.'&state=2');//邮编错误
	die;
}

if(preg_match("/^1[3|4|5|7|8][0-9]{9}$/", $phone) == 0){
	header('location:editAddress.php?aid='.$aid.'&state=3');//手机号错误
	die;
}

$sql = "update address set address = '{$address}',code = '{$code}',phone = '{$phone}',linkman = '{$linkman}' where id = {$aid}";
$res = mysqli_query($link,$sql);
if(!$res){
	header('location:editAddress.php?aid='.$aid.'&state=4');//添加失败
	die;
}

header('location:my.php?state=2');//修改成功
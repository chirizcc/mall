<?php

include '../public/db.php';
session_start();

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "../login.php";</script>';
	die;
}


$id = $_SESSION['id'];
$aid = $_GET['aid'];

$link = connectDB();
$sql = "select * from address where uid = {$id} and id = {$aid}";
$res = mysqli_query($link,$sql);
if($res->num_rows != 1){
	header('location:myAddress.php');
	die;
}

$sql = "delete from address where id = {$aid}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("删除失败");window.location = "myAddress.php";</script>';
	die;
}

header('location:myAddress.php');
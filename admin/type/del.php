<?php

include '../public/db.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$id = $_GET['id'];

$link = connectDB();
$sql = "select id from type where pid = {$id}";
$res = mysqli_query($link,$sql);

if($res->num_rows > 0){
	echo '<script>alert("请先删除子类别");window.location = "index.php";</script>';
	die;
}

$sql = "delete from type where id = {$id}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("该类下还有商品，无法删除");window.location = "index.php";</script>';
	die;
}else{
	$url = $_SERVER['HTTP_REFERER'];//返回上一页
	header("location:$url");
	die;
}
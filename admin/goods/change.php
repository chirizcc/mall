<?php

include '../public/db.php';
$link = connectDB();

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$imageid = $_GET['imageid'];
$goodid = $_GET['goodid'];

if(empty($imageid) || empty($goodid)){
	$url = $_SERVER['HTTP_REFERER'];
	header("location:$url");
	die;
}

$sql = "select picname,state from images where id = {$imageid} and goodsid = {$goodid}";
$res = mysqli_query($link,$sql);
if($res->num_rows != 1){
	$url = $_SERVER['HTTP_REFERER'];
	header("location:$url");
	die;
}

$row = mysqli_fetch_assoc($res);

if($row['state'] == 0){
	echo '<script>alert("该图片已经是封面");window.history.go(-1);</script>';
	die;
}

$sql = "update images set state = 1 where state = 0 and goodsid = {$goodid}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("设置失败");window.history.go(-1);</script>';
	die;
}

$sql = "update images set state = 0 where id = {$imageid}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("1设置失败");window.history.go(-1);</script>';
	die;
}
$url = $_SERVER['HTTP_REFERER'];
header("location:$url");
die;
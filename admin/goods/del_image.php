<?php

include '../public/db.php';
$link = connectDB();

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$div = '../../images/goodsImages';

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
$picname = $row['picname'];

if($row['state'] == 0){
	echo '<script>alert("封面无法删除");window.history.go(-1);</script>';
	die;
}

$sql = "delete from images where id = {$imageid}";
$res = mysqli_query($link,$sql);
if(!res){
	echo '<script>alert("删除失败");window.history.go(-1);</script>';
	die;
}

unlink($div.'/l_'.$picname);
unlink($div.'/m_'.$picname);
unlink($div.'/s_'.$picname);

$url = $_SERVER['HTTP_REFERER'];
header("location:$url");
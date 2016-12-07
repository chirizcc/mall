<?php
include '../public/db.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$pid = $_POST['pid'];
$name = str_replace("'",'',trim($_POST['name']));

if(empty($name)){
	echo '<script>alert("类型名不能为空");window.history.go(-1);</script>';
	die;
}

$link = connectDB();

$sql = "select count(id) as count from type";
$row = mysqli_fetch_assoc(mysqli_query($link,$sql));
$count = $row['count'];
if($count >= 12){
	echo '<script>alert("类型数量过多，请先删除无用的类型");window.history.go(-1);</script>';
	die;
}


if($pid == 0){
	$path = $pid.',';
}else{
	$sql = 'select path from type where id = '.$pid;
	$res = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($res);
	$path = $row['path'].$pid.',';
}

$sql = "insert into type (name,pid,path) values ('{$name}',{$pid},'{$path}')";
$res = mysqli_query($link,$sql);

if(!$res){
	echo '<script>alert("添加失败");window.history.go(-1);</script>';
	die;
}else{
	// header('location:index.php');
	$url = $_SERVER['HTTP_REFERER'];
	header("location:$url");
}
<?php

include '../public/db.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$link = connectDB();
$id = $_POST['id'];
$name = str_replace("'",'',trim($_POST['name']));

if(empty($name)){
	header('location:edit.php?id='.$id.'&state=1');
	die;
}

$sql = "update type set name = '{$name}' where id = {$id}";
$res = mysqli_query($link,$sql);

if(!$res){
	header('location:edit.php?id='.$id.'&state=2');
	die;
}else{
	header('location:index.php');
}
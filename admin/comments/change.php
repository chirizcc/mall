<?php

include '../public/db.php';

$link = connectDB();

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$id = $_GET['id'];
$state = $_GET['state'];

if(!($state == 1 || $state == 0)){
	header('location:index.php');
	die;
}

$sql = "update comments set state = {$state} where id = {$id}";
mysqli_query($link,$sql);
header('location:index.php');
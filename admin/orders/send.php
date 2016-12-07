<?php

include '../isLogin.php';
include '../public/db.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$link = connectDB();

$id = $_GET['id'];

//发货更新订单状态
$sql = "update orders set status = 2 where id = {$id}";
mysqli_query($link,$sql);
header('location:index.php');
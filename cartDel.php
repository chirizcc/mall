<?php

include 'public/db.php';
session_start();

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
	die;
}

$link = connectDB();

$userid = $_SESSION['id'];
$goodsid = $_GET['goodsid'];

//根据用户id获取购物车id
$orderid = mysqli_fetch_assoc(mysqli_query($link,"select id from orders where uid = {$userid} and status = 0"))['id'];
if($orderid == null){
	header('location:cart.php');
	die;
}

//获取目前库存以及原本的购买数量
$store = mysqli_fetch_assoc(mysqli_query($link,"select store from goods where id = {$goodsid}"))['store'];
$num = mysqli_fetch_assoc(mysqli_query($link,"select num from detail where orderid = {$orderid} and goodsid = {$goodsid}"))['num'];
if($num == null){
	header('location:cart.php');
	die;
}

$nowstore = $store + $num;

//从购物车中删除
$sql = "delete from detail where orderid = {$orderid} and goodsid = {$goodsid}";
mysqli_query($link,$sql);

//更新库存
$sql = "update goods set store = {$nowstore} where id = {$goodsid}";
mysqli_query($link,$sql);

header('location:cart.php');
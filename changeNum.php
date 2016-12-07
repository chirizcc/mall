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
$num = $_GET['num'];

//根据用户id获取购物车id
$orderid = mysqli_fetch_assoc(mysqli_query($link,"select id from orders where status = 0 and uid = {$userid}"))['id'];
if($orderid == null){
	header('location:cart.php');
	die;
}

//如果num=0则从购物车总删除这个商品，并且库存加1
if($num == 0){
	$sql = "delete from detail where orderid = {$orderid} and goodsid = {$goodsid}";
	mysqli_query($link,$sql);

	$store = mysqli_fetch_assoc(mysqli_query($link,"select store from goods where id = {$goodsid}"))['store'];

	$nowstore = $store + 1;
	$sql = "update goods set store = {$nowstore} where id = {$goodsid}";
	mysqli_query($link,$sql);
	header('location:cart.php');
	die;
}

//获取目前库存已经原本的购买数量
$store = mysqli_fetch_assoc(mysqli_query($link,"select store from goods where id = {$goodsid}"))['store'];
$old = mysqli_fetch_assoc(mysqli_query($link,"select num from detail where orderid = {$orderid} and goodsid = {$goodsid}"))['num'];
if($old == null){
	header('location:cart.php');
	die;
}

//购买数量不能超出库存
$nowstore = $store + $old - $num;
if($nowstore < 0){
	echo '<script>alert("购买数量超出库存");window.location = "cart.php";</script>';
	die;
}

//库存足够则更改数量
$sql = "update detail set num = {$num} where orderid = {$orderid} and goodsid = {$goodsid}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("数量更改失败");window.location = "cart.php";</script>';
	die;
}

//更新库存
$sql = "update goods set store = {$nowstore} where id = {$goodsid}";
mysqli_query($link,$sql);

header('location:cart.php');
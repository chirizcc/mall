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

//更新订单状态
$sql = "update orders set status = 4 where id = {$id}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("关闭订单失败");window.location = "index.php";</script>';
	die;
}

//关闭订单成功将订单中的数量返还给商品库存
$sql = "select goodsid,num from detail where orderid = {$id}";
$res = mysqli_query($link,$sql);
while($row = mysqli_fetch_assoc($res)){

	$store = mysqli_fetch_assoc(mysqli_query($link,"select store from goods where id = {$row['goodsid']}"))['store'];
	$store += $row['num'];
	mysqli_query($link,"update goods set store = {$store} where id = {$row['goodsid']}");

}

header('location:index.php');
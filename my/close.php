<?php

include '../public/db.php';
session_start();

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "../login.php";</script>';
	die;
}

$link = connectDB();

$id = $_SESSION['id'];
$oid = $_GET['orderid'];

$sql = "select * from orders where status = 1 and uid = {$id} and id = {$oid}";
$res = mysqli_query($link,$sql);
if($res->num_rows != 1){
	header('location:myOrder.php');
	die;
}

//更新订单状态
$sql = "update orders set status = 4 where id = {$oid}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("关闭订单失败");window.location = "index.php";</script>';
	die;
}

//关闭订单成功将订单中的数量返还给商品库存
$sql = "select goodsid,num from detail where orderid = {$oid}";
$res = mysqli_query($link,$sql);
while($row = mysqli_fetch_assoc($res)){

	$store = mysqli_fetch_assoc(mysqli_query($link,"select store from goods where id = {$row['goodsid']}"))['store'];
	$store += $row['num'];
	mysqli_query($link,"update goods set store = {$store} where id = {$row['goodsid']}");

}
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

$sql = "select * from orders where status = 2 and uid = {$id} and id = {$oid}";
$res = mysqli_query($link,$sql);
if($res->num_rows != 1){
	header('location:myOrder.php');
	die;
}
$total = mysqli_fetch_assoc($res)['total'];

$sql = "update orders set status = 3 where id = {$oid}";
mysqli_query($link,$sql);

//更新购买量
$sql = "select goodsid,num from detail where orderid = {$oid}";
$res = mysqli_query($link,$sql);
while($row = mysqli_fetch_assoc($res)){
	$sql = "update goods set num = num + {$row['num']} where id = {$row['goodsid']}";
	mysqli_query($link,$sql);
}

//更新积分
$sql = "update users set integral = integral + {$total} where id = {$id}";
mysqli_query($link,$sql);

header('location:myOrder.php');
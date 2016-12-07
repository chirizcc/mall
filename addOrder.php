<?php

include 'public/db.php';
session_start();

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
	die;
}

$link = connectDB();

$userid = $_SESSION['id'];

$aid = $_POST['address'];
if(empty($aid)){
	echo '<script>alert("请选择收货地址");window.location = "order.php";</script>';
	die;
}

//获取购物车的订单id
$sql = "select id from orders where uid = {$userid} and status = 0";
$orderid = mysqli_fetch_assoc(mysqli_query($link,$sql))['id'];
if(empty($orderid)){
	header('location:cart.php');
	die;
}

//获取地址信息
$sql = "select * from address where id = {$aid}";
$ainfo = mysqli_fetch_assoc(mysqli_query($link,$sql));

//计算订单金额
$total = 0;
$info = '';
$sql = "select name,num,price from detail where orderid = {$orderid}";
$res = mysqli_query($link,$sql);
if($res->num_rows == 0){
	header('location:cart.php');
	die;
}
while($row = mysqli_fetch_assoc($res)){
	$total += $row['num'] * $row['price'];
	$info = $info.' '.$row['name'].'&times;'.$row['num'];
}

//根据积分优惠
$integral = mysqli_fetch_assoc(mysqli_query($link,"select integral from users where id = {$userid}"))['integral'];
if($integral < 2000){
	$discount = 1;
}elseif($integral < 5000){
	$discount = 0.98;
}elseif($integral < 10000){
	$discount = 0.95;
}elseif($integral < 20000){
	$discount = 0.9;
}else{
	$discount = 0.88;
}
$total = $discount * $total;

//更新订单表信息
$time = time();
$sql = "update orders set linkman = '{$ainfo['linkman']}',address='{$ainfo['address']}',code='{$ainfo['code']}',phone='{$ainfo['phone']}',addtime='{$time}',total='{$total}',info='{$info}',status=1 where id = {$orderid}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("订单提交失败");window.location = "order.php";</script>';
	die;
}

header('location:my.php');
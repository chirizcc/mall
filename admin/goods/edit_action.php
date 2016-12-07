<?php

include '../public/db.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$id = $_POST['id'];
$goods = str_replace("'", '', trim($_POST['goods']));
$typeid = trim($_POST['typeid']);
$company = str_replace("'",'',trim($_POST['company']));
$price = trim($_POST['price']);
$store = $_POST['store'];
$state = $_POST['state'];
$descr = trim($_POST['descr']);
$descr = str_replace("'",'',$descr);//去除字符串中的单引号

if(empty($goods)){
	header('location:edit.php?id='.$id.'&state=2');
	die;
}

if(empty($price)){
	header('location:edit.php?id='.$id.'&state=3');
	die;
}

if(empty($descr)){
	header('location:edit.php?id='.$id.'&state=4');
	die;
}

if($store < 0 || $price <= 0){
	header('location:edit.php?id='.$id.'&state=7');
	die;
}

$link = connectDB();

$oldprice = mysqli_fetch_assoc(mysqli_query($link,"select price from goods where id = {$id}"))['price'];

$sql = "update goods set goods = '{$goods}',typeid = {$typeid},company = '{$company}',price = {$price},state = {$state},descr = '{$descr}',store = {$store} where id = {$id}";

$res = mysqli_query($link,$sql);
if(!$res){
	header('location:edit.php?id='.$id.'&state=1');
	die;
}else{

	//如果价格修改了，则页修改购物车中的商品价格
	if($oldprice != $price){

		$sql = "select d.id from orders as o,detail as d where o.id = d.orderid and o.`status` = 0 and d.goodsid = {$id}";
		$res = mysqli_query($link,$sql);
		while($row = mysqli_fetch_assoc($res)){
			mysqli_query($link,"update detail set price = {$price} where id = {$row['id']}");
		}

	}

	header('location:index.php');
	die;
}
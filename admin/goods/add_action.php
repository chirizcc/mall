<?php

include '../public/db.php';
include '../public/function.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

if($_POST['typeid'] == 0){
	header('location:add.php?state=1');
	die;
}

$goods = str_replace("'", '', trim($_POST['goods']));
$typeid = trim($_POST['typeid']);
$company = str_replace("'",'',trim($_POST['company']));
$price = trim($_POST['price']);
$descr = trim($_POST['descr']);
$descr = str_replace("'",'',$descr);//去除字符串中的单引号
$time = time();

if(empty($goods)){
	header('location:add.php?state=2');
	die;
}

if(empty($price) || $price <= 0){
	header('location:add.php?state=3');
	die;
}

if(empty($descr)){
	header('location:add.php?state=4');
	die;
}

if($_FILES['file']['error'] == 4){
	header('location:add.php?state=7');
	die;
}

$result = upload($_FILES['file'],'../../images/goodsImages');
if(!$result['result']){
	header('location:add.php?state=5');
	die;
}

$picname = $result['picname'];
$picpath="../../images/goodsImages/".$picname;

if(!(zoom($picpath,480,480,'l_') && zoom($picpath,200,200,'m_') && zoom($picpath,180,180,'s_'))){
	unlink($picpath);
	header('location:add.php?state=6');
	die;
}

unlink($picpath);

$link = connectDB();
$sql = "insert into goods (typeid,goods,company,descr,price,addtime) values({$typeid},'{$goods}','{$company}','{$descr}',$price,{$time})";
$res = mysqli_query($link,$sql);
if(!$res){
	unlink("../../images/goodsImages/l_".$picname);
	unlink("../../images/goodsImages/m_".$picname);
	unlink("../../images/goodsImages/s_".$picname);
	header('location:add.php?state=5');
	die;
}else{
	$id = mysqli_insert_id($link);
	$sql = "insert into images (goodsid,picname,state) values({$id},'{$picname}',0)";
	$res = mysqli_query($link,$sql);
	if(!res){
		mysqli_query($link,"delete from goods where id = {$id}");
		unlink("../../images/goodsImages/l_".$picname);
		unlink("../../images/goodsImages/m_".$picname);
		unlink("../../images/goodsImages/s_".$picname);
		header('location:add.php?state=5');
		die;
	}else{
		header('location:index.php');
		die;
	}
}
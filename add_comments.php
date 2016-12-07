<?php

include 'public/db.php';
session_start();

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
	die;
}

$link = connectDB();

$userid = $_SESSION['id'];
$goodsid = $_POST['goodsid'];
$content = str_replace("'", '"', $_POST['content']);
$time = time();

if(empty($content)){
	header('location:goods.php?id='.$goodsid.'#comment');
	die;
}

$sql = "select count(o.id) as count from orders as o,detail as d where o.id = d.orderid and o.`status` = 3 and o.uid = {$userid} and d.goodsid = {$goodsid}";
$buycount = mysqli_fetch_assoc(mysqli_query($link,$sql))['count'];
$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from comments where uid = {$userid} and goodsid = {$goodsid}"))['count'];

if(!($buycount > $count)){
	echo '<script>alert("已评论过或未购买");window.location = "goods.php?id='.$goodsid.'#comment";</script>';
	die;
}

if(!empty($_POST['anonymous'])){
	$sql = "insert into comments (uid,goodsid,content,addtime) values ({$userid},{$goodsid},'{$content}',{$time})";
}else{
	$sql = "insert into comments (uid,goodsid,content,anonymous,addtime) values ({$userid},{$goodsid},'{$content}',0,{$time})";
}
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("评论失败");window.location = "goods.php?id='.$goodsid.'#comment";</script>';
	die;
}
header('location:goods.php?id='.$goodsid.'#comment');
die;
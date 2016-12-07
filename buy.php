<?php

include 'public/db.php';
session_start();

$link = connectDB();

//验证登录状态
if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
	die;
}

$goodsid = $_GET['id'];
$num = empty($_GET['num']) ? 1 : (int)$_GET['num'];
$userid = $_SESSION['id'];

//判断购买数量
if($num <= 0){
	echo '<script>alert("数量错误");window.history.go(-1);</script>';
	die;
}

//验证商品状态
$sql = "select goods,price,store from goods where id = {$goodsid} and state != 3";
$res = mysqli_query($link,$sql);

if($res->num_rows == 0){
	echo '<script>alert("商品已下架或不存在");window.location = "index.php";</script>';
	die;
}

$goodsinfo = mysqli_fetch_assoc($res);
$name = $goodsinfo['goods'];
$price = $goodsinfo['price'];
$store = $goodsinfo['store'];

//验证库存
if($num > $store){
	echo '<script>alert("购买数量超出库存");window.history.go(-1);</script>';
	die;
}

//orders表中status字段为0的为购物车，如没有购物车就增加一条购物车记录，有则获取购物车id
$sql = "select id from orders where uid = {$userid} and status = 0";
$res = mysqli_query($link,$sql);
if($res->num_rows == 1){
	$orderid = mysqli_fetch_assoc($res)['id'];
}else{
	$res = mysqli_query($link,"insert into orders (uid,status) values ({$userid},0)");
	if(!$res){
		die('出错');
	}
	$orderid = mysqli_fetch_assoc(mysqli_query($link,"select id from orders where uid = {$userid} and status = 0"))['id'];
}

//判断购买的商品是否已在购物车中，在则增加数量，不在则添加记录
$sql = "select id,num from detail where orderid = {$orderid} and goodsid = {$goodsid}";
$res = mysqli_query($link,$sql);
if($res->num_rows == 1){
	$detailinfo = mysqli_fetch_assoc($res);
	$detailnum = $detailinfo['num'] + $num;
	$detailid = $detailinfo['id'];
	$res = mysqli_query($link,"update detail set num = '{$detailnum}' where id = {$detailid}");
	if(!$res){
		die('出错');
	}
}else{
	$sql = "insert into detail value(null,{$orderid},{$goodsid},'{$name}',{$price},{$num})";
	$res = mysqli_query($link,$sql);
	if(!$res){
		die('出错');
	}
}

//添加购物车成功更改库存数量
$nowStore = $store - $num;
if(!mysqli_query($link,"update goods set store = {$nowStore} where id = {$goodsid}")){
	die('出错');
}

?>
<script>
	if(confirm("添加购物车成功，是否前往购物车"))
        {
          window.location = "cart.php";
        }
        else 
        {
           window.history.go(-1);
        }
</script>
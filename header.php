<?php
include 'public/db.php';
session_start();

$link = connectDB();

$isLogin = 0;
$goodsnum = 0;
if(!empty($_SESSION['isLogin']) && $_SESSION['isLogin'] == 1){
	$isLogin = 1;
	$user = $_SESSION['user'];
	$id = $_SESSION['id'];

	$sql = "select count(d.id) as count from detail as d,orders as o where o.id = d.orderid and o.status = 0 and o.uid = {$id}";
	$res = mysqli_query($link,$sql);
	$goodsnum = mysqli_fetch_assoc($res)['count'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>360商城</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/globalStyle.css">
</head>
<body>
	<div class="head-top">
		<div class="top-content">
			<span class="floatR">
				<?php

				if($isLogin == 0){

				?>
				
				<a href="login.php">登录</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="register.php">注册</a>
				&nbsp;&nbsp;&nbsp;&nbsp;

				<?php

				}else{
					echo '<a href="my.php">'.$user.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="logout_action.php">退出</a>';
				}

				?>

				|&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="my.php">我的订单</a>
			</span>
			<div class="clear"></div>
		</div>
	</div>
	<div class="head-content">
		<div class="con-top">
			<a href="index.php"><img src="images/logo.png"></a>
			<div class="con-top-cart floatR">
				<a href="cart.php">我的购物车<span>(<?php echo $goodsnum; ?>)</span></a>
			</div>
			<div class="con-top-search floatR">
				<form action="brand.php" method="get">
					<input type="text" name="search" placeholder="请输入关键字">
					<input class="submit floatR" type="submit" value="搜索">
					<div class="clear"></div>
				</form>
			</div>
			<div class="clear"></div>
		</div>

		<div class="con-bottom">
			<div class="floatL"><a href="brand.php">全部商品</a></div>
			<ul class="floatL">
				<?php

				//点击量和购买量最高的商品所在的类
				$sql = "select t.id,t.name,g.clicknum+g.num as snum from goods as g,type as t where g.typeid = t.id and g.state != 3";
				$res = mysqli_query($link,$sql);
				while($row = mysqli_fetch_assoc($res)){
					$arr[$row['id']]['snum'] += $row['snum'];
					$arr[$row['id']]['name'] = $row['name'];
				}
				arsort($arr);
				$i = 0;
				foreach ($arr as $k => $v) {
					?>
					<li><a href="brand.php?typeid=<?php echo $k; ?>"><?php echo $v['name']; ?></a></li>
					<?php
					$i++;
					if($i >= 4){
						break;
					}
				}
				unset($i);
				?>
			</ul>
			<div class="clear"></div>
		</div>
	</div>
	<div class="head-line"></div>
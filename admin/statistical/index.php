<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>首页</title>
	<style type="text/css">
	body{
		padding: 0;
		margin: 0;
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
	}

	a:link,a:visited{
		text-decoration: none;
		color: #0000EE;
	}

	a:hover{
		color:red;
	}

	table tr td form{
		float:left;
	}

	table tr td{
		text-align: center;
	}

	table tr td .add{
		float:right;
	}
	</style>
</head>
<body>
	<?php

	session_start();
	include '../public/db.php';
	date_default_timezone_set('PRC');

	$link = connectDB();

	$userCount = mysqli_fetch_assoc(mysqli_query($link,"select count(id) as count from users"))['count'];
	$goodsCount = mysqli_fetch_assoc(mysqli_query($link,"select count(id) as count from goods"))['count'];
	$orderCount = mysqli_fetch_assoc(mysqli_query($link,"select count(id) as count from orders where status = 3"))['count'];
	$commentCount = mysqli_fetch_assoc(mysqli_query($link,"select count(id) as count from comments"))['count'];
	
	$numCount = 0;
	$moneyCount = 0;
	$sql = "select id,total from orders where status = 3";
	$res = mysqli_query($link,$sql);
	while($row = mysqli_fetch_assoc($res)){
		$sql = "select num from detail where orderid = {$row['id']}";
		$numres = mysqli_query($link,$sql);
		while($num = mysqli_fetch_assoc($numres)){
			$numCount += $num['num'];
		}
		$moneyCount += $row['total'];
	}


	?>
	<table border="1" cellspacing="0" align="center" width="500">
		<caption><h2>统计信息</h2></caption>

		<tr>
			<th>总用户数：</th>
			<td><?php echo $userCount; ?></td>
		</tr>

		<tr>
			<th>总商品数：</th>
			<td><?php echo $goodsCount; ?></td>
		</tr>

		<tr>
			<th>完成订单数：</th>
			<td><?php echo $orderCount; ?></td>
		</tr>

		<tr>
			<th>总评论数：</th>
			<td><?php echo $commentCount; ?></td>
		</tr>

		<tr>
			<th>已售商品数量：</th>
			<td><?php echo $numCount; ?></td>
		</tr>

		<tr>
			<th>销售额：</th>
			<td>&yen;<?php echo $moneyCount; ?></td>
		</tr>
	</table>
</body>
</html>
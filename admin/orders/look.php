<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<style type="text/css">
	body{
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
	}

	a:link,a:visited{
		text-decoration: none;
		color: #0000EE;
	}

	a:hover{
		color:red;
	}

	table tr td{
		text-align: center;
	}

	.return{
		display: block;
		width: 50px;
		height: 20px;
		line-height: 20px;
		text-align: center;
		background:#2DA4FF;
		color: #fff;
		text-decoration: none;
	}
	.return:hover{
		background:#2D44FF;
	}

	</style>
</head>
<body>
	<?php
	include '../public/db.php';
	date_default_timezone_set('PRC');
	$link = connectDB();

	$id = $_GET['id'];
	$sql = "select * from orders where id = {$id}";
	$res = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($res);
	?>
	<a class="return" href="index.php">返回</a>
	<table border="1" cellspacing="0" align="center" width="500">
		<caption><h2>订单详情</h2></caption>
		<tr>
			<th>id</th>
			<td><?php echo $row['id']; ?></td>
			<th>用户id</th>
			<td><?php echo $row['uid']; ?></td>
		</tr>
		<tr>
			<th>金额</th>
			<td><?php echo $row['total']; ?></td>
			<th>状态</th>
			<td>
				<?php

				$status = '';
				$operation = '';
				switch ($row['status']) {
					case '1':
						$status = '未发货';
						$operation = '<a href="send.php?id='.$row['id'].'">发货</a> <a href="">关闭订单</a>';
						break;
					
					case '2':
						$status = '已发货';
						break;

					case '3':
						$status = '已收货';
						break;

					case '4':
						$status = '已关闭';
						break;

					default:
						break;
				}

				echo $status;
				?>

			</td>
		</tr>
		<tr>
			<th>添加时间</th>
			<td><?php echo date('Y-m-d H:i:s',$row['addtime']) ?></td>
			<th>操作</th>
			<td><?php echo $operation; ?></td>
		</tr>
		<tr>
			<th>联系人</th>
			<td><?php echo $row['linkman']; ?></td>
			<th>联系电话</th>
			<td><?php echo $row['phone']; ?></td>
		</tr>
		<tr>
			<th>详细地址</th>
			<td colspan="3"><?php echo $row['address']; ?></td>
		</tr>
	</table>
	<br>

	<?php

	$sql = "select i.picname,d.goodsid,d.`name`,d.price,d.num from images as i,detail as d where i.goodsid = d.goodsid and i.state = 0 and d.orderid = {$id}";
	$res = mysqli_query($link,$sql);

	?>
	<table border="1" cellspacing="0" align="center" width="600">
		<tr><th colspan="6">商品详情</th></tr>
		<tr>
			<th>商品id</th>
			<th>图片</th>
			<th>商品名</th>
			<th>单价</th>
			<th>数量</th>
			<th>小计</th>
		</tr>
		<?php

		while($row = mysqli_fetch_assoc($res)){
			?>
			<tr>
				<td><?php echo $row['goodsid']; ?></td>
				<td><a href="../goods/look.php?id=<?php echo $row['goodsid']; ?>"><img src="../../images/goodsImages/s_<?php echo $row['picname']; ?>" width="60"></a></td>
				<td><a href="../goods/look.php?id=<?php echo $row['goodsid']; ?>"><?php echo $row['name']; ?></a></td>
				<td><?php echo $row['price']; ?></td>
				<td><?php echo $row['num']; ?></td>
				<td><?php echo $row['price'] * $row['num'] ?></td>
			</tr>
			<?php
		}

		?>
	</table>
</body>
</html>
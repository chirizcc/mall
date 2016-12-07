<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>订单详情</title>
	<link rel="stylesheet" type="text/css" href="../css/globalStyle.css">
</head>
<body>
	<div class="myorder-content">
		<div class="title">订单详情</div>
		<div class="gap10"></div>
		<div class="head-line"></div>
		<div class="gap20"></div>
		<div class="order-info">
			<?php

			include '../public/db.php';
			date_default_timezone_set('PRC');
			session_start();

			$link = connectDB();
			$id = $_SESSION['id'];
			$orderid = $_GET['orderid'];

			$sql = "select * from orders where id = {$orderid} and uid = {$id}";
			$res = mysqli_query($link,$sql);
			if($res->num_rows != 1){
				header('location:my.php');
				die;
			}

			$sql = "select i.picname,g.goods,g.id,d.num,d.price from orders as o,detail as d,goods as g,images as i where o.id = d.orderid and d.goodsid = g.id and i.goodsid = g.id and i.state = 0 and o.id = {$orderid}";
			$res = mysqli_query($link,$sql);

			?>
			<table cellspacing="0">
				<tr>
					<td>商品信息</td>
					<td>单价</td>
					<td>数量</td>
				</tr>
				<?php

				while($row = mysqli_fetch_assoc($res)){
					?>
					<tr>
						<td>
							<a href="../goods.php?id=<?php echo $row['id']; ?>" target="_top"><img width="60" src="../images/goodsImages/s_<?php echo $row['picname']; ?>">
							<?php echo $row['goods']; ?></a>
						</td>
						<td><?php echo $row['price']; ?></td>
						<td><?php echo $row['num']; ?></td>
					</tr>
					<?php
				}

				?>
			</table>
			<div class="gap20"></div>
			<?php

			$sql = "select * from orders where id = {$orderid}";
			$res = mysqli_query($link,$sql);
			$row = mysqli_fetch_assoc($res);
			switch ($row['status']) {
				case '1':
					$status = '未发货';
					break;

				case '2':
					$status = '已发货';
					break;

				case '3':
					$status = '已签收';
					break;

				case '4':
					$status = '已关闭';
					break;
				
				default:
					# code...
					break;
			}
			echo '<p>';
			echo '总金额：'.$row['total'];
			echo '</p>';
			echo '<div class="gap10"></div>';
			echo '<p>';
			echo '收货地址：'.$row['address'];
			echo '&nbsp;邮编：'.$row['code'];
			echo '&nbsp;联系人：'.$row['linkman'];
			echo '&nbsp;联系电话：'.$row['phone'];
			echo '</p>';
			echo '<div class="gap10"></div>';
			echo '<p>';
			echo '提交时间：'.date('Y-m-d H:i:s',$row['addtime']);
			echo '</p>';
			echo '<div class="gap10"></div>';
			echo '<p>';
			echo '订单状态：'.$status;
			echo '</p>';
			?>
			
		</div>
	</div>
</body>
</html>
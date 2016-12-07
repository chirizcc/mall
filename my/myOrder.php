<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>个人中心</title>
	<link rel="stylesheet" type="text/css" href="../css/globalStyle.css">
</head>
<body>
	<div class="myorder-content">
		<div class="title">我的订单</div>
		<div class="gap10"></div>
		<div class="nav">
			<ul>
				<li><a href="myOrder.php">全部订单</a></li>
				<li><a href="myOrder.php?state=1">待发货</a></li>
				<li><a href="myOrder.php?state=2">已发货</a></li>
				<li><a href="myOrder.php?state=3">已完成</a></li>
				<li><a href="myOrder.php?state=4">已关闭</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="gap10"></div>
		<div class="gap10"></div>
		<div class="orders">
			<?php
			include '../public/db.php';
			session_start();

			$link = connectDB();
			$id = $_SESSION['id'];

			$state = '';
			switch ($_GET['state']) {
				case '1':
					$state = ' and status = 1 ';
					break;
				
				case '2':
					$state = ' and status = 2 ';
					break;

				case '3':
					$state = ' and status = 3 ';
					break;

				case '4':
					$state = ' and status = 4 ';
					break;

				default:
					# code...
					break;
			}

			$nowPage = $_GET['page'] > 0 ? $_GET['page'] : 1;
			$size = 5;

			//获取符合条件的记录数
			$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from orders where uid = {$id} and status != 0 $state order by id desc"))['count'];
			$sumPage = ceil($count / $size);

			//计算当前页数
			$nowPage = $nowPage >= $sumPage ? $sumPage : $nowPage;

			//计算偏移量
			$limit = ($nowPage - 1) * $size;
			$limit = $limit < 0 ? 0 : $limit;

			$sql = "select * from orders where uid = {$id} and status != 0 $state order by id desc limit {$limit},{$size}";
			$res = mysqli_query($link,$sql);
			?>
			<table cellspacing="0">
				<tr>
					<td>订单信息</td>
					<td>订单金额</td>
					<td>订单状态</td>
					<td>操作</td>
				</tr>
				<?php

				while($row = mysqli_fetch_assoc($res)){
					switch ($row['status']) {
						case '1':
							$status = '待发货';
							break;

						case '2':
							$status = '已发货';
							break;

						case '3':
							$status = '已收货';
							break;

						case '4':
							$status = '无效订单';
							break;
						
						default:
							# code...
							break;
					}

					?>
					<tr>
						<td><a href="order_info.php?orderid=<?php echo $row['id']; ?>"><?php echo $row['info'] ?></a></td>
						<td><?php echo $row['total'] ?></td>
						<td><?php echo $status; ?></td>
						<td>
							<a href="order_info.php?orderid=<?php echo $row['id']; ?>">详情</a>
							<?php

							switch ($row['status']) {
								case '1':
									echo '<a href="close.php?orderid='.$row['id'].'">取消订单</a>';
									break;

								case '2':
									echo '<a href="confirm.php?orderid='.$row['id'].'">确认收货</a>';
									break;

								case '3':
									// echo '<a href="#">退换货</a>';
									break;

								default:
									break;
							}

							?>
						</td>
					</tr>

					<?php
				}

				?>
			</table>

			<div class="gap20"></div>
			<div class="page">
				<ul>
					<li><a href="myOrder.php?state=<?php echo $_GET['state'] ?>&page=1">&lt;&lt;</a></li>
					<li><a href="myOrder.php?state=<?php echo $_GET['state'] ?>&page=<?php echo $nowPage - 1; ?>">&lt;</a></li>
					<li><?php echo $nowPage.' / '.$sumPage; ?></li>
					<li><a href="myOrder.php?state=<?php echo $_GET['state'] ?>&page=<?php echo $nowPage + 1; ?>">&gt;</a></li>
					<li><a href="myOrder.php?state=<?php echo $_GET['state'] ?>&page=<?php echo $sumPage; ?>">&gt;&gt;</a></li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>
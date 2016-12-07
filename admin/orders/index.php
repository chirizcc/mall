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

	table tr td form{
		float: left;
	}

	table tr td .box{
		float: right;
	}

	</style>
</head>
<body>
	<?php
	include '../public/db.php';
	date_default_timezone_set('PRC');
	$link = connectDB();

	$status = '';
	switch ($_GET['state']) {

		case '1':
			$status = ' and status = 1 ';
			break;
		
		case '2':
			$status = ' and status = 2 ';
			break;

		case '3':
			$status = ' and status = 3 ';
			break;

		case '4':
			$status = ' and status = 4 ';
			break;

		default:
			break;
	}

	$search = trim($_GET['search']);
	if(empty($search)){
		$where = '';
	}else{

		$type = $_GET['type'];
		switch ($type) {
			case '0':
				$typename = 'id';
				break;
			case '1':
				$typename = 'uid';
				break;

			default:
				header('location:index.php');
				die;
				break;
		}
		$where = "and {$typename} like '%{$search}%' ";

	}

	$nowPage = $_GET['page'] > 0 ? $_GET['page'] : 1;
	$size = 5;

	//获取符合条件的记录数
	$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from orders where status != 0 $status $where"))['count'];

	$sumPage = ceil($count / $size);

	//计算当前页数
	$nowPage = $nowPage >= $sumPage ? $sumPage : $nowPage;

	//计算偏移量
	$limit = ($nowPage - 1) * $size;
	$limit = $limit < 0 ? 0 : $limit;

	$sql = "select * from orders where status != 0 $status $where order by id desc limit {$limit},{$size}";
	$res = mysqli_query($link,$sql);
	?>
	<table border="1" cellspacing="1" align="center" width="900">
		<caption><h2>订单管理</h2></caption>
		<tr>
			<td colspan="8">

				<form action="index.php" method="get">
					<select name="type">
						<option value="0">订单id</option>
						<option value="1">用户id</option>
					</select>
					<input type="text" name="search" placeholder="订单搜索">
					<input type="submit" value="搜索">
				</form>
				
				<div class="box">
					<a href="index.php?">全部订单</a>
					<a href="index.php?state=1">未发货</a>
					<a href="index.php?state=2">已发货</a>
					<a href="index.php?state=3">已完成</a>
					<a href="index.php?state=4">已关闭</a>
				</div>
			</td>
		</tr>
		<tr>
			<th>id</th>
			<th>用户id</th>
			<th>订单信息</th>
			<th>收货信息</th>
			<th>订单金额</th>
			<th>订单状态</th>
			<th>添加时间</th>
			<th>操作</th>
		</tr>
		<?php
		while($row = mysqli_fetch_assoc($res)){
			$status = '';
			$operation = '';
			switch ($row['status']) {
				case '1':
					$status = '未发货';
					$operation = '<a href="send.php?id='.$row['id'].'">发货</a> <a href="close.php?id='.$row['id'].'">关闭订单</a>';
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
			?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['uid']; ?></td>
				<td><?php echo $row['info']; ?></td>
				<td><?php echo '地址:'.$row['address'].' 联系人:'.$row['linkman']; ?></td>
				<td><?php echo $row['total']; ?></td>
				<td><?php echo $status; ?></td>
				<td><?php echo date('Y-m-d H:i:s',$row['addtime']); ?></td>
				<td><a href="look.php?id=<?php echo $row['id']; ?>">详情</a> <?php echo $operation; ?></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="8">
				<a href="index.php?page=<?php echo $nowPage - 1; ?>&search=<?php echo $search; ?>&state=<?php echo $_GET['state']; ?>&type=<?php echo $type ?>">上一页</a>
				<?php
				echo '第'.$nowPage.'页 | 共'.$sumPage.'页';
				?>
				<a href="index.php?page=<?php echo $nowPage + 1; ?>&search=<?php echo $search; ?>&state=<?php echo $_GET['state']; ?>&type=<?php echo $type ?>">下一页</a>
			</td>
		</tr>
	</table>
</body>
</html>
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

	$search = trim($_GET['search']);
	if(empty($search)){
		$where = '';
	}else{

		$type = $_GET['type'];
		switch ($type) {
			case '0':
				$typename = 'g.goods';
				break;
			case '1':
				$typename = 'u.username';
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
	$count = mysqli_fetch_assoc(mysqli_query($link,"select count(c.id) as count from comments as c,goods as g,users as u where c.goodsid = g.id and c.uid = u.id {$where}"))['count'];

	$sumPage = ceil($count / $size);

	//计算当前页数
	$nowPage = $nowPage >= $sumPage ? $sumPage : $nowPage;

	//计算偏移量
	$limit = ($nowPage - 1) * $size;
	$limit = $limit < 0 ? 0 : $limit;

	$sql = "select c.id,c.anonymous,c.addtime,c.content,c.state,i.picname,g.goods,u.username from comments as c,images as i,goods as g,users as u where c.goodsid = i.goodsid and g.id = i.goodsid and u.id = c.uid and i.state = 0 {$where} order by c.id desc limit {$limit},{$size}";
	$res = mysqli_query($link,$sql);
	?>
	<table border="1" cellspacing="0" align="center" width="900">
		<caption><h2>评论管理</h2></caption>
		<tr>
			<td colspan="8">
				<form action="index.php" method="get">
					<select name="type">
						<option value="0">商品</option>
						<option value="1">用户</option>
					</select>
					<input type="text" name="search" placeholder="评论搜索">
					<input type="submit" value="搜索">
				</form>
			</td>
		</tr>
		<tr>
			<th>商品图片</th>
			<th>商品名</th>
			<th>评论用户</th>
			<th>匿名</th>
			<th>评论内容</th>
			<th>评论时间</th>
			<th>操作</th>
		</tr>

		<?php

		while($row = mysqli_fetch_assoc($res)){
			?>
			<tr>
				<td><img width="60" src="../../images/goodsImages/s_<?php echo $row['picname'] ?>"></td>
				<td><?php echo $row['goods'] ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['anonymous'] == 1 ? '是' : '否'; ?></td>
				<td><?php echo $row['content']; ?></td>
				<td><?php echo date('Y-m-d H:i:s',$row['addtime']); ?></td>
				<td>
					<?php
					if($row['state'] == 0){
						echo '<a href="change.php?id='.$row['id'].'&state=1">隐藏</a>';
					}else{
						echo '<a href="change.php?id='.$row['id'].'&state=0">显示</a>';
					}
					?>
				</td>
			</tr>
			<?php
		}

		?>
		<tr>
			<td colspan="8">
				<a href="index.php?page=<?php echo $nowPage - 1; ?>&search=<?php echo $search; ?>&type=<?php echo $type ?>">上一页</a>
				<?php
				echo '第'.$nowPage.'页 | 共'.$sumPage.'页';
				?>
				<a href="index.php?page=<?php echo $nowPage + 1; ?>&search=<?php echo $search; ?>&type=<?php echo $type ?>">下一页</a>
			</td>
		</tr>
	</table>
</body>
</html>
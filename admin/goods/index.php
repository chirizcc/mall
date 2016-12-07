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
	include '../public/db.php';
	date_default_timezone_set('PRC');
	$link = connectDB();

	//获取tpyeid对应的type名
	$sql = "select id,name from type";
	$res = mysqli_query($link,$sql);
	$typearr = array();
	while($row = mysqli_fetch_assoc($res)){
		$typearr[$row['id']] = $row['name'];
	}

	//接收搜索关键字
	$search = trim($_GET['search']);
	if(empty($search)){
		$where = '';
	}else{
		/*$type = $_GET['type'];
		switch ($type) {
			case '0':
				$typename = 'goods';
				break;
			case '1':
				$typename = 'typeid';
				break;
			case '2':
				$typename = 'company';
				break;
			default:
				header('location:index.php');
				die;
				break;
		}
		if($type == 1){
			foreach ($typearr as $k => $v) {
				if($search == $v){
					$where = "where typeid = {$k}";
					break;
				}
			}
		}else{
			$where = "where {$typename} like '%{$search}%'";
		}*/
		$where = "where goods like '%{$search}%'";
	}

	$nowPage = $_GET['page'] > 0 ? $_GET['page'] : 1;
	$size = 4;

	//获取符合条件的记录数

	$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from goods {$where}"))['count'];

	$sumPage = ceil($count / $size);

	//计算当前页数
	$nowPage = $nowPage >= $sumPage ? $sumPage : $nowPage;

	//计算偏移量
	$limit = ($nowPage - 1) * $size;
	$limit = $limit < 0 ? 0 : $limit;

	?>
	<table border="1" width="900" cellspacing="0" align="center">
		<caption><h2>商品管理</h2></caption>
		<tr>
			<td colspan="9">
				<form action="index.php" method="get">
					<!-- <select name="type">
						<option value="0">名称</option>
						<option value="1">类别</option>
						<option value="2">厂家</option>
					</select> -->
					<input type="text" name="search" placeholder="商品搜索">
					<input type="submit" value="搜索">
				</form>
				<a class="add" href="add.php">添加商品</a>
			</td>
		</tr>
		<tr>
			<th>商品id</th>
			<th>商品图片</th>
			<th>商品名称</th>
			<th>商品类别</th>
			<th>商品厂家</th>
			<th>商品单价</th>
			<th>商品库存</th>
			<th>商品状态</th>
			<th>操作</th>
		</tr>
		<?php
		if(empty($where)){
			$where = ' where ';
		}else{
			$where = $where.' and ';
		}
		$sql = "select g.id,g.typeid,g.goods,g.company,g.price,g.store,g.state,i.picname from goods as g,images as i {$where} g.id = i.goodsid and i.state = 0 order by g.id desc limit {$limit},{$size}";
		// $sql = "select * from goods {$where} order by id desc limit {$limit},{$size}";
		$res = mysqli_query($link,$sql);
		while($row = mysqli_fetch_assoc($res)){
			echo '<tr>';
			echo '<td>'.$row['id'].'</td>';
			echo '<td><a href="../../images/goodsImages/l_'.$row['picname'].'" target="_blank"><img src="../../images/goodsImages/s_'.$row['picname'].'" width="60"></a></td>';
			echo '<td><a href="../../goods.php?id='.$row['id'].'" target="_top">'.$row['goods'].'</td>';
			echo '<td>'.$typearr[$row['typeid']].'</a></td>';
			echo '<td>'.$row['company'].'</td>';
			echo '<td>'.$row['price'].'</td>';
			echo '<td>'.$row['store'].'</td>';

			if($row['state'] == 1){
				$state = '新上架';
			}elseif($row['state'] == 2){
				$state = '在售';
			}else{
				$state = '以下架';
			}

			echo '<td>'.$state.'</td>';
			echo '<td>';
			echo '<a href="look.php?id='.$row['id'].'">详情</a> ';
			echo '<a href="images.php?id='.$row['id'].'">图片管理</a> ';
			echo '<a href="edit.php?id='.$row['id'].'">信息修改</a> ';
			// echo '<a href="">删除</a>';
			echo '</td>';
			echo '</tr>';
		}

		?>

		<tr>
			<td colspan="9">
				<a href="index.php?page=<?php echo $nowPage - 1; ?>&type=<?php echo $type; ?>&search=<?php echo $search; ?>">上一页</a>
				<?php
				echo '第'.$nowPage.'页 | 共'.$sumPage.'页';
				?>
				<a href="index.php?page=<?php echo $nowPage + 1; ?>&type=<?php echo $type; ?>&search=<?php echo $search; ?>">下一页</a>
			</td>
		</tr>

	</table>
</body>
</html>
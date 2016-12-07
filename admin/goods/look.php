<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>goods-look</title>
	<style type="text/css">
	body{
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
	}

	h2{
		margin: 0;
		padding: 0;
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

	$sql = "select id,name from type";
	$res = mysqli_query($link,$sql);
	$typearr = array();
	while($row = mysqli_fetch_assoc($res)){
		$typearr[$row['id']] = $row['name'];
	}

	//根据ID获取记录
	$id = $_GET['id'];
	$sql = "select g.*,i.picname as pic from goods as g,images as i where g.id = i.goodsid and i.state = 0 and g.id = {$id}";
	// $sql = "select * from goods where id = $id";
	$res = mysqli_query($link,$sql);

	//判断是否有这条记录
	if($res->num_rows != 1){
		header('location:index.php');
	}

	$row = mysqli_fetch_assoc($res);

	?>
	<a class="return" href="index.php">返回</a>
	<table width="300" align="center" border="1" cellspacing="0">
		<caption><h2>商品详情</h2></caption>
		<tr>
			<td colspan="2">
				<a href="../../images/goodsImages/l_<?php echo $row['pic']; ?>" target="_top"><img src="../../images/goodsImages/s_<?php echo $row['pic']; ?>" width="150"></a>
			</td>
		</tr>
		<tr>
			<td>id</td>
			<td><?php echo $row['id']; ?></td>
		</tr>
		<tr>
			<td>商品名称</td>
			<td><?php echo $row['goods']; ?></td>
		</tr>
		<tr>
			<td>商品类别</td>
			<td><?php echo $typearr[$row['typeid']]; ?></td>
		</tr>
		<tr>
			<td>商品厂家</td>
			<td><?php echo $row['company']; ?></td>
		</tr>
		<tr>
			<td>商品单价</td>
			<td><?php echo $row['price']; ?></td>
		</tr>
		<tr>
			<td>商品状态</td>
			<td>
				<?php
				if($row['state'] == 1){
				$state = '新上架';
				}elseif($row['state'] == 2){
					$state = '在售';
				}else{
					$state = '以下架';
				}
				echo $state;
				?>
			</td>
		</tr>
		<tr>
			<td>商品库存</td>
			<td><?php echo $row['store']; ?></td>
		</tr>
		<tr>
			<td>商品购买量</td>
			<td><?php echo $row['num']; ?></td>
		</tr>
		<tr>
			<td>商品点击量</td>
			<td><?php echo $row['clicknum']; ?></td>
		</tr>
		<tr>
			<td>添加时间</td>
			<td><?php echo date('Y-m-d H:i:s',$row['addtime']); ?></td>
		</tr>
		<tr>
			<td>商品简介</td>
			<td><?php echo $row['descr']; ?></td>
		</tr>
	</table>
</body>
</html>
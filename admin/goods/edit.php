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

	$sql = "select * from type order by concat(path,id)";
	$res = mysqli_query($link,$sql);
	$typearr = array();
	while($row = mysqli_fetch_assoc($res)){
		$typearr[] = $row;
	}

	//根据ID获取记录
	$id = $_GET['id'];
	$sql = "select * from goods where id = $id";
	$res = mysqli_query($link,$sql);

	//判断是否有这条记录
	if($res->num_rows != 1){
		header('location:index.php');
	}

	$row = mysqli_fetch_assoc($res);

	?>
	<a class="return" href="index.php">返回</a>
	<table width="300" align="center" border="1" cellspacing="0">
		<form action="edit_action.php" method="post" enctype="multipart/form-data">
			<caption><h2>商品信息详情</h2></caption>
			<!-- <tr>
				<td colspan="2">
					<a href="../../images/goodsImages/l_<?php echo $row['picname']; ?>" target="_top"><img src="../../images/goodsImages/s_<?php echo $row['picname']; ?>" width="150"></a>
					<input type="file" name="file">
				</td>
			</tr> -->
			<tr>
				<td>id</td>
				<td><input type="hidden" name="id" value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></td>
			</tr>
			<tr>
				<td>商品名称</td>
				<td><input type="text" name="goods" value="<?php echo $row['goods']; ?>"></td>
			</tr>
			<tr>
				<td>商品类别</td>
				<td>
					<select name="typeid">
						<?php
						foreach ($typearr as $v) {
							$selected = $row['typeid'] == $v['id'] ? 'selected' : '';
							$disabled = $v['pid'] == 0 ? 'disabled' : '';
							$count = substr_count($v['path'],',');
							$repeat = str_repeat('→', $count - 1);
							echo '<option value="'.$v['id'].'"'.$selected.' '.$disabled.'>'.$repeat.$v['name'].'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>商品厂家</td>
				<td><input type="text" name="company" value="<?php echo $row['company']; ?>"></td>
			</tr>
			<tr>
				<td>商品单价</td>
				<td><input type="number" name="price" value="<?php echo $row['price']; ?>"></td>
			</tr>
			<tr>
				<td>商品状态</td>
				<td>
					<input type="radio" name="state" value="1" <?php echo $row['state'] == 1 ? 'checked' : ''; ?>>新上架
					<input type="radio" name="state" value="2" <?php echo $row['state'] == 2 ? 'checked' : ''; ?>>在售
					<input type="radio" name="state" value="3" <?php echo $row['state'] == 3 ? 'checked' : ''; ?>>下架
				</td>
			</tr>
			<tr>
				<td>商品库存</td>
				<td><input type="number" name="store" value="<?php echo $row['store']; ?>"></td>
			</tr>
			<tr>
				<td>商品简介</td>
				<td><textarea cols="22" rows="5" name="descr" style="resize:none;"><?php echo $row['descr']; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="reset" value="重置">
					<input type="submit" value="修改">
				</td>
			</tr>
		</form>
	</table>
	<?php
	switch ($_GET['state']) {
		case '1':
			echo '<center>修改失败</center>';
			break;
		
		case '2':
			echo '<center>商品名不能为空</center>';
			break;

		case '3':
			echo '<center>商品单价不能为空</center>';
			break;

		case '4':
			echo '<center>商品简介不能为空</center>';
			break;

		case '5':
			echo '<center>添加失败</center>';
			break;
			
		case '6':
			echo '<center>缩放失败</center>';
			break;

		case '7':
			echo '<center>库存或价格不能为零</center>';
			break;

		default:
			# code...
			break;
	}
	?>
</body>
</html>
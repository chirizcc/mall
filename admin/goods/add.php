<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>goods-add</title>
	<style type="text/css">
	body{
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
	}
	</style>
</head>
<body>
	<?php

	include '../public/db.php';

	$link = connectDB();
	$sql = "select * from type order by concat(path,id)";
	$res = mysqli_query($link,$sql);

	$arr = array();
	while($row = mysqli_fetch_assoc($res)){
		$arr[] = $row;
	}
	mysqli_free_result($res);
	mysqli_close($link);
	?>
	<table border="0" align="center">
		<caption><h2>添加商品</h2></caption>
		<form action="add_action.php" method="post" enctype="multipart/form-data">
			<tr>
				<th>商品名称</th>
				<td><input type="text" name="goods"></td>
			</tr>
			<tr>
				<th>商品类别</th>
				<td>
					<select name="typeid">
						<option value="0">请选择</option>
						<?php
						foreach ($arr as $v) {
							$count = substr_count($v['path'],',');
							$repeat = str_repeat('→', $count - 1);
							$disabled = $v['pid'] == 0 ? 'disabled' : '';
							echo '<option value="'.$v['id'].'"'.$disabled.'>'.$repeat.$v['name'].'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>生产厂家</th>
				<td><input type="text" name="company"></td>
			</tr>
			<tr>
				<th>商品单价</th>
				<td><input type="number" name="price"></td>
			</tr>
			<tr>
				<th>商品图片</th>
				<td><input type="file" name="file"></td>
			</tr>
			<tr>
				<th>商品简介</th>
				<td>
					<textarea cols="22" rows="5" name="descr" style="resize:none;"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="reset" value="重置">
					<input type="submit" value="添加">
				</td>
			</tr>
		</form>
	</table>
	<?php
	switch ($_GET['state']) {
		case '1':
			echo '<center>请选择商品类别</center>';
			break;
		
		case '2':
			echo '<center>商品名不能为空</center>';
			break;

		case '3':
			echo '<center>商品单价不能为空或小于0</center>';
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
			echo '<center>请上传图片</center>';
			break;

		default:
			# code...
			break;
	}
	?>
</body>
</html>
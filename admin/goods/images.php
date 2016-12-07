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
	$link = connectDB();

	if(empty($_GET['id'])){
		header('location:index.php');
		die;
	}
	$id = $_GET['id'];
	$res = mysqli_query($link,"select goods from goods where id = {$id}");
	if(!$res){
		header('location:index.php');
		die;
	}
	$name = mysqli_fetch_assoc($res)['goods'];
	
	$sql = "select i.id,i.picname,i.state from images as i,goods as g where i.goodsid = g.id and g.id = {$id}";
	$res = mysqli_query($link,$sql);

	?>
	<a class="return" href="index.php">返回</a>
	<table border="1" cellspacing="0" align="center" width="600">
		<caption><h2>图片管理</h2></caption>
		<tr>
			<td colspan="4">
				<form action="image_add_action.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<input type="hidden" name="num" value="<?php echo $res->num_rows; ?>">
					上传图片:<input type="file" name="file">
					<input type="submit" value="上传">
				</form>
			</td>
		</tr>
		<tr>
			<th colspan="4">商品名:<?php echo $name ?></th>
		</tr>
		<tr>
			<th>id</th>
			<th>图片</th>
			<th>封面</th>
			<th>操作</th>
		</tr>
		<?php

		while ($row = mysqli_fetch_assoc($res)) {
			?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><a href="../../images/goodsImages/l_<?php echo $row['picname'] ?>" target="_blank"><img width="100" src="../../images/goodsImages/s_<?php echo $row['picname'] ?>"></a></td>
				<td><a href="change.php?imageid=<?php echo $row['id']; ?>&goodid=<?php echo $id; ?>" title="设为封面"><?php echo $row['state'] == 1 ? '否' : '是' ?></a></td>
				<td><a href="edit_image.php?imageid=<?php echo $row['id']; ?>&goodid=<?php echo $id; ?>">修改</a> <a href="del_image.php?imageid=<?php echo $row['id']; ?>&goodid=<?php echo $id; ?>">删除</a></td>
			</tr>
			<?php
		}

		?>
	</table>
</body>
</html>
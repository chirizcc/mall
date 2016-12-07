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


	$div = '../../images/goodsImages';

	$imageid = $_GET['imageid'];
	$goodid = $_GET['goodid'];
	if(empty($imageid) || empty($goodid)){
		$url = $_SERVER['HTTP_REFERER'];
		header("location:$url");
		die;
	}

	$sql = "select picname,state from images where id = {$imageid} and goodsid = {$goodid}";
	$res = mysqli_query($link,$sql);
	if($res->num_rows != 1){
		$url = $_SERVER['HTTP_REFERER'];
		header("location:$url");
		die;
	}
	$row = mysqli_fetch_assoc($res);

	if($row['state'] == 0){
		echo '<script>alert("封面无法修改");window.history.go(-1);</script>';
		die;
	}
	?>
	<a class="return" href="images.php?id=<?php echo $goodid; ?>">返回</a>
	<table border="1" cellspaning="0" align="center">
		<caption><h2>修改图片</h2></caption>
		<tr>
			<th>原图片</th>
			<td height="200">
				<img src="../../images/goodsImages/s_<?php echo $row['picname']; ?>">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<form action="edit_image_action.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="goodid" value="<?php echo $goodid; ?>">
					<input type="hidden" name="id" value="<?php echo $imageid; ?>">
					上传新图片<input type="file" name="file">
					<input type="submit" value="上传">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>
<?php 
include 'header.php'; 
date_default_timezone_set('PRC');

$link = connectDB();
$id = $_GET['id'];

if(empty($id)){
	header('location:index.php');
	die;
}

$sql = "select g.id,g.goods,g.price,g.descr,g.store,i.picname from goods as g,images as i where g.id = i.goodsid and i.state = 0 and g.id = {$id}";
$res = mysqli_query($link,$sql);
if($res->num_rows != 1){
	header('location:index.php');
	die;
}

//点击量增加
mysqli_query($link,"update goods set clicknum = clicknum + 1 where id = {$id}");

$row = mysqli_fetch_assoc($res);
?>
<div class="gap20"></div>

<div class="goods-content">
	<div class="top">
		<div class="left floatL">
			<img src="images/goodsImages/<?php echo 'l_'.$row['picname']; ?>">
			<div class="gap10"></div>
			<?php
			$imgres = mysqli_query($link,"select picname from images where goodsid = {$id} order by state");
			while($imgrow = mysqli_fetch_assoc($imgres)){
				echo '<img class="marginL" width="100" src="images/goodsImages/s_'.$imgrow['picname'].'">';
			}
			?>
		</div>
		<div class="right floatR">
			<p class="title"><?php echo $row['goods']; ?></p>
			<p><?php echo $row['descr']; ?></p>
			<div class="gap20"></div>
			<p>&yen;&nbsp;&nbsp;<?php echo $row['price']; ?></p>
			<div class="gap20"></div>
			<form action="buy.php" method="get">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<p>数量&nbsp;&nbsp;<input type="number" name="num" value='1'>&nbsp;剩余库存：<?php echo $row['store'] ?></p>
				<p><input type="submit" value="加入购物车"></p>
			</form>
			<div class="gap20"></div>
			<span>保障&nbsp;&nbsp;360商城发货&售后&nbsp;&nbsp;满99元包邮&nbsp;&nbsp;7天无理由退货&nbsp;&nbsp;15天免费换货 </span>
		</div>
		
	</div>

	<a name="comment"></a>
	<div class="gap20"></div>
	<div class="evaluation">
		<div class="title">用户评价</div>

		<div class="gap10"></div>
		<div class="add">
			<form action="add_comments.php" method="post">
				<textarea name="content"></textarea>
				<div class="gap10"></div>
				<span class="floatR">
					<input type="hidden" name="goodsid" value="<?php echo $id; ?>">
					<input type="checkbox" name="anonymous" value="1" checked>匿名评论
					<input type="submit" value="提交评论">
				</span>
			</form>
			<div class="clear"></div>
		</div>

		<div class="gap20"></div>
		<div class="gap20"></div>

		<?php

		$nowPage = $_GET['page'] > 0 ? $_GET['page'] : 1;
		$size = 5;

		//获取符合条件的记录数

		$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from comments where goodsid = {$id}"))['count'];

		$sumPage = ceil($count / $size);

		//计算当前页数
		$nowPage = $nowPage >= $sumPage ? $sumPage : $nowPage;

		//计算偏移量
		$limit = ($nowPage - 1) * $size;
		$limit = $limit < 0 ? 0 : $limit;

		$sql = "select * from comments where goodsid = {$id} and state = 0 order by id desc limit {$limit},{$size}";
		$res = mysqli_query($link,$sql);
		while($row = mysqli_fetch_assoc($res)){
			?>
			<div class="box">
				<div class="floatL">
					<?php
					if($row['anonymous'] == 1){
						echo '<img src="images/usersImages/tx.png">';
					}else{
						$picname = mysqli_fetch_assoc(mysqli_query($link,"select picname from users where id = {$row['uid']}"))['picname'];
						echo '<img src="images/usersImages/'.$picname.'">';
					}
					?>

				</div>
				<div class="floatL con">
					
					<?php
					echo date('Y-m-d H:i',$row['addtime']);
					echo '<br>';
					if($row['anonymous'] == 1){
						echo '匿名用户';
					}else{
						$username = mysqli_fetch_assoc(mysqli_query($link,"select username from users where id = {$row['uid']}"))['username'];
						echo $username;
					}
					echo ':';
					echo $row['content'];
					?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="gap10"></div>
			<?php
		}

		?>
		<div class="gap20"></div>
		<div class="page">
			<ul>
				<li><a href="goods.php?id=<?php echo $id ?>&page=1#comment">&lt;&lt;</a></li>
				<li><a href="goods.php?id=<?php echo $id ?>&page=<?php echo $nowPage -1; ?>#comment">&lt;</a></li>
				<li><?php echo $nowPage; ?> / <?php echo $sumPage; ?></li>
				<li><a href="goods.php?id=<?php echo $id ?>&page=<?php echo $nowPage + 1; ?>#comment">&gt;</a></li>
				<li><a href="goods.php?id=<?php echo $id ?>&page=<?php echo $sumPage; ?>#comment">&gt;&gt;</a></li>
			</ul>
		</div>
		<div class="gap20"></div>
	</div>
	
</div>

<div class="gap20"></div>
<?php include 'footer.php'; ?>
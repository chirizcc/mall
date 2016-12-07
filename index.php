<?php 
include 'header.php';

$link = connectDB();
?>

<div class="index-content">
	<div class="index-top">
		<div class="index-nav floatL">
			<ul >
				<?php
				$sql = "select * from type order by concat(path,id) limit 0,12";
				$res = mysqli_query($link,$sql);
				while($row = mysqli_fetch_assoc($res)){
					echo '<li><a href="brand.php?typeid='.$row['id'].'">'.$row['name'].'</a></li>';
				}
				?>
			</ul>
		</div>
		<div class="index-imageBox floatL">
			<a href="goods.php"></a>
		</div>
		<div class="clear"></div>
	</div>
	<div class="gap10"></div>

	<div class="index-goods-box">
		<div class="gap10"></div>
		<div class="goods">

			<?php
			$sql = "select g.id,g.goods,g.price,g.descr,i.picname from goods as g,images as i where g.id = i.goodsid and i.state = 0 and g.state != 3 order by g.id desc limit 0,8";
			$res = mysqli_query($link,$sql);
			$num = $res->num_rows;
			$count = 0;
			while($row = mysqli_fetch_assoc($res)){
				if ($count % 2 == 0) {
					echo '<div class="goods2 ">';
				}
				?>
				<div class="<?php echo $count % 2 == 0 ? 'floatL' : 'marginL floatL';?>">
					<a href="goods?id=<?php echo $row['id']; ?>"><img class="floatL" src="images/goodsImages/<?php echo 'm_'.$row['picname']; ?>"></a>
					<p class="floatL">
						<span><a href="goods.php?id=<?php echo $row['id']; ?>"><?php echo $row['goods']; ?></a></span>
						<span><?php echo $row['descr']; ?></span>
						<span>&yen;<?php echo $row['price']; ?></span>
						<a href="buy.php?id=<?php echo $row['id']; ?>" class="buy">立即购买</a>
					</p>
				</div>
				<?php
				if ($count % 2 != 0 || $count == $num - 1) {
					echo '</div>';
					echo '<div class="gap10"></div>';
				}
				$count++;
			}

			$sql = "select g.id,g.goods,g.price,g.state,g.descr,i.picname from goods as g,images as i where g.id = i.goodsid and i.state = 0 and g.state != 3 order by g.id desc limit 8,22";
			$res = mysqli_query($link,$sql);
			$num = $res->num_rows;
			$count = 0;
			while($row = mysqli_fetch_assoc($res)){
				if($count == 0 || $count == 4 || $count == 8 || $count == 12|| $count == 16 || $count == 20 || $count == 24){
					echo '<div class="goods4">';
				}
				?>
				<div class="<?php echo $count % 4 == 0 ? 'floatL' : 'floatL marginL'; ?>">
					<a href="goods?id=<?php echo $row['id']; ?>"><img src="images/goodsImages/<?php echo 's_'.$row['picname']; ?>"></a>
					<p><a href="goods?id=<?php echo $row['id']; ?>"><?php echo $row['goods']; ?></a></p>
					<p><?php echo $row['descr'] ?></p>
					<p>&yen;<?php echo $row['price']; ?></p>
					<a class="buy" href="buy.php?id=<?php echo $row['id']; ?>">立即购买</a>
				</div>
				<?php
				if ($count == 3 || $count == 7 || $count == 11 || $count == 15 || $count == 19 || $count == 23 || $count == $num - 1) {
					echo '</div>';
					echo '<div class="gap10"></div>';
				}
				$count++;
			}
			?>

		</div>
		<div class="gap20"></div>
	</div>
</div>

<?php include 'footer.php'; ?>
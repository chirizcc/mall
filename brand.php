<?php 
include 'header.php';
// $link = connectDB();
$typeid = $_GET['typeid'];

$nowPage = $_GET['page'] > 0 ? $_GET['page'] : 1;
$size = 10;

//获取符合条件的记录数
if(!empty($typeid)){
	$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from goods where state !=3 and typeid = {$typeid}"))['count'];
	$sql = "select id from type where path like '%,{$typeid},%' order by concat(path,id)";
	$res = mysqli_query($link,$sql);
	$typearr = array();
	while($row = mysqli_fetch_assoc($res)){
		$typearr[] = $row['id'];
		$count += mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from goods where state != 3 and typeid = {$row['id']}"))['count'];
	}
}else{
	//接收搜索关键字，仅允许搜索账号
	$search = $_GET['search'];
	if(empty($search)){
		$where = '';
	}else{
		$where = " and goods like '%{$search}%' ";
	}

	$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from goods where state != 3 {$where}"))['count'];
}

$sumPage = ceil($count / $size);

//计算当前页数
$nowPage = $nowPage >= $sumPage ? $sumPage : $nowPage;

//计算偏移量
$limit = ($nowPage - 1) * $size;
$limit = $limit < 0 ? 0 : $limit;

$goodsarr = array();
if(!empty($typeid)){
	$also = $size;//还需要多少个商品
	$num = 0;//已有多少个商品
	$nowLimit = $limit;
	//先将选择的类型的商品遍历
	$number = mysqli_fetch_assoc(mysqli_query($link,"select count(id) as count from goods where typeid = {$typeid}"))['count'];
	if($nowLimit < $number){
		$sql = "select g.id,g.goods,g.price,g.state,i.picname from goods as g,images as i where g.id = i.goodsid and i.state = 0 and g.state != 3 and g.typeid = {$typeid} order by g.id desc limit {$limit},{$size}";
		$res = mysqli_query($link,$sql);
		$num = $res->num_rows;
		$also -= $res->num_rows;
		while($row = mysqli_fetch_assoc($res)){
			$goodsarr[] = $row;
		}
	}
	$nowLimit = $limit - $number < 0 ? 0 : $limit - $number;

	//若选择的类型的商品数量不足显示，则遍历该类型的子类
	if($num != $size){
		// $also -= $num;
		foreach ($typearr as $v) {
			$number = mysqli_fetch_assoc(mysqli_query($link,"select count(id) as count from goods where typeid = {$v}"))['count'];
			if($nowLimit < $number){
				$sql = "select g.id,g.goods,g.price,g.state,i.picname from goods as g,images as i where g.id = i.goodsid and i.state = 0 and g.state != 3 and g.typeid = {$v} order by g.id desc limit {$nowLimit},{$also}";
				$res = mysqli_query($link,$sql);
				$num += $res->num_rows;
				$also -= $res->num_rows;
				while($row = mysqli_fetch_assoc($res)){
					$goodsarr[] = $row;
				}
			}
			$nowLimit = $nowLimit - $number <= 0 ? 0 : $nowLimit - $number;
			//数量足够则不再循环
			if($also <= 0){
				break;
			}
		}
	}
}else{

	//若未选择类型，这遍历全部
	$sql = "select g.id,g.goods,g.price,g.state,i.picname from goods as g,images as i where g.id = i.goodsid and i.state = 0 and g.state != 3 {$where} order by g.id desc limit {$limit},{$size}";
	$res = mysqli_query($link,$sql);
	$num = $res->num_rows;
	while ($row = mysqli_fetch_assoc($res)) {
		$goodsarr[] = $row;
	}
}

?>

<div class="brand-content">
	<div class="top">
		<div class="bor">
			<a href="index.php">首页</a>&gt;
			<?php
			if(!empty($typeid)){
				$sql = "select name from type where id = {$typeid}";
				echo mysqli_fetch_assoc(mysqli_query($link,"select name from type where id = {$typeid}"))['name'];
			}elseif(!empty($search)){
				echo '搜索结果';
			}else{
				echo '全部';
			}
			?>
		</div>

		<div><span class="floatL">分类:</span>
			<ul class="floatL">
				<?php
				if(!empty($typeid)){
					foreach ($typearr as $v) {
						$sql = "select name from type where id = {$v}";
						$res = mysqli_query($link,$sql);
						$row = mysqli_fetch_assoc($res);
						echo '<li class="floatL"><a href="brand.php?typeid='.$v.'">'.$row['name'].'</a></li>';
					}
				}else{
					$sql = "select * from type order by concat(path,id)";
					$res = mysqli_query($link,$sql);
					while($row = mysqli_fetch_assoc($res)){
						echo '<li class="floatL"><a href="brand.php?typeid='.$row['id'].'">'.$row['name'].'</a></li>';
					}
				}
				?>
			</ul>
			<div class="clear"></div>
		</div>

	</div>
	

	<div class="show">
		<div class="gap20"></div>

		<div class="box">
			<?php

			$count = 0;
			foreach ($goodsarr as $v) {
				if($num == 0){
					break;
				}
				?>
				<div class="<?php echo $count % 5 == 0 ? 'goods floatL' : 'goods floatL marginL' ?>">
					<div class="gap10"></div>
					<a href="goods?id=<?php echo $v['id']; ?>"><img src="images/goodsImages/<?php echo 's_'.$v['picname']; ?>"></a>
					<div class="gap10"></div>
					<p><a href="goods?id=<?php echo $v['id']; ?>"><?php echo $v['goods']; ?></a></p>
					<p><span><?php echo $v['price']; ?>元</span></p>
				</div>
				<?php
				if($count == 4 || $count == 9 || $count == $num - 1){
					echo '<div class="gap10"></div>';
				}
				$count++;
			}

			?>

		</div>

		<div class="gap20"></div>
		<div class="page">
			<ul>
				<li><a href="brand.php?page=<?php echo 1; ?>&typeid=<?php echo $typeid ?>&search=<?php echo $search ?>" title="第一页">&lt;&lt;</a></li>
				<li><a href="brand.php?page=<?php echo $nowPage - 1; ?>&typeid=<?php echo $typeid ?>&search=<?php echo $search ?>" title="上一页">&lt;</a></li>
				<li><?php echo "{$nowPage} / {$sumPage}"; ?></li>
				<li><a href="brand.php?page=<?php echo $nowPage + 1; ?>&typeid=<?php echo $typeid ?>&search=<?php echo $search ?>" title="下一页">&gt;</a></li>
				<li><a href="brand.php?page=<?php echo $sumPage; ?>&typeid=<?php echo $typeid ?>&search=<?php echo $search ?>" title="最后一页">&gt;&gt;</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="gap20"></div>
	</div>
</div>

<?php include 'footer.php'; ?>
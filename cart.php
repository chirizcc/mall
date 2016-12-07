<?php 
include 'header.php';

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
}

$sql = "select id from orders where uid = {$id} and status = 0";
$res = mysqli_query($link,$sql);
if($res->num_rows == 1){
	$orderid = mysqli_fetch_assoc($res)['id'];
}else{
	$res = mysqli_query($link,"insert into orders (uid,status) values ({$id},0)");
	if(!$res){
		die('出错');
	}
	$orderid = mysqli_fetch_assoc(mysqli_query($link,"select id from orders where uid = {$id} and status = 0"))['id'];
}

$sql = "select d.*,i.picname from orders as o,detail as d,goods as g,images as i where o.id = d.orderid and d.goodsid = g.id and g.id = i.goodsid and o.status = 0 and i.state = 0 and o.uid = {$id}";
$res = mysqli_query($link,$sql);
?>

<div class="gap20"></div>
<div class="gap20"></div>
<div class="cart-content">
	<div class="title">我的购物车</div>
	<div class="goods">
		<table cellspacing="0">
			<tr>
				<td>商品信息</td>
				<td>单价</td>
				<td>数量</td>
				<td>小计</td>
				<td>操作</td>
			</tr>
			<?php
			$total = 0;
			if($res->num_rows > 0){
				while ($row = mysqli_fetch_assoc($res)) {
					$total += $row['price'] * $row['num'];//计算购物车总金额
					?>
					<tr>
						<td>
							<a href="goods.php?id=<?php echo $row['goodsid']; ?>"><img class="floatL" src="images/goodsImages/<?php echo 's_'.$row['picname']; ?>"></a>
							<a class="floatL" href="goods.php?id=<?php echo $row['goodsid']; ?>"><?php echo $row['name']; ?></a>
							<div class="clear"></div>
						</td>
						<td><span class="bleak"><?php echo $row['price']; ?>元</span></td>
						<td><a class="floatL" href="changeNum.php?goodsid=<?php echo $row['goodsid']; ?>&num=<?php echo $row['num'] - 1; ?>">-</a>&nbsp;<span class="bleak floatL" class="bleak"> <?php echo $row['num']; ?> </span>&nbsp;<a class="floatL" href="changeNum.php?goodsid=<?php echo $row['goodsid']; ?>&num=<?php echo $row['num'] + 1; ?>">+</a><div class="clear"></div></td>
						<td><span class="sum"><?php echo $row['price'] * $row['num']; ?></span></td>
						<td><a href="cartDel.php?goodsid=<?php echo $row['goodsid']; ?>">删除</a></td>
					</tr>	
					<?php
				}
			}
			?>
		</table>
	</div>
	<div class="gap20"></div>
	<div class="gap20"></div>

	<div class="allsum floatR">
		<p>商品总计：<span><?php echo $total; ?>元</span></p>
		<div class="gap20"></div>
		<div class="gap20"></div>
		<a href="index.php">继续购物</a>
		<a class="marginL" href="order.php">去结算</a>
		<div class="gap20"></div>
	</div>
</div>
<div class="gap20"></div>

<?php include 'footer.php'; ?>
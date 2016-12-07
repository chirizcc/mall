<?php 
include 'header.php'; 

$sql = "select count(d.goodsid) as count from orders as o,detail as d where o.uid = {$id} and o.id = d.orderid and o.status = 0";
$count = mysqli_fetch_assoc(mysqli_query($link,$sql))['count'];
if($count == 0){
	echo '<script>alert("购物车为空");window.location = "cart.php";</script>';
	die;
}
?>
<div class="gap20"></div>
<div class="gap10"></div>

<div class="order-content">
	<form action="addOrder.php" method="post">
		<div class="box">
			<p class="title">收货地址</p>
			<div class="gap20"></div>
			<?php
			$sql = "select * from address where uid = {$id}";
			$res = mysqli_query($link,$sql);
			if($res->num_rows < 3){
				echo '<span><a href="newAddress.php">使用新地址</a></span><div class="gap10"></div>';
			}
			while ($row = mysqli_fetch_assoc($res)) {
				echo '<input type="radio" name="address" value="'.$row['id'].'"> 地址：'.$row['address'].' 联系人：'.$row['linkman'].' 联系电话：'.$row['phone'].'<br>';
			}
			?>
			
			<div class="gap20"></div>
		</div>

		<div class="box">
			<p class="title">支付方式</p>
			<div class="gap20"></div>
			<span>货到付款</span>
			<div class="gap20"></div>
		</div>

		<div class="box">
			<p class="title">配送方式</p>
			<div class="gap20"></div>
			<span>免费配送</span>
			<div class="gap20"></div>
		</div>

		<div class="box">
			<p class="title">商品清单</p>
			<div class="gap20"></div>
			<table cellspacing="0">
				<tr>
					<td>商品名称</td>
					<td>单价</td>
					<td>数量</td>
					<td>合计</td>
				</tr>
				<?php

				$sql = "select id from orders where uid = {$id} and status = 0";
				$res = mysqli_query($link,$sql);
				if($res->num_rows == 1){
					$orderid = mysqli_fetch_assoc($res)['id'];
				}else{
					header('location:cart.php');
					die;
				}

				$sql = "select d.*,i.picname from orders as o,detail as d,goods as g,images as i where o.id = d.orderid and d.goodsid = g.id and g.id = i.goodsid and o.status = 0 and i.state = 0 and o.uid = {$id}";
				$res = mysqli_query($link,$sql);

				$total = 0;
				$num = 0;
				$fee = 0;
				if($res->num_rows > 0){
					while($row = mysqli_fetch_assoc($res)){
						$total += $row['price'] * $row['num'];//计算购物车总金额
						$num += $row['num'];
						?>
						<tr>
							<td>
								<a href="goods.php?id=<?php echo $row['goodsid']; ?>"><img class="floatL" src="images/goodsImages/<?php echo 's_'.$row['picname']; ?>"></a>
								<span class="floatL"><a href="goods.php?id=<?php echo $row['goodsid']; ?>"><?php echo $row['name']; ?></a></span>
								<div class="clear"></div>
							</td>
							<td><span>&yen;<?php echo $row['price']; ?></span></td>
							<td><span>&times;<?php echo $row['num']; ?></span></td>
							<td><span>&yen;<?php echo $row['price'] * $row['num'] ?></span></td>
						</tr>
						<?php
					}
					$fee = $total > 99 ? 0 : 10;
				}
				?>
			</table>
			<div class="gap20"></div>
		</div>

		<div class="sum">
			<div class="number floatR">
				<p>共<span><?php echo $num ?></span>件</p>
				<p>金额合计:<?php echo $total; ?>元</p>
				<p>配送费:<?php echo $fee; ?>元</p>
				<?php
				$integral = mysqli_fetch_assoc(mysqli_query($link,"select integral from users where id = {$id}"))['integral'];
				if($integral < 2000){
					$discount = 1;
				}elseif($integral < 5000){
					$discount = 0.98;
				}elseif($integral < 10000){
					$discount = 0.95;
				}elseif($integral < 20000){
					$discount = 0.9;
				}else{
					$discount = 0.88;
				}
				?>
				<p>会员折扣: -<?php echo $total * (1 - $discount); ?>元</p>
				<p>应付金额:&nbsp;<span><?php echo $total * $discount + $fee; ?></span>&nbsp;元</p>
			</div>
			<div class="clear"></div>
			<div class="botton floatR">
				<input class="floatR" type="submit" value="立即下单">
			</div>
			<div class="clear"></div>
		</div>
	</form>
</div>

<div class="gap20"></div>
<div class="gap20"></div>

<?php include 'footer.php'; ?>
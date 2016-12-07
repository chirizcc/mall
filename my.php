<?php 
include 'header.php'; 

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
	die;
}

$res = mysqli_query($link,"select username,picname from users where id = {$id}");
$row = mysqli_fetch_assoc($res);
$username = $row['username'];
$picname = $row['picname'];

$state = 'myOrder.php';
switch ($_GET['state']) {
	case '1':
		$state = 'myInfo.php';
		break;
	
	case '2':
		$state = 'myAddress.php';
		break;

	default:
		break;
}
?>

<div class="my">
	<div class="gap20"></div>

	<div class="my-content">
		<div class="my-left floatL">
			<div class="tx">
				<div class="gap10"></div>
				<div>
					<a href="my/edit_image.php" target="right" title="修改头像"><img src="images/usersImages/<?php echo $picname; ?>"></a>
				</div>
				<div class="gap10"></div>
				<p><?php echo $username; ?></p>
				<div class="gap10"></div>
			</div>
			<div class="gap10"></div>
			<div class="box">
				<ul>
					<li>个人中心</li>
					<li><a href="my/myOrder.php" target="right">我的订单</a></li>
					<li><a href="my/myAddress.php" target="right">收货地址</a></li>
					<li><a href="my/myInfo.php" target="right">账户信息</a></li>
					<li><a href="my/myIntegral.php" target="right">积分中心</a></li>
				</ul>
			</div>
		</div>

		<iframe class="my-right floatR" src="my/<?php echo $state; ?>" scrolling="yes" name="right">
			
		</iframe>
	</div>

	<div class="gap20"></div>
	<div class="gap20"></div>	
</div>

<?php include 'footer.php'; ?>
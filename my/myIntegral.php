<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>个人中心</title>
	<link rel="stylesheet" type="text/css" href="../css/globalStyle.css">
</head>
<body>
	<?php
	include '../public/db.php';
	session_start();

	$link = connectDB();
	$id = $_SESSION['id'];

	$integral = mysqli_fetch_assoc(mysqli_query($link,"select integral from users where id = {$id}"))['integral'];
	if($integral < 2000){
		$level = 'LV1会员';
		$discount = '无';
		$gap = '距下个等级还差：'.(2000 - $integral).'消费额 可享受特权：9.8折优惠';
	}elseif($integral < 5000){
		$level = 'LV2会员';
		$discount = '9.8折优惠';
		$gap = '距下个等级还差：'.(5000 - $integral).'消费额 可享受特权：9.5折优惠';
	}elseif($integral < 10000){
		$level = 'LV3会员';
		$discount = '9.5折优惠';
		$gap = '距下个等级还差：'.(10000 - $integral).'消费额 可享受特权：9.0折优惠';
	}elseif($integral < 20000){
		$level = 'LV4会员';
		$discount = '9.0折优惠';
		$gap = '距下个等级还差：'.(20000 - $integral).'消费额 可享受特权：8.8折优惠';
	}else{
		$level = 'LV5会员';
		$discount = '8.8折优惠';
		$gap = '恭喜你已到达最高会员等级，享受最高消费优惠';
	}
	?>
	<div class="myinfo-content">
		<div class="title">积分中心</div>
		<div class="gap10"></div>
		<div class="head-line"></div>
		<div class="gap20"></div>
		<p class="integral">
			当前积分：<?php echo $integral; ?> 当前等级：<?php echo $level; ?> 享受特权：<?php echo $discount; ?><br><br>
			<?php echo $gap; ?>
		</p>
	</div>
</body>
</html>
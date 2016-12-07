<?php 
include 'header.php';

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "login.php";</script>';
	die;
}

$num = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from address where uid = {$id}"))['count'];
if($num >= 5){
	echo '<script>alert("地址数量超出上限");window.location = "my.php?state=2";</script>';
	die;
}

$sql = "select phone from users where id = {$id}";
$phone = mysqli_fetch_assoc(mysqli_query($link,$sql))['phone'];
?>
<div class="gap20"></div>
<div class="gap10"></div>

<div class="order-content">
	<div class="box">
		<p class="title">新地址</p>
		<div class="gap20"></div>
		<div class="address">
			<?php
            switch ($_GET['state']) {

                case '1':
                    echo '<center>不能为空</center>';
                    break;
                
                case '2':
                    echo '<center>邮编错误</center>';
                    break;

                case '3':
                    echo '<center>手机号错误</center>';
                    break;

                case '4':
                    echo '<center>添加失败</center>';
                    break;

                default:
                    break;
            }
            ?>
			<form action="newAddress_action.php" method="post">
				<ul>
					<li>
						<p><span>  </span>收货人姓名</p>
						<p><input type="text" name="linkman" placeholder="收货人姓名"></p>
					</li>
				</ul>
				<div class="gap10"></div>

				<ul>
					<li>
						<p><span>  </span>地址</p>
						
						<div class="gap10"></div>
						<p><textarea cols="50" rows="3" placeholder="详细地址" name="address"></textarea></p>
					</li>
				</ul>
				<div class="gap10"></div>

				<ul>
					<li>
						<p><span>  </span>邮政编码</p>
						<p><input type="text" name="code" placeholder="6位邮政编码"></p>
					</li>
				</ul>
				<div class="gap10"></div>	

				<ul>
					<li>
						<p><span>  </span>手机号码</p>
						<p><input type="text" name="phone" placeholder="11位手机号码" value="<?php echo $phone; ?>"></p>
					</li>
				</ul>
				<div class="gap20"></div>
				<div><input type="submit" value="保存"><input class="marginL" type="reset" value="取消"></div>
			</form>
		</div>	
		<div class="gap20"></div>
		<div class="gap20"></div>
	</div>

</div>

<div class="gap20"></div>
<div class="gap20"></div>

<?php include 'footer.php'; ?>
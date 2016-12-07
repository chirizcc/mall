<?php 
include 'header.php';

$aid = $_GET['aid'];

$sql = "select * from address where uid = {$id} and id = {$aid}";
$res = mysqli_query($link,$sql);
if($res->num_rows != 1){
	header('location:my.php?state=2');
	die;
}

$row = mysqli_fetch_assoc($res);
?>
<div class="gap20"></div>
<div class="gap10"></div>

<div class="order-content">
	<div class="box">
		<p class="title">编辑地址</p>
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
                    echo '<center>修改失败</center>';
                    break;

                default:
                    break;
            }
            ?>
			<form action="editAddress_action.php" method="post">
				<ul>
					<li>
						<p><span>  </span>收货人姓名</p>
						<p><input type="text" name="linkman" value="<?php echo $row['linkman']; ?>"></p>
					</li>
				</ul>
				<div class="gap10"></div>

				<ul>
					<li>
						<p><span>  </span>地址</p>
						
						<div class="gap10"></div>
						<p><textarea cols="50" rows="3" placeholder="详细地址" name="address"><?php echo $row['address']; ?></textarea></p>
					</li>
				</ul>
				<div class="gap10"></div>

				<ul>
					<li>
						<p><span>  </span>邮政编码</p>
						<p><input type="text" name="code" value="<?php echo $row['code']; ?>"></p>
					</li>
				</ul>
				<div class="gap10"></div>	

				<ul>
					<li>
						<p><span>  </span>手机号码</p>
						<p><input type="text" name="phone" placeholder="11位手机号码" value="<?php echo $row['phone'] ?>"></p>
					</li>
				</ul>
				<input type="hidden" name="aid" value="<?php echo $row['id']; ?>">
				<div class="gap20"></div>
				<div><input class="floatL" type="submit" value="保存"><a class="marginL floatL" href="my.php?state=2">取消</a><div class="clear"></div></div>
			</form>
		</div>	
		<div class="gap20"></div>
		<div class="gap20"></div>
	</div>

</div>

<div class="gap20"></div>
<div class="gap20"></div>

<?php include 'footer.php'; ?>
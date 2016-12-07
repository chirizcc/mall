<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>查看详情</title>
	<style type="text/css">
	body{
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
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
date_default_timezone_set('PRC');
session_start();

$link = connectDB();
if(!$link){
	echo '数据库连接失败';
}

//根据id获取记录
$id = $_GET['id'];
$sql = "select * from users where id = $id";
$res = mysqli_query($link,$sql);

if($res->num_rows != 1){
	header('location:index.php');
}

$row = mysqli_fetch_assoc($res);

?>
<a class="return" href="index.php">返回</a>
<table width="300" align="center" border="1" cellspacing="0">
	<form action="edit_action.php" method="post">
		<caption><h2>修改用户</h2></caption>
		<tr>
			<td>id:</td>
			<td>
				<?php echo $row['id']; ?>
				<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
			</td>
		</tr>
		<tr>
			<td>账号:</td>
			<td><input type="text" name="userName" value="<?php echo $row['username']; ?>"></td>
		</tr>
		<tr>
			<td>真实姓名:</td>
			<td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
		</tr>
		
		<tr>
			<td>性别:</td>
			<td>
				<input type="radio" name="sex" value="0" <?php echo $row['sex'] == 0 ? 'checked' : '' ?>>男
				<input type="radio" name="sex" value="1" <?php echo $row['sex'] == 1 ? 'checked' : '' ?>>女
			</td>
		</tr>
		<tr>
			<td>积分：</td>
			<td><input type="number" name="integral" value="<?php echo $row['integral']; ?>"></td>
		</tr>
		<tr>
			<td>电话:</td>
			<td><input type="number" name="phone" value="<?php echo $row['phone']; ?>"></td>
		</tr>
		<tr>
			<td>邮箱:</td>
			<td><input type="text" name="email" value="<?php echo $row['email']; ?>"></td>
		</tr>

		<?php 
		if($_SESSION['myState'] == 3){
			?>

			<tr>
				<td>权限</td>
				<td>
					<input type="radio" name="state" value="1" <?php echo $row['state'] == 1 ? 'checked' : '' ?>>启用
					<input type="radio" name="state" value="2" <?php echo $row['state'] == 2 ? 'checked' : '' ?>>禁用
					<input type="radio" name="state" value="0" <?php echo $row['state'] == 0 ? 'checked' : '' ?>>管理员
				</td>
			</tr>

			<?php
		}elseif($row['state'] == 1 || $row['state'] ==2){
		?>
		<tr>
			<td>状态:</td>
			<td>
				
				<input type="radio" name="state" value="1" <?php echo $row['state'] == 1 ? 'checked' : '' ?>>启用
				<input type="radio" name="state" value="2" <?php echo $row['state'] == 2 ? 'checked' : '' ?>>禁用
			</td>
		</tr>
		<?php
		}else{
			?>
			<tr>
				<td>权限</td>
				<td>管理员</td>
			</tr>
			<?php
		}
		?>
		
		<tr>
			<td colspan="2" align="center">
				<input type="reset" value="重置">
				<input type="submit" value="修改" <?php if($_SESSION['myState'] == 0 && $row['state'] == 0 && $_SESSION['uid'] != $row['id']) {echo 'disabled';}?>>
			</td>
		</tr>
	</form>
</table>

<?php
	switch ($_GET['state']) {
		case '1':
			echo '<center>账号不能为空</center>';
			break;

		case '2':
			echo '<center>该账户已存在</center>';
			break;

		case '3':
			echo '<center>添加错误</center>';
			break;

		case '4':
			echo '<center>请输入正确的手机号</center>';
			break;

		case '5':
			echo '<center>请输入正确的邮箱</center>';
			break;

		case '6':
			echo '<center>用户名不符合规则</center>';
			break;

		default:
			# code...
			break;
	}
?>

</body>
</html>
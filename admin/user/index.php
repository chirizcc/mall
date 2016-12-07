<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>首页</title>
	<style type="text/css">
	body{
		padding: 0;
		margin: 0;
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
	}

	a:link,a:visited{
		text-decoration: none;
		color: #0000EE;
	}

	a:hover{
		color:red;
	}

	table tr td form{
		float:left;
	}

	table tr td{
		text-align: center;
	}

	table tr td .add{
		float:right;
	}
	</style>
</head>
<body>
	<table border="1" width="900" cellspacing="0" cellpadding="0" align="center">
		<caption><h2>用户管理</h2></caption>
		<tr>
			<td colspan="8">
				<form action="index.php" method="get">
					<input type="text" name="search" placeholder="账号搜索">
					<input type="submit" value="搜索">
				</form>
				<a class="add" href="add.php">添加用户</a>
			</td>
		</tr>
		<tr>
			<th>id</th>
			<th>账号</th>
			<th>性别</th>
			<th>电话</th>
			<th>email</th>
			<th>注册时间</th>
			<th>状态</th>
			<th>操作</th>
		</tr>

		<?php

		session_start();
		include '../public/db.php';
		date_default_timezone_set('PRC');

		$link = connectDB();
		if(!$link){
			echo '数据库连接失败';
		}

		//接收搜索关键字，仅允许搜索账号
		$search = $_GET['search'];
		if(empty($search)){
			$where = '';
		}else{
			$where = " username like '%{$search}%' and ";
		}

		$nowPage = $_GET['page'] > 0 ? $_GET['page'] : 1;
		$size = 15;

		//获取符合条件的记录数

		$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from users where {$where} state in (0,1,2) and username != '{$_SESSION['userName']}'"))['count'];

		$sumPage = ceil($count / $size);

		//计算当前页数
		$nowPage = $nowPage >= $sumPage ? $sumPage : $nowPage;

		//计算偏移量
		$limit = ($nowPage - 1) * $size;
		$limit = $limit < 0 ? 0 : $limit;

		//获取符合条件的记录
		$sql = "select * from users where {$where} state in (0,1,2) and username != '{$_SESSION['userName']}' order by id limit $limit,$size";
		$res = mysqli_query($link,$sql);

		if($res){
			//遍历输出
			while ($row = mysqli_fetch_assoc($res)) {
				echo '<tr>';
				echo '<td>'.$row['id'].'</td>';
				echo '<td>'.$row['username'].'</td>';
				$sex = $row['sex'] == 0 ? '男' : '女';
				echo '<td>'.$sex.'</td>';
				echo '<td>'.$row['phone'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				echo '<td>'.date('Y-m-d H:i:s',$row['addtime']).'</td>';

				if($row['state'] == 0){
					$state = '管理员';
				}elseif($row['state'] == 1){
					$state = '启用';
				}else{
					$state = '禁用';
				}
				echo '<td>'.$state.'</td>';
				echo '<td><a href="look.php?id='.$row['id'].'">查看</a>|<a href="edit.php?id='.$row['id'].'">修改信息</a>|<a href="editpwd.php?id='.$row['id'].'">修改密码</a>|<a href="del.php?id='.$row['id'].'">删除</a></td>';
				echo '</tr>';
			}
			mysqli_free_result($res);
		}
		
		mysqli_close($link);
		?>
		<tr>
			<td colspan="8">
				<a href="index.php?page=<?php echo $nowPage - 1; ?>&search=<?php echo $search; ?>">上一页</a>
				<?php
				echo '第'.$nowPage.'页 | 共'.$sumPage.'页';
				?>
				<a href="index.php?page=<?php echo $nowPage + 1; ?>&search=<?php echo $search; ?>">下一页</a>
			</td>
		</tr>
	</table>
</body>
</html>
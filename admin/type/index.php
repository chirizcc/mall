<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>type</title>
	<style type="text/css">
	body{
		background: url("../../images/4b83acdab13b2a9b0308bedb4ea1161b.jpg");
	}
	a:link,a:visited{
		text-decoration: none;
		color: #0000EE;
	}

	a:hover{
		color:red;
	}
	</style>
</head>
<body>
	<?php

	include '../public/db.php';

	$link = connectDB();

	//分页
	$size = 10;
	$nowpage = $_GET['page'] > 0 ? $_GET['page'] : 1;

	$pid = (empty($_GET['pid'])) ?  0 : (int)$_GET['pid'];
	// $sql = "select count(*) as count from type where pid = {$pid}";

	$count = mysqli_fetch_assoc(mysqli_query($link,"select count(*) as count from type where pid = {$pid}"))['count'];
	$sumpage = ceil($count / $size);

	$nowpage = $nowpage >= $sumpage ? $sumpage : $nowpage;
	$limit = ($nowpage - 1) * $size;

	if($pid == 0){
		$name = "顶级";
	}else{
		$name = mysqli_fetch_assoc(mysqli_query($link,"select name from type where id = {$pid}"))['name'];
	}
	?>
	<table border="1" width="400" align="center" cellspacing="0">
		<caption><h2>类别信息</h2></caption>
		<tr>
			<td colspan="4">
				
				<form action="add_action.php" method="post">
					<input type="hidden" name="pid" value="<?php echo $pid; ?>">
					添加<?php echo $name; ?>的子分类：<input type="text" name="name">
					<input type="submit" value="添加">
				</form>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<a href="index.php?pid=0">顶级分类</a>-&gt;
				<?php
				
				if($pid != 0){
					
					$row = mysqli_fetch_assoc(mysqli_query($link,"select path from type where id = {$pid}"));
					$arr = explode(',', $row['path']);
					array_shift($arr);
					array_pop($arr);
					if(!empty($arr)){
						$res = mysqli_query($link,"select id,name from type");
						$typearr = array();
						while($row = mysqli_fetch_assoc($res)){
							$typearr[$row['id']] = $row['name'];
						}
						foreach ($arr as $v) {
							echo '<a href="index.php?pid='.$v.'">'.$typearr[$v].'</a>-&gt;';
						}
					}

					$sql = "select name from type where id = {$pid}";
					$row = mysqli_fetch_assoc(mysqli_query($link,$sql));
					echo '<a href="index.php?pid='.$pid.'">'.$row['name'].'</a>-&gt;';

				}

				?>
			</td>
		</tr>
		<tr>
			<th>id</th>
			<th>类别名</th>
			<!-- <th>pid</th> -->
			<th>操作</th>
		</tr>
		<?php

		$sql = "select * from type where pid = {$pid} limit {$limit},{$size}";
		$res = mysqli_query($link,$sql);

		if(!$res){
			echo '<tr><td colspan="3">已没有子分类</td></tr>';
		}else{

			$arr = array();
			while($row = mysqli_fetch_assoc($res)){
				$arr[] = $row;
			}
			mysqli_free_result($res);
			mysqli_close($link);

			foreach ($arr as $v) {
				// $count = substr_count($v['path'],',');
				// $repeat = str_repeat('→', $count - 1);
				echo '<tr>';
				echo '<td>'.$v['id'].'</td>';
				echo '<td>'.$v['name'].'</td>';
				// echo '<td>'.$v['pid'].'</td>';
				echo '<td>';
				echo '<a href="index.php?pid='.$v['id'].'">查看其子分类</a> ';
				// echo '<a href="index.php?pid='.$v['id'].'">添加其子分类</a> ';
				echo '<a href="edit.php?id='.$v['id'].'">修改</a>  <a href="del.php?id='.$v['id'].'">删除</a>';
				echo '</td>';
				echo '</tr>';
			}
		}
		?>
		<tr>
			<td colspan="4" align="center">
				<a href="index.php?page=<?php echo $nowpage - 1; ?>&pid=<?php echo $pid; ?>">上一页</a> 第<?php echo $nowpage; ?>页 | 共<?php echo $sumpage; ?>页 <a href="index.php?page=<?php echo $nowpage + 1; ?>&pid=<?php echo $pid; ?>">下一页</a>
			</td>
		</tr>
	</table>
</body>
</html>
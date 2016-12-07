<?php
include 'public/db.php';

if(empty($_POST)){
	header('location:login.php?state=1');//表单为空
	die;
}

$userName = trim($_POST['userName']);
$userPwd1 = trim($_POST['password']);

if(empty($userName)){
	header('location:login.php?state=2');//用户名为空
	die;
}

if(empty($userPwd1)){
	header('location:login.php?state=3');//密码为空
	die;
}

$userPwd = md5($userPwd1);

$link = connectDB();
if(!$link){
	echo '数据库连接失败';
}

$sql = "select id,pass from users where username = '{$userName}' and state != 2";
$res = mysqli_query($link,$sql);

if($res->num_rows == 0){
	header('location:login.php?state=4');//没有该用户
	die;
}

$row = mysqli_fetch_assoc($res);

mysqli_free_result($res);
mysqli_close($link);

if($row['pass'] == $userPwd){
    session_start();
    $_SESSION['user'] = $userName;
    $_SESSION['isLogin'] = 1;
    $_SESSION['id'] = $row['id'];
	header('location:./');
}else{
	header('location:login.php?state=5');//密码错误
}
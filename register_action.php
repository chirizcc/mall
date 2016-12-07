<?php

session_start();
include 'public/db.php';

if(empty($_POST)){
	die('表单为空');
}

$userName = trim($_POST['userName']);
$userPwd1 = trim($_POST['password']);
$userPwd2 = trim($_POST['password2']);
$time = time();
$yzm = trim($_POST['auth']);

if(empty($userName)){
	header('location:register.php?state=1');//用户名为空
	die;
}

if(empty($userPwd1) || empty($userPwd2)){
	header('location:register.php?state=2');//密码为空
	die;
}

if($userPwd1 != $userPwd2){
	header('location:register.php?state=3');//密码与确认密码不相同
	die;
}

if(empty($yzm)){
	header('location:register.php?state=4');//验证码为空
	die;
}

if(strcasecmp($yzm, $_SESSION['yzm']) !== 0){//验证码错误
	header('location:register.php?state=5');
	die;
}

if(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,9}$/", $userName) == 0 || preg_match("/^.{8,20}$/", $userPwd1) == 0){
	header('location:register.php?state=8');
	die;
}

$userPwd = md5($userPwd1);

$link = connectDB();
/*if(!$link){
	echo '数据库连接失败';
}*/

$sql = "select id from users where username = '{$userName}'";
$res = mysqli_query($link,$sql);
if($res->num_rows != 0){
	header('location:register.php?state=6');//该用户名已存在
	die;
}

$sql = "insert into users (username,pass,addtime) values('{$userName}','{$userPwd}',{$time})";

if(mysqli_query($link,$sql)){
	header('location:login.php');
}else{
	header('location:register.php?state=7');//注册失败
	die;
}

mysqli_close($link);
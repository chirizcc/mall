<?php

session_start();
include '../public/db.php';

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "../login.php";</script>';
}

$userid = $_SESSION['id'];

$link = connectDB();

$old = trim($_POST['oldpwd']);
$new = trim($_POST['newpwd']);
$new2 = trim($_POST['newpwd2']);

if(empty($old) || empty($new) || empty($new2)){
	header('location:edit_pwd.php?state=1');//密码为空
	die;
}

if($new != $new2){
	header('location:edit_pwd.php?state=2');//密码与确认密码不同
	die;
}

if($old == $new){
	header('location:edit_pwd.php?state=6');//密码与确认密码不同
	die;
}

if(preg_match("/^.{8,20}$/", $new) == 0){
	header('location:edit_pwd.php?state=5');//不符合正则匹配
	die;
}

$oldpass = md5($old);
$sql = "select pass from users where id = {$userid}";
$res = mysqli_query($link,$sql);
if($oldpass != mysqli_fetch_assoc($res)['pass']){
	header('location:edit_pwd.php?state=4');//旧密码错误
	die;
}

$pass = md5($new);
$sql = "update users set pass = '{$pass}' where id = {$userid}";
$res = mysqli_query($link,$sql);

if($res){
	echo '<script>alert("修改成功");window.location = "myInfo.php";</script>';
}else{
	header('location:editpwd.php?state=3');//修改失败
	die;
}
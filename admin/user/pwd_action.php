<?php

include '../public/db.php';

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$id = $_POST['id'];
$pwd = trim($_POST['newpwd']);
$pwd2 = trim($_POST['newpwd2']);

if(empty($pwd) || empty($pwd2)){
	header('location:editpwd.php?id='.$id.'&state=1');//密码为空
	die;
}

if($pwd != $pwd2){
	header('location:editpwd.php?id='.$id.'&state=2');//密码与确认密码不同
	die;
}

if(preg_match("/^.{8,20}$/", $pwd) == 0){
	header('location:editpwd.php?id='.$id.'&state=4');//不符合正则匹配
	die;
}

$pass = md5($pwd);
$link = connectDB();

$sql = "update users set pass = '{$pass}' where id = {$id}";
$res = mysqli_query($link,$sql);

if($res){
	echo '<script>alert("修改成功");window.location = "index.php";</script>';
}else{
	header('location:editpwd.php?id='.$id.'&state=3');
	die;
}
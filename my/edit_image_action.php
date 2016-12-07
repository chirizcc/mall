<?php

session_start();
include '../public/db.php';
include '../public/function.php';

if(empty($_SESSION['isLogin']) && $_SESSION['isLogin'] != 1){
	echo '<script>alert("请先登录");window.location = "../login.php";</script>';
	die;
}

$id = $_SESSION['id'];
$div = "../images/usersImages";

$link = connectDB();

if($_FILES['file']['error'] == 4){
	header('location:edit_image.php?state=1');
	die;
}

$result = upload($_FILES['file'],$div);
if(!$result['result']){
	header('location:edit_image.php?state=2');
	die;
}

$picname = $result['picname'];
$picpath = $div."/".$picname;

if(!zoom($picpath,82,82,'s_')){
	unlink($picpath);
	header('location:edit_image.php?state=3');
	die;
}

unlink($picpath);

$oldpic = mysqli_fetch_assoc(mysqli_query($link,"select picname from users where id = {$id}"))['picname'];
$sql = "update users set picname = 's_{$picname}' where id = {$id}";
$res = mysqli_query($link,$sql);
if(!$res){
	unlink($div.'/s_'.$picname);
	header('location:edit_image.php?state=4');
	die;
}

if($oldpic != 'tx.png'){
	unlink($div.'/'.$oldpic);
}

header('location:myInfo.php');
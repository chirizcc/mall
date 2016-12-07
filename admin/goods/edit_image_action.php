<?php

include '../public/db.php';
include '../public/function.php';
$link = connectDB();

//判断登录状态
session_start();
if(empty($_SESSION['adminLogin']) || $_SESSION['adminLogin'] != 1){
	header('location:../login.php');
	die;
}

$div = '../../images/goodsImages';

$id = $_POST['id'];
$goodid = $_POST['goodid'];

if($_FILES['file']['error'] == 4){
	$url = $_SERVER['HTTP_REFERER'];
	header("location:$url");
	die;
}

//处理上传图片
$result = upload($_FILES['file'],$div);
if(!$result['result']){
	echo '<script>alert("上传失败");window.history.go(-1);</script>';
	die;
}

$picname = $result['picname'];
$picpath= $div."/".$picname;

//缩放图片
if(!(zoom($picpath,480,480,'l_') && zoom($picpath,200,200,'m_') && zoom($picpath,180,180,'s_'))){
	unlink($picpath);
	echo '<script>alert("缩放失败");window.history.go(-1);</script>';
	die;
}

//删除原图片，保留缩放后的图片
unlink($picpath);

$oldpic = mysqli_fetch_assoc(mysqli_query($link,"select picname from images where id = {$id}"))['picname'];
$sql = "update images set picname = '{$picname}' where id = {$id}";
$res = mysqli_query($link,$sql);
if(!$res){
	echo '<script>alert("失败");window.history.go(-1);</script>';
	die;
}
unlink($div."/l_".$oldpic);
unlink($div."/m_".$oldpic);
unlink($div."/s_".$oldpic);
header('location:images.php?id='.$goodid);
// echo '<script>window.history.go(-2);</script>';
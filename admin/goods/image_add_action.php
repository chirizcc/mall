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
$num = $_POST['num'];


if($_FILES['file']['error'] == 4){
	$url = $_SERVER['HTTP_REFERER'];
	header("location:$url");
	die;
}

//判断该商品的图片数量
if($num >= 3){
	echo '<script>alert("该商品图片数量达到上限");window.history.go(-1);</script>';
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

//存入数据库
$sql = "insert into images (goodsid,picname) values ({$id},'{$picname}')";
$res = mysqli_query($link,$sql);
if(!$res){
	unlink($div."/l_".$picname);
	unlink($div."/m_".$picname);
	unlink($div."/s_".$picname);
	echo $sql;
	die;
	echo '<script>alert("失败");window.history.go(-1);</script>';
	die;
}else{
	$url = $_SERVER['HTTP_REFERER'];
	header("location:$url");
	die;
}
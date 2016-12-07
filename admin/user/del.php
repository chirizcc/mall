<?php

include '../public/db.php';
session_start();

$id = $_GET['id'];

$link = connectDB();

$sql = "select state from users where id = $id";
$res = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($res);

if($_SESSION['myState'] == 0 && $row['state'] == 0 && $_SESSION['uid'] != $id){
	echo '<script>alert("权限不足");window.location = "index.php";</script>';
}else{

	$sql = 'delete from users where id = '.$id;
	$res = mysqli_query($link,$sql);

	header('location:index.php');
}
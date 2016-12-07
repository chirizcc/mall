<?php

/*$width = 160;//宽度
$height = 50;//高度
$state = 3;//字母数字混合
$poxel = 100;//干扰元素点个数
$line = 8;//干扰元素线
*/
// yzm(160,50);

function yzm($width,$height,$state = 3,$poxel = 100,$line = 8){
	//创建画布
	$dst = imageCreateTrueColor($width,$height);

	//为画布分配颜色
	$bgColor = imageColorAllocate($dst,rand(0,200),rand(0,200),rand(0,200));

	//给干扰元素点分配颜色
	$pixelColor = imageColorAllocate($dst,rand(0,255),rand(0,255),rand(0,255));

	//给干扰元素线分配颜色
	$lineColor = imageColorAllocate($dst,rand(0,255),rand(0,255),rand(0,255));

	//给字体分配颜色
	$textColor = imageColorAllocate($dst,rand(150,255),rand(150,255),rand(150,255));

	//画一个矩形并填充
	imagefilledrectangle($dst,0,0,$width,$height,$bgColor);

	//画干扰元素点
	for($i = 0;$i < $poxel;$i++){
		imagesetpixel($dst,rand(0,$width),rand(0,$height),$pixelColor);
	}

	//画干扰元素线
	for($i = 0;$i < $line;$i++){
		imageline($dst,rand(0,$width),rand(0,$height),rand(0,$width),rand(0,$height),$lineColor);
	}

	switch($state){
		case 1:
			$text = array_rand(range(0, 9),4);
			break;
		case 2:
			$text = array_rand(array_flip(array_merge(range('a','z'),range('A','Z'))),4);
			break;
		case 3:
			$text = array_rand(array_flip(array_merge(range(0,9),range('a','z'),range('A','Z'))),4);
			break;
		default:
			die('没有该选项');
	}

	for($i = 0;$i < 4;$i++){
		imagettftext($dst, 20, 0, rand($i * ($width / 4),($i + 1) * ($width / 4) - 20), rand(20,$height), $textColor, 'simsun.ttc', $text[$i]);
	}

	// $fileName = date('YmdHis').rand(10000,99999).'.jpg';

	session_start();
	$yzm = implode('', $text);
	$_SESSION['yzm'] = $yzm;

	header('Content-type:image/jpeg');
	// imagejpeg($dst,'images/yzm/'.$fileName);
	imagejpeg($dst);
	imagedestroy($dst);

	// echo '<a href="getYzm.php"><img src="images/yzm/'.$fileName.'"></a>';

	// return $fileName;
}

yzm(160,50);
<?php

function upload($file,$dir = './upload',$size = 10240000,$picarr = array('image/jpeg','image/png','image/gif','image/jpg')){

	$result = array('result' => false,'info' => '','picname' => '');

	if($file['error'] != 0){
		switch ($file['error']) {
			case 1:
				$result['info'] = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
				break;
			
			case 2:
				$result['info'] = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
				break;

			case 3:
				$result['info'] = '文件只有部分被上传';
				break;

			case 4:
				$result['info'] = '没有文件被上传';
				break;

			case 6:
				$result['info'] = '找不到临时文件夹';
				break;

			case 7:
				$result['info'] = '文件写入失败';
				break;

			default:
				$result['info'] = '未知错误';
				break;
		}

		return $result;
	}

	if(!in_array($file['type'],$picarr)){
		$result['info'] = '该文件类型不允许上传';
		return $result;
	}

	if($file['size'] > $size){
		$result['info'] = '文件过大，无法上传';
		return $result;
	}

	if(!is_uploaded_file($file['tmp_name'])){
		$result['info'] = '该文件不是通过正常form上传';
		return $result;
	}

	$path = rtrim($dir,'/').'/';
	if(!file_exists($path) || !is_dir($path)){
		mkdir($path);
	}

	do{
		$newName = date('YmdHis').rand(10000,99999).'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
	}while(file_exists($path.$newName));
	
	if(move_uploaded_file($file['tmp_name'],$path.$newName)){
		$result['result'] = true;
		$result['picname'] = $newName;
		return $result;
	}else{
		$result['info'] = '上传失败';
		return $result;
	}

}


function zoom($srcImage,$width='200',$height='100'){

	$imageInfo = getimagesize($srcImage);

	switch ($imageInfo['2']) {
		case 1:
			$src = imagecreatefromgif($srcImage);
			break;
		
		case 2:
			$src = imagecreatefromjpeg($srcImage);
			break;

		case 2:
			$src = imagecreatefrompng($srcImage);
			break;

		default:
			//$result['info'] = '没有此类型的画布';
			unlink($srcImage);
			return false;
			break;
	}

	if($imageInfo['0'] > $imageInfo['1']){
		$height = ($width / $imageInfo['0']) * $imageInfo['1'];
	}else{
		$width = ($height / $imageInfo['1']) * $imageInfo['0'];
	}

	$dst = imagecreatetruecolor($width, $height);

	imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$imageInfo['0'],$imageInfo['1']);

	$path = dirname($srcImage).'/s_'.basename($srcImage);

	if(!imagejpeg($dst,$path)){
		// unlink($srcImage);
		return false;
	}
	imagedestroy($dst);
	imagedestroy($src);
	
	return true;
}
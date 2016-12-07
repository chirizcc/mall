<?php

define('HOST','localhost');
define('USER','root');
define('PWD','QQ397397');
define('DBNAME','project');

function connectDB(){
	$link = @mysqli_connect(HOST,USER,PWD);

	if(!$link){
		return false;
	}

	mysqli_select_db($link,DBNAME);
	mysqli_set_charset($link,'utf8');
	return $link;
}
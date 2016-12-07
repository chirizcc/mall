<?php

include 'function.php';

if(zoom('1.jpg',2000,2000)){
	echo '成功';
}else{
	echo '失败';
}
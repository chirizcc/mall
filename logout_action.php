<?php

session_start();
unset($_SESSION['user']);
unset($_SESSION['isLogin']);
unset($_SESSION['id']);
$isLogin = 0;

echo '<script>alert("退出成功");window.location = "index.php";</script>';
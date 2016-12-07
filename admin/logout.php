<?php

//登出
session_start();
unset($_SESSION['adminLogin']);
unset($_SESSION['userName']);
unset($_SESSION['uid']);
unset($_SESSION['myState']);
header('location:index.php');
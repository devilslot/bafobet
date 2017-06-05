<?php
header("Content-type: text/html; charset=utf-8");
session_start();
//session_destroy();
require_once "creation/creation.init.php";
unset($_SESSION[MEMBER]);
unset($_SESSION['username']);
unset($_SESSION['password']);
header('location: index.php');
?>
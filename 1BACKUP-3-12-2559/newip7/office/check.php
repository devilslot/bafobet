<?php
@session_start();
header("Content-type: text/html; charset=utf-8");
include "../service/service.php";
echo "<pre>";print_r($_SESSION);echo "</pre>";
?>
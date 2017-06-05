<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once "service/service.php";
if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
	@header('location: /index.php');
	exit;
}

$sql="
DELETE FROM comment WHERE code= '".$_GET['id']."'
";

$query=mysql_query($sql) or die(mysql_error());

echo '<script language="javascript">window.location.replace("comment.php?matchID='.$_GET['matchID'].'");</script>';



?>
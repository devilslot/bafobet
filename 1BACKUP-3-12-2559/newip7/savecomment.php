<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once "service/service.php";
if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
  @header('location: /index.php');
  exit;
}

if ($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'])) {
	$sql="
	INSERT INTO comment (
		memberID,
		matchID,
		msg,
		ip,
		user_create,
		date_create
		)
VALUES(
	'".$_SESSION[MEMBER]['DATA']['code']."',
	'".$_POST['matchID']."',
	'".$_POST['msg']."',
	'".get_client_ip()."',
	'".$_SESSION[MEMBER]['DATA']['username']."',
	NOW()
	)
";

$query=mysql_query($sql) or die(mysql_error());

echo '<script language="javascript">window.location.replace("comment.php?matchID='.$_POST['matchID'].'");</script>';


}else{
	echo '<script language="javascript">alert("กรุณาตรวจสอบ CODE  4  หลัก ");</script>';
	echo '<script language="javascript">window.location.replace("addComment.php?matchID='.$_POST['matchID'].'");</script>';

}

?>
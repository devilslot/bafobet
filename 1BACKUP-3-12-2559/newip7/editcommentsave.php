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
	UPDATE  comment  SET msg = '".$_POST['msg']."', date_update = NOW() 
	WHERE code = '".$_POST['id']."'
";

$query=mysql_query($sql) or die(mysql_error());

echo '<script language="javascript">window.location.replace("comment.php?matchID='.$_POST['matchID'].'");</script>';


}else{
	echo '<script language="javascript">alert("กรุณาตรวจสอบ CODE  4  หลัก ");</script>';
	echo '<script language="javascript">window.location.replace("editComment.php?id='.$_POST['id'].'&matchID='.$_POST['matchID'].'");</script>';

}

?>
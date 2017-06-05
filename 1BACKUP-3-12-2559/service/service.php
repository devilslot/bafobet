<?php
error_reporting(E_ALL & ~E_NOTICE);

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minates ago
    session_destroy();   // destroy session data in storage
    session_unset();     // unset $_SESSION variable for the runtime
}
$_SESSION['LAST_ACTIVITY'] = time();
get_magic_quotes_gpc();
function getTime()  {   $a = explode (' ',microtime());    return(double) $a[0] + $a[1];  } 
$_SESSION['set_begin_page_time'] =getTime(); 

ini_set('display_errors', 1); // Value 0 Not Show Error,1 Show Error 
ini_set('register_globals', 'Off');

date_default_timezone_set('Asia/Bangkok');
//date_default_timezone_set('America/Mexico_City');

@include("core/core.php");
@include("../core/core.php");
$db=Live::core("db");
$member=Live::member();
$moncredit=$member['moncredit'];

if($member['locked'] == 'lock'){
session_destroy();
?>
<script>
    alert("บัญชีของท่านถูกล๊อค!! กรุณาติดต่อแชท");
	window.location="index.php";
</script>
<? 
		exit();
}

if($member['mactive_date']==''){
	$mactive_date=strtotime('+2 day',time());
}else{
	$mactive_date=strtotime('+1 day',$member['mactive_date']);
}
Live::close();/**/


include "connection.php";
include "define.php";
include "func.php";



if(date('H')<12){
$datestart = strtotime('-1 day', strtotime(date('Y-m-d 12:00:00')));
$datestop = strtotime(date('Y-m-d 11:59:59'));

}else{
$datestart = strtotime(date('Y-m-d 12:00:00'));
$datestop = strtotime('+1 day', strtotime(date('Y-m-d 11:59:59')));
}

if(empty($_GET['dateMatch'])){
 	$datestart=$datestart;
	$datestop=$datestop;
}else{
  	$date = $_GET['dateMatch'];
	
	if(date('H')<12){
	$datestart=strtotime('-1 day', strtotime(date($_GET['dateMatch'].' 12:00:00')));
	$datestop=strtotime(date($_GET['dateMatch'].' 11:59:59'));
	
	}else{
	$datestart = strtotime(date($_GET['dateMatch'].' 12:00:00'));
	$datestop = strtotime('+1 day', strtotime(date($_GET['dateMatch'].' 11:59:59')));
	}
}

?>
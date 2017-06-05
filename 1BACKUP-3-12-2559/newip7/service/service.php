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

include "connection.php";
include "define.php";
include "func.php";


?>
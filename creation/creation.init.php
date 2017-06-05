<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 05/12/2013 09:09
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

require_once "service/service.php";
require_once "main/main.class.php";
require_once "creation/creation.class.php";
require_once "creation/module/content/content.class.php";

// if(empty($_SESSION['LANG'])){
//   $lang = 'th';
//   $_SESSION['LANG'] = 'th';
// }else{
//   $lang = $_SESSION['LANG'];
// }
function DisplayLeague($name){
	$sql="
	SELECT
	sname
	FROM
	soccer_league
	WHERE
	ename = '$name'
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$sname=$row->sname;
	}
	mysql_free_result($query);

	return $sname;
}

function CheckColor($name){
	$sql="
	SELECT
	color
	FROM
	soccer_league
	WHERE
	sname = '$name'
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$color=$row->color;
	}
	mysql_free_result($query);

	if(empty($color)){
	$color = dechex(crc32($name));
  	$color = substr($color, 0, 6);
	}
	
	return $color;
}

function color_inverse($color){
    /*$color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }*/
	
	//$color = "78ff2f"; //Bg color in hex, without any prefixing #!

//break up the color in its RGB components
//$color = substr($color,1,6);
$r = hexdec(substr($color,0,2));
$g = hexdec(substr($color,2,2));
$b = hexdec(substr($color,4,2));

//do simple weighted avarage
//
//(This might be overly simplistic as different colors are perceived
// differently. That is a green of 128 might be brighter than a red of 128.
// But as long as it's just about picking a white or black text color...)
if($r + $g + $b > 382){
    //bright color, use dark font
	return '#000000';
}else{
    //dark color, use bright font
	return '#FFFFFF';
}

    //return '#'.$rgb;
}

function DisplayUser($id){
	$sql="
	SELECT
	username
	FROM
	members
	WHERE
	code = '$id'
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$username=$row->username;
	}
	mysql_free_result($query);

	return $username;
}



function RandomColor(){
	$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
	$color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];

	return $color;

}


function checkHDC($matchID){
	$sql="
	SELECT
	count(code) AS  cnt
	FROM
	matchHDC
	WHERE
	MatchID = '$matchID'
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$cnt=$row->cnt;
	}
	mysql_free_result($query);

	return $cnt;
}

function ReCheckHDC($hdc){
	$sql="
	SELECT
	count(code) AS  cnt
	FROM
	hdc_setting
	WHERE
	hdc = '".number_format($hdc,2)."'
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$cnt=$row->cnt;
	}
	mysql_free_result($query);
	if($cnt == 0){
		return false;
	}else{
		return true;
	}

	
}


function CountPlay($memberID){
	$sql="
	SELECT
	COUNT(code) AS cnt
	FROM
	playgame
	WHERE
	memberID = '$memberID'
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$total=$row->cnt;
	}
	mysql_free_result($query);

	return $total;
}


function CountWin($memberID){
	$sql="
	SELECT
	COUNT(code) AS cnt
	FROM
	playgame
	WHERE
	memberID = '$memberID' AND
	status = 1
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$total=$row->cnt;
	}
	mysql_free_result($query);

	return $total;
}

function CountDraw($memberID){
	$sql="
	SELECT
	COUNT(code) AS cnt
	FROM
	playgame
	WHERE
	memberID = '$memberID' AND
	status = 0
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$total=$row->cnt;
	}
	mysql_free_result($query);

	return $total;
}

function CountLoss($memberID){
	$sql="
	SELECT
	COUNT(code) AS cnt
	FROM
	playgame
	WHERE
	memberID = '$memberID' AND
	status = 2
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$total=$row->cnt;
	}
	mysql_free_result($query);

	return $total;
}


function Countcomment($matchID){
	$sql="
	SELECT
	COUNT(code) AS cnt
	FROM
	comment
	WHERE
	matchID = '$matchID'
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$total=$row->cnt;
	}
	mysql_free_result($query);

	return $total;
}

function Counttry($matchID){
	$sql="
	SELECT
	COUNT(code) AS cnt
	FROM
	playgame
	WHERE
	matchID = '$matchID'
	";
//		echo $sql;
	$result=array();
	$query=mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_object($query)){
		$total=$row->cnt;
	}
	mysql_free_result($query);

	return $total;
}




$ojc = new clsContent();

// $content = $ojc->LoadContent($lang);
// $text = $ojc->LoadLanguage($lang);
$config = $ojc->LoadConfig();
//PrintR($text);
?>
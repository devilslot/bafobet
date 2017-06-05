<?php
session_start();
/*if($_SERVER['HTTPS']!="on")
{
$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
header("Location:$redirect");
}*/
//error_reporting(1);
date_default_timezone_set('Asia/Bangkok');
define('START',array_sum(explode(' ',microtime())));
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(dirname(__FILE__)).DS);
define('CORE',ROOT.'core'.DS);
define('TEMPLATE',ROOT.'template'.DS);
define('FILES',ROOT.'files/');

class Live {
		protected static $Live;
		public static $config;
		public static $core;
		public static $header;
		public static $site;
		public static $meta;
	public static function init()
	{
		if(is_null(Live::$Live)){
		Live::$Live=true;
		Live::$site=Live::$config['siteurl'];
		}
	}
	function core($core){
		require_once(CORE.$core.'.php');
		Live::$core = new $core;
		return Live::$core;
	}
	
	function GetMemberById($id){
		$db = Live::core('db');
		if($id != ''){
			$res = $db->GetRow("select * from member where id = '$id' limit 1");
			if($res){
				return $res;
			}else{
				return false;
			}	
		}else{
			return false;
		}	
	}	

	function nicetime($date)
	{
		if(empty($date)) {
			return "No date provided";
		}
		$periods         = array("วินาที", "นาที", "ชั่วโมง", "วัน", "อาทิตย์", "เดือน", "ปี", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		$now             = time();
		$unix_date         = strtotime($date);
		if(empty($unix_date)) {
			return "Bad date";
		}
		if($now > $unix_date) {
			$difference     = $now - $unix_date;
			$tense         = "ago";
		} else {
			$difference     = $unix_date - $now;
			$tense         = "";
		}
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		$difference = round($difference);
		if($difference != 1) {
			$periods[$j].= "s";
		}
		return "$difference $periods[$j] {$tense}";
	}

	function member(){
			$db = Live::core("db");
			$user = $_SESSION["username"];
			$pass = $_SESSION["mid"];
			$row = $db->GetRow("select * from member where username = '".$user."' and id = '".$pass."' AND webroot='bafobet' ");
			if(!empty($row)){
				return $row;
			}else{
				return false;
			}
	}
	
	function close(){
			$db = Live::core("db");
			$db->CloseDB();
			
				return 'fff';
			
	}

	function GetById($id){
		$db = Live::core('db');
		if($id != ''){
			$res = $db->GetRow("select * from member where id = '$id' limit 1");
			if($res){
				return $res;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function personnel(){
			$db = Live::core("db");
			$id = $_SESSION["pid"];
			$pass = $_SESSION["ppass"];
			$row = $db->GetRow("select * from personnel where id = '".$id."' and password = '".$pass."'");
			if(!empty($row)){
				return $row;
			}else{
				return false;
			}
	}
}

function checkemail($email) {
		if(!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
			return false;
		}
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for($i = 0; $i < sizeof($local_array); $i++) {
			if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",$local_array[$i])) {
				return false;
			}
		}
		 if(!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
				$domain_array = explode(".", $email_array[1]);
					if (sizeof($domain_array) < 2) {
						return false;
					}
			for($i = 0; $i < sizeof($domain_array); $i++) {
				if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$",$domain_array[$i])) {
					return false;
				}
			}
		}
	return true;
}

function cutStr($str, $maxChars='', $holder=''){
    if (strlen($str) > $maxChars ){
            $str = iconv_substr($str, 0, $maxChars,"UTF-8") . $holder;
    }
    return $str;
}

function number($a,$b,$c,$d){
	$number = explode(".",$a);
	return number_format($number[0], 0, '', ',');
}

include("betconfig.php");
Live::init();
?>

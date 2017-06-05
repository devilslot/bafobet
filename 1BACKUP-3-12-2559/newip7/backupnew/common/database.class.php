<?php
date_default_timezone_set("Asia/Bangkok");
if(isset($_COOKIE['PID'])){ $cookie_pid = $_COOKIE['PID']; }else{ $cookie_pid = ''; }

require('database.php');

$conn = new mysqli($servername, $username, $password, $dbname);
$conn -> query("SET names utf8");

/*$cbaf = new mysqli($servername2, $username2, $password2, $dbname2);
$cbaf -> query("SET names utf8");*/

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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


if((date('H')>='00')and(date('H')<'08')){
	#00:00-08:00
	$timework = '08';
}else if((date('H')>='08')and(date('H')<'16')){
	#08:00-16:00
	$timework = '16';
}else if((date('H')>='16')and(date('H')<='23')){
	#16:00-00:00
	$timework = '00';
}




$sqlre = '';
$sqlree = '';
$withdrawal = '';
$checkbank = ''; 
if(date('H')=='11'){ $spaesql = "AND froms NOT LIKE '2r%' "; }


$resultsum = $conn->query("select id from gamesid");
$gamesidnum = $resultsum->num_rows;

$resultsums = $conn->query("select persoid,date,gamesidname from sharework where  status='y'");
if ($resultsums->num_rows > 0) {
	$worknums=0;
	$shwork=0;
	$shwo=0;
	while($sums = $resultsums->fetch_assoc()) {
	
	if($sums['date']==$timework){ $worknums++; }
		if(($sums['date']==$timework)and($sums['persoid']==$cookie_pid)){ $shwork++; }
		if($sums['persoid']==$cookie_pid){
		
		$usesel[] = $sums['gamesidname'];
		
			$shwo++;
			if ($shwo == 1){
				$sqlre .= " tos LIKE  '".$sums['gamesidname']."%' OR tos LIKE  'NEWUSER:%' OR( tos LIKE  'SMS:%' AND transfrom='confirmed' )";
				$sqlree .= " froms LIKE  '".$sums['gamesidname']."%' ";
				
			}else{
				$sqlre .= "OR  tos LIKE  '".$sums['gamesidname']."%' ";
				$sqlree .= "OR  froms LIKE  '".$sums['gamesidname']."%' ";
			}
			
			
			if($sums['gamesidname']=='withdrawal'){ $withdrawal = 'Y'; }
			if($sums['gamesidname']=='checkbank'){ $checkbank = 'Y'; }
		
		}
	}
}

?>
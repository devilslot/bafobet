<?php
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";
$date = date('Y-m-d');


///  Tomorow

$date1 = date("Y-m-d", strtotime("-2 day", strtotime($date)));

$date2 = date("Y-m-d", strtotime("+1 day", strtotime($date)));


$json = file_get_contents('http://hereball.com/data/json/V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D/'.$date1.'/'.$date2.'');

$obj = json_decode($json);






// echo  "<h1>Get Data</h1>";
// echo "<pre>";print_r($obj);echo "</pre>";

foreach ($obj as $key => $value) {

	// echo ' ********************************************************************<br/>';
	// echo 'MatchID = '.$value->MatchID.'<br/>';
	// echo 'LeagueEngName = '.$value->LeagueEngName.'<br/>';
	// echo 'HomeName = '.$value->HomeName.'<br/>';
	// echo 'AwayName = '.$value->AwayName.'<br/>';
	// $current_time = $value->Date;
 //    $new_time = strtotime($current_time . "+7hours");
	// echo 'Date = '.date('Y-m-d H:i:s', $new_time).'<br/>';
	// echo 'AsianHandicap = '.number_format($value->AsianHandicap,2).'<br/>';
	// echo 'AsianHandicapHome = '.$value->AsianHandicapHome.'<br/>';
	// echo 'AsianHandicapAway = '.$value->AsianHandicapAway.'<br/><br/>';
	// echo ' ********************************************************************<br/><br/><br/>';
	
	
	
	$sqlck="SELECT COUNT(code) AS cnt FROM matchHDC  WHERE MatchID = '$value->MatchID' ";
	$queryck = mysql_query($sqlck);
	$count = 0;
	if($row=mysql_fetch_object($queryck)){
		$count = $row->cnt;
	} 


	if($value->Status=='1'){
		$sql="SELECT start FROM matchHDC WHERE MatchID=".$value->MatchID." ";
       // echo $sql;
        $query=mysql_query($sql);
        $rowdb=mysql_fetch_assoc($query);
		if($rowdb['start']==''){
					@mysql_query("UPDATE matchHDC SET start='".time()."',ScoreHomeFullTime='0',ScoreAwayFulltime='0'   WHERE MatchID=".$value->MatchID." ");
		}
		}
		
		if($value->Status=='3'){
		
			$sql="SELECT halfstart FROM matchHDC WHERE MatchID=".$value->MatchID." ";
       // echo $sql;
        $query=mysql_query($sql);
        $rowdb=mysql_fetch_assoc($query);
		$sht =$rowdb['halfstart']+3600;
		if($sht<time()){ mysql_query("UPDATE matchHDC SET Status='-1'   WHERE MatchID=".$value->MatchID." AND Status!='-1'"); }
		}
		
	if($count==0 and $value->AsianHandicap !=''){
		$hdc= number_format($value->AsianHandicap,2);
		
		
		
		
		if(ReCheckHDC($hdc)){
			$sql="
			INSERT  INTO matchHDC  SET
			MatchID = '".mysql_real_escape_string($value->MatchID)."',
			LeagueID = '".mysql_real_escape_string($value->LeagueID)."',
			LeagueShortName = '".mysql_real_escape_string($value->LeagueShortName)."',
			LeagueEngName = '".mysql_real_escape_string($value->LeagueEngName)."',
			LeagueThaiName = '".mysql_real_escape_string($value->LeagueThaiName)."',
			HomeID = '".mysql_real_escape_string($value->HomeID)."',
			AwayID = '".mysql_real_escape_string($value->AwayID)."',
			HomeName = '".mysql_real_escape_string($value->HomeName)."',
			AwayName = '".mysql_real_escape_string($value->AwayName)."',
			Date = '".mysql_real_escape_string($value->Date)."',
			Status = '".mysql_real_escape_string($value->Status)."',
			ScoreHomeHalfTime = '".mysql_real_escape_string($value->ScoreHomeHalfTime)."',
			ScoreAwayHalfTime = '".mysql_real_escape_string($value->ScoreAwayHalfTime)."',
			ScoreHomeFullTime = '".mysql_real_escape_string($value->ScoreHomeFullTime)."',
			ScoreAwayFulltime = '".mysql_real_escape_string($value->ScoreAwayFulltime)."',
			HomeRedCard = '".mysql_real_escape_string($value->HomeRedCard)."',
			AwayRedCard = '".mysql_real_escape_string($value->AwayRedCard)."',
			HomeYellowCard = '".mysql_real_escape_string($value->HomeYellowCard)."',
			AwayYellowCard = '".mysql_real_escape_string($value->AwayYellowCard)."',
			AwayPosition = '".mysql_real_escape_string($value->AwayPosition)."',
			HomePosition = '".mysql_real_escape_string($value->HomePosition)."',
			AsianHandicap = '".mysql_real_escape_string($value->AsianHandicap)."',
			AsianHandicapLive = '".mysql_real_escape_string($value->AsianHandicapLive)."',
			AsianHandicapHome = '".mysql_real_escape_string($value->AsianHandicapHome)."',
			AsianHandicapAway = '".mysql_real_escape_string($value->AsianHandicapAway)."',
			date_save = '".$date."',
			date_create = NOW(),
			date_update = NOW()
			";

			$query=mysql_query($sql) or die(mysql_error());

		}

	}else{


		$hdc= number_format($value->AsianHandicap,2);
		
/*
AwayPosition = '".mysql_real_escape_string($value->AwayPosition)."',
			HomePosition = '".mysql_real_escape_string($value->HomePosition)."',
*/
			$sql="
			UPDATE   matchHDC  SET
			Status = '".mysql_real_escape_string($value->Status)."',
			ScoreHomeHalfTime = '".mysql_real_escape_string($value->ScoreHomeHalfTime)."',
			ScoreAwayHalfTime = '".mysql_real_escape_string($value->ScoreAwayHalfTime)."',
			ScoreHomeFullTime = '".mysql_real_escape_string($value->ScoreHomeFullTime)."',
			ScoreAwayFulltime = '".mysql_real_escape_string($value->ScoreAwayFulltime)."',
			HomeRedCard = '".mysql_real_escape_string($value->HomeRedCard)."',
			AwayRedCard = '".mysql_real_escape_string($value->AwayRedCard)."',
			HomeYellowCard = '".mysql_real_escape_string($value->HomeYellowCard)."',
			AwayYellowCard = '".mysql_real_escape_string($value->AwayYellowCard)."',
			
			date_update = NOW()
			WHERE  MatchID = '".$value->MatchID."'
AND Status !='-1'
			";

			$query=mysql_query($sql) or die(mysql_error());	

		

	}


}

///  Today
/*
$date1 = date("Y-m-d");

$date2 =  date("Y-m-d");


$json = file_get_contents('http://hereball.com/data/json/V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D/'.$date1.'/'.$date2.'');

$obj = json_decode($json);






// echo  "<h1>Get Data</h1>";
// echo "<pre>";print_r($obj);echo "</pre>";

foreach ($obj as $key => $value) {

	// echo ' ********************************************************************<br/>';
	// echo 'MatchID = '.$value->MatchID.'<br/>';
	// echo 'LeagueEngName = '.$value->LeagueEngName.'<br/>';
	// echo 'HomeName = '.$value->HomeName.'<br/>';
	// echo 'AwayName = '.$value->AwayName.'<br/>';
	// $current_time = $value->Date;
 //    $new_time = strtotime($current_time . "+7hours");
	// echo 'Date = '.date('Y-m-d H:i:s', $new_time).'<br/>';
	// echo 'AsianHandicap = '.number_format($value->AsianHandicap,2).'<br/>';
	// echo 'AsianHandicapHome = '.$value->AsianHandicapHome.'<br/>';
	// echo 'AsianHandicapAway = '.$value->AsianHandicapAway.'<br/><br/>';
	// echo ' ********************************************************************<br/><br/><br/>';
	
	
	
	$sqlck="SELECT COUNT(code) AS cnt FROM matchHDC  WHERE MatchID = '$value->MatchID' ";
	$queryck = mysql_query($sqlck);
	$count = 0;
	if($row=mysql_fetch_object($queryck)){
		$count = $row->cnt;
	} 

	if($value->Status=='1'){
		$sql="SELECT start FROM matchHDC WHERE MatchID=".$value->MatchID." ";
       // echo $sql;
        $query=mysql_query($sql);
        $rowdb=mysql_fetch_assoc($query);
		if($rowdb['start']==''){
					@mysql_query("UPDATE matchHDC SET start='".time()."',ScoreHomeFullTime='0',ScoreAwayFulltime='0'   WHERE MatchID=".$value->MatchID." ");
		}
		}
		
		
	if($count==0 and $value->AsianHandicap !=''){
		$hdc= number_format($value->AsianHandicap,2);
		
				
		if(ReCheckHDC($hdc)){
			$sql="
			INSERT  INTO matchHDC  SET
			MatchID = '".mysql_real_escape_string($value->MatchID)."',
			LeagueID = '".mysql_real_escape_string($value->LeagueID)."',
			LeagueShortName = '".mysql_real_escape_string($value->LeagueShortName)."',
			LeagueEngName = '".mysql_real_escape_string($value->LeagueEngName)."',
			LeagueThaiName = '".mysql_real_escape_string($value->LeagueThaiName)."',
			HomeID = '".mysql_real_escape_string($value->HomeID)."',
			AwayID = '".mysql_real_escape_string($value->AwayID)."',
			HomeName = '".mysql_real_escape_string($value->HomeName)."',
			AwayName = '".mysql_real_escape_string($value->AwayName)."',
			Date = '".mysql_real_escape_string($value->Date)."',
			Status = '".mysql_real_escape_string($value->Status)."',
			ScoreHomeHalfTime = '".mysql_real_escape_string($value->ScoreHomeHalfTime)."',
			ScoreAwayHalfTime = '".mysql_real_escape_string($value->ScoreAwayHalfTime)."',
			ScoreHomeFullTime = '".mysql_real_escape_string($value->ScoreHomeFullTime)."',
			ScoreAwayFulltime = '".mysql_real_escape_string($value->ScoreAwayFulltime)."',
			HomeRedCard = '".mysql_real_escape_string($value->HomeRedCard)."',
			AwayRedCard = '".mysql_real_escape_string($value->AwayRedCard)."',
			HomeYellowCard = '".mysql_real_escape_string($value->HomeYellowCard)."',
			AwayYellowCard = '".mysql_real_escape_string($value->AwayYellowCard)."',
			AwayPosition = '".mysql_real_escape_string($value->AwayPosition)."',
			HomePosition = '".mysql_real_escape_string($value->HomePosition)."',
			AsianHandicap = '".mysql_real_escape_string($value->AsianHandicap)."',
			AsianHandicapLive = '".mysql_real_escape_string($value->AsianHandicapLive)."',
			AsianHandicapHome = '".mysql_real_escape_string($value->AsianHandicapHome)."',
			AsianHandicapAway = '".mysql_real_escape_string($value->AsianHandicapAway)."',
			date_save = '".$date."',
			date_create = NOW(),
			date_update = NOW()
			";

			$query=mysql_query($sql) or die(mysql_error());

		}

	}else{
		$hdc= number_format($value->AsianHandicap,2);
		if(ReCheckHDC($hdc)){
			$sql="
			UPDATE   matchHDC  SET
			LeagueID = '".mysql_real_escape_string($value->LeagueID)."',
			LeagueShortName = '".mysql_real_escape_string($value->LeagueShortName)."',
			LeagueEngName = '".mysql_real_escape_string($value->LeagueEngName)."',
			LeagueThaiName = '".mysql_real_escape_string($value->LeagueThaiName)."',
			HomeID = '".mysql_real_escape_string($value->HomeID)."',
			AwayID = '".mysql_real_escape_string($value->AwayID)."',
			HomeName = '".mysql_real_escape_string($value->HomeName)."',
			AwayName = '".mysql_real_escape_string($value->AwayName)."',
			Date = '".mysql_real_escape_string($value->Date)."',
			Status = '".mysql_real_escape_string($value->Status)."',
			ScoreHomeHalfTime = '".mysql_real_escape_string($value->ScoreHomeHalfTime)."',
			ScoreAwayHalfTime = '".mysql_real_escape_string($value->ScoreAwayHalfTime)."',
			ScoreHomeFullTime = '".mysql_real_escape_string($value->ScoreHomeFullTime)."',
			ScoreAwayFulltime = '".mysql_real_escape_string($value->ScoreAwayFulltime)."',
			HomeRedCard = '".mysql_real_escape_string($value->HomeRedCard)."',
			AwayRedCard = '".mysql_real_escape_string($value->AwayRedCard)."',
			HomeYellowCard = '".mysql_real_escape_string($value->HomeYellowCard)."',
			AwayYellowCard = '".mysql_real_escape_string($value->AwayYellowCard)."',
			AwayPosition = '".mysql_real_escape_string($value->AwayPosition)."',
			HomePosition = '".mysql_real_escape_string($value->HomePosition)."',
			AsianHandicap = '".mysql_real_escape_string($value->AsianHandicap)."',
			AsianHandicapLive = '".mysql_real_escape_string($value->AsianHandicapLive)."',
			AsianHandicapHome = '".mysql_real_escape_string($value->AsianHandicapHome)."',
			AsianHandicapAway = '".mysql_real_escape_string($value->AsianHandicapAway)."',
			date_update = NOW()
			WHERE  MatchID = '".$value->MatchID."'
			";

			$query=mysql_query($sql) or die(mysql_error());	
		}
	}




}


///  Yesterday

$date1 = date("Y-m-d", strtotime("-1 day", strtotime($date)));

$date2 = date("Y-m-d", strtotime("-1 day", strtotime($date)));


$json = file_get_contents('http://hereball.com/data/json/V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D/'.$date1.'/'.$date2.'');

$obj = json_decode($json);






// echo  "<h1>Get Data</h1>";
// echo "<pre>";print_r($obj);echo "</pre>";

foreach ($obj as $key => $value) {

	// echo ' ********************************************************************<br/>';
	// echo 'MatchID = '.$value->MatchID.'<br/>';
	// echo 'LeagueEngName = '.$value->LeagueEngName.'<br/>';
	// echo 'HomeName = '.$value->HomeName.'<br/>';
	// echo 'AwayName = '.$value->AwayName.'<br/>';
	// $current_time = $value->Date;
 //    $new_time = strtotime($current_time . "+7hours");
	// echo 'Date = '.date('Y-m-d H:i:s', $new_time).'<br/>';
	// echo 'AsianHandicap = '.number_format($value->AsianHandicap,2).'<br/>';
	// echo 'AsianHandicapHome = '.$value->AsianHandicapHome.'<br/>';
	// echo 'AsianHandicapAway = '.$value->AsianHandicapAway.'<br/><br/>';
	// echo ' ********************************************************************<br/><br/><br/>';
	
	
	
	$sqlck="SELECT COUNT(code) AS cnt FROM matchHDC  WHERE MatchID = '$value->MatchID' ";
	$queryck = mysql_query($sqlck);
	$count = 0;
	if($row=mysql_fetch_object($queryck)){
		$count = $row->cnt;
	} 
	
	if($value->Status=='1'){
		$sql="SELECT start FROM matchHDC WHERE MatchID=".$value->MatchID." ";
       // echo $sql;
        $query=mysql_query($sql);
        $rowdb=mysql_fetch_assoc($query);
		if($rowdb['start']==''){
					@mysql_query("UPDATE matchHDC SET start='".time()."',ScoreHomeFullTime='0',ScoreAwayFulltime='0'   WHERE MatchID=".$value->MatchID." ");
		}
		}

	if($count==0 and $value->AsianHandicap !=''){
		$hdc= number_format($value->AsianHandicap,2);
		if(ReCheckHDC($hdc)){
			$sql="
			INSERT  INTO matchHDC  SET
			MatchID = '".mysql_real_escape_string($value->MatchID)."',
			LeagueID = '".mysql_real_escape_string($value->LeagueID)."',
			LeagueShortName = '".mysql_real_escape_string($value->LeagueShortName)."',
			LeagueEngName = '".mysql_real_escape_string($value->LeagueEngName)."',
			LeagueThaiName = '".mysql_real_escape_string($value->LeagueThaiName)."',
			HomeID = '".mysql_real_escape_string($value->HomeID)."',
			AwayID = '".mysql_real_escape_string($value->AwayID)."',
			HomeName = '".mysql_real_escape_string($value->HomeName)."',
			AwayName = '".mysql_real_escape_string($value->AwayName)."',
			Date = '".mysql_real_escape_string($value->Date)."',
			Status = '".mysql_real_escape_string($value->Status)."',
			ScoreHomeHalfTime = '".mysql_real_escape_string($value->ScoreHomeHalfTime)."',
			ScoreAwayHalfTime = '".mysql_real_escape_string($value->ScoreAwayHalfTime)."',
			ScoreHomeFullTime = '".mysql_real_escape_string($value->ScoreHomeFullTime)."',
			ScoreAwayFulltime = '".mysql_real_escape_string($value->ScoreAwayFulltime)."',
			HomeRedCard = '".mysql_real_escape_string($value->HomeRedCard)."',
			AwayRedCard = '".mysql_real_escape_string($value->AwayRedCard)."',
			HomeYellowCard = '".mysql_real_escape_string($value->HomeYellowCard)."',
			AwayYellowCard = '".mysql_real_escape_string($value->AwayYellowCard)."',
			AwayPosition = '".mysql_real_escape_string($value->AwayPosition)."',
			HomePosition = '".mysql_real_escape_string($value->HomePosition)."',
			AsianHandicap = '".mysql_real_escape_string($value->AsianHandicap)."',
			AsianHandicapLive = '".mysql_real_escape_string($value->AsianHandicapLive)."',
			AsianHandicapHome = '".mysql_real_escape_string($value->AsianHandicapHome)."',
			AsianHandicapAway = '".mysql_real_escape_string($value->AsianHandicapAway)."',
			date_save = '".$date."',
			date_create = NOW(),
			date_update = NOW()
			";

			$query=mysql_query($sql) or die(mysql_error());

		}

	}else{
		$hdc= number_format($value->AsianHandicap,2);
		if(ReCheckHDC($hdc)){
			$sql="
			UPDATE   matchHDC  SET
			LeagueID = '".mysql_real_escape_string($value->LeagueID)."',
			LeagueShortName = '".mysql_real_escape_string($value->LeagueShortName)."',
			LeagueEngName = '".mysql_real_escape_string($value->LeagueEngName)."',
			LeagueThaiName = '".mysql_real_escape_string($value->LeagueThaiName)."',
			HomeID = '".mysql_real_escape_string($value->HomeID)."',
			AwayID = '".mysql_real_escape_string($value->AwayID)."',
			HomeName = '".mysql_real_escape_string($value->HomeName)."',
			AwayName = '".mysql_real_escape_string($value->AwayName)."',
			Date = '".mysql_real_escape_string($value->Date)."',
			Status = '".mysql_real_escape_string($value->Status)."',
			ScoreHomeHalfTime = '".mysql_real_escape_string($value->ScoreHomeHalfTime)."',
			ScoreAwayHalfTime = '".mysql_real_escape_string($value->ScoreAwayHalfTime)."',
			ScoreHomeFullTime = '".mysql_real_escape_string($value->ScoreHomeFullTime)."',
			ScoreAwayFulltime = '".mysql_real_escape_string($value->ScoreAwayFulltime)."',
			HomeRedCard = '".mysql_real_escape_string($value->HomeRedCard)."',
			AwayRedCard = '".mysql_real_escape_string($value->AwayRedCard)."',
			HomeYellowCard = '".mysql_real_escape_string($value->HomeYellowCard)."',
			AwayYellowCard = '".mysql_real_escape_string($value->AwayYellowCard)."',
			AwayPosition = '".mysql_real_escape_string($value->AwayPosition)."',
			HomePosition = '".mysql_real_escape_string($value->HomePosition)."',
			AsianHandicap = '".mysql_real_escape_string($value->AsianHandicap)."',
			AsianHandicapLive = '".mysql_real_escape_string($value->AsianHandicapLive)."',
			AsianHandicapHome = '".mysql_real_escape_string($value->AsianHandicapHome)."',
			AsianHandicapAway = '".mysql_real_escape_string($value->AsianHandicapAway)."',
			date_update = NOW()
			WHERE  MatchID = '".$value->MatchID."'
			";

			$query=mysql_query($sql) or die(mysql_error());	
		}
	}




}

*/


?>

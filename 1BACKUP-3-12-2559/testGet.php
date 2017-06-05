<?php
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
$json = file_get_contents('http://hereball.com/data/json/V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D/2016-06-30/2016-06-30');

$obj = json_decode($json);


// echo  "<h1>Get Data</h1>";
// echo "<pre>";print_r($obj);echo "</pre>";

foreach ($obj as $key => $value) {
	// echo ' ********************************************************************<br/>';
	echo 'MatchID = '.$value->MatchID.'<br/>';
	echo 'LeagueEngName = '.$value->LeagueEngName.'<br/>';
	echo 'HomeName = '.$value->HomeName.'<br/>';
	echo 'AwayName = '.$value->AwayName.'<br/>';
	$current_time = $value->Date;
    $new_time = strtotime($current_time . "+7hours");
	echo 'Date = '.date('Y-m-d H:i:s', $new_time).'<br/>';
	echo 'AsianHandicap = '.$value->AsianHandicap.'<br/>';
	echo 'AsianHandicapHome = '.$value->AsianHandicapHome.'<br/>';
	echo 'AsianHandicapAway = '.$value->AsianHandicapAway.'<br/><br/>';
	echo ' ********************************************************************<br/><br/><br/>';




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
  date_create = NOW(),
  date_update = NOW()
  ";

  $query=mysql_query($sql) or die(mysql_error());





}




?>

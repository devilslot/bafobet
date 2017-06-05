<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 29/07/14 13:27
*  Module : Office
*  Description : Office
*  Involve People : Boy
*  Last Updated : 29/07/14 13:27
\*================================================*/
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");

require_once "service/service.php";

$url = 'xml/match.xml';
$xml =  simplexml_load_file($url);
mysql_query('TRUNCATE TABLE matchDataLive');

foreach ($xml->Match as $key => $value) {
	$cut = substr($value->Date,0,-9);
	$temp = explode('T', $cut);

$selectedTime = $temp[1];
$endTime = strtotime("+7 hours", strtotime($selectedTime));
$TIMEM = date('H:i:s', $endTime);

	$sql="
  INSERT INTO matchDataLive (Id, date_match,time_match,League,Round,HomeTeam,HomeGoals,
    AwayTeam,AwayTeam_Id,AwayGoals,TimeM,Location,Groups,Groups_Id,HomeTeamYellowCardDetails,AwayTeamYellowCardDetails,
    HomeTeamRedCardDetails,AwayTeamRedCardDetails,date_create,date_update)
VALUES(
  '$value->Id', '$temp[0]', '$TIMEM', '".mysql_real_escape_string($value->League)."',
  '".mysql_real_escape_string($value->Round)."', '".mysql_real_escape_string($value->HomeTeam)."','','".mysql_real_escape_string($value->AwayTeam)."',
  '".mysql_real_escape_string($value->AwayTeam_Id)."', '','".mysql_real_escape_string($value->Time)."','".mysql_real_escape_string($value->Location)."','".mysql_real_escape_string($value->Group)."','".mysql_real_escape_string($value->Group_Id)."',
  '".mysql_real_escape_string($value->HomeTeamYellowCardDetails)."', '".mysql_real_escape_string($value->AwayTeamYellowCardDetails)."','".mysql_real_escape_string($value->HomeTeamRedCardDetails)."','".mysql_real_escape_string($value->AwayTeamRedCardDetails)."',
  NOW(),NOW()
  )
";
$query=mysql_query($sql) or die(mysql_error());



$sqlck="SELECT COUNT(code) AS cnt FROM matchData  WHERE Id = '$value->Id' ";
$queryck = mysql_query($sqlck);
$count = 0;
if($row=mysql_fetch_object($queryck)){
  $count = $row->cnt;
} 

if($count == 0){
  $sql="
  INSERT INTO matchData (Id, date_match,time_match,League,Round,HomeTeam,HomeGoals,
    AwayTeam,AwayTeam_Id,AwayGoals,TimeM,Location,Groups,Groups_Id,HomeTeamYellowCardDetails,AwayTeamYellowCardDetails,
    HomeTeamRedCardDetails,AwayTeamRedCardDetails,date_create,date_update)
VALUES(
  '$value->Id', '$temp[0]', '$temp[1]', '".mysql_real_escape_string($value->League)."',
  '".mysql_real_escape_string($value->Round)."', '".mysql_real_escape_string($value->HomeTeam)."','','".mysql_real_escape_string($value->AwayTeam)."',
  '".mysql_real_escape_string($value->AwayTeam_Id)."', '','".mysql_real_escape_string($value->Time)."','".mysql_real_escape_string($value->Location)."','".mysql_real_escape_string($value->Group)."','".mysql_real_escape_string($value->Group_Id)."',
  '".mysql_real_escape_string($value->HomeTeamYellowCardDetails)."', '".mysql_real_escape_string($value->AwayTeamYellowCardDetails)."','".mysql_real_escape_string($value->HomeTeamRedCardDetails)."','".mysql_real_escape_string($value->AwayTeamRedCardDetails)."',
  NOW(),NOW()
  )
";
$query=mysql_query($sql) or die(mysql_error());

}





 //echo $value->Id.'|'.$cut.'<br/>';







}

?>
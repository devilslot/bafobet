<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 29/07/14 13:27
*  Module : Office
*  Description : Office
*  Involve People : Boy
*  Last Updated : 29/07/14 13:27
\*================================================*/
// $url = 'http://www.hereball.com/data/odds.php?api=';
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");

require_once "service/service.php";

$url = 'xml/livescore.xml';
$xml =  simplexml_load_file($url);

foreach ($xml->Match as $key => $value) {

  $content =  file_get_contents($url.'V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D');

  // if(!empty ($content)){
  //   @unlink("xml/odds.xml");
  //   $content = str_replace("\r\n","",$content);
  //   file_put_contents(dirname(__FILE__) . '/xml/odds.xml', $content);
  // }


  $sql="
  UPDATE  matchDataLive  SET
  Spectators = '".mysql_real_escape_string($value->Spectators)."',
  TimeM = '".mysql_real_escape_string($value->Time)."',
  HomeGoals = '".mysql_real_escape_string($value->HomeGoals)."',
  AwayGoals = '".mysql_real_escape_string($value->AwayGoals)."',
  HomeGoalDetails = '".mysql_real_escape_string($value->HomeGoalDetails)."',
  AwayGoalDetails = '".mysql_real_escape_string($value->AwayGoalDetails)."',
  HomeLineupGoalkeeper = '".mysql_real_escape_string($value->HomeLineupGoalkeeper)."',
  AwayLineupGoalkeeper = '".mysql_real_escape_string($value->AwayLineupGoalkeeper)."',
  HomeLineupDefense = '".mysql_real_escape_string($value->HomeLineupDefense)."',
  AwayLineupDefense = '".mysql_real_escape_string($value->AwayLineupDefense)."',
  HomeLineupMidfield = '".mysql_real_escape_string($value->HomeLineupMidfield)."',
  AwayLineupMidfield = '".mysql_real_escape_string($value->AwayLineupMidfield)."',
  HomeLineupForward = '".mysql_real_escape_string($value->HomeLineupForward)."',
  AwayLineupForward = '".mysql_real_escape_string($value->AwayLineupForward)."',
  HomeLineupSubstitutes = '".mysql_real_escape_string($value->HomeLineupSubstitutes)."',
  AwayLineupSubstitutes = '".mysql_real_escape_string($value->AwayLineupSubstitutes)."',
  HomeLineupCoach = '".mysql_real_escape_string($value->HomeLineupCoach)."',
  AwayLineupCoach = '".mysql_real_escape_string($value->AwayLineupCoach)."',
  HomeSubDetails = '".mysql_real_escape_string($value->HomeSubDetails)."',
  AwaySubDetails = '".mysql_real_escape_string($value->AwaySubDetails)."',
  HomeTeamFormation = '".mysql_real_escape_string($value->HomeTeamFormation)."',
  AwayTeamFormation = '".mysql_real_escape_string($value->AwayTeamFormation)."',
  Stadium = '".mysql_real_escape_string($value->Stadium)."',
  HomeTeamYellowCardDetails = '".mysql_real_escape_string($value->HomeTeamYellowCardDetails)."',
  AwayTeamYellowCardDetails = '".mysql_real_escape_string($value->AwayTeamYellowCardDetails)."',
  HomeTeamRedCardDetails = '".mysql_real_escape_string($value->HomeTeamRedCardDetails)."',
  AwayTeamRedCardDetails = '".mysql_real_escape_string($value->AwayTeamRedCardDetails)."',
  Referee = '".mysql_real_escape_string($value->Referee)."',
  date_update = NOW()
  WHERE Id = '$value->Id'
  ";

  $query=mysql_query($sql) or die(mysql_error());

  $sql="
  UPDATE  matchData  SET
  Spectators = '".mysql_real_escape_string($value->Spectators)."',
  TimeM = '".mysql_real_escape_string($value->Time)."',
  HomeGoals = '".mysql_real_escape_string($value->HomeGoals)."',
  AwayGoals = '".mysql_real_escape_string($value->AwayGoals)."',
  HomeGoalDetails = '".mysql_real_escape_string($value->HomeGoalDetails)."',
  AwayGoalDetails = '".mysql_real_escape_string($value->AwayGoalDetails)."',
  HomeLineupGoalkeeper = '".mysql_real_escape_string($value->HomeLineupGoalkeeper)."',
  AwayLineupGoalkeeper = '".mysql_real_escape_string($value->AwayLineupGoalkeeper)."',
  HomeLineupDefense = '".mysql_real_escape_string($value->HomeLineupDefense)."',
  AwayLineupDefense = '".mysql_real_escape_string($value->AwayLineupDefense)."',
  HomeLineupMidfield = '".mysql_real_escape_string($value->HomeLineupMidfield)."',
  AwayLineupMidfield = '".mysql_real_escape_string($value->AwayLineupMidfield)."',
  HomeLineupForward = '".mysql_real_escape_string($value->HomeLineupForward)."',
  AwayLineupForward = '".mysql_real_escape_string($value->AwayLineupForward)."',
  HomeLineupSubstitutes = '".mysql_real_escape_string($value->HomeLineupSubstitutes)."',
  AwayLineupSubstitutes = '".mysql_real_escape_string($value->AwayLineupSubstitutes)."',
  HomeLineupCoach = '".mysql_real_escape_string($value->HomeLineupCoach)."',
  AwayLineupCoach = '".mysql_real_escape_string($value->AwayLineupCoach)."',
  HomeSubDetails = '".mysql_real_escape_string($value->HomeSubDetails)."',
  AwaySubDetails = '".mysql_real_escape_string($value->AwaySubDetails)."',
  HomeTeamFormation = '".mysql_real_escape_string($value->HomeTeamFormation)."',
  AwayTeamFormation = '".mysql_real_escape_string($value->AwayTeamFormation)."',
  Stadium = '".mysql_real_escape_string($value->Stadium)."',
  HomeTeamYellowCardDetails = '".mysql_real_escape_string($value->HomeTeamYellowCardDetails)."',
  AwayTeamYellowCardDetails = '".mysql_real_escape_string($value->AwayTeamYellowCardDetails)."',
  HomeTeamRedCardDetails = '".mysql_real_escape_string($value->HomeTeamRedCardDetails)."',
  AwayTeamRedCardDetails = '".mysql_real_escape_string($value->AwayTeamRedCardDetails)."',
  Referee = '".mysql_real_escape_string($value->Referee)."',
  date_update = NOW()
  WHERE Id = '$value->Id'
  ";

  $query=mysql_query($sql) or die(mysql_error());

}

?>
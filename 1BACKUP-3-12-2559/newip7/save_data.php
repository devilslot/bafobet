<?php
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";

$url = "http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/soccernew/home";

$xml = json_decode(json_encode(simplexml_load_file($url)), true);
// Get League
foreach ($xml['category'] as $key => $value) {
	// echo '<pre>';print_r($value['@attributes']);echo '</pre>';
	// echo $value['@attributes']['name'].'Date Match = '.$value['matches']['@attributes']['formatted_date'].'<br/>';

	// Get Match
	foreach ($value['matches']['match'] as $key2 => $value2) {
		// echo '########################################################<br/>';
		// echo '<pre>';print_r($value2['@attributes']['name']);echo '</pre>';
		// echo 'Sattus = '.$value2['@attributes']['status'].'<br/>';
		// echo 'Date = '.$value2['@attributes']['formatted_date'].'<br/>';
		// echo 'Time = '.$value2['@attributes']['time'].'<br/>';
		// echo 'Static ID = '.$value2['@attributes']['static_id'].'<br/>';
		// echo 'Fix ID = '.$value2['@attributes']['fix_id'].'<br/>';
		// echo 'ID = '.$value2['@attributes']['id'].'<br/>';
		// echo 'Local Team Name = '.$value2['localteam']['@attributes']['name'].'<br/>';
		// echo 'Local Team Goal = '.$value2['localteam']['@attributes']['goals'].'<br/>';
		// echo 'Local Team ID = '.$value2['localteam']['@attributes']['id'].'<br/>';
		// echo 'Visitor Team Name = '.$value2['visitorteam']['@attributes']['name'].'<br/>';
		// echo 'Visitor Team Goal = '.$value2['visitorteam']['@attributes']['goals'].'<br/>';
		// echo 'Visitor Team ID = '.$value2['visitorteam']['@attributes']['id'].'<br/>';
		// echo 'HT = '.$value2['ht']['@attributes']['score'].'<br/>';
		// // echo 'ID = '.$value2['@attributes']['id'].'<br/>';
		// echo '########################################################<br/>';

		$sqlck="SELECT COUNT(code) AS cnt FROM soccer_match  WHERE id_match = '".$value2['@attributes']['id']."' ";
		$queryck = mysql_query($sqlck);
		if($row=mysql_fetch_object($queryck)){
			$count = $row->cnt;
		} 

		if($count <= 0 and $value2['@attributes']['status'] != ""){
			$temp =explode('.', $value2['@attributes']['formatted_date']);
			$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
			$sql="
			INSERT  INTO soccer_match  SET
			status = '".mysql_real_escape_string($value2['@attributes']['status'])."',
			date_match = '".mysql_real_escape_string($date)."',
			time_match = '".mysql_real_escape_string($value2['@attributes']['time'])."',
			static_id = '".mysql_real_escape_string($value2['@attributes']['static_id'])."',
			fix_id = '".mysql_real_escape_string($value2['@attributes']['fix_id'])."',
			id_match = '".mysql_real_escape_string($value2['@attributes']['id'])."',
			local_team_name = '".mysql_real_escape_string($value2['localteam']['@attributes']['name'])."',
			local_team_goal = '".mysql_real_escape_string($value2['localteam']['@attributes']['goals'])."',
			local_team_id = '".mysql_real_escape_string($value2['localteam']['@attributes']['id'])."',
			visitor_team_name = '".mysql_real_escape_string($value2['visitorteam']['@attributes']['name'])."',
			visitor_team_goal = '".mysql_real_escape_string($value2['visitorteam']['@attributes']['goals'])."',
			visitor_team_id = '".mysql_real_escape_string($value2['visitorteam']['@attributes']['id'])."',
			ht = '".$value2['ht']['@attributes']['score']."',
			date_update = NOW()
			";
			$query=mysql_query($sql) or die(mysql_error());

		}else{
			$temp =explode('.', $value2['@attributes']['formatted_date']);
			$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
			$sql="
			UPDATE  soccer_match  SET
			status = '".mysql_real_escape_string($value2['@attributes']['status'])."',
			date_match = '".mysql_real_escape_string($date)."',
			time_match = '".mysql_real_escape_string($value2['@attributes']['time'])."',
			static_id = '".mysql_real_escape_string($value2['@attributes']['static_id'])."',
			fix_id = '".mysql_real_escape_string($value2['@attributes']['fix_id'])."',
			id_match = '".mysql_real_escape_string($value2['@attributes']['id'])."',
			local_team_name = '".mysql_real_escape_string($value2['localteam']['@attributes']['name'])."',
			local_team_goal = '".mysql_real_escape_string($value2['localteam']['@attributes']['goals'])."',
			local_team_id = '".mysql_real_escape_string($value2['localteam']['@attributes']['id'])."',
			visitor_team_name = '".mysql_real_escape_string($value2['visitorteam']['@attributes']['name'])."',
			visitor_team_goal = '".mysql_real_escape_string($value2['visitorteam']['@attributes']['goals'])."',
			visitor_team_id = '".mysql_real_escape_string($value2['visitorteam']['@attributes']['id'])."',
			ht = '".$value2['ht']['@attributes']['score']."',
			date_update = NOW()
			WHERE id_match = '".$value2['@attributes']['id']."'
			";
			$query=mysql_query($sql) or die(mysql_error());
		}









	}

	
}
echo "ok";
?>
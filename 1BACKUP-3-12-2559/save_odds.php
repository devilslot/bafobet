<?php
ini_set('memory_limit', '256M');
define("DB_HOST", "localhost");
define("DB_USER", "bafobet_zero");
define("DB_PASS", "Pd?am+H_,s2t");
define("DB_NAME", "bafobet_zero");

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS,TRUE) or die ('Error connecting to mysql');

@mysql_query("SET NAMES utf8");
@mysql_query("SET character_set_results=utf8");
@mysql_query("SET character_set_client=utf8");
@mysql_query("SET character_set_connection=utf8");
mysql_select_db(DB_NAME, $conn);


$url = "http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/getodds/soccer?cat=home";

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
		// echo 'Visitor Team ID = '.$value2['visitorteam']['@attributes']['name'].'<br/>';
		// echo 'Visitor Team Goal = '.$value2['visitorteam']['@attributes']['goals'].'<br/>';
		// echo 'Visitor Team ID = '.$value2['visitorteam']['@attributes']['id'].'<br/>';
		// echo 'HT = '.$value2['ht']['@attributes']['score'].'<br/>';
		// echo 'FT = '.$value2['ft']['@attributes']['score'].'<br/>';

		foreach ($value2['odds']['type'] as $key3 => $value3) {

			// echo '<pre>';print_r($value3['@attributes']);echo '</pre>';
			if($value3['@attributes']['value'] == "Handicap"){
				//echo $value3['@attributes']['value'].' ID = '.$value3['@attributes']['id'].'<br/>';

				foreach ($value3['bookmaker'] as $key4 => $value4) {
					echo $value4['@attributes']['name'].' ID = '.$value4['@attributes']['id'].'<br/>';
					foreach ($value4['handicap'] as $key5 => $value5) {

					 // echo $value5['@attributes']['name'].' MAIN = '.$value4['@attributes']['main'].'<br/>';
						foreach ($value5['odd'] as $key6 => $value6) {
							$sqlck="SELECT COUNT(code) AS cnt FROM soccer_odds  WHERE handicap_odd_id = '".$value6['@attributes']['id']."' ";
							$queryck = mysql_query($sqlck);
							if($row=mysql_fetch_object($queryck)){
								$count = $row->cnt;
							} 

							if($count <= 0 and $value2['@attributes']['status'] != ""){
								$temp =explode('.', $value2['@attributes']['formatted_date']);
								$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
								$sql="
								INSERT  INTO soccer_odds  SET
								status = '".mysql_real_escape_string($value2['@attributes']['status'])."',
								date_match = '".mysql_real_escape_string($date)."',
								time_match = '".mysql_real_escape_string($value2['@attributes']['time'])."',
								static_id = '".mysql_real_escape_string($value2['@attributes']['static_id'])."',
								fix_id = '".mysql_real_escape_string($value2['@attributes']['fix_id'])."',
								id_match = '".mysql_real_escape_string($value2['@attributes']['id'])."',
								bookmaker_name = '".$value4['@attributes']['name']."',
								handicap_name = '".$value5['@attributes']['name']."',
								handicap_main = '".$value5['@attributes']['main']."',
								handicap_odd_name = '".$value6['@attributes']['name']."',
								handicap_odd_handicap = '".$value6['@attributes']['handicap']."',
								handicap_odd_value = '".$value6['@attributes']['value']."',
								handicap_odd_id = '".$value6['@attributes']['id']."',
								date_update = NOW()
								";
								$query=mysql_query($sql) or die(mysql_error());

							}else{
								$temp =explode('.', $value2['@attributes']['formatted_date']);
								$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
								$sql="
								UPDATE  soccer_odds  SET
								status = '".mysql_real_escape_string($value2['@attributes']['status'])."',
								date_match = '".mysql_real_escape_string($date)."',
								time_match = '".mysql_real_escape_string($value2['@attributes']['time'])."',
								static_id = '".mysql_real_escape_string($value2['@attributes']['static_id'])."',
								fix_id = '".mysql_real_escape_string($value2['@attributes']['fix_id'])."',
								id_match = '".mysql_real_escape_string($value2['@attributes']['id'])."',
								bookmaker_name = '".$value4['@attributes']['name']."',
								handicap_name = '".$value5['@attributes']['name']."',
								handicap_main = '".$value5['@attributes']['main']."',
								handicap_odd_name = '".$value6['@attributes']['name']."',
								handicap_odd_handicap = '".$value6['@attributes']['handicap']."',
								handicap_odd_value = '".$value6['@attributes']['value']."',
								handicap_odd_id = '".$value6['@attributes']['id']."',
								date_update = NOW()
								WHERE id_match = '".$value2['@attributes']['id']."'
								";
								$query=mysql_query($sql) or die(mysql_error());
							}

						}
					}

				}
				//echo '$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br/>';
			}
		}

		// echo 'FT = '.$value2['ft']['@attributes']['score'].'<br/>';
		// echo 'ID = '.$value2['@attributes']['id'].'<br/>';
		//echo '########################################################<br/>';

	}
	
}

?>
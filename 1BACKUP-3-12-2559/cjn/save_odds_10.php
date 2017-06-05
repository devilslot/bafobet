<?php
include('config_cronjob.php');




$url[]="http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/getodds/soccer?cat=portugal";
$url[]="http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/getodds/soccer?cat=romania";
$url[]="http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/getodds/soccer?cat=russia";
$url[]="http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/getodds/soccer?cat=saudi_arabia";
$url[]="http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/getodds/soccer?cat=scotland";




for($i=0;$i<count($url);$i++){
echo $url[$i];
$xml = json_decode(json_encode(simplexml_load_file($url[$i])), true);
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
						
						if($value5['odd'][0]['@attributes']['name']=='2'){
							$handicap1=$value5['odd'][1]['@attributes']['handicap'];  
							$handicap2=$value5['odd'][0]['@attributes']['handicap'];  
						}else{
							$handicap1=$value5['odd'][0]['@attributes']['handicap'];
							$handicap2=$value5['odd'][1]['@attributes']['handicap'];
						}
						
						
						
							$sqlck="SELECT COUNT(code) AS cnt FROM soccer_odds  WHERE handicap_odd_id = '".$value5['odd'][0]['@attributes']['id']."' ";
							$queryck = mysql_query($sqlck);
							if($row=mysql_fetch_object($queryck)){
								$count = $row->cnt;
							} 
//echo '<pre>';print_r($value5['odd'][0]['@attributes']['handicap']);echo '</pre>';
				$temp =explode('.', $value2['@attributes']['formatted_date']);
				$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
				//echo $date."-".date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
							if($date==date('Y-m-d') or $date==date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d')))) or $date==date('Y-m-d', strtotime("-1 day", strtotime(date('Y-m-d'))))){
							if($count <= 0 and $value2['@attributes']['status'] != ""){
								
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
								handicap_odd_name = '".$value5['odd'][0]['@attributes']['name']."',
								handicap_odd_handicap = '".$handicap1."',
								handicap_odd_handicap2 = '".$handicap2."',
								handicap_odd_value = '".$value5['odd'][0]['@attributes']['value']."',
								handicap_odd_value2 = '".$value5['odd'][1]['@attributes']['value']."',
								handicap_odd_id = '".$value5['odd'][0]['@attributes']['id']."',
								date_update = NOW()
								";
								$query=mysql_query($sql) or die(mysql_error());

							}else{
								/*$temp =explode('.', $value2['@attributes']['formatted_date']);
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
								handicap_odd_name = '".$value5['odd'][0]['@attributes']['name']."',
								handicap_odd_handicap = '".$handicap1."',
								handicap_odd_handicap2 = '".$handicap2."',
								handicap_odd_value = '".$value5['odd'][0]['@attributes']['value']."',
								handicap_odd_value2 = '".$value5['odd'][1]['@attributes']['value']."',
								handicap_odd_id = '".$value5['odd'][0]['@attributes']['id']."',
								date_update = NOW()
								WHERE id_match = '".$value2['@attributes']['id']."' 
								";
								$query=mysql_query($sql) or die(mysql_error());*/

							}
							//echo $sql;
							}
						echo '<pre>';print_r($sql);echo '</pre>';
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

}
?>
<?php
include('config_cronjob.php');


$url = "http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/getodds/soccer?cat=colombia";

$xml = json_decode(json_encode(simplexml_load_file($url)), true);
// Get League
foreach ($xml['category'] as $key => $value) {
	foreach ($value['matches']['match'] as $key2 => $value2) {
	echo '<pre>';print_r($value2['@attributes']['id']);echo '</pre>';
		foreach ($value2['odds']['type'] as $key3 => $value3) {
		echo '<pre>';print_r($value3);echo '</pre>';
			
				//foreach ($value3['bookmaker']['handicap'] as $key4 => $value4) {
					if($value3['@attributes']['value'] == 'Handicap'){	
					 echo 'cccc';
					}
					
						
						/*echo '<pre>';print_r($value4['odd'][0]['@attributes']['handicap']);echo '</pre>';
						echo '<br><br>1.:'.$value4['odd'][0]['@attributes']['value'];
						echo '<br>2.:'.$value4['odd'][1]['@attributes']['value'];
						
						$cutsum = ($value4['odd'][0]['@attributes']['value']-$value4['odd'][1]['@attributes']['value']);
						$cutsum = str_replace("-", "", $cutsum);
						
						if($cutsum<0.20){
						
						$sqlck="SELECT COUNT(code) AS cnt FROM soccer_odds  WHERE id_match = '".$value2['@attributes']['id']."' ";
							echo $sqlck;
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
								handicap_odd_name = '".$value4['odd'][0]['@attributes']['name']."',
								handicap_odd_handicap = '".$value4['odd'][0]['@attributes']['handicap']."',
								handicap_odd_value = '".$value4['odd'][0]['@attributes']['value']."',
								handicap_odd_value2 = '".$value4['odd'][1]['@attributes']['value']."',
								handicap_odd_id = '".$value4['odd'][0]['@attributes']['id']."',
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
								handicap_odd_name = '".$value4['odd'][0]['@attributes']['name']."',
								handicap_odd_handicap = '".$value4['odd'][0]['@attributes']['handicap']."',
								handicap_odd_value = '".$value4['odd'][0]['@attributes']['value']."',
								handicap_odd_value2 = '".$value4['odd'][1]['@attributes']['value']."',
								handicap_odd_id = '".$value4['odd'][0]['@attributes']."',
								date_update = NOW()
								WHERE id_match = '".$value2['@attributes']['id']."'
								";
								$query=mysql_query($sql) or die(mysql_error());
							}
							
							echo "<br>DDDDDDDDDDDDDDD : ".$cutsum."<br>";
							break;
						}*/
					
				
			//}
		}	
	}
}

?>
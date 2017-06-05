<?php
ini_set('memory_limit', '256M');
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
					 		echo $value6['@attributes']['name'].' Handicap = '.$value6['@attributes']['handicap'].' Value = '.$value6['@attributes']['value'].' ID = '.$value6['@attributes']['id'].'<br/>';

						}
					}

				}
				echo '$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br/>';
			}
		}

		// echo 'FT = '.$value2['ft']['@attributes']['score'].'<br/>';
		// echo 'ID = '.$value2['@attributes']['id'].'<br/>';
		//echo '########################################################<br/>';

	}
	
}

?>
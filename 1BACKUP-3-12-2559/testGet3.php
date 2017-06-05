<?php
@header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Bangkok');
$date = date('Y-m-d');

echo $date."<br>";
///  Tomorow

$date1 = date("Y-m-d", strtotime("-1 day", strtotime($date)));

$date2 = date("Y-m-d", strtotime("+1 day", strtotime($date)));

echo 'http://hereball.com/data/json/V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D/'.$date1.'/'.$date2.'';

$json = file_get_contents('http://hereball.com/data/json/V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D/'.$date1.'/'.$date2.'');

$obj = json_decode($json);


echo  "<h1>Get Data</h1>";
echo "<pre>";print_r($obj);echo "</pre>";

// foreach ($obj as $key => $value) {
// 	// echo ' ********************************************************************<br/>';
// 	echo 'MatchID = '.$value->MatchID.'<br/>';
// 	echo 'LeagueEngName = '.$value->LeagueEngName.'<br/>';
// 	echo 'HomeName = '.$value->HomeName.'<br/>';
// 	echo 'AwayName = '.$value->AwayName.'<br/>';
// 	$current_time = $value->Date;
//     $new_time = strtotime($current_time . "+7hours");
// 	echo 'Date = '.date('Y-m-d H:i:s', $new_time).'<br/>';
// 	echo 'AsianHandicap = '.$value->AsianHandicap.'<br/>';
// 	echo 'AsianHandicapHome = '.$value->AsianHandicapHome.'<br/>';
// 	echo 'AsianHandicapAway = '.$value->AsianHandicapAway.'<br/><br/>';
// 	echo ' ********************************************************************<br/><br/><br/>';
// }


?>

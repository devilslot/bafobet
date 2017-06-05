<?php
ini_set('memory_limit', '256M');
$url = "http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/getodds/soccer?cat=home";

// $xml = @simplexml_load_file($url);

// echo '<pre>'; print_r($xml); echo '</pre>';

$test = json_decode(json_encode(simplexml_load_file($url)), true);
echo '<pre>';print_r($test);echo '</pre>';
//
// foreach ($xml->TABLE->DATA as $i => $value) {
//   $result = explode(',', $value);
//   $league[$result[1]][] = $result;
// //  echo $value.'<br/>';  
// }
?>
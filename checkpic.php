<?php
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");

require_once "service/service.php";
$pic = 'zerolinew';

$path = URL."/memberpic/".$pic.'.jpg';
function remoteFileExists($url) {
$curl = curl_init($url);

//don't fetch the actual page, you only want to check the connection is ok
curl_setopt($curl, CURLOPT_NOBODY, true);

//do request
$result = curl_exec($curl);

$ret = false;

//if request did not fail
if ($result !== false) {
    //if request was ok, check response code
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

    if ($statusCode == 200) {
        $ret = true;   
    }
}

curl_close($curl);

return $ret;
}
$exists = remoteFileExists($path);
if ($exists) {
echo 'file exists';
} else {
   echo 'file does not exist';   
}




					if (file_exists($path)) { 
						$filepic = '<img src="'.URL.'/memberpic/'.$pic.'.jpg" width="50" />';
					}else{
						$filepic = '<img src="'.URL.'/pro-pic.jpg" width="50" />';
					}
 // echo $path.'<br/>';
 // echo $filepic;
?>
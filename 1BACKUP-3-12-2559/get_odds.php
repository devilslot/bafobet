<?php 

@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");

require_once "service/service.php";

$sql="
SELECT
      *
FROM
matchData
WHERE
date_match = '".date('Y-m-d')."' 
ORDER BY
code 
ASC
;";
       // echo $sql;
$query=mysql_query($sql);
$tmpl ='';
while($row=mysql_fetch_assoc($query)){
  echo $row['Id']."<br/>";


 //  $url = 'http://www.hereball.com/data/odds.php?api=';
 //  $content =  file_get_contents($url.'V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D&id='.$row['Id']);

 //  if(!empty ($content)){
 //    @unlink("xml/odds_".$row['Id'].".xml");
 //    //$file="xml/feed.xml";
 // //chmod('xml', 0777);
 //    $content = str_replace("\r\n","",$content);
 //    file_put_contents(dirname(__FILE__) . '/xml/odds_'.$row['Id'].'.xml', $content);
 //     //chmod('xml/feed.xml', 0777);
 //     //file_put_contents(dirname(__FILE__) . '/writefeed/feed88.xml', $content);
 //   //chmod('writefeed/feed.xml', 0777);
 //    $result = 'complete'; 
 //  }
  
 //  else{
 //    $result = 'fail';
 //  }





}


// $url = 'http://www.hereball.com/data/odds.php?api=';
// $content =  file_get_contents($url.'V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D');

//   if(!empty ($content)){
//     @unlink("xml/odds.xml");
//     //$file="xml/feed.xml";
// 	//chmod('xml', 0777);
// 	$content = str_replace("\r\n","",$content);
//     file_put_contents(dirname(__FILE__) . '/xml/odds.xml', $content);
//      //chmod('xml/feed.xml', 0777);
//      //file_put_contents(dirname(__FILE__) . '/writefeed/feed88.xml', $content);
//    //chmod('writefeed/feed.xml', 0777);
//         $result = 'complete'; 
//   }

//   else{
//     $result = 'fail';
//   }

//   echo json_encode($result);
?>
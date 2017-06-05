<?php 
$url = 'http://www.hereball.com/data/match.php?api=';
$content =  file_get_contents($url.'V1VKV1UwRkdRMHhFV0VkVVUxbE1UMFJRUWtsWlNsWlhXa1ZLUVZkYVJVUmFWbFphUmtsRFdFUlpTVmxXVFZaV1IwVT0%3D');

  if(!empty ($content)){
    @unlink("xml/match.xml");
    //$file="xml/feed.xml";
	//chmod('xml', 0777);
	$content = str_replace("\r\n","",$content);
    file_put_contents(dirname(__FILE__) . '/xml/match.xml', $content);
     //chmod('xml/feed.xml', 0777);
     //file_put_contents(dirname(__FILE__) . '/writefeed/feed88.xml', $content);
   //chmod('writefeed/feed.xml', 0777);
        $result = 'complete'; 
  }
  
  else{
    $result = 'fail';
  }
  
  echo json_encode($result);
?>
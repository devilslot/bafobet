<?php
header('Content-Type:image/jpeg');
include('../plugin/resize/resizeimg.php');

$pic = $_GET['pic'];
$pic = str_replace(".jpg", "", $pic);
$pic = str_replace(".png", "", $pic);
$pic = str_replace(".gif", "", $pic);
$pic = "$pic.jpg";
if(is_file($pic)){
  $path = $pic;
}else{
  $path = 'nopic.jpg';
}

$image = new SimpleImage();
$image->load($path);
if(!empty($_GET['w'])){
	if(!empty($_GET['h'])){
		$image->resize($_GET['w'], $_GET['h']);
	}else{
		$image->resizeToWidth($_GET['w']);
	}
}
$image->output();
?>
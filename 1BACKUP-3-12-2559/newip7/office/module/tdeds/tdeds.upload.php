<?php
error_reporting(0);
error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once "../../../service/service.php";
require_once "../../../main/upload.class.php";

$path = '../../../img';
$type = CheckType($_FILES['fileupload']['name']);
$org = str_replace(".$type", '', $_FILES['fileupload']['name']);

$name = $org;
$name = CreateFileName($name);
if(is_file($path.'/'.$name.'.'.$type)){
  echo$name = $name.'_'.RandomNumber(3);
}
$name = strtolower($name);
$filename = $name.'.'.$type;

$obj = new Upload($_FILES['fileupload']);

if ($obj->uploaded) {
//  $wf=getimagesize($_FILES["fileupload"]["tmp_name"]);
//  $width=$wf[0];
//  $height=$wf[1];
//  
//  if($width>$height){
//    $height = floor(3/4*$width);
//    $obj->image_resize=true;
//    $obj->image_ratio_fill='T';
//    $obj->image_y=$height;
//    $obj->image_x=$width;
//    $obj->image_background_color='#FFFFFF';
//  }elseif($height>$width){
//    $width = $height;
//    $height = floor(3/4*$width);
//    $obj->image_resize=true;
//    $obj->image_ratio_fill='C';
//    $obj->image_y=$height;
//    $obj->image_x=$width;
//    $obj->image_background_color='#FFFFFF';
//  }
  $obj->file_new_name_body=$name; 
  $obj->Process($path);
  if ($obj->processed) {
      echo '<script>';
      echo ' window.parent.me.UploadPic.Complete("'.$filename.'");';
      echo '</script>';
  } else {
      echo '<p class="result">';
      echo '  <b>File not uploaded to the wanted location</b><br />';
      echo '  Error: ' . $obj->error . '';
      echo '</p>';
  }
  $obj-> Clean();

} else {
		echo '<p class="result">';
		echo '  <b>File not uploaded on the server</b><br />';
		echo '  Error: ' . $obj->error . '';
		echo '</p>';
}

?>

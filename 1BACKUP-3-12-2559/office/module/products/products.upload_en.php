<?php
error_reporting(0);
error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once "../../../service/service.php";
require_once "../../../main/upload.class.php";

$path = '../../../doc';
$type = CheckType($_FILES['fileupload']['name']);
$org = str_replace(".$type", '', $_FILES['fileupload']['name']);

$name = $org;
$name = 'ocs_'.RandomNumber(3).time();
if(is_file($path.'/'.$name.'.'.$type)){
  $name = $name.'_'.RandomNumber(3);
}
$name = strtolower($name);
$filename = $name.'.'.$type;

$handle = new Upload($_FILES['fileupload']);

if ($handle->uploaded) {
    $handle->file_new_name_body = $name;
		$handle->Process($path);
		if ($handle->processed) {
				echo '<script>';
				echo ' window.parent.me.UploadComplete("en", "'.$filename.'");';
				echo '</script>';
		} else {
				echo '<p class="result">';
				echo '  <b>File not uploaded to the wanted location</b><br />';
				echo '  Error: ' . $handle->error . '';
				echo '</p>';
		}
		$handle-> Clean();

} else {
		echo '<p class="result">';
		echo '  <b>File not uploaded on the server</b><br />';
		echo '  Error: ' . $handle->error . '';
		echo '</p>';
}

?>

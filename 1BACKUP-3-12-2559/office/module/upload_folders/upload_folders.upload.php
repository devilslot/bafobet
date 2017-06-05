<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 24/01/2015 09:09
*  Module : inc
*  Description : upload
*  Involve People : MangEak
*  Last Updated : 24/01/2015 09:09
\*================================================*/

@session_start();
@header("Content-type: text/html; charset=utf-8");

//error_reporting(0);
//error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once "../../../service/service.php";
require_once "../../../main/upload.class.php";
require_once "../../../main/main.class.php";
require_once "../../app.class.php";
require_once "upload_folders.class.php";

function AddFile($name, $filename, $filetype){
  $obj = new SubClass();  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  $data['name'] = $name;
  $data['filename'] = $filename;
  $data['filetype'] = $filetype;
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $data['folder_code'] = $_POST['code'];
  $result = $obj->Add('upload_files', $data);

  $obj->Log('ADD', 'upload_files', $result['code'], $user, $data);   
  
  return $result;
}

ini_set("memory_limit","512M");
//set_time_limit(0);

$path = '../../../doc';
$files = 'file';
$type = CheckType($_FILES[$files]['name']);
$name_org = str_replace(".$type", '', $_FILES[$files]['name']);
$type = strtolower($type);

//print_r($_POST);

$name = CreateFileName($name_org);
if(is_file($path.'/'.$name.'.'.$type)){
  $name = $name.'_'.RandomNumber(3);
}
$name = strtolower($name);
$filename = $name.'.'.$type;

$obj = new Upload($_FILES[$files]);

if ($obj->uploaded) {
  $obj->file_new_name_body=$name;
  
  $obj->Process($path);
  if($obj->processed){
    $photo = AddFile($name_org, $filename, $type);
    
    $result['success'] = 'COMPLETE';
    $result['code'] = $photo['code'];
    $result['thumb'] = URL."/doc/$filename";
    $result['pic'] = URL."/doc/$filename";
    $result['name'] = $name_org;
    $result['filename'] = $filename;
    $result['filetype'] = $type;
    
    $url = URL."/doc/".$filename;
    $result['url'] = "<a href='".$url."' target='_blank'>".$url."</a>";
  }else{
    $result['success'] = 'ERROR';
    $result['msg'] = '<b>File not uploaded to the wanted location</b><br />  Error: '.$obj->error;
  }
  $obj->Clean();

} else {
  $result['success'] = 'ERROR';
  $result['msg'] = '<b>File not uploaded on the server</b><br />  Error: '.$obj->error;
}

echo json_encode($result);

?>

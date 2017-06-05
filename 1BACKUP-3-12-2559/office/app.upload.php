<?php

/* ==================================================
*  Author : Attaphon Wongbuatong
 *  Created Date : 11/09/2554 01:30
 *  Module : 
 *  Description : 
 *  Involve People : -
 *  Last Updated : 11/09/2554 01:30
  ================================================== */

@session_start();
@header("Content-type: text/html; charset=utf-8");

//error_reporting(0);
//error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$mod = $_GET['mod'];

require_once "../service/service.php";
require_once "../main/upload.class.php";
require_once "../main/main.class.php";
require_once "app.class.php";
require_once "module/$mod/$mod.class.php";

function AddPhoto($name, $filepic){
  global $mod;
  $table = $mod.'_photos';
  
  $obj = new SubClass($table);  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  $data['name'] = $name;
  $data['filepic'] = $filepic;
  $data['parent_code'] = $_POST['code'];
  
  if(!$obj->CheckTable()){
    $obj->CreateTable($table, $data);
  }
  
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  
  $result = $obj->Add($table, $data);

  $obj->Log('ADD', $table, $result['code'], $user, $data);   
  
  return $result;
}

ini_set("memory_limit","512M");
//set_time_limit(0);

$path = '../img';
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
$filepic = $name.'.'.$type;

$obj = new Upload($_FILES[$files]);

if ($obj->uploaded) {
  $obj->file_new_name_body=$name;
  
  $obj->Process($path);
  if($obj->processed){
    $photo = AddPhoto($name_org, $filepic);
    
    $result['success'] = 'COMPLETE';
    $result['code'] = $photo['code'];
    $result['thumb'] = URL."/img/$filepic";
//    $result['thumb'] = Thumbnail($filepic, 300);
    $result['pic'] = URL."/img/$filepic";
    $result['name'] = $name_org;
    $result['filepic'] = $filepic;
    $result['shortname'] = Cut($name_org, 20);
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

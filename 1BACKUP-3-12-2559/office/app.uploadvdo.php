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

function AddVdo($name, $filevdo, $filepic){
  global $mod;
  $table = $mod.'_vdos';
  
  $obj = new SubClass($table);  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  $data['name'] = $name;
  $data['filevdo'] = $filevdo;
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

//print_r($_FILES);
  
/* UPLOAD IMAGE */
$path = '../vdo';
$files = 'file_pic';
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

if($type != 'jpg'){
  $result_pic['success'] = 'ERROR';
  $result_pic['msg'] = '<b>กรุณาเลือกไฟล์ชนิด jpg เท่านั้น</b> ';
}elseif ($obj->uploaded) {
  $obj->file_new_name_body=$name;
  $obj->image_resize          = true;
  $obj->image_x               = 1000;
  $obj->image_y               = 556;
  $obj->image_watermark       = '../images/play.png';
  
  $obj->Process($path);
  if($obj->processed){
    $result_pic['success'] = 'COMPLETE';
    $result_pic['filepic'] = $filepic;
  }else{
    $result_pic['success'] = 'ERROR';
    $result_pic['msg'] = '<b>File not uploaded to the wanted location</b><br />  Error: '.$obj->error;
  }
  $obj->Clean();

}else{
  $result_pic['success'] = 'ERROR';
  $result_pic['msg'] = '<b>File not uploaded on the server</b><br />  Error: '.$obj->error;
}

/* UPLOAD VDO */
$path = '../vdo';
$files = 'file_vdo';
$type = CheckType($_FILES[$files]['name']);
$name_org = str_replace(".$type", '', $_FILES[$files]['name']);
$type = strtolower($type);

//print_r($_POST);

$name = CreateFileName($name_org);
if(is_file($path.'/'.$name.'.'.$type)){
  $name = $name.'_'.RandomNumber(3);
}
$name = strtolower($name);
$filevdo = $name.'.'.$type;

$obj = new Upload($_FILES[$files]);

if($type != 'mp4'){
  $result_vdo['success'] = 'ERROR';
  $result_vdo['msg'] = '<b>กรุณาเลือกไฟล์วีดีโอ mp4 เท่านั้น</b> ';
}elseif ($obj->uploaded) {
  $obj->file_new_name_body=$name;
  
  $obj->Process($path);
  if($obj->processed){
    
    $result_vdo['success'] = 'COMPLETE';
    $result_vdo['filevdo'] = $filevdo;
  }else{
    $result_vdo['success'] = 'ERROR';
    $result_vdo['msg'] = '<b>File not uploaded to the wanted location</b><br />  Error: '.$obj->error;
  }
  $obj->Clean();

}else{
  $result_vdo['success'] = 'ERROR';
  $result_vdo['msg'] = '<b>File not uploaded on the server</b><br />  Error: '.$obj->error;
}

if(($result_vdo['success'] == 'COMPLETE') && ($result_pic['success'] == 'COMPLETE')){
  $file_name = $_POST['file_name'];
  $file_pic = $result_pic['filepic'];
  $file_vdo = $result_vdo['filevdo'];
  $data = AddVdo($file_name, $file_vdo, $file_pic);
  
  $shortname = Cut($name_org, 20);
  
  $result['success'] = 'COMPLETE';
  echo '<script>';
  echo ' window.parent.me.UploadVdo.Complete({
        code : "'.$data['code'].'",
        name : "'.$file_name.'",
        shortname : "'.$shortname.'",
        filevdo : "'.$file_vdo.'",
        filepic : "'.$file_pic.'",
        pic : "'.URL.'/vdo/'.$file_pic.'",
        vdo : "'.URL.'/vdo/'.$file_vdo.'"
      });';
  echo '</script>';
}else{
  $result['success'] = 'ERROR';
  if($result_vdo['success'] == 'ERROR'){
    $result['msg'] = $result_vdo['msg'].'<br/>';
  }
  if($result_pic['success'] == 'ERROR'){
    $result['msg'] .= $result_pic['msg'];
  }
  
//  print_r($result_pic);
//  print_r($result_vdo);
//  print_r($result);
  echo '<script>';
  echo ' window.parent.me.UploadVdo.Error("'.$result['msg'].'");';
  echo '</script>';
}
    

?>
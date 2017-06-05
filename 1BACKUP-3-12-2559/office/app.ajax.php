<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 05/12/2013 09:09
*  Module : inc
*  Description : Backoffice Include
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

header("Content-type: text/html; charset=utf-8");
session_start();

require_once "../service/service.php";
require_once "../main/main.class.php";
require_once "app.class.php";

function ChangeLang(){
  if($_GET['lang'] == 'th'){
    $_SESSION[OFFICE]['LANG'] = 'th';
    $result['success'] = 'COMPLETE';
  }elseif($_GET['lang'] == 'en'){
    $_SESSION[OFFICE]['LANG'] = 'en';
    $result['success'] = 'COMPLETE';
  }else{
    $result['success'] = 'FAIL';
  }
  
  echo json_encode($result);
}

function LoadAlert(){
  if($_SESSION[OFFICE]["LOGIN"] != "ON"){
    $result['success'] = 'LOGOUT';
    $result['url'] = URL.'/office';

    echo json_encode($result);
    exit;
  }

	$obj = new AppClass();
	$result['row'] = $obj->LoadAlert();
	$result['cnt'] = $obj->LoadAlertCount();
  
	echo json_encode($result);
}

function DelUpload(){
  $table = $_GET['mod'].'_photos';
  
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $obj = new AppClass($table);
  $obj->attr = $_POST;
  $photo = $obj->LoadOne($table, array('code'=>$_POST['code']));
  
  $result = $obj->Del($table, array('code'=>$_POST['code']));
  
  $filepath = '../img/'.$photo['filepic'];

  if(is_file($filepath)){
    unlink($filepath);
  }
  
  $obj->Log('DEL', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function DelUploadVdo(){
  $table = $_GET['mod'].'_vdos';
  
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $obj = new AppClass($table);
  $obj->attr = $_POST;
  $photo = $obj->LoadOne($table, array('code'=>$_POST['code']));
  
  $result = $obj->Del($table, array('code'=>$_POST['code']));
  
  $filepath = '../vdo/'.$photo['filevdo'];

  if(is_file($filepath)){
    unlink($filepath);
  }
  
  $filepath = '../vdo/'.$photo['filepic'];

  if(is_file($filepath)){
    unlink($filepath);
  }
  
  $obj->Log('DEL', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function Pin(){
  $table = $_GET['mod'];
  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $obj = new AppClass($table);
  $obj->attr = $_POST;
  $data['filepic'] = $_POST['filepic'];
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $result = $obj->Edit($table, $data, array('code'=>$_POST['code']));
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function PinMap(){
  $table = $_GET['mod'];
  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $obj = new AppClass($table);
  $obj->attr = $_POST;
  $data['filemap'] = $_POST['filemap'];
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $result = $obj->Edit($table, $data, array('code'=>$_POST['code']));
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function DelPin(){
  $table = $_GET['mod'];
  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $obj = new AppClass($table);
  $obj->attr = $_POST;
  $data['filepic'] = '';
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $result = $obj->Edit($table, $data, array('code'=>$_POST['code']));
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function DelPinMap(){
  $table = $_GET['mod'];
  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $obj = new AppClass($table);
  $obj->attr = $_POST;
  $data['filemap'] = '';
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $result = $obj->Edit($table, $data, array('code'=>$_POST['code']));
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function LoadInbox(){
	$obj = new AppClass();
	$result['row'] = $obj->LoadInbox();
	$result['cnt'] = $obj->LoadInboxCount();
  
	echo json_encode($result);
}

function LoadTasks(){  
  $url = 'http://www.onlinecreationsoft.com';
  
  echo curl($url.'/creation/module/api/api.inc.php', array('mode'=>md5('LoadTask')));
  
//  $data = json_decode($json);
//  
//	echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "ChangeLang" : ChangeLang(); break;
  case "LoadAlert" : LoadAlert(); break;
  case "LoadInbox" : LoadInbox(); break;
  case "LoadTasks" : LoadTasks(); break;
  case "DelUpload" : DelUpload(); break;
  case "DelUploadVdo" : DelUploadVdo(); break;
  case "DelPin" : DelPin(); break;
  case "Pin" : Pin(); break;
  case "PinMap" : PinMap(); break;
  case "DelPinMap" : DelPinMap(); break;
  default : echo '{"success":"FAIL"}';
}
?>
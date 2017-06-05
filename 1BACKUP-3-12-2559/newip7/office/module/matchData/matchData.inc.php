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

require_once "../../../service/service.php";
$table = $_GET['mod'];

require_once "../../../main/main.class.php";
require_once "../../app.class.php";
require_once "$table.class.php";
require_once "../../app.inc.php";

function LoadCbo(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result['football'] = $obj->LoadCboResult();
  
  echo json_encode($result);
}

function SaveHdc(){
  global $table;
  
  $lang = $_SESSION[OFFICE]['LANG'];
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['user'];
  $code = $_POST['code'];
  //print_r($_POST);
  $obj = new SubClass($table, $lang);

  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $data['hdc'] = $_POST['hdc'];

  $result = $obj->Edit($table, $data, array('code'=>$code));
  
  $obj->LoadLanguageAlert();
  if($result['success']=='COMPLETE'){
    $result['msg'] = 'บันทึกสำเร็จ';
  }else{
    $result['msg'] = $obj->alert['SAVEERROR'];
  }  
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function SaveTded(){
  global $table;
  
  $lang = $_SESSION[OFFICE]['LANG'];
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['user'];
  $code = $_POST['code'];
  //print_r($_POST);
  $obj = new SubClass($table, $lang);

  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $data['tded'] = $_POST['tded'];

  $result = $obj->Edit($table, $data, array('code'=>$code));
  
  $obj->LoadLanguageAlert();
  if($result['success']=='COMPLETE'){
    $result['msg'] = 'บันทึกสำเร็จ';
  }else{
    $result['msg'] = $obj->alert['SAVEERROR'];
  }  
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function SaveRate(){
  global $table;
  
  $lang = $_SESSION[OFFICE]['LANG'];
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['user'];
  $code = $_POST['code'];
  //print_r($_POST);
  $obj = new SubClass($table, $lang);

  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $data['ratio'] = $_POST['ratio'];

  $result = $obj->Edit($table, $data, array('code'=>$code));
  
  $obj->LoadLanguageAlert();
  if($result['success']=='COMPLETE'){
    $result['msg'] = 'บันทึกสำเร็จ';
  }else{
    $result['msg'] = $obj->alert['SAVEERROR'];
  }  
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}


switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "SaveHdc" : SaveHdc(); break;
  case "SaveTded" : SaveTded(); break;
  case "SaveRate" : SaveRate(); break;
  case "LoadCbo" : LoadCbo(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "OpenView" : OpenViews(); break;
  default : echo '{"success":"FAIL"}';
}
?>
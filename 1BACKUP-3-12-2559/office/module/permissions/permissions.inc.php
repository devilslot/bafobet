<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 24/01/2015 09:09
*  Module : inc
*  Description : Backoffice Include
*  Involve People : MangEak
*  Last Updated : 24/01/2015 09:09
\*================================================*/

header("Content-type: text/html; charset=utf-8");
session_start();

require_once "../../../service/service.php";
$table = $_GET['mod'];

require_once "../../../main/main.class.php";
require_once "../../app.class.php";
require_once "$table.class.php";

function Add(){
  global $table;
  
  $lang = $_SESSION[OFFICE]['LANG'];
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['user'];
  $emp_code = $_SESSION[OFFICE]['DATA']['code'];

  $obj = new SubClass($table, $lang); 
  
  $data = $_POST['data'];
  $per = (array)$_POST['per'];
  sort($per);
  
  $data['level_open'] = implode(',', $per);
          
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $result = $obj->Add($table, $data);

  $obj->LoadLanguageAlert();
  if($result['success']=='COMPLETE'){
    $result['msg'] = $obj->alert['SAVECOMPLETE'];
  }else{
    $result['msg'] = $obj->alert['SAVEERROR'];
  }
  
  $obj->Log('ADD', $table, $result['code'], $user, $data);
  
  $obj->AddMsg("user $user add permission", $emp_code, $table, $result['code']);
  
  echo json_encode($result);  
}

function Edit(){
  global $table;
  
  $lang = $_SESSION[OFFICE]['LANG'];
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['user'];
  $code = $_POST['code'];
  
  $obj = new SubClass($table, $lang);
  $data = $_POST['data'];
  $per = (array)$_POST['per'];
  sort($per);
  
  $data['level_open'] = implode(',', $per);  
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $result = $obj->Edit($table, $data, array('code'=>$code));
  
  $obj->LoadLanguageAlert();
  if($result['success']=='COMPLETE'){
    $result['msg'] = $obj->alert['SAVECOMPLETE'];
  }else{
    $result['msg'] = $obj->alert['SAVEERROR'];
  }  
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function Del(){
  global $table;
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];

  $obj = new SubClass($table);
  $result = $obj->Del($table, array('code'=>$_POST['code']));
  
  $obj->Log('DEL', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function LoadEdit(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result = $obj->LoadEdit();
  
  echo json_encode($result);
}

function OpenView(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result = $obj->OpenView();
  
  echo json_encode($result);
}

function View(){
  global $table;
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $obj->attr = $_POST;
  $obj->permission = $_SESSION[OFFICE]['PERMISSION'];
  $obj->LoadLanguageDefine();
  $result = $obj->View();
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "OpenView" : OpenView(); break;
  default : echo '{"success":"FAIL"}';
}
?>
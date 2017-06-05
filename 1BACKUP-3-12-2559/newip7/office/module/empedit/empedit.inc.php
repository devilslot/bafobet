<?php
/*================================================*\
*  Author : BoyBangkhla
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
$table = 'employees';

function LoadEdit(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr['code'] = $_SESSION[OFFICE]['DATA']['code'];
  $result = $obj->LoadEdit();
  
  echo json_encode($result);
}

function Edit(){
  global $table;
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  $code = $_SESSION[OFFICE]['DATA']['code'];
  
  $obj = new SubClass($table);
  $data = $_POST['data'];
  $data['user_update'] = $user;
  $data['date_update'] = DateNow();
  $result = $obj->Edit($table, $data, array('code'=>$code));
  
  $obj->Log('EDIT', $table, $code, $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function LoadCbo(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result['province'] = $obj->LoadCboProvince();
  $result['prefix'] = $obj->LoadCboPrefix();
  $result['departments'] = $obj->LoadCboDepartments();
  $result['position'] = $obj->LoadCboPosition();
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Edit" : Edit(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "LoadCbo" : LoadCbo(); break;
  default : echo '{"success":"FAIL"}';
}
?>
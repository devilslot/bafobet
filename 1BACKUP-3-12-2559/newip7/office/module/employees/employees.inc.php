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

function Add(){
  global $table;
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];

  $obj = new SubClass($table);
  $data = $_POST['data'];
  $permission = (array)$_POST['permission'];
  
  unset($data['change_pass']);
  if($_SESSION[OFFICE]['DATA']['level'] != 9){
    $data['level'] = '1';
  }  
  
  $data['user_pass'] = md5($data['user_pass']);
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = DateNow();
  $data['date_update'] = DateNow();
  $result = $obj->Add($table, $data);
  
  $code = $result['code'];  
  foreach($permission as $i => $item){
    list($id, $task) = explode('-', $item);
    $obj->Add('emp_permission', array(
      'emp_code' => $code,
      'id' => $id,
      'task' => $task,
      'user_create' => $user,
      'date_create' => $datenow
    ));
  }
  
  $obj->Log('ADD', $table, $result['code'], $user);
  
  echo json_encode($result);  
}

function Edit(){
  global $table;
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  $datenow = DateNow();
  
  $obj = new SubClass($table);
  $data = $_POST['data'];
  $code = $_POST['code'];
  $permission = (array)$_POST['permission'];
//  PrintR($permission);
  
  if($_POST['data']['change_pass'] == 'Y'){
    $data['user_pass'] = md5($data['user_pass']);
    unset($data['change_pass']);
  }else{
    unset($data['change_pass']);
    unset($data['user_pass']);
  }
  
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  
  $result = $obj->Edit($table, $data, array('code'=>$code));
  
  $obj->Del('emp_permission', array('emp_code'=>$code));
  foreach($permission as $i => $item){
    list($id, $task) = explode('-', $item);
    $obj->Add('emp_permission', array(
      'emp_code' => $code,
      'id' => $id,
      'task' => $task,
      'user_create' => $user,
      'date_create' => $datenow
    ));
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

function LoadCbo(){
  global $table;
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $obj->attr = $_GET;
  $result['province'] = $obj->LoadCboProvince();
  $result['prefix'] = $obj->LoadCboPrefix();
//  $result['departments'] = $obj->LoadCboDepartments();
  $result['departments'] = $obj->LoadCbo('departments', 'code', "name_$lang");
  $result['task'] = $obj->LoadCbo('tasks', 'code', "name_$lang");
  
  echo json_encode($result);
}

function OpenView(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result = $obj->OpenView();
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "OpenView" : OpenView(); break;
  case "LoadCbo" : LoadCbo(); break;
  default : echo '{"success":"FAIL"}';
}
?>
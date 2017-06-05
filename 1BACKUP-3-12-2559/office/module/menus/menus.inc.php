<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
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

  $obj = new SubClass($table, $lang); 
  
  $data = $_POST['data'];
  $perview = (array)$_POST['perview'];
  $peradd = (array)$_POST['peradd'];
  $peredit = (array)$_POST['peredit'];
  $perdel = (array)$_POST['perdel'];
  sort($perview);
  sort($peradd);
  sort($peredit);
  sort($perdel);
  
  $after_code = $data['after_code'];
  unset($data['after_code']);
  
  if(!empty($after_code)){
    $obj->MoveAfter($after_code);
  }
  
  $data['level_view'] = implode(',', $perview);
  $data['level_add'] = implode(',', $peradd);
  $data['level_edit'] = implode(',', $peredit);
  $data['level_del'] = implode(',', $perdel);
  $data['encode'] =strtoupper(md5($data['id']));
  $data['sort'] = $obj->SortAfter($after_code);
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $result = $obj->Add($table, $data);
  $obj->UpdateSort();

  $obj->LoadLanguageAlert();
  if($result['success']=='COMPLETE'){
    $result['msg'] = $obj->alert['SAVECOMPLETE'];
  }else{
    $result['msg'] = $obj->alert['SAVEERROR'];
  }
  
  $obj->Log('ADD', $table, $result['code'], $user, $data);
  
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
  $perview = (array)$_POST['perview'];
  $peradd = (array)$_POST['peradd'];
  $peredit = (array)$_POST['peredit'];
  $perdel = (array)$_POST['perdel'];
  $after_code = $data['after_code'];
  unset($data['after_code']);
  
  if(!empty($after_code)){
    $obj->MoveBetween($code, $after_code);
  }
  
  sort($perview);
  sort($peradd);
  sort($peredit);
  sort($perdel);
  
  $data['level_view'] = implode(',', $perview);
  $data['level_add'] = implode(',', $peradd);
  $data['level_edit'] = implode(',', $peredit);
  $data['level_del'] = implode(',', $perdel);
  $data['encode'] =strtoupper(md5($data['id']));
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $result = $obj->Edit($table, $data, array('code'=>$code));
  $obj->UpdateSort();
  
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
  
  $obj->MoveBefore($_POST['code']);
  $result = $obj->Del($table, array('code'=>$_POST['code']));
  $obj->UpdateSort();
  
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

function LoadCbo(){
  global $table;
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $obj->attr = $_GET;
  
  $result['menu'] = $obj->LoadCboMenu();
  
  echo json_encode($result);
}

function MoveUp(){
  global $table;
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $obj->attr = $_GET;
  
  $result = $obj->MoveUp();
  
  echo json_encode($result);
}

function MoveDown(){
  global $table;
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $obj->attr = $_GET;
  
  $result = $obj->MoveDown();
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "OpenView" : OpenView(); break;
  case "MoveUp" : MoveUp(); break;
  case "MoveDown" : MoveDown(); break;
  case "LoadCbo" : LoadCbo(); break;
  default : echo '{"success":"FAIL"}';
}
?>
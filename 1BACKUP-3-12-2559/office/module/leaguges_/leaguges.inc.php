<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 08/02/2016 01:14
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 08/02/2016 01:14
\*================================================*/

header("Content-type: text/html; charset=utf-8");
session_start();

require_once "../../../service/service.php";
$table = $_GET['mod'];

require_once "../../../main/main.class.php";
require_once "../../app.class.php";
require_once "$table.class.php";


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



function Add(){
  global $table;
  
  $lang = $_SESSION[OFFICE]['LANG'];
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['user'];

  $obj = new SubClass($table, $lang); 
  
  $data = $_POST['data'];
  $detail = $_POST['detail'];
  
  if(!$obj->CheckTable()){
    $obj->CreateTable($table, $data);
  }

  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $result = $obj->Add($table, $data);
  
  
  foreach((array)$detail as $i => $value){
    $value['leaguge_code'] = $result['code'];
    $value['user_create'] = $user;
    $value['date_create'] = $datenow;
    $obj->Add('teams', $value);
  }

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
  $detail = $_POST['detail'];
  

  
  $obj->DelProduct($_POST['code']);
  foreach((array)$detail as $i => $value){
    $value['leaguge_code'] = $_POST['code'];
    $value['user_create'] = $user;
    $value['date_create'] = $datenow;
    $obj->Add('teams', $value);
  }
  

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


function LoadEdit(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result = $obj->LoadEdit();
  $result['product'] = $obj->LoadProduct();
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
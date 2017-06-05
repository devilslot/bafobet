<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 24/01/2015 09:09
*  Module : inc
*  Description : Backoffice Include
*  Involve People : MangEak
*  Last Updated : 24/01/2015 09:09
\*================================================*/

@session_start();
@header("Content-type: text/html; charset=utf-8");

require_once "../../../service/service.php";
$table = $_GET['mod'];

require_once "../../../main/main.class.php";
require_once "../../app.class.php";
require_once "$table.class.php";

function Add(){
  global $table;
  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];

  $obj = new SubClass($table);  
  $data = $_POST['data'];
  
  if(!$obj->CheckTable()){
    $obj->CreateTable($table, $data);
  }
          
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $result = $obj->Add($table, $data);
  
  $obj->Log('ADD', $table, $result['code'], $user, $data);
  
  echo json_encode($result);  
}

function Edit(){
  global $table;
  
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $obj = new SubClass($table);
  $data = $_POST['data'];
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $result = $obj->Edit($table, $data, array('code'=>$_POST['code']));
  
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
  $result['photo'] = $obj->LoadFile($_GET['code']);
  
  echo json_encode($result);
}

function DelUpload(){
  $table = 'upload_files';
  
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $obj = new SubClass($table);
  $obj->attr = $_POST;
  $file = $obj->LoadOne($table, array('code'=>$_POST['code']));
  
  $result = $obj->Del($table, array('code'=>$_POST['code']));
  
  $filepath = '../../../doc/'.$file['filename'];

  if(is_file($filepath)){
    unlink($filepath);
  }
  
  $obj->Log('DEL', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function View(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_POST;
  $result = $obj->View();
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "DelUpload" : DelUpload(); break;
  default : echo '{"success":"FAIL"}';
}
?>
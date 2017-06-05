<?php
/*================================================*\
*  Author : Online creation soft
*  Created Date : 28/11/2014 10:51
*  Module : inc
*  Description : ajax include
*  Involve People : Tirapant Tongpann
*  Last Updated : 28/11/2014 10:51
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
  
  $province = $obj->LoadOne('provinces', array('code'=>$data['province_code']));
          
  $data['geo_code'] = $province['geo_code'];
  $data['content_th'] = ContentFormat($data['content_th']);
  $data['content_en'] = ContentFormat($data['content_en']);
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
  
  $province = $obj->LoadOne('provinces', array('code'=>$data['province_code']));
          
  $data['geo_code'] = $province['geo_code'];
  $data['content_th'] = ContentFormat($data['content_th']);
  $data['content_en'] = ContentFormat($data['content_en']);
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
  $result['photo'] = $obj->LoadPhoto($_GET['code']);
  $result['vdo'] = $obj->LoadVdo($_GET['code']);
  $result['review'] = $obj->LoadReview($_GET['code']);
  
  $result['field']['thumb'] = Thumbnail($result['field']['filepic'], 300);
  $result['field']['thumbmap'] = Thumbnail($result['field']['filemap'], 300);
  
  echo json_encode($result);
}

function View(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_POST;
  $result = $obj->View();
  
  echo json_encode($result);
}

function LoadCbo(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result['province'] = $obj->LoadCbo('provinces', 'code', 'name_th');
  $result['paro'] = $obj->LoadCbo('paros', 'code', 'name_th');
  $result['paro_sub'] = $obj->Load('paros_sub');
  $result['geo'] = $obj->LoadCbo('geographies', 'code', 'name_th');
  
  echo json_encode($result);
}

function EditComment(){
  global $table;
  $obj = new SubClass($table);
  $result = $obj->Edit($table.'_review', array('enable'=>'Y'), array('code'=>$_POST['code']));

  echo json_encode($result);
}

function DelComment(){
  global $table;
  $obj = new SubClass($table);
  $result = $obj->Edit($table.'_review', array('enable'=>'N'), array('code'=>$_POST['code']));

  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "LoadCbo" : LoadCbo(); break;
  case "EditComment" : EditComment(); break;
  case "DelComment" : DelComment(); break;
  default : echo '{"success":"FAIL"}';
}
?>
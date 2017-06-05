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

function LoadEdit(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result = $obj->LoadEdit();
  
  $item = unserialize($result['field']['item']);
  if(empty($item[0])){
    foreach((array)$item as $i => $value){
      $result['item'][] = array('name'=>$i, 'value'=>$value);
    }
  }else{
    foreach((array)$item as $i => $itm){
      foreach((array)$itm as $j => $value){
        $result['item'][] = array('name'=>$j, 'value'=>$value);
      }
    }
  }
//  print_r($item);
  
  echo json_encode($result);
}

function RollBack(){
  global $table;
  $obj = new SubClass($table);
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];
  
  $log = $obj->LoadOne('logs', array('code'=>$_GET['code']));
  
  $mode = $log['mode'];
  $menu = $log['menu'];
  $item = unserialize($log['item']);
  if(empty($item[0])){
    $data = $item;
  }else{
    foreach((array)$item as $i => $itm){
      $data = $itm;
    }
  }
  
  if($mode=='EDIT'){
    $result['success'] = 'FAIL';
  }elseif($mode=='DEL'){
    $result = $obj->Add($menu, $data);
    $obj->Log('ADD', $menu, $result['code'], $user, $data);
  }else{
    $result['success'] = 'FAIL';
  }
//  print_r($data);
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "View" : View(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "RollBack" : RollBack(); break;
  case "OpenView" : OpenView(); break;
  default : echo '{"success":"FAIL"}';
}
?>
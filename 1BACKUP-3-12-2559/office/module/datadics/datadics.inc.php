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
require_once "../../app.inc.php";

function LoadEdits(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result = $obj->LoadEdit();
  
  $dic_code = $_GET['code'];
  $datadic = $obj->LoadDataDic($dic_code);
  $field = $obj->LoadField($datadic['id']);
  foreach($field as $i => $value){
    if($obj->CheckDataField($dic_code, $value['Field'])){          
      switch($value['Field']){
        case 'code' : $name='รหัส'; break;
        case 'enable' : $name='แสดงผล'; break;
        case 'user_create' : $name='ผู้สร้าง'; break;
        case 'user_update' : $name='ผู้แก้ไข'; break;
        case 'date_create' : $name='วันสร้าง'; break;
        case 'date_update' : $name='วันแก้ไข'; break;
        default : $name=''; break;
      }
      $data['dic_code'] = $dic_code;
      $data['id'] = $value['Field'];
      $data['name'] = $name;
      $data['attr_type'] = $value['Type'];
      $data['pkey'] = $value['Key'];
      $data['user_create'] = $user;
      $data['user_update'] = $user;
      $data['date_create'] = $datenow;
      $data['date_update'] = $datenow;
      $obj->Add('datafields', $data);
    }
  }  
  
  $datafield['header'][] = array('name'=>'id', 'display'=>'ID');
  $datafield['header'][] = array('name'=>'name', 'display'=>'Name');
  $datafield['header'][] = array('name'=>'attr_type', 'display'=>'Type');
  $datafield['header'][] = array('name'=>'remark', 'display'=>'Remark');
  $datafield['header'][] = array('name'=>'pkey', 'display'=>'Key', 'align'=>'center');
  
  $datafield['data'] = $obj->Load('datafields', array('dic_code'=>$dic_code));
  
  $result['datafield'] = $datafield;
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "LoadEdit" : LoadEdits(); break;
  default : echo '{"success":"FAIL"}';
}
?>
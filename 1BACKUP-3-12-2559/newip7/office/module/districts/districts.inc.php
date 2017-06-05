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

function LoadCbo(){
  global $table;
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $obj->attr = $_GET;
  $result['amphur'] = $obj->LoadCbo("amphurs", "code", "name_$lang");
  $result['province'] = $obj->LoadCbo("provinces", "code", "name_$lang");
  $result['geography'] = $obj->LoadCbo("geographies", "code", "name_$lang");
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "LoadEdit" : LoadEdit(); break;
  case "LoadCbo" : LoadCbo(); break;
  case "OpenView" : OpenView(); break;
  default : echo '{"success":"FAIL"}';
}
?>
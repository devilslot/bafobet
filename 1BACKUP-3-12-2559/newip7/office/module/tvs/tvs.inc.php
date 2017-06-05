<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
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
require_once "../../app.inc.php";

function LoadCbo(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result['position'] = $obj->LoadCboPosition();
  
  echo json_encode($result);
}

function OpenViews(){
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
	case "OpenView" : OpenViews(); break;
	case "LoadCbo" : LoadCbo(); break;
	default : echo '{"success":"FAIL"}';
}
?>
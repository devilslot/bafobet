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


switch($_REQUEST["mode"]){
  case "Add" : Add(); break;
  case "Edit" : Edit(); break;
  case "Del" : Del(); break;
  case "View" : View(); break;
  case "LoadEdit" : LoadEdit(); break;
  default : echo '{"success":"FAIL"}';
}
?>
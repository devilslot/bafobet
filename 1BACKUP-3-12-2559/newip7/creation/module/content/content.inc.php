<?php
/*================================================*\
*  Author : OCS
*  Created Date : 29/07/14 13:27
*  Module : Creation
*  Description : Creation
*  Involve People : Boy
*  Last Updated : 29/07/14 13:27
\*================================================*/

header("Content-type: text/html; charset=utf-8");
session_start();

require_once "../../../service/service.php";
require_once "../../../main/main.class.php";
require_once "../../creation.class.php";
require_once "content.class.php";

switch($_REQUEST["mode"]){
  default : echo '{"success":"FAIL"}';
}
?>
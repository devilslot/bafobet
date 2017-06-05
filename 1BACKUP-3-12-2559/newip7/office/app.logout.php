<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 29/07/14 13:27
*  Module : Office
*  Description : Log out
*  Involve People : Boy
*  Last Updated : 29/07/14 13:27
\*================================================*/

@session_start();
@header("Content-type: text/html; charset=utf-8");

require_once "../service/service.php";
require_once "../main/main.class.php";
require_once "app.class.php";

$app = new AppClass();
$app->Log('LOGOUT', 'employees', $_SESSION[OFFICE]['DATA']['code'], $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'], $_SESSION[OFFICE]['DATA']);

//unset($_SESSION[OFFICE]);
$_SESSION[OFFICE]['LOGIN'] = 'OFF';
$_SESSION[OFFICE]['DATA'] = array();
?>
<html>
<head>
  <title>Logout!!</title>
</head>
<body>
  <script language="JavaScript">
    window.location.href='../office';
  </script>
</body>
</html>
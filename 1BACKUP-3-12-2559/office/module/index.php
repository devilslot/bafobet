<?php
/*==================================================
*  Author : Tirapant Tongpann
*  Created Date : 25/12/2553 17:45
*  Module : index
*  Description : index
*  Involve People : -
*  Last Updated : 25/12/2553 17:45
==================================================*/
	header("Content-type: text/html; charset=utf-8");
	ob_start();
	session_start();
  include "../../../service/service.php";
  include "../../include/inc.checklogin.php";
	include "../../include/inc.template.php";
?>


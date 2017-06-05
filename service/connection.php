<?php	
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 5/1/2559
*  Module : connection
*  Description : service
*  Involve People : Tirapant Tongpann
*  Last Updated : 5/1/2559
\*================================================*/

/* :: http://localhost/backoffice :: */
/*define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "bafo");*/

/* :: http://backoffice.testdebug.com :: */
/*
define("DB_HOST", "localhost");
define("DB_USER", "bafobet_zero");
define("DB_PASS", "Pd?am+H_,s2t");
define("DB_NAME", "bafobet_zero");
*/

define("DB_HOST", "139.162.25.110");
define("DB_USER", "bafobet_db");
define("DB_PASS", "9IivNTE^08.e");
define("DB_NAME", "bafobet_localhost");


$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS,TRUE) or die ('Error connecting to mysql');

@mysql_query("SET NAMES utf8");
@mysql_query("SET character_set_results=utf8");
@mysql_query("SET character_set_client=utf8");
@mysql_query("SET character_set_connection=utf8");
mysql_select_db(DB_NAME, $conn);
?>
<?php
ini_set('allow_url_fopen ','ON');
ini_set('max_execution_time', 300);
ini_set('memory_limit', '256M');
define("DB_HOST", "localhost");
define("DB_USER", "bafobet_zero");
define("DB_PASS", "Pd?am+H_,s2t");
define("DB_NAME", "bafobet_zero");


/*define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "bafo");*/

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS,TRUE) or die ('Error connecting to mysql');

@mysql_query("SET NAMES utf8");
@mysql_query("SET character_set_results=utf8");
@mysql_query("SET character_set_client=utf8");
@mysql_query("SET character_set_connection=utf8");
mysql_select_db(DB_NAME, $conn);
?>
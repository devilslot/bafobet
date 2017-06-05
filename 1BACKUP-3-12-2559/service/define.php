<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 29/07/14 13:27
*  Module : Office
*  Description : Office
*  Involve People : Boy
*  Last Updated : 29/07/14 13:27
\*================================================*/


define("ZERO","ZeRoLiNe {Deverloper}");					

define("OFFICE", "OFFICE_BACKOFFICE");

define("TITLE", "");
define("DESCRIPTION", "");
define("KEYWORDS", "");
define("ROBOTS", "noindex, nofollow");
define("COPYRIGHT", "Online creation soft");
define("AUTHOR", "ONCS");
define("VIEW", 1);
define("ADD", 2);
define("EDIT", 3);
define("DEL", 4);

/* :: Log Admin :: */
define('LOGADD', '1');
define('LOGEDIT', '2');
define('LOGDEL', '3');
define('LOGLOAD', '4');
define('LOGLOGIN', '5');
define('LOGLOGOUT', '6');

/* :: http://localhost/backoffice :: */
//define("SITE", "backoffice");
//define("URL", "http://localhost/backoffice");
//define('FILEPATH', $_SERVER['DOCUMENT_ROOT'].'/backoffice');
//define("NOPIC", URL.'/img/nopic.jpg');
//define("DEBUG", true);
//define("FRIENDLY_URL", false);
//define("FRIENDLY_ADMIN", false);
//define("FRIENDLY_API", false);
//define("SENDMAIL", false);
//define("TYPEURL", "php");

/* :: http://backoffice.testdebug.com :: */
define("SITE", "BAFOBET");
define("URL", "http://www.bafobet.com");
define('FILEPATH', $_SERVER['DOCUMENT_ROOT']);
define("DEBUG", false);
define("FRIENDLY_URL", false);
define("FRIENDLY_ADMIN", true);
define("FRIENDLY_API", true);
define("TYPEURL", "php");
define("SENDMAIL", true);
date_default_timezone_set('Asia/Bangkok');

?>
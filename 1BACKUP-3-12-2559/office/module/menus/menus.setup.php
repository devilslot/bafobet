<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 05/12/2013 09:09
*  Module : inc
*  Description : Backoffice Include
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

include "$mod.class.php";
$obj = new SubClass();
$task = $obj->select()->from('tasks')->where('code', '<>', '0')->all()->result;

//PrintR($menu);     
?>
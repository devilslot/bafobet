<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 05/12/2013 09:09
*  Module : inc
*  Description : Backoffice Include
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

include "$mod.class.php";
$obj = new SubClass();

$dbname = DB_NAME;

function AddTable($dbname, $obj){
  $table = 'datadics';
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];

  $tb = $obj->LoadTable($dbname);
//  PrintR($tb);    
  foreach((array)$tb as $i => $value){
    if($obj->CheckDataDic($value)){          
      $data['id'] = $value;
      $data['user_create'] = $user;
      $data['user_update'] = $user;
      $data['date_create'] = $datenow;
      $data['date_update'] = $datenow;
      $obj->Add($table, $data);
    }
  }
}
  
AddTable($dbname, $obj);

//PrintR($tb);     
?>
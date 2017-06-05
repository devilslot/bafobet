<?php
/*================================================*\
*  Author : BoyBangkhla
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
$table = 'employees';

function Edit(){
  global $table;
  $user = $_SESSION[OFFICE]['DATA']['user'];
  $code = $_SESSION[OFFICE]['DATA']['code'];
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $old_pass = md5($_POST['data']['old_pass']);
  $emp = $obj->LoadOne($table, array('code'=>$code));
//  PrintR($emp);
  
  $obj->LoadLanguageAlert();
  if($old_pass == $emp['user_pass']){
    if($_POST['data']['new_pass'] == $_POST['data']['new_pass_again']){
      $data['user_pass'] = md5($_POST['data']['new_pass']);
      $data['user_update'] = $user;
      $data['date_update'] = DateNow();
      $result = $obj->Edit($table, $data, array('code'=>$code));

      $obj->Log('EDIT', $table, $code, $user, $result['log']);
      unset($result['log']);
      
      $result['msg'] = $obj->alert['SAVECOMPLETE'];
    }else{
      $result['msg'] = "NEWPASS";
      $result['success'] = 'FAIL';
    }
  }else{
    $result['msg'] = "OLDPASS";
    $result['success'] = 'FAIL';
  }
  
  echo json_encode($result);
}

switch($_REQUEST["mode"]){
  case "Edit" : Edit(); break;
  default : echo '{"success":"FAIL"}';
}
?>
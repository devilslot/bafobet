<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 05/12/2013 09:09
*  Module : inc
*  Description : Office Include
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

@session_start();
@header("Content-type: text/html; charset=utf-8");

include "../service/service.php";

function Login($user_name){
  $sql="
    SELECT
      code, id, prefix_code, name, surname, nickname, 
      user_name, user_pass, filepic, superadmin, 
      CONCAT(name, ' ', surname) AS user,
      NOW() AS datenow
    FROM
      employees
    WHERE
      user_name = '$user_name' AND
      enable = 'Y'
  ";
//    echo $sql;

  $query = mysql_query($sql) or die(mysql_error());
  $result=array();
  if($row=mysql_fetch_assoc($query)){
    $result=$row;
  }

  mysql_free_result($query);
  return $result;
}

function LoadEmpPermission($code){
  $sql="
    SELECT
      *
    FROM
      emp_permission
    WHERE
      emp_code = '$code'
  ";
//    echo $sql;
  $result = array();
  $query=mysql_query($sql) or die(mysql_error());
  while($row=mysql_fetch_object($query)){
    $result[$row->task][$row->id]=true;
  }
  mysql_free_result($query);

  return $result;
}

function LoadEmpPermissionAdmin(){
  $result = array();

  $sql="
    SELECT
      *
    FROM
      menus
    WHERE
      code <> 0
    ORDER BY
      sort
  ";
//    echo $sql;
  $query=mysql_query($sql) or die(mysql_error());
  while($row=mysql_fetch_object($query)){
    $result['VIEW'][$row->id]=true;
    $result['ADD'][$row->id]=true;
    $result['EDIT'][$row->id]=true;
    $result['DEL'][$row->id]=true;
    $result['PRINT'][$row->id]=true;
  }
  mysql_free_result($query);

  $sql="
    SELECT
      id
    FROM
      permissions
    WHERE
      code <> 0
    ORDER BY
      id
  ";
//    echo $sql;
  $query=mysql_query($sql) or die(mysql_error());
  while($row=mysql_fetch_object($query)){
    $result['OPEN'][$row->id]=true;
  }
  mysql_free_result($query);

  return $result;
}

function Logs($mode, $menu, $record, $user, $item=array()){
  if(empty($item)){
    $log = array();
  }
  $log = serialize($item);
  $log = mysql_real_escape_string($log);
  $ip = get_client_ip();
//    echo $log;
//    print_r($item);

  $sql="
    INSERT INTO logs (mode, menu, record, item, ip, user_create, date_create)
    VALUES(
      '$mode', '$menu', '$record', '$log', '$ip', '$user', NOW()
    )
  ";
//    echo $sql;
  $query=mysql_query($sql) or die(mysql_error());
} 

$attr = $_POST;
$user_name = $_POST['user'];
$user_pass = md5($_POST['pass']);

$login = Login($user_name);

$_SESSION[OFFICE]['LOGIN'] = 'OFF';
$_SESSION[OFFICE]['DATA'] = array();

if(strcmp($login['user_pass'], $user_pass)==0){
  unset($login['user_pass']);
  $login['SESSION_ID'] = session_id();

  $_SESSION[OFFICE]['LOGIN'] = 'ON';
  $_SESSION[OFFICE]['DATA'] = $login;

  if($login['superadmin']=='Y'){
    $_SESSION[OFFICE]['PERMISSION'] = LoadEmpPermissionAdmin();
  }else{
    $_SESSION[OFFICE]['PERMISSION'] = LoadEmpPermission($login['code']);
  }
  // if(!DEBUG){
  //   session_regenerate_id(true);
  // }
  // session_write_close();
  
  $result['success'] = 'COMPLETE';
  
  $redirect = strtoupper(md5('home'));
  if(FRIENDLY_ADMIN){
    $result['url'] = URL.'/office/'.$redirect.'.html';
  }else{
    $result['url'] = URL.'/office/app.php?mod='.$redirect;
  }
  
  Logs('LOGIN', 'employees', $login['code'], $login['name'].' '.$login['surname'], $login);
}else{
  $result['success'] = 'FAIL';
  
  Logs('LOGIN', 'employees', $login['code'], 'FAIL');
}
//print_r($_SESSION);

echo json_encode($result);
?>
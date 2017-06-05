<?php
/*==================================================
*  Author : Attaphon Wongbuatong
*  Created Date : 11/09/2554 01:30
*  Module : 
*  Description : 
*  Involve People : -
*  Last Updated : 11/09/2554 01:30
==================================================*/

$app = new AppClass();

$attr = $_POST;
$user_name = $_POST['user'];
$user_pass = md5($_POST['pass']);

$login = $app->Login($user_name);


if($_SESSION[OFFICE]['LOGIN'] != 'ON'){
  if(strcmp($login['user_pass'], $user_pass) == 0){
    unset($login['user_pass']);
    $login['SESSION_ID']=session_id();

    $_SESSION[OFFICE]['LOGIN']='ON';
    $_SESSION[OFFICE]['DATA']=$login;

    if($login['superadmin'] == 'Y'){
      $_SESSION[OFFICE]['PERMISSION']=$app->LoadEmpPermissionAdmin();
    }else{
      $_SESSION[OFFICE]['PERMISSION']=$app->LoadEmpPermission($login['code']);
    }
//    if(!DEBUG){
//      session_regenerate_id(true);
//    }
//    session_write_close();


    $app->Logs('LOGIN', 'employees', $login['code'], $login['name'].' '.$login['surname'], $login);
  }else{
    $result['success']='FAIL';

    $app->Logs('LOGIN', 'employees', $login['code'], 'FAIL');
    @header('location: index.php');
  }
}


if($_SESSION[OFFICE]["LOGIN"] != "ON"){
  $_SESSION[OFFICE]['LOGIN'] = 'OFF';
  echo PleaseLogin(URL.'/office');
  exit;
}

if(empty($_SESSION[OFFICE]['LANG'])){
  $lang = 'th';
  $_SESSION[OFFICE]['LANG'] = 'th';
}else{
  $lang = $_SESSION[OFFICE]['LANG'];
}


$app->lang = $lang;
$mymenu = $app->LoadMyMenu($_GET['mod']);

if($mymenu['main_menu']=='N'){
  $parentmenu = $app->LoadMyParentMenu($mymenu['code']);
  
  $parent = $parentmenu['id'];
}

$mod = $mymenu['id'];

$menus = $app->LoadMainMenu();
$menus_sub = $app->LoadSubMenu();

$permiss = $_SESSION[OFFICE]['PERMISSION'];
//PrintR($permiss);
if(!$permiss['VIEW'][$mod]){include 'app.notfound.php'; exit;};
if($permiss['ADD'][$mod])$per_add = true;
if($permiss['EDIT'][$mod])$per_edit = true;
if($permiss['DEL'][$mod])$per_del = true;
if($permiss['PRINT'][$mod])$per_print = true;

//
//exit;

$config = $app->LoadConfig();
$tmp = $app->LoadLanguage($lang);
$define = $tmp['DEFINE'];
$alert = $tmp['ALERT'];
$text = $tmp['CONTENT'];

//PrintR($menus_sub);

if(is_file("module/$mod/$mod.setup.php")){
  include "module/$mod/$mod.setup.php";
}

if(is_file("module/$mod/$mod.page.php")){
  include "module/$mod/$mod.page.php";
  exit;
}
?>
<?php
/*==================================================
*  Author : Attaphon Wongbuatong
*  Created Date : 11/09/2554 01:30
*  Module : Compile
*  Description : _SEARCH_ _VIEWLIST_ _ADDEDIT_
*  Involve People : -
*  Last Updated : 11/09/2554 01:30
==================================================*/
function Add(){
  global $table;
  
  $lang = $_SESSION[OFFICE]['LANG'];
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['user'];

  $obj = new SubClass($table, $lang); 
  
  $data = $_POST['data'];
  
  if(!$obj->CheckTable()){
    $obj->CreateTable($table, $data);
  }
          
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $result = $obj->Add($table, $data);

  $obj->LoadLanguageAlert();
  if($result['success']=='COMPLETE'){
    $result['msg'] = $obj->alert['SAVECOMPLETE'];
  }else{
    $result['msg'] = $obj->alert['SAVEERROR'];
  }
  
  $obj->Log('ADD', $table, $result['code'], $user, $data);
  
  echo json_encode($result);  
}

function Edit(){
  global $table;
  
  $lang = $_SESSION[OFFICE]['LANG'];
  $datenow = DateNow();
  $user = $_SESSION[OFFICE]['DATA']['user'];
  $code = $_POST['code'];
  
  $obj = new SubClass($table, $lang);
  $data = $_POST['data'];
  $data['user_update'] = $user;
  $data['date_update'] = $datenow;
  $result = $obj->Edit($table, $data, array('code'=>$code));
  
  $obj->LoadLanguageAlert();
  if($result['success']=='COMPLETE'){
    $result['msg'] = $obj->alert['SAVECOMPLETE'];
  }else{
    $result['msg'] = $obj->alert['SAVEERROR'];
  }  
  
  $obj->Log('EDIT', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function Del(){
  global $table;
  $user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];

  $obj = new SubClass($table);
  $result = $obj->Del($table, array('code'=>$_POST['code']));
  
  $obj->Log('DEL', $table, $_POST['code'], $user, $result['log']);
  unset($result['log']);
  
  echo json_encode($result);
}

function LoadEdit(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result = $obj->LoadEdit();
  
  echo json_encode($result);
}

function OpenView(){
  global $table;
  $obj = new SubClass($table);
  $obj->attr = $_GET;
  $result = $obj->OpenView();
  
  echo json_encode($result);
}

function View(){
  global $table;
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $obj->attr = $_POST;
  $obj->permission = $_SESSION[OFFICE]['PERMISSION'];
  $obj->LoadLanguageDefine();
  $result = $obj->View();
  
  echo json_encode($result);
}

function template_LoadCbo(){
  global $table;
  $lang = $_SESSION[OFFICE]['LANG'];
  
  $obj = new SubClass($table, $lang);
  $obj->attr = $_GET;
  $result['table'] = $obj->LoadCbo("table", "code", "name_$lang");
  
  echo json_encode($result);
}
?>
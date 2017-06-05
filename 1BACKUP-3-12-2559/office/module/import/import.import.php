<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 05/12/2013 09:09
*  Module : inc
*  Description : Backoffice Include
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

@session_start();
@header("Content-type: text/html; charset=utf-8");

ob_start();

require_once "../../../service/service.php";
require_once "../../../main/main.class.php";
require_once "../../app.class.php";
require_once "import.class.php";

error_reporting(0);

$table = $_POST['tablename'];

$datenow = DateNow();
$user = $_SESSION[OFFICE]['DATA']['name'].' '.$_SESSION[OFFICE]['DATA']['surname'];

$path="../../../temp/".$_POST['excel'].".xls";

require_once '../../../plugin/excelreader/excel.php';
require_once '../../../plugin/excelreader/oleread.php';

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('utf-8');
$data->read($path);

$obj = new SubClass($table);  

error_reporting(E_ALL ^ E_NOTICE);

$record = (array) $data->sheets[0]['cells'];

if($_REQUEST['mode']=='CreateTable'){
  $topic=(array)$record[1];
//  print_r($topic);
//  unset($record[1]);
  
  foreach($topic as $i => $value){
    $item[$value] = '';
  }
//  echo $obj->table;
  if(!$obj->CheckTable()){
    $result = $obj->CreateTable($table, $item);
    $result['msg'] = 'Create table complete';
  }else{
    $result['success'] = 'SAMETABLE';
    $result['msg'] = 'Same table';
  }
}elseif($_REQUEST['mode']=='Import'){
  $result['success'] = 'COMPLETE';
  $result['msg'] = 'Import complete';
  $result['topic']=(array)$record[1];
  unset($record[1]);

  foreach($result['topic'] as $i => $value){
    $tmp[$i] = '';
  }

  $cnttopic = count($cnttopic);
  $n = 1;
  foreach ((array) $record as $i => $row) {
    if(count($row) == $cnttopic){
      $result['record'][$n] = (array)$row;
    }else{
      $attr=array();
      $result['record'][$n] = $tmp; 
      foreach((array)$row as $j => $value){
        $id = $result['topic'][$j];
        if(!empty($id)){
          $attr[$id]=$value;
          $result['record'][$n][$j] = $value;
        }
      }

      $attr['user_create'] = $user;
      $attr['user_update'] = $user;
      $attr['date_create'] = $datenow;
      $attr['date_update'] = $datenow;
      $obj->Add($table, $attr);
    }
    $n++;
  }
}elseif($_REQUEST['mode']=='DeleteFile'){
  unlink($path);
  $result['success'] = 'COMPLETE';
  $result['msg'] = 'Delete complete';
}else{
  $result['success'] = 'FAIL';
  $result['msg'] = 'Errot';
}

unset($obj);
mysql_close();

echo json_encode($result);
?>
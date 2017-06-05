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

$task = $obj->select()->from('tasks')->where('code', '<>', '0')->all()->result;
//PrintR($task);

function LevelMap($n){
  return('level-'.$n);
}

function ClassLevel($value){
  if(empty($value)){
    $result = '';
  }else{
    $level = explode(',', $value);
    $arr = array_map("LevelMap", (array)$level);
    $result = implode(' ', (array)$arr);
  }
  
  return $result;
}
//          $level_view = explode(',', $value['level_view']);

//PrintR($level_view);     
?>
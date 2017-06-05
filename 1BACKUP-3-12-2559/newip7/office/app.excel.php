<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 05/12/2013 09:09
*  Module : inc
*  Description : Office Include
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

@session_start();

require_once '../service/service.php';
if($_GET['file'] == 'excel'){
  @header('Content-Disposition: attachment; filename="'.$_GET['mod'].'-'.time().'.xls"');
  @header("Content-Type: application/vnd.ms-excel");
}else{
  @header("Content-type: text/html; charset=utf-8");
}

$table = $_GET['mod'];

require_once "../main/main.class.php";
require_once "app.class.php";
//require_once "module/$table/$table.class.php";

$obj = new AppClass($table);  
$obj->attr = $_GET;

$field = $obj->LoadField($table);
$data = $obj->ExportExcel();
//PrintR($field);
//exit;

if($_GET['file'] == 'excel'){
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
  <meta http-equiv="Content-Type" content="application/vnd.ms-excel; charset=utf-8" />  
</head>
<?php }else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $_GET['mod'].'-'.time(); ?></title>
</head>
<style>
  table{border-collapse:collapse;}
  td, th{white-space:nowrap;}
</style>
<?php } ?>

<body>
  <table border="1" cellpadding="3">

      <?php 
      $found = true;
      foreach((array)$data as $i => $col){ 
        if($found){
          echo '<tr>';
          foreach((array)$col as $j => $value){
            if(!empty($field[$j])){
              echo "<th>".$field[$j]."</th>";
            }
          }
          echo '</tr>';
          $found = false;
        }
        echo '<tr>';
        foreach((array)$col as $j => $value){
          if(!empty($field[$j])){
            echo "<td>$value</td>";
          }
        }
        echo '</tr>';
      }
        
        ?>

  </table>
</body>
</html>

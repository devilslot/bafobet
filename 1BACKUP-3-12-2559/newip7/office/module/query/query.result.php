<?php
/*================================================*\
*  Author : OCS
*  Created Date : 29/07/14 13:27
*  Module : Office
*  Description : Office
*  Involve People : Boy
*  Last Updated : 29/07/14 13:27
\*================================================*/
@session_start();
@header("Content-type: text/html; charset=utf-8");

require_once "../../../service/service.php";
$table = $_GET['mod'];

require_once "../../../main/main.class.php";
require_once "../../app.class.php";
require_once "$table.class.php";
require_once "$table.format.php";

$obj = new SubClass($table);

$type = $_GET['type'];
$sql = $_POST["query$type"];
$code = $_POST['query_code'];
$sql = str_replace("\r\n", "\n", $sql);

//PrintR($_POST);
$query = SqlFormatter::format($sql);

$obj->Edit($table, array("query$type"=>$sql), array('code'=>$code)); 
$result = $obj->LoadResult($sql);

//PrintR($mod); 
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Head -->
<head>
<meta charset="utf-8" />
<title><?php echo "#$code / query$type"; ?></title>

<meta name="description" content="ONCS" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../plugin/assets/css/bootstrap.min.css" rel="stylesheet" />
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">

<body>

<div class="table-scrollable">
  <?php echo $query; ?>
  <table class="table table-striped table-hover table-striped table-bordered">
    <thead class="bordered-blue">
      
      <?php 
      foreach((array)$result as $i => $item){ 
        echo "<tr>";
        foreach((array)$item as $j => $value){ 
          echo "<th>$j</th>";
        }
        echo "</tr>";
        break;
      }
        ?>
    </thead>
    <tbody>
      <?php 
      foreach((array)$result as $i => $item){ 
        echo "<tr>";
        foreach((array)$item as $j => $value){ 
          echo "<td>$value</td>";
        }
        echo "</tr>";
      }
        ?>
    </tbody>
  </table>
</div>
</body>
</html>

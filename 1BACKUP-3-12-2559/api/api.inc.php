<?php
/*================================================*\
*  Author : oncs.co.th
*  Created Date : 05/01/2016 11:42
*  Module : api
*  Description : Backoffice Include
*  Involve People : Tirapant Tongpann
*  Last Updated : 05/01/2016 11:42
\*================================================*/

@session_start();
@header("Content-type: text/html; charset=utf-8");

require_once "../service/service.php";
require_once "../main/main.class.php";
require_once "../main/upload.class.php";
require_once "api.class.php";

$json = '{}';

switch($_REQUEST["mode"]){
  default : $json = '{"success":"FAIL"}';
}

if($_REQUEST['jsonview']!='true'){
  echo $json;
}else{
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JQuery JSON View</title>
  <link rel="stylesheet" href="../plugin/jsonview/jquery.jsonview.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
  <script type="text/javascript" src="../plugin/jsonview/jquery.jsonview.js"></script>
  <script type="text/javascript">
    var json = <?php echo $json; ?>;
    $(function() {
//      $("#json").JSONView(json);
      $("#json").JSONView(json, { collapsed: true, nl2br: true, recursive_collapser: true });
    });
  </script>
</head>
<body>

  <div id="json"></div>

</body>
</html>
<?php
}
?>


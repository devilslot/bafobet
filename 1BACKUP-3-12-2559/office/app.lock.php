<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 05/12/2013 09:09
*  Module : inc
*  Description : Backoffice Include
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

@session_start();
@header("Content-type: text/html; charset=utf-8");
require_once "../service/service.php";
require_once "../main/main.class.php";
require_once "login.class.php";

if(empty($_SESSION)){
  session_start();
}
$_SESSION[OFFICE]['LOGIN'] = 'OFF';

$obj = new SubClass();
$obj->attr['user_name'] = $_GET['user'];
$user = $obj->Login();
//PrintR($user);
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<!--Head-->
<head>
    <meta charset="utf-8" />
    <title><?php echo SITE;?> :: OFFICE LOCK</title>

    <meta name="description" content="lock screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">

    <!--Basic Styles-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />

    <!--Beyond styles-->
    <link id="beyond-link" href="assets/css/beyond.min.css" rel="stylesheet" />
    <link href="assets/css/demo.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="assets/js/skins.min.js"></script>
</head>
<!--Head Ends-->
<!--Body-->
<body>
    <div class="lock-container animated fadeInDown">
        <div class="lock-box text-align-center">
            <div class="lock-username"><?php echo $user['name'].' '.$user['surname']; ?></div>
            <img src="<?php echo '../img/'.$user['filepic']; ?>" alt="<?php echo $user['name'].' '.$user['surname']; ?>" />
            <div class="lock-password" style="width:85%;">
                <form id="frmLogin" class="form-inline" role="form" name="frmLogin" method="post" action=" " onsubmit="return false;" autocomplete="off">
                    <div class="form-group">
                        <span class="input-icon icon-right">
                          <input name="usernames" id="usernames" type="hidden" value="<?php echo $_GET['user']; ?>" />
                          <input class="form-control" placeholder="PASSWORD" name="password"  id="passwords" type="password" />
                            <i class="glyphicon glyphicon-log-in themeprimary"></i>
                        </span>
                    </div>
                </form>
            </div>

        </div>
        <div class="signinbox">
            <span>กลับเข้าสู่</span>
            <a href="<?php echo URL.'/office'; ?>">หน้าหลัก</a>
        </div>
    </div>

<!--Basic Scripts-->
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!--Beyond Scripts-->
<script src="assets/js/beyond.min.js"></script>
<script src="../main/main.func.js" charset="utf-8"></script>
<script src="login.script.js" charset="utf-8"></script>
<script charset="utf-8">
$(document).ready(function(){
	$('#passwords').focus();
});
</script>
</body>
<!--Body Ends-->
</html>

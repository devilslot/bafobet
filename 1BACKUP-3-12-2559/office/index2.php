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

if(empty($_SESSION)){
  session_start();
}


if(empty($_SESSION[OFFICE]['LOGIN'])){
  $_SESSION[OFFICE]['LOGIN'] = 'OFF';
}

$bg = RandomNumber(1);
$bg = (empty($bg))?0:$bg;
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title><?php echo SITE;?> :: OFFICE</title>

    <meta name="description" content="login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo URL; ?>/images/favicon.png" type="image/x-icon">
      <!--Fonts-->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo URL; ?>/plugin/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="<?php echo URL; ?>/plugin/assets/css/font-awesome.min.css" rel="stylesheet" />
    <link id="beyond-link" href="<?php echo URL; ?>/plugin/assets/css/beyond.min.css" rel="stylesheet" />
    <link href="<?php echo URL; ?>/plugin/assets/css/demo.min.css" rel="stylesheet" />
    <link href="<?php echo URL; ?>/plugin/assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />
    
    <script src="<?php echo URL; ?>/plugin/assets/js/skins.js"></script>
    
<style>

.bgwidth { width: 100%; }
.bgheight { height: 100%; }


.form-control{font-weight:normal;}
</style>
</head>
<!--Head Ends-->
<!--Body-->
<body>

  <form id="frmLogin" name="frmLogin" method="post" action="login2.inc.php" autocomplete="off">
    <div class="login-container animated fadeInDown">
        <div class="loginbox">
            <div class="loginbox-social padding-top-20 padding-left-40 padding-right-40">
                <img src="<?php echo URL; ?>/images/logo.png" class="img-responsive" />
            </div>

            <div class="loginbox-textbox">
                <input class="form-control" placeholder="USERNAME" name="usernames"  id="usernames" type="text" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" />
                <div id="err_insertuser" class="alert alert-danger" style="display:none; margin:5px 0;"><i class="fa fa-warning"></i> Please enter your username</div>
            </div>
            <div class="loginbox-textbox">
                <input class="form-control" placeholder="PASSWORD" name="password"  id="passwords" type="password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" />
              
              <div id="err_insertpass" class="alert alert-danger" style="display:none; margin:5px 0;"><i class="fa fa-warning"></i> Please enter your password</div>
              <div id="err_login" class="alert alert-danger" style="display:none; margin:5px 0;"><i class="fa fa-warning"></i> Invalid username or password</div>
            </div>
            <div class="loginbox-submit">
                <button type="submit" class="btn shiny btn-block primary">L O G I N <i class="fa fa-sign-in primary"></i></button>
            </div>
        </div>
        <div class=" text-align-center padding-top-20">
          Copyright &copy;<?php echo date('Y');?> Siamratebook
        </div>
    </div>
</form>

<!--Basic Scripts-->
<script src="<?php echo URL; ?>/plugin/assets/js/jquery.min.js"></script>
<script src="<?php echo URL; ?>/plugin/assets/js/bootstrap.min.js"></script>
<script src="<?php echo URL; ?>/plugin/assets/js/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo URL; ?>/plugin/assets/js/beyond.js"></script>
<script src="<?php echo URL; ?>/main/main.func.js" charset="utf-8"></script>

</body>
<!--Body Ends-->
</html>


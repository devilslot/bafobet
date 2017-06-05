<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 29/07/14 13:27
*  Module : Office
*  Description : Office
*  Involve People : Boy
*  Last Updated : 29/07/14 13:27
\*================================================*/
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");

require_once "../service/service.php";
require_once "../main/main.class.php";
require_once "app.class.php";
require_once "app.init.php";
//PrintR($mod); 
?><!DOCTYPE html>
<!--
BeyondAdmin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 1.4.2
Purchase: http://wrapbootstrap.com
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
  <meta charset="utf-8" />
  <title><?php echo $config["name_$lang"]; ?> :: <?php echo $mymenu['name']; ?></title>

  <meta name="description" content="form editors" />
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
  <link href="<?php echo URL; ?>/plugin/assets/css/weather-icons.min.css" rel="stylesheet" />
  <link id="beyond-link" href="<?php echo URL; ?>/plugin/assets/css/beyond.min.css" rel="stylesheet" />
  <link href="<?php echo URL; ?>/plugin/assets/css/demo.min.css" rel="stylesheet" />
  <link href="<?php echo URL; ?>/plugin/assets/css/typicons.min.css" rel="stylesheet" />
  <link href="<?php echo URL; ?>/plugin/assets/css/animate.min.css" rel="stylesheet" />
  <link href="<?php echo URL; ?>/plugin/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" /> 
  <link href="<?php echo URL; ?>/plugin/plupload/src/javascript/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet" type="text/css" media="screen" />  
  <link id="skin-link" href="" rel="stylesheet" type="text/css" />
  <link href="<?php echo URL; ?>/office/app.style.css" rel="stylesheet" />
  <?php if(is_file("module/$mod/$mod.style.php"))include "module/$mod/$mod.style.php"; ?>  
  <link href="<?php echo URL."/office/module/$mod/$mod.style.css"; ?>" type="text/css" rel="stylesheet"  />
  
  <script src="<?php echo URL; ?>/plugin/assets/js/skins.js"></script>
</head>
<!-- /Head -->
<!-- Body -->
<body>
  <!-- Loading Container -->
  <div class="loading-container">
    <div class="loader"></div>
  </div>
  <!--  /Loading Container -->
  <!-- Navbar -->
  <?php include 'app.header.php'; ?>
  <!-- /Navbar -->
  <!-- Main Container -->
  <div class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
      <!-- Page Sidebar -->
      <div class="page-sidebar" id="sidebar">
        <!-- Page Sidebar Header-->
        <div class="sidebar-header-wrapper">
          <input type="text" class="searchinput" id="SearchMenu" />
          <i class="searchicon fa fa-search"></i>
        </div>
        <!-- /Page Sidebar Header -->
        <!-- Sidebar Menu -->
        <?php include 'app.menu.php'; ?>
        <!-- /Sidebar Menu -->
      </div>
      <!-- /Page Sidebar -->
      <!-- Chat Bar -->
      <?php include 'app.chat.php'; ?>
      <!-- /Chat Bar -->
      <!-- Page Content -->
      <div class="page-content">
        <!-- Page Breadcrumb -->
        <div class="page-breadcrumbs">
          <ul class="breadcrumb">
            <li>
              
              <a href="#"><?php echo $text['HOME']; ?></a>
            </li>
            <?php if(!empty($parentmenu))echo "<li>".$parentmenu["name_$lang"]."</li>"; ?>
            <li class="active"><?php echo $mymenu["name_$lang"]; ?></li>
          </ul>
        </div>
        <!-- /Page Breadcrumb -->
        <!-- Page Header -->
        <div class="page-header position-relative">
          <div class="header-title">
            <h1>
              <i class="fa <?php echo (empty($parentmenu))?$mymenu['icon']:$parentmenu['icon'];?>"></i> 
              <?php 
              echo $mymenu["name_$lang"]; 
              if(DEBUG) echo " [$mod]";
              ?>
            </h1>
          </div>
          <!--Header Buttons-->
          <div class="header-buttons">
            <a class="sidebar-toggler" href="#">
              <i class="fa fa-arrows-h"></i>
            </a>
            <a class="refresh" id="refresh-toggler" href="">
              <i class="glyphicon glyphicon-refresh"></i>
            </a>
            <a class="fullscreen" id="fullscreen-toggler" href="#">
              <i class="glyphicon glyphicon-fullscreen"></i>
            </a>
          </div>
          <!--Header Buttons End-->
        </div>
        <!-- /Page Header -->
        <!-- Page Body -->
        <?php
        if(is_file("module/$mod/$mod.content.php")){
          include "module/$mod/$mod.content.php";
        }else{
          include 'app.content.php'; 
        }
        ?>
        <!-- /Page Body -->
      </div>
      <!-- /Page Content -->
    </div>
    <!-- /Page Container -->
    <!-- Main Container -->

  </div>
  <?php include 'app.popup.php'; ?>

  <script src="<?php echo URL; ?>/plugin/assets/js/jquery.min.js"></script>
  <script src="<?php echo URL; ?>/plugin/assets/js/bootstrap.min.js"></script>
  <script src="<?php echo URL; ?>/plugin/assets/js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo URL; ?>/plugin/assets/js/beyond.min.js"></script>
  <script src="<?php echo URL; ?>/plugin/assets/js/editors/wysiwyg/jquery.hotkeys.js"></script>
  <script src="<?php echo URL; ?>/plugin/assets/js/editors/wysiwyg/prettify.js"></script>
  <script src="<?php echo URL; ?>/plugin/assets/js/editors/wysiwyg/bootstrap-wysiwyg.js"></script>
  <script src="<?php echo URL; ?>/plugin/assets/js/editors/summernote/summernote.js"></script>
  <script src="<?php echo URL; ?>/plugin/autocomplete/bootstrap3-typeahead.js" charset="UTF-8"></script>
  <script src="<?php echo URL; ?>/plugin/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script src="<?php echo URL; ?>/plugin/datetimepicker/js/locales/bootstrap-datetimepicker.th.js" charset="UTF-8"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/src/javascript/jquery.plupload.queue/jquery.plupload.queue.js"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/src/javascript/plupload.js"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/src/javascript/plupload.gears.js"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/src/javascript/plupload.silverlight.js"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/src/javascript/plupload.flash.js"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/src/javascript/plupload.browserplus.js"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/src/javascript/plupload.html4.js"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/src/javascript/plupload.html5.js"></script>
  <script src="<?php echo URL; ?>/plugin/plupload/js/i18n/th.js"></script>
  <script src="<?php echo URL; ?>/main/main.func.js" charset="utf-8"></script>
  <script src="<?php echo URL; ?>/office/app.script.js" charset="utf-8"></script>
  <?php if(is_file("module/$mod/$mod.script.php")) include "module/$mod/$mod.script.php"; ?>
  <script>
  $(document).ready(function(){
    me.mod = '<?php echo $mod; ?>';
    me.site = '<?php echo URL; ?>';
    me.define = <?php echo json_encode($define); ?>;
    me.alert = <?php echo json_encode($alert); ?>;
    me.menu = '<?php echo (empty($parent))?$mod:$parent; ?>';
    me.submenu = '<?php echo (empty($parent))?'':$mod; ?>';
    me.Init();    
    me.permission.add = '<?php echo $per_add; ?>';
    me.permission.edit = '<?php echo $per_edit; ?>';
    me.permission.del = '<?php echo $per_del; ?>';
  });
  </script>
  <script src="<?php echo "module/$mod/$mod.script.js"; ?>" charset="utf-8"></script>  
</body>
<!--  /Body -->
</html>

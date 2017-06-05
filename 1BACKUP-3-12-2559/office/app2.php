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
?>
<!DOCTYPE html>
<!--

TABLE OF CONTENTS.

Use search to find needed section.

=====================================================

|  1. $BODY                 |  Body                 |
|  2. $MAIN_NAVIGATION      |  Main navigation      |
|  3. $NAVBAR_ICON_BUTTONS  |  Navbar Icon Buttons  |
|  4. $MAIN_MENU            |  Main menu            |
|  5. $GRID                 |  Grid                 |

=====================================================

-->


<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ONCS ADMIN</title>
  <link href="../images/favicon.png" rel="icon" />
	<meta name="viewport" content="width=device-width, user-scalable=no">


	<!-- Pixel Admin's stylesheets -->
	<link href="../plugin/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../plugin/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="../plugin/assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
	<link href="../plugin/assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="../plugin/assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
		<script src="../plugin/assets/javascripts/ie.min.js"></script>
	<![endif]-->

	<style>
		h4 {
			margin-bottom: 20px;
			margin-top: 30px;
		}
		.grid-example .row {
			margin-bottom: 20px;
			margin-left: 0;
			margin-right: 0;
		}
		.grid-example [class*="col-"] {
			background: #f2f2f2;
			background: rgba(0,0,0,.05);
			border: 1px solid;
			border-color: #d9d9d9;
			border-color: rgba(0,0,0,.1);
			padding-bottom: 10px;
			padding-top: 10px;
			text-align: center;
			-webkit-transition: all .3s;
			-moz-transition: all .3s;
			-ms-transition: all .3s;
			-o-transition: all .3s;
			transition: all .3s;
		}
		.grid-example [class*="col-"]:hover {
			background: #d9d9d9;
			background: rgba(0,0,0,.1);
		}
	</style>
<?php
  if(is_file("module/$mod/$mod.style.php")){
    include "module/$mod/$mod.style.php";
  }
?>  
<link href="app.style.css" rel="stylesheet" type="text/css"  />
<link href="<?php echo "module/$mod/$mod.style.css"; ?>" type="text/css" rel="stylesheet"  />
</head>


<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'      - Sets text direction to right-to-left
	* 'main-menu-right'    - Places the main menu on the right side
	* 'no-main-menu'       - Hides the main menu
	* 'main-navbar-fixed'  - Fixes the main navigation
	* 'main-menu-fixed'    - Fixes the main menu
	* 'main-menu-animated' - Animate main menu
-->
<body class="theme-default main-menu-animated page-mail main-navbar-fixed main-menu-fixed dont-animate-mm-content-sm animate-mm-md animate-mm-lg">
<!-- Loading Container -->
<div class="loading-container loading-inactive">
  <div class="loading-progress">
      <img src="../images/loader.png" class="fa-spin" />
  </div>
</div>
<!--  /Loading Container -->

<script>var init = [];</script>
<script src="../plugin/assets/demo/demo.js"></script>

<div id="main-wrapper">



<?php 
include 'app.header.php'; 
include 'app.menu.php'; 
?>


	<div id="content-wrapper">
    <ul id="page-breadcrumb-demo" class="breadcrumb breadcrumb-page" style="display: block;">
					<li><a href="app.php?mod=home"><?php echo $text['HOME']; ?></a></li>
          <?php if(!empty($parentmenu)){ ?>
          <li><?php echo $parentmenu["name_$lang"];?></li>
          <?php } ?>
          <li class="active"><?php echo $mymenu["name_$lang"]; ?></li>
				</ul>
  		<div class="page-header">
        <h1>
          <i class="fa <?php echo (empty($parentmenu))?$mymenu['icon']:$parentmenu['icon'];?>"></i> 
          <?php echo $mymenu["name_$lang"]; 
        if(DEBUG){
          echo " [$mod]";
        }
        ?>
        </h1>
		</div> <!-- / .page-header -->

<?php
if(is_file("module/$mod/$mod.content.php")){
  include "module/$mod/$mod.content.php";
}else{
  include 'app.content.php'; 
}
?>
	</div> <!-- / #content-wrapper -->
	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

<?php
include 'app.popup.php'; 
?>


<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="../plugin/assets/javascripts/jquery-2.0.3.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="../plugin/assets/javascripts/jquery-1.8.3.js">'+"<"+"/script>"); </script>
<![endif]-->

<!-- Pixel Admin's javascripts -->
<script src="../plugin/assets/javascripts/bootstrap.min.js"></script>
<script src="../plugin/assets/javascripts/pixel-admin.min.js"></script>
<script type="text/javascript">
	init.push(function () {
		//Javascript code here
//		$('#main-menu, #main-navbar').on('touchend', 'a', function(){
//			$(this).trigger('click');
//			return false;
//		});
//		$('#main-menu, #main-navbar').on('touchend', 'button', function(){
//			$(this).trigger('click');
//			return false;
//		});
	})
	window.PixelAdmin.start(init);
</script>
<?php
  if(is_file("module/$mod/$mod.script.php")){
    include "module/$mod/$mod.script.php";
  }
?>
<script src="../main/main.func.js" charset="utf-8"></script>
<script src="app.script.js" charset="utf-8"></script>
<script>
$(document).ready(function(){
  me.mod = '<?php echo $mod; ?>';
  me.site = '<?php echo URL; ?>';
  me.define = <?php echo json_encode($define); ?>;
  me.alert = <?php echo json_encode($alert); ?>;
  me.menu = '<?php echo (empty($parent))?$mod:$parent; ?>';
  me.submenu = '<?php echo (empty($parent))?'':$mod; ?>';
  me.Init();    
//  me.permission.add = '<?php echo $per_add; ?>';
//  me.permission.edit = '<?php echo $per_edit; ?>';
//  me.permission.del = '<?php echo $per_del; ?>';
});
</script>
<!--<script src="<?php echo "module/$mod/$mod.script.js"; ?>" charset="utf-8"></script>  -->
</body>
</html>
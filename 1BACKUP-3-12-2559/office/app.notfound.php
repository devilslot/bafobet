<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 05/12/2013 09:09
*  Module : inc
*  Description : Office Include
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<!--Head-->
<head>
    <meta charset="utf-8" />
    <title>Error 404 - Page Not Found</title>

    <meta name="description" content="Error 404 - Page Not Found" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo URL; ?>/plugin/assets/images/favicon.png" type="image/x-icon">

    <!--Basic Styles-->
    <link href="<?php echo URL; ?>/plugin/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="<?php echo URL; ?>/plugin/assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo URL; ?>/plugin/assets/css/weather-icons.min.css" rel="stylesheet" />

    <!--Beyond styles-->
    <link id="beyond-link" href="<?php echo URL; ?>/plugin/assets/css/beyond.min.css" rel="stylesheet" />
    <link href="<?php echo URL; ?>/plugin/assets/css/demo.min.css" rel="stylesheet" />
    <link href="<?php echo URL; ?>/plugin/assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="<?php echo URL; ?>/plugin/assets/js/skins.js"></script>
</head>
<!--Head Ends-->
<!--Body-->
<body class="body-404">
    <div class="error-header"> </div>
    <div class="container ">
        <section class="error-container text-center">
            <h1>404</h1>
            <div class="error-divider">
                <h2>page not found</h2>
                <p class="description">We Couldn’t Find This Page</p>
            </div>
            <a href="<?php echo URL; ?>/office" class="return-btn"><i class="fa fa-home"></i>Home</a>
        </section>
    </div>
    <!--Basic Scripts-->
    <script src="<?php echo URL; ?>/plugin/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL; ?>/plugin/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL; ?>/plugin/assets/js/slimscroll/jquery.slimscroll.min.js"></script>

    <!--Beyond Scripts-->
    <script src="<?php echo URL; ?>/plugin/assets/js/beyond.min.js"></script>

    
</body>
<!--Body Ends-->
</html>

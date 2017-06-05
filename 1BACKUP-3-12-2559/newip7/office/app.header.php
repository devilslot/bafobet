<?php
if(FRIENDLY_ADMIN){
  $url_edit=strtoupper(md5('empedit')).".html";
  $url_pic=strtoupper(md5('empedit')).".html?tab=picture";
  $url_pass=strtoupper(md5('emppass')).".html";
}else{
  $url_edit="app.php?mod=".strtoupper(md5('empedit'));
  $url_pic="app.php?mod=".strtoupper(md5('empedit'))."&tab=picture";
  $url_pass="app.php?mod=".strtoupper(md5('emppass'));
}
?>
<div class="navbar">
  <div class="navbar-inner">
    <div class="navbar-container">
      <!-- Navbar Barnd -->
      <div class="navbar-header pull-left">
        <a href="#" class="navbar-brand" style="padding-top:10px;">
          <?php echo $config["name_$lang"]; ?>
        </a>
      </div>
      <!-- /Navbar Barnd -->
      <!-- Sidebar Collapse -->
      <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="collapse-icon fa fa-bars"></i>
      </div>
      <!-- /Sidebar Collapse -->
      <!-- Account Area and Settings --->
      <div class="navbar-header pull-right">
        <div class="navbar-account">
          <ul class="account-area">
<?php 
//include 'app.alert.php';
//include 'app.mailbox.php';
//include 'app.task.php';
?>
<!--            <li>
              <a class="wave in" id="chat-link" title="Chat" href="#">
                <i class="icon glyphicon glyphicon-comment"></i>
              </a>
            </li>-->
            <li>
              <a class="login-area dropdown-toggle" data-toggle="dropdown">
                <div class="avatar" title="View your public profile">
                  <img src="<?php echo '../img/?pic='.$_SESSION[OFFICE]['DATA']['filepic'];?>">
                </div>
                <section>
                  <h2><span class="profile"><span><?php echo $_SESSION[OFFICE]['DATA']['user'];?></span></span></h2>
                </section>
              </a>
              <!--Login Area Dropdown-->
              <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                <li class="username"><a><?php echo $_SESSION[OFFICE]['DATA']['user'];?></a></li>
                <li class="email"><a><?php echo $_SESSION[OFFICE]['DATA']['user_name'];?></a></li>
                <!--Avatar Area-->
                <li>
                  <div class="avatar-area">
                    <img src="<?php echo '../img/?pic='.$_SESSION[OFFICE]['DATA']['filepic'];?>" class="avatar">
                    <span class="caption" onclick="location.href='<?php echo $url_pic; ?>';">Change Photo</span>
                  </div>
                </li>
                <!--Avatar Area-->
                <li class="edit">
                  <a href="<?php echo $url_edit; ?>" class="pull-left"><i class="fa fa-user"></i> <?php echo $text['EDITPROFILE'];?></a>
                  <a href="<?php echo $url_pass; ?>" class="pull-right"><?php echo $text['CHANGEPASS'];?> <i class="fa fa-key"></i></a>
                </li>
                <!--Theme Selector Area-->
                <li class="theme-area">
                  <ul class="colorpicker" id="skin-changer">
                    <li><a class="colorpick-btn" href="#" style="background-color:#5DB2FF;" rel="<?php echo URL;?>/plugin/assets/css/skins/blue.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#2dc3e8;" rel="<?php echo URL;?>/plugin/assets/css/skins/azure.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#03B3B2;" rel="<?php echo URL;?>/plugin/assets/css/skins/teal.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#53a93f;" rel="<?php echo URL;?>/plugin/assets/css/skins/green.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#FF8F32;" rel="<?php echo URL;?>/plugin/assets/css/skins/orange.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#cc324b;" rel="<?php echo URL;?>/plugin/assets/css/skins/pink.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#AC193D;" rel="<?php echo URL;?>/plugin/assets/css/skins/darkred.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#8C0095;" rel="<?php echo URL;?>/plugin/assets/css/skins/purple.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#0072C6;" rel="<?php echo URL;?>/plugin/assets/css/skins/darkblue.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#585858;" rel="<?php echo URL;?>/plugin/assets/css/skins/gray.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#474544;" rel="<?php echo URL;?>/plugin/assets/css/skins/black.min.css"></a></li>
                    <li><a class="colorpick-btn" href="#" style="background-color:#001940;" rel="<?php echo URL;?>/plugin/assets/css/skins/deepblue.min.css"></a></li>
                  </ul>
                </li>
                <!--/Theme Selector Area-->
                <li class="dropdown-footer">
                  <a href="app.logout.php">
                    <?php echo $text['LOGOUT'];?>
                  </a>
                </li>
              </ul>
              <!--/Login Area Dropdown-->
            </li>
            <!-- /Account Area -->

            <!-- Settings -->
          </ul><div class="setting">
            <a id="btn-setting" title="Setting" href="#">
              <i class="icon glyphicon glyphicon-cog"></i>
            </a>
          </div><div class="setting-container">
            <label>
              <input type="checkbox" id="checkbox_fixednavbar">
              <span class="text">Fixed Navbar</span>
            </label>
            <label>
              <input type="checkbox" id="checkbox_fixedsidebar">
              <span class="text">Fixed SideBar</span>
            </label>
            <label>
              <input type="checkbox" id="checkbox_fixedbreadcrumbs">
              <span class="text">Fixed BreadCrumbs</span>
            </label>
            <label>
              <input type="checkbox" id="checkbox_fixedheader">
              <span class="text">Fixed Header</span>
            </label>
          </div>
          <!-- Settings -->
        </div>
      </div>
      <!-- /Account Area and Settings -->
    </div>
  </div>
</div>
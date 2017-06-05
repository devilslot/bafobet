<ul class="nav sidebar-menu">
  <?php
/*
 * MENU
 */
foreach((array)$menus as $i => $value){
  
  if(FRIENDLY_ADMIN){
    $url = strtoupper(md5($value['id'])).".html";
  }else{
    $url = "app.php?mod=".strtoupper(md5($value['id']));
  }
  
  if(DEBUG){
    if(is_file("module/{$value['id']}/index.php")){
      $found = '';
    }else{
      $found = '<sup style="color:red">***</sup>';
    }
  }else{
    $index = '';
  }
  if(empty($menus_sub[$value['code']])){
    if($permiss['VIEW'][$value['id']]){
      echo "<li id='menu-{$value['id']}' class='menuitem'><a href='$url'><i class='menu-icon fa {$value['icon']}'></i> <span class='menu-text'>{$value["shortname_$lang"]}$index $found</span></a></li>";
    }
  }else{
    $c_sub = 0;
    
    $text_menu = "<li id='menu-{$value['id']}' class='menuitem'>";
    $text_menu .= "<a href='#' class='menu-dropdown'><i class='menu-icon fa {$value['icon']}'></i> <span class='menu-text'>{$value["shortname_$lang"]}$index</span><i class='menu-expand'></i></a>";
    $text_menu .= "<ul class='submenu'>";
    foreach($menus_sub[$value['code']] as $j => $submenu){
      if(DEBUG){
        if(is_file("module/{$submenu['id']}/index.php")){
          $found = '';
        }else{
          $found = '<sup style="color:red">***</sup>';
        }
      }else{
        $index = '';
      }

      if($permiss['VIEW'][$submenu['id']]){
        $c_sub++;
        if(FRIENDLY_ADMIN){
          $url = strtoupper(md5($submenu['id'])).".html";
        }else{
          $url = "app.php?mod=".strtoupper(md5($submenu['id']));
        }

        $text_menu .= "<li id='submenu-{$value['id']}-{$submenu['id']}' class='menusubitem'><a href='#' onclick='window.location.href=\"$url\"'><span class='menu-text'>{$submenu["shortname_$lang"]}$index $found</span></a></li>";
      }
    }
//    echo 'c='.$c_sub;
//    echo $text_menu;
    $text_menu .= "</ul>";
    $text_menu .= "</li>";
    
    if($c_sub > 0){echo $text_menu;}
  }
}
?>  
  
  
<?php
/*
 * MENU SEARCH
 */
foreach((array)$menus as $i => $value){
  
  if(FRIENDLY_ADMIN){
    $url = strtoupper(md5($value['id'])).".html";
  }else{
    $url = "app.php?mod=".strtoupper(md5($value['id']));
  }
  
  if(empty($menus_sub[$value['code']])){
    if($permiss['VIEW'][$value['id']]){
      echo "<li rel='{$value["shortname_$lang"]}' class='menusearch' style='display:none;'><a href='$url'><i class='menu-icon fa fa-chevron-right info'></i> <span class='menu-text'></span></a></li>";
    }
  }else{
    $c_sub = 0;
    $text_menu = "";
    
    foreach($menus_sub[$value['code']] as $j => $submenu){
      if($permiss['VIEW'][$submenu['id']]){
        $c_sub++;
        if(FRIENDLY_ADMIN){
          $url = strtoupper(md5($submenu['id'])).".html";
        }else{
          $url = "app.php?mod=".strtoupper(md5($submenu['id']));
        }

        $text_menu .= "<li rel='{$submenu["shortname_$lang"]}' class='menusearch' style='display:none;'><a href='$url' onclick=''><i class='menu-icon fa fa-chevron-right info'></i> <span class='menu-text'></span></a></li>";
      }
    }
    
    if($c_sub > 0){echo $text_menu;}
  }
}
?>      
</ul>
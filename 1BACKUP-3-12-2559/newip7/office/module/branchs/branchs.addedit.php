

<div class="tabbable">
  <ul class="nav nav-tabs tabs-flat">
    <li class="active"><a href="#tab_info" data-toggle="tab"><i class="fa fa-info-circle info"></i> ข้อมูล</a></li>
    <li><a href="#tab_pass" data-toggle="tab"><i class="fa fa-bitcoin info"></i> ค่าผ่านทาง</a></li>
    <li><a href="#tab_content_th" data-toggle="tab"><i class="fa fa-file-text-o info"></i> เนื้อหา<sup><i class="flag flag-th"></i><sup></a></li>
    <li><a href="#tab_content_en" data-toggle="tab"><i class="fa fa-file-text info"></i> เนื้อหา<sup><i class="flag flag-en"></i><sup></a></li>
    <li id="lnktab_image"><a href="#tab_image" data-toggle="tab"><i class="fa fa-picture-o info"></i> รูปภาพ</a></li>
    <li id="lnktab_vdo"><a href="#tab_vdo" data-toggle="tab"><i class="fa fa-play-circle-o info"></i> VDO</a></li>

  </ul>
  <div class="tab-content tabs-flat">
    <div class="tab-pane in active" id="tab_info">     
      <?php include "$mod.tabinfo.php"; ?>
    </div>
    <div class="tab-pane" id="tab_pass">
      <?php include "$mod.tabpass.php"; ?>
    </div>
    <div class="tab-pane" id="tab_content_th">
      <textarea id="content_th" name="content_th" class="mydata editor"></textarea>
    </div>
    <div class="tab-pane" id="tab_content_en">
      <textarea id="content_en" name="content_en" class="mydata editor"></textarea>
    </div>
    <div class="tab-pane" id="tab_image">
      <?php include "$mod.tabpic.php"; ?>
    </div>
    <div class="tab-pane" id="tab_vdo">
      <?php include "$mod.tabvdo.php"; ?>
    </div>
  </div>
</div>

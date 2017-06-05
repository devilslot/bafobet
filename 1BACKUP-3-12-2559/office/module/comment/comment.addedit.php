<div class="form-horizontal" role="form">
  <div class="col-sm-6 col-md-6 col-lg-6">  
    <?php
    $app->PushText('ชื่อบริษัท (TH)', 'name_th', 'mydata empty', 100);
    ?>
  </div>              
  <div class="col-sm-6 col-md-6 col-lg-6">  
    <?php
    $app->PushText('ชื่อบริษัท (EN)', 'name_en', 'mydata empty', 100);
    ?>
  </div>              
</div>
<div class="form-horizontal" role="form">
  <div class="col-sm-6 col-md-6 col-lg-6">  
    <?php
    $app->PushText('รหัสบริษัท', 'company_code', 'mydata empty', 100);
    ?>
  </div>              
  <div class="col-sm-6 col-md-6 col-lg-6">  
    <?php
    $app->PushRadio('การใช้งาน', 'enable', 'mydata', array('Y'=>'เปิด', 'N'=>'ปิด'));
    ?>
  </div>              
</div>
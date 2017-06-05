<div class="form-horizontal" role="form">
  <div class="col-sm-6">  
<?php
$app->PushText('ชื่อแผนก (TH)', 'name_th', 'mydata empty', 255);
?>
  </div>              
  <div class="col-sm-6">  
<?php
$app->PushText('ชื่อแผนก (EN)', 'name_en', 'mydata empty', 255);
$app->PushCheckbox('เปิดใช้งาน', 'enable', 'mydata');
?>
  </div>              

</div>
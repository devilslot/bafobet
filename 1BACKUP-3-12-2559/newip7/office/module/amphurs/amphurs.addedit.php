<div class="form-horizontal" role="form">
  <div class="col-sm-6">  
<?php
$app->PushText('อำเภอ (TH)', 'name_th', 'mydata empty', '100');
$app->PushText('อำเภอ (EN)', 'name_en', 'mydata', '100');
?>
  </div>              
  <div class="col-sm-6">  
<?php
$app->PushSelect('ภาค', 'geo_code', 'mydata empty');
$app->PushSelect('จังหวัด', 'province_code', 'mydata empty');
$app->PushCheckbox('เปิดใช้งาน', 'enable', 'mydata');
?>
  </div>     
</div>
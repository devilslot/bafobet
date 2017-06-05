<div class="form-horizontal" role="form">
  <div class="col-sm-6">  
<?php
$app->PushSelect('แผนก', 'depart_code', 'mydata empty');
$app->PushText('ชื่อตำแหน่ง (TH)', 'name_th', 'mydata', '100');
$app->PushText('ชื่อย่อตำแหน่ง (TH)', 'shortname_th', 'mydata', '100');
?>
  </div>              
  <div class="col-sm-6">  
<?php
$app->PushText('ชื่อตำแหน่ง (EN)', 'name_en', 'mydata', '100');
$app->PushText('ชื่อย่อตำแหน่ง (EN)', 'shortname_en', 'mydata', '100');
$app->PushCheckbox('เปิดใช้งาน', 'enable', 'mydata');
?>
  </div>     
</div>
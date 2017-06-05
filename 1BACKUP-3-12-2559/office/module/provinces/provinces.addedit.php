<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('จังหวัด (TH)', 'name_th', 'mydata empty', '100');
$app->PushText('จังหวัด (EN)', 'name_en', 'mydata', '100');
?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushSelect('ภาค', 'geo_code', 'mydata');
$app->PushCheckbox('แสดงผล', 'enable', 'mydata');
?>   
    </div>
  </div>
</div>
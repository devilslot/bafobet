<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$groups['CONTENT'] = 'CONTENT';
$groups['DEFINE'] = 'DEFINE';
$groups['ALERT'] = 'ALERT';

$app->PushText('ID', 'id', 'mydata empty', '100');
$app->PushSelect('Group', 'groups', 'mydata empty', $groups);
?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('Text (TH)', 'name_th', 'mydata empty', '255');
$app->PushText('Text (EN)', 'name_en', 'mydata', '255');
?>   
    </div>
  </div>
</div>

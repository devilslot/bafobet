<div class="form-horizontal" role="form">
  <div class="col-sm-6">  
<?php
$app->PushPassword('รหัสผ่านเดิม', 'old_pass', 'mydata empty', '100');
?>
  </div>              
  <div class="col-sm-6">  
<?php
$app->PushPassword('รหัสผ่านใหม่', 'new_pass', 'mydata empty', '100');
$app->PushPassword('รหัสผ่านใหม่ อีกครั้ง', 'new_pass_again', 'mydata empty', '100');
?>
  </div>              

</div>
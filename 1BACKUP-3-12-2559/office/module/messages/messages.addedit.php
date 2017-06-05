<div class="form-horizontal" role="form">
  <div class="col-sm-6 col-md-6 col-lg-6">  
    <?php
    $app->PushText('ข้อความ', 'msg', 'mydata', 100);
    $app->PushSelect('พนักงาน', 'emp_code', 'mydata');
    $app->PushText('Module', 'module', 'mydata', 100);
    $app->PushText('code', 'ref_code', 'mydata', 100);
    ?>
  </div>              
  <div class="col-sm-6 col-md-6 col-lg-6">  
    <?php
    $app->PushSelect('สถานะ', 'status', 'mydata', array('1'=>'รอเปิดอ่าน', '2'=>'อ่านแล้ว', '3'=>'ถังขยะ'));
    ?>
  </div>              
</div>
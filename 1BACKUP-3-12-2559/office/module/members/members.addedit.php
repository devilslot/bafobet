
<div class="tabbable">
  <ul class="nav nav-tabs tabs-flat">
    <li class="active"><a id="titletab_info" href="#tab_info" data-toggle="tab">ข้อมูล</a></li>
  </ul>

  <div class="tab-content tabs-flat">
    <div class="tab-pane in active" id="tab_info">
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('ชื่อ', 'firstname', 'mydata empty', '100');
            $app->PushText('อีเมลล์', 'email', 'mydata empty', '100');
            $app->PushText('Username', 'username', 'mydata empty', '100');

            ?>      
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('นามสกุล', 'lastname', 'mydata empty', '100');
            $app->PushText('เบอร์โทร', 'tel', 'mydata empty', '100');
            $app->PushText('Password', 'password', 'mydata empty', '100');
            $app->PushRadio('การใช้งาน', 'enable', 'mydata', array('Y'=>'เปิด', 'N'=>'ปิด'));
            ?>  


          </div>
        </div>
      </div>

    </div>

  </div>
</div>


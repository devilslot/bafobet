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
            $app->PushText('วันที่', 'date_match', 'mydata dpk empty', '100');
            $app->PushText('เซียนรอง', 'zean2', 'mydata  empty', '100');
            $app->PushRadio('การใช้งาน', 'enable', 'mydata', array('Y'=>'เปิด', 'N'=>'ปิด'));

            ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('เซียนต่อ', 'zean1', 'mydata  empty', '100');
            $app->PushText('เซียนหมู', 'zean3', 'mydata  empty', '100');
            ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushSelect('ผลเซียนต่อ', 'result_zean1', 'mydata empty');
            $app->PushSelect('ผลเซียนหมู', 'result_zean3', 'mydata empty');

            ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushSelect('ผลเซียนรอง', 'result_zean2', 'mydata empty');
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

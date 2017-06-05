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
             $app->PushText('งวดประจำวันที่', 'lotto_date', 'mydata dpk empty');
             $app->PushText('เลขหน้า 3 ตัว [1]', 'threedigitf1', 'mydata empty');
             $app->PushText('เลขท้าย 3 ตัว [1]', 'threedigitl1', 'mydata empty');
             $app->PushText('เลขท้าย 2 ตัว', 'twodigit', 'mydata empty');
            ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
             $app->PushText('รางวัลที่ 1', 'sixdigit', 'mydata empty');
            $app->PushText('เลขหน้า 3 ตัว [2]', 'threedigitf2', 'mydata empty');
            $app->PushText('เลขท้าย 3 ตัว [2]', 'threedigitl2', 'mydata empty');
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

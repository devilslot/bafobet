<div class="tabbable">
  <ul class="nav nav-tabs tabs-flat">
    <li class="active"><a id="titletab_info" href="#tab_info" data-toggle="tab">หมวดหมู่</a></li>
  </ul>
  <div class="tab-content tabs-flat">

    <div class="tab-pane in active" id="tab_info">
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('ชื่อยี่ห้อ (TH)', 'name_th', 'mydata empty', '100');
            $app->PushText('ชื่อยี่ห้อ (EN)', 'name_en', 'mydata empty', '100');
            ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushCheckBox('แสดงผล', 'enable', 'mydata');
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

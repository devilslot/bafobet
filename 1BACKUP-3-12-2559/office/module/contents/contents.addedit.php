<div class="tabbable">
  <ul class="nav nav-tabs tabs-flat">
    <li class="active"><a id="titletab_info" href="#tab_info" data-toggle="tab">ข้อมูล</a></li>
    <li><a href="#tab_content" data-toggle="tab">เนื้อหา</a></li>
  </ul>
  <div class="tab-content tabs-flat">
    <div class="tab-pane in active" id="tab_info">
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('รหัส', 'id', 'mydata empty', '30');
            $app->PushTextArea('Description', 'description_th', 'mydata');

            ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('Title', 'title_th', 'mydata');
            $app->PushTextArea('Keywords', 'keywords_th', 'mydata');
            ?>
          </div>
        </div>
      </div>

    </div>
    <div class="tab-pane" id="tab_content">
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('หัวข้อ ', 'name_th', 'mydata');
            ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushRadio('การใช้งาน', 'enable', 'mydata', array('Y'=>'เปิด', 'N'=>'ปิด'));
            ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushTextEditor('เนื้อหา', 'content_th', 'mydata editor');
            ?>
          </div>
        </div>
      </div>
    </div>

    
  </div>
</div>


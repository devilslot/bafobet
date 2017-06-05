<div class="form-title">ข้อมูลทั่วไป</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
//$app->PushText('รหัสอุทยาน', 'id', 'mydata', '20');
//$app->PushText('คะแนน', 'rating', 'mydata num');
      $branch_type['A']='อุทยาน';
      $branch_type['B']='วนอุทยาน';
      $app->PushSelect('ประเภท', 'branch_type', 'mydata empty', $branch_type);
      $app->PushSelect('สบอ.', 'paro_code', 'mydata empty');
      $app->PushSelect('สบอ. สาขา', 'paro_sub_code', 'mydata');
      ?>
<!--      <div id="dvtheme" class="form-group">
        <label class="col-sm-4 control-label no-padding-right">Theme : </label>
        <div class="col-sm-8">

          <div class="radiobox">
            <label>
              <input type="radio" name="theme" id="theme1" class="mydata colored-blueberry" rel="1" checked="checked" value=""> 
              <span class="text"> 1</span>
              <img src="<?php echo URL.'/images/p01.jpg';?>" width="100px" class="img-responsive" style="display:inline-block">
            </label>
          </div> 

          <div class="radiobox">
            <label>
              <input type="radio" name="theme" id="theme2" class=" colored-blueberry" rel="2" value=""> 
              <span class="text"> 2</span>
              <img src="<?php echo URL.'/images/p02.jpg';?>" width="100px" class="img-responsive" style="display:inline-block">
            </label>
          </div> 

          <div class="radiobox">
            <label>
              <input type="radio" name="theme" id="theme3" class=" colored-blueberry" rel="3" value=""> 
              <span class="text"> 3</span>
              <img src="<?php echo URL.'/images/p03.jpg';?>" width="100px" class="img-responsive" style="display:inline-block">
            </label>
          </div> 

        </div>
      </div>-->
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
      $app->PushSelect('จังหวัด', 'province_code', 'mydata empty');
      $app->PushTextArea('Tag (Ex : เทส1,เทส2)', 'tags', 'mydata', 5, 1);
      ?>   
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div id="dvtheme" class="form-group">
        <div class="col-sm-12">Theme : </div>
    </div>
  </div>
</div>
<div class="row">
    
        <div class="col-sm-4">
          <div class="radiobox">
            <label>
              <input type="radio" name="theme" id="theme1" class="mydata colored-blueberry" rel="1" checked="checked" value=""> 
              <span class="text"> 1</span>
              <img src="<?php echo URL.'/images/p01.jpg';?>" width="100px" class="img-responsive" style="display:inline-block">
            </label>
          </div> 
              </div>

        <div class="col-sm-4">
          <div class="radiobox">
            <label>
              <input type="radio" name="theme" id="theme2" class=" colored-blueberry" rel="2" value=""> 
              <span class="text"> 2</span>
              <img src="<?php echo URL.'/images/p02.jpg';?>" width="100px" class="img-responsive" style="display:inline-block">
            </label>
          </div> 
</div> 
          <div class="col-sm-4">
          <div class="radiobox">
            <label>
              <input type="radio" name="theme" id="theme3" class=" colored-blueberry" rel="3" value=""> 
              <span class="text"> 3</span>
              <img src="<?php echo URL.'/images/p03.jpg';?>" width="100px" class="img-responsive" style="display:inline-block">
            </label>
          </div> 
      </div>
    
</div>
<div class="clear"></div>
<br/>

<div class="form-title">ข้อมูล (ไทย)</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
      $app->PushText('ชื่อ (TH)', 'name_th', 'mydata empty', '100');
      $app->PushText('ชื่อย่อ (TH)', 'shortname_th', 'mydata empty', '100');
      ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
      $app->PushTextArea('เนื้อหาย่อ (TH)', 'shortcontent_th', 'mydata');
      $app->PushTextArea('ที่ติดต่อ (TH)', 'address_th', 'mydata');
      ?>   
    </div>
  </div>
</div>
<div class="clear"></div>
<br/>

<div class="form-title">ข้อมูล (English)</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
      $app->PushText('ชื่อ (EN)', 'name_en', 'mydata', '100');
      $app->PushText('ชื่อย่อ (EN)', 'shortname_en', 'mydata', '100');
      ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
      $app->PushTextArea('เนื้อหาย่อ (EN)', 'shortcontent_en', 'mydata');
      $app->PushTextArea('ที่ติดต่อ (TH)', 'address_en', 'mydata');
      ?>   
    </div>
  </div>
</div>      
<div class="clear"></div>
<br/>

<div class="form-title">สถานะ</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
      $app->PushText('วันเริ่มปิดอุทยาน', 'close_start', 'mydata dpk', '10');
      $app->PushText('สิ้นสุดปิดอุทยาน', 'close_stop', 'mydata dpk', '10');
      ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
      $app->PushCheckbox('แสดงผล', 'enable', 'mydata');
      ?>   
    </div>
  </div>
</div>      
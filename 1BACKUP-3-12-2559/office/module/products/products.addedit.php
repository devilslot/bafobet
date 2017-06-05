
<div class="tabbable">
  <ul class="nav nav-tabs tabs-flat">
    <li class="active"><a id="titletab_info" href="#tab_info" data-toggle="tab">Info</a></li>
    <li><a href="#tab_th" data-toggle="tab">เนื้อหา <i class="flag flag-th"></i></a></li>
    <li><a href="#tab_en" data-toggle="tab">เนื้อหา <i class="flag flag-en"></i></a></li>
    <li><a href="#tab_picture" data-toggle="tab">รูปภาพ</a></li>
  </ul>

  <div class="tab-content tabs-flat">
    <div class="tab-pane in active" id="tab_info">
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('รหัสสินค้า', 'id', 'mydata empty', '60');
            $app->PushText('ชื่อสินค้า (TH)', 'name_th', 'mydata empty', '100');
            $app->PushText('ชื่อสินค้า (EN)', 'name_en', 'mydata empty', '100');
            $app->PushSelect('หมวดหมู่', 'cat_code', 'mydata empty');
            $app->PushSelect('หมวดหมู่ย่อย', 'subcat_code', 'mydata');
            
            ?>      
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            
            $app->PushText('จำนวนสินค้า', 'quantity', 'mydata num empty');
            $app->PushText('ราคา', 'price', 'mydata num2 empty');
            $app->PushCheckbox('แสดงผล', 'enable', 'mydata');
            ?>  


          </div>
        </div>
      </div>

    </div>

    <div class="tab-pane" id="tab_th">

      <div class="row">
        <div class="col-md-12">
          <div class="form-horizontal" role="form">

            <?php
            $app->PushTextArea('เนื้อหาสินค้าย่อ (TH)', 'shortcontent_th', 'mydata', 5,2);
            $app->PushTextEditor('เนื้อหาสินค้าหลัก (TH)', 'content_th', 'mydata editor');
            ?>  

          </div>
        </div>
      </div>
    </div>

    <div class="tab-pane" id="tab_en">
      <div class="row">
        <div class="col-md-12">
          <div class="form-horizontal" role="form">

<?php
$app->PushTextArea('เนื้อหาสินค้าย่อ (EN)', 'shortcontent_en', 'mydata', 5,2);
$app->PushTextEditor('เนื้อหาสินค้าหลัก (EN)', 'content_en', 'mydata editor');
?>  

          </div>
        </div>
      </div>
    </div>

    <div class="tab-pane" id="tab_picture">
      <iframe id="uploadtarget" name="uploadtarget" src="" style="width:0px;height:0px;border:0"></iframe>
      <div class="row">
        <div class="col-md-6">
          <label class="col-sm-4"></label>
          <div class="col-sm-8">
            <a id="lnkUpload" href="../img/nopic.jpg" target="_blank"><img src="../img/nopic.jpg" class="img-responsive img-photo" /></a>
          </div>
        </div>
      </div>
      <br/>
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <form name="frmUpload" id="frmUpload" method="post" action="<?php echo "module/$mod/$mod.upload.php";?>" enctype="multipart/form-data" target="uploadtarget" style="margin:0;" onsubmit="return me.UploadPic.Submit();">
              <div id="dvfilepic" class="form-group">
                <label id="lblfilepic" for="filepic" class="col-sm-4 control-label" style="white-space:nowrap">ไฟล์ภาพ :</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input class="form-control" id="fileupload" name="fileupload" type="file" />
                    <span class="input-group-btn"> 
                      <button id="btnUpload" class="btn btn-info" type="submit" style="padding:5px;"><i class="fa fa-upload"></i> Upload</button> 
                      <button type="button" id="btnLoading" style="display:none;padding:5px;" class="btn btn-default"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                      <button type="button" id="btnfiledel" style="display:none; padding:5px;" class="btn btn-danger" onclick="me.UploadPic.Clear();"><i class="fa fa-times"></i></button>
                    </span>
                  </div>        
                </div>
              </div>  
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
<?php
$app->PushText('ชื่อรูปภาพ', 'filepic', 'mydata readonly', '100');
?>
          </div>
        </div>
      </div>
    </div><!-- $check -->


  </div>
</div>


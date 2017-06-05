<iframe id="uploadtarget" name="uploadtarget" src="" style="width:0px;height:0px;border:0"></iframe>

<div class="alert alert-warning"><i class="fa fa-warning danger"></i> Open permission 777 Folder <b>/temp</b></div>
<div class="row">
  <div class="col-md-6">
      <form name="frmUpload" id="frmUpload" method="post" action="<?php echo "module/$mod/$mod.upload.php"; ?>" enctype="multipart/form-data" target="uploadtarget" style="margin:0;" onsubmit="return me.Upload.Submit();">
        <div id="dvfiledoc" class="form-group">
          <label id="lblfiledoc" for="fileupload" class="col-sm-5 control-label" style="white-space:nowrap">
            ไฟล์แนบ (.xls เท่านั้น) [<a href="module/import/example.xls">ตัวอย่าง</a>] :</label>
          <div class="col-sm-7">
            <div class="input-group">
              <input class="form-control" id="fileupload" name="fileupload" type="file" />
              <span class="input-group-btn"> 
                <button id="btnUpload" class="btn btn-info" type="submit" style="padding:5px;"><i class="fa fa-upload"></i> Upload</button> 
                <button type="button" id="btnLoading" style="display:none;padding:5px;" class="btn btn-default"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
              </span>
            </div>   
          </div>
        </div> 
      </form>
  </div>
</div>
<br/>
    
<div class="row" id="lyUpload" style="display:none;">
  <hr/>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('ชื่อตาราง', 'tablename', 'empty', '100');
?>
    </div> 
    <div class="form-group">
      <label class="col-sm-4 control-label" style="text-align:right;">ไฟล์ข้อมูล :</label>
      <div class="col-sm-8">
        <div id="excel_file"></div>
        <br/>
        <div>
          <button type="button" onclick="me.CreateTable();" class="btn btn-success"><i class="fa fa-plus-square"></i> Create table</button>
          <button type="button" onclick="me.Import();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Import data</button>
        </div>
      </div>
    </div>   
  </div>
</div>
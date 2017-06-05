

<div class="row">
  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
      <div class="widget">
        <div class="widget-header">
          <span class="widget-caption"><i class="fa fa-upload sky"></i> อัพโหลด</span>
        </div><!--Widget Header-->
        <div class="widget-body">
    <form name="frm" id="frm" role="form" method="post" action="app.uploadvdo.php?mod=<?php echo $mod; ?>" enctype="multipart/form-data" target="uploadtarget" style="margin:0;" onsubmit="return me.UploadVdo.Submit();" novalidate>  
      <div class="form-group">
        <label class="control-label" for="">ชื่อ VDO<sup><i class="fa fa-star danger"></i></sup></label>
        <span class="input-icon">
          <input type="text" class="form-control input-sm" id="file_name" name="file_name" />
          <i class="fa fa-play-circle-o blue"></i>
        </span>
      </div>
      <div class="form-group">
        <label class="control-label" for="">ไฟล์ VDO (.mp4 เท่านั้น)<sup><i class="fa fa-star danger"></i></sup></label>
        <span class="input-icon">
          <input type="file" class="form-control input-sm" id="file_vdo" name="file_vdo" />
          <i class="fa fa-video-camera blue"></i>
        </span>
      </div>
      <div class="form-group">
        <label class="control-label" for="">ไฟล์ ภาพประกอบ (.jpg เท่านั้น) <sup><i class="fa fa-star danger"></i></sup></label>
        <span class="input-icon">
          <input type="file" class="form-control input-sm" id="file_pic" name="file_pic" />
          <i class="fa fa-image blue"></i>
        </span>
      </div>
      <hr/>
      <div class="text-right">
        <button id="btnvdo_submit" type="submit" class="btn btn-lg btn-default darkorange"><i class="fa fa-upload"></i> อัพโหลด</button>
        <button id="btnvdo_loading" style="display:none;" type="button" class="btn btn-lg btn-default"><i class="fa fa-spin fa-spinner"></i> กำลังอัพโหลด</button>
      </div>
      <input type="hidden" id="upload_code" name="code" />
    </form>      
        </div><!--Widget Body-->
      </div>
    </div>
  </div>
</div>
<iframe id="uploadtarget" name="uploadtarget" src="" style="width:0px;height:0px;border:0"></iframe>

<hr/>
 
<div class="row" id="tbUpload_vdo">

</div>

<div id="modelvdo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" onclick="me.UploadVdo.Close();">×</button>
        <h4 class="modal-title"><i class="fa fa-picture-o info"></i> <span id="modelvdo_title"></span></h4>
      </div>
      <div class="modal-body text-center" id="modelvdo_file">

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
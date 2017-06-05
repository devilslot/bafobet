<div class="row">
  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    <div class="col-md-3">
    <div class="widget">
      <div class="widget-header bordered-left bordered-themefifthcolor">
        <span class="widget-caption"><i class="fa fa-picture-o sky"></i> รูปหลัก</span>
        <div class="widget-buttons">
          <a href="javascript:me.Upload.DelPin();">
            <i class="fa fa-times red"></i>
          </a>
        </div>
      </div>
      <div class="widget-body bordered-left bordered-darkorange">
        <img id="pinFilepic" src="../img/nopic.jpg" class="img-responsive" />
        <input type="text" id="filepic" name="filepic" class="mydata readonly form-control input-sm" style="width:100%;" />
      </div>
    </div>
    </div>  
    <div class="col-md-3">
      <div class="widget">
      <div class="widget-header bordered-left bordered-themefifthcolor">
        <span class="widget-caption"><i class="fa fa-picture-o sky"></i> รูปแผนที่</span>
        <div class="widget-buttons">
          <a href="javascript:me.Upload.DelPinMap();">
            <i class="fa fa-times red"></i>
          </a>
        </div>
      </div>
      <div class="widget-body bordered-left bordered-darkorange">
        <img id="pinFilemap" src="../img/nopic.jpg" class="img-responsive" />
        <input type="text" id="filemap" name="filemap" class="mydata readonly form-control input-sm" style="width:100%;" />
      </div>
    </div>
  </div>
    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
      <div class="widget">
        <div class="widget-header">
          <span class="widget-caption"><i class="fa fa-upload sky"></i> อัพโหลด</span>
        </div><!--Widget Header-->
        <div class="widget-body">
          <div id="uploader"></div> 
        </div><!--Widget Body-->
      </div>
    </div>
  </div>
</div>

<hr/>
 
<div class="row" id="tbUpload">

</div>

<div id="modelpic" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><i class="fa fa-picture-o info"></i> <span id="modelpic_title"></span></h4>
      </div>
      <div class="modal-body" id="modelpic_img">
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<div class="row">
 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    <div class="widget radius-bordered collapsed">
      <div class="widget-header">
        <span class="widget-caption">
          <div class="form-group">
            <span class="input-icon">
              <input class="form-control input-sm mydata" id="name" name="name" type="text" placeholder="Folder" maxlength="100" />
              <i class="fa fa-folder danger circular"></i>

            </span>

          </div>
        </span>
        <div id="tooladd" class="widget-buttons buttons-bordered">
          <?php if($per_add){?>
          <a href="#" id="btnAddSave" onclick="me.Add();">
            <i class="fa fa-save green"></i> <?php echo $define['SAVE'];?>
          </a>
          <?php } ?>
        </div>
        <div id="tooledit" class="widget-buttons buttons-bordered">
          <?php if($per_edit){?>
          <a href="#" id="btnEditSave" onclick="me.Edit();">
            <i class="fa fa-save green"></i> <?php echo $define['SAVE'];?>
          </a>
          <?php } ?>
        </div>
        <div class="widget-buttons buttons-bordered">
          <a href="#" data-toggle="collapse">
            <i class="fa fa-plus blue"></i> Upload
          </a>
        </div>
      </div>

      <div class="widget-body">
        <div id="uploader"></div> 
      </div>
    </div>
  </div>
</div>

 
<div class="row">
 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    <table class="table table-hover table-bordered">
      <thead class="bordered-darkorange">
        <tr>
          <th class="text-center">No.</th>
          <th class="text-center">Name</th>
          <th class="text-center">Type</th>
          <th class="text-center">Url</th>
          <th class="text-center">&nbsp;</th>
        </tr>
      </thead>
      <tbody id="tbUpload">

      </tbody>
    </table>
  </div>
</div>

<div class="clear"></div>
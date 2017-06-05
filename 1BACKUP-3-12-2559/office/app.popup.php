 <!--Success Modal Templates-->
    <div id="popup-success" class="modal modal-message modal-success fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="glyphicon glyphicon-check"></i>
                </div>
                <div class="modal-title"><?php echo $alert['ALERT']; ?></div>

                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!--End Success Modal Templates-->
    <!--Info Modal Templates-->
    <div id="popup-info" class="modal modal-message modal-info fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="modal-title"><?php echo $alert['ALERT']; ?></div>

                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
                </div>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!--End Info Modal Templates-->
    <!--Danger Modal Templates-->
    <div id="popup-danger" class="modal modal-message modal-danger fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="glyphicon glyphicon-fire"></i>
                </div>
                <div class="modal-title"><?php echo $alert['ALERT']; ?></div>

                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
                </div>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!--End Danger Modal Templates-->
    <!--Danger Modal Templates-->
    <div id="popup-warning" class="modal modal-message modal-warning fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-warning"></i>
                </div>
                <div class="modal-title"><?php echo $alert['ALERT']; ?></div>

                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">OK</button>
                </div>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!--End Danger Modal Templates-->



<?php if($permiss['ADD'][$mod]){ ?>
<!-- Template -->
<div id="popup-add" class="modal fade" tabindex="-1" role="dialog" style="display:none;">
  <div class="modal-dialog modal-sm animated bounceInDown">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title darkorange">
          <i class="fa fa-warning"></i>
                <?php echo $alert['ALERT']; ?></h4>
      </div>
      <div class="modal-body"><?php echo $alert['CALLADD']; ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $define['CANCEL']; ?></button>
        <button type="button" class="btn btn-primary" onclick="me.Add();"><?php echo $define['OK']; ?></button>
      </div>
    </div><!-- / .modal-content -->
  </div><!-- / .modal-dialog -->
</div>
<!-- / Template -->
<?php } if($permiss['EDIT'][$mod]){ ?>
<!-- Template -->
<div id="popup-edit" class="modal fade" tabindex="-1" role="dialog" style="display:none;">
  <div class="modal-dialog modal-sm animated bounceInDown">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title darkorange">
          <i class="fa fa-warning"></i>
                <?php echo $alert['ALERT']; ?></h4>
      </div>
      <div class="modal-body"><?php echo $alert['CALLEDIT']; ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $define['CANCEL']; ?></button>
        <button type="button" class="btn btn-primary" onclick="me.Edit();"><?php echo $define['OK']; ?></button>
      </div>
    </div><!-- / .modal-content -->
  </div><!-- / .modal-dialog -->
</div>
<!-- / Template -->
<?php } if($permiss['DEL'][$mod]){ ?>
<!-- Template -->
<div id="popup-del" class="modal fade" tabindex="-1" role="dialog" style="display:none;">
  <div class="modal-dialog modal-sm animated bounceInDown">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title darkorange">
          <i class="fa fa-warning"></i>
                <?php echo $alert['ALERT']; ?></h4>
      </div>
      <div class="modal-body"><?php echo $alert['CALLDEL']; ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $define['CANCEL']; ?></button>
        <button type="button" class="btn btn-primary" onclick="me.DelEdit();"><?php echo $define['OK']; ?></button>
      </div>
    </div><!-- / .modal-content -->
  </div><!-- / .modal-dialog -->
</div>
<!-- / Template -->
<!-- Template -->
<div id="popup-delview" class="modal fade" tabindex="-1" role="dialog" style="display:none;">
  <div class="modal-dialog modal-sm animated bounceInDown">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title darkorange">
          <i class="fa fa-warning"></i>
        <?php echo $alert['ALERT']; ?></h4>
      </div>
      <div class="modal-body"><?php echo $alert['CALLDEL']; ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $define['CANCEL']; ?></button>
        <button type="button" class="btn btn-primary" onclick="me.DelViewOpen();"><?php echo $define['OK']; ?></button>
      </div>
    </div><!-- / .modal-content -->
  </div><!-- / .modal-dialog -->
</div>
<!-- / Template -->
<?php } ?>

<!-- Large modal -->
<div id="popup-view" class="modal fade" tabindex="-1" role="dialog" style="display:none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="view-header"><?php echo $define['VIEW'];?> #<span id="view_code"></span></h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped" style="clear:both">
          <tbody id="tb-view">
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <?php if($permiss['EDIT'][$mod]){ ?>
        <button id="btnViewOpenEdit" type="button" onclick="me.LoadEditView();" class="btn btn-success"><i class="fa fa-edit"></i> <?php echo $define['OPEN'];?></button>
        <?php } if($permiss['DEL'][$mod]){ ?>
        <button id="btnViewOpenDel" type="button" onclick="me.DelViewPopup();" class="btn btn-danger"><i class="fa fa-trash-o"></i> <?php echo $define['DEL'];?></button>
        <?php } ?>
      </div>
    </div> <!-- / .modal-content -->
  </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->
<!-- / Large modal -->
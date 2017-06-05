
<!-- Page Content -->
<div class="page-content">
  <!-- Page Breadcrumb -->
  <div class="page-breadcrumbs">
    <ul class="breadcrumb">
      <li>
        <a href="app.php?mod=home"><?php echo $text['HOME']; ?></a>
      </li>
      <?php if(!empty($parentmenu)){ ?>
      <li><?php echo $parentmenu["name_$lang"];?></li>
      <?php } ?>
      <li class="active"><?php echo $mymenu["name_$lang"]; ?></li>
    </ul>
  </div>
  <!-- /Page Breadcrumb -->
  <!-- Page Header -->
  <div class="page-header position-relative">
    <div class="header-title">
      <h1>
        <i class="fa <?php echo (empty($parentmenu))?$mymenu['icon']:$parentmenu['icon'];?>"></i>
        <span id="ModTitle"><?php echo $mymenu["name_$lang"]; 
        if(DEBUG){
          echo " [$mod]";
        }
        ?></span>
      </h1>
    </div>
    <!--Header Buttons-->
    <div class="header-buttons">
      <a class="fullscreen" id="fullscreen-toggler" href="#">
        <i class="glyphicon glyphicon-fullscreen"></i>
      </a>
      <a class="exportexcel" href="#" onclick="me.ExportExcel();">
        <i class="glyphicon glyphicon-export"></i>
      </a>
      <a class="sidebar-toggler" href="#">
        <i class="fa fa-arrows-h"></i>
      </a>
      <a href="javascript:;" class="refresh" onclick="me.ViewList();">
        <i class="fa fa-list-alt"></i>
      </a>
    </div>
    <!--Header Buttons End-->
  </div>
  <!-- /Page Header -->
  <!-- Page Body -->
  <div id="tabviewlist" class="page-body">
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <div class="widget">
          <div class="widget-header  with-footer" style="padding-left:0;">
            <div class="col-sm-3" style="padding-top:5px;">
              <div class="btn-group" style="width:100%;">
                <button id="btnGroupLimit" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <?php echo $text['DISPLAY'];?> &nbsp;&nbsp;10 <?php echo $text['ROW'];?> <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupLimit">
                  <li><a id="limit_10" href="javascript:;" onclick="me.Limit(10, this);"><?php echo $text['DISPLAY'];?> &nbsp;&nbsp;10 <?php echo $text['ROW'];?></a></li>
                  <li><a id="limit_50" href="javascript:;" onclick="me.Limit(50, this);"><?php echo $text['DISPLAY'];?> &nbsp;&nbsp;50 <?php echo $text['ROW'];?></a></li>
                  <li><a id="limit_100" href="javascript:;" onclick="me.Limit(100, this);"><?php echo $text['DISPLAY'];?> 100 <?php echo $text['ROW'];?></a></li>
                  <li><a id="limit_500" href="javascript:;" onclick="me.Limit(500, this);"><?php echo $text['DISPLAY'];?> 500 <?php echo $text['ROW'];?></a></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-9" style="padding-top:5px; margin-bottom:0; text-align:right;">
              <div class="dataTables_paginate paging_bootstrap" style="">
                <ul class="pagination" id="lyPage">

                </ul>
              </div>
            </div>
            <div class="clear"></div>

          </div>
          <div class="widget-body">
            <div id="ViewSearch" class="row">
              <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="widget flat" style="margin-bottom:10px;">
                  <div id="SearchHeadCollapse" class="widget-header bordered-bottom bordered-themesecondary">
                    <span class="widget-caption" style="font-size:15px;"><i class="fa fa-search"></i> <?php echo $text['TOOL_SEARCH']; ?></span>

                    <div class="widget-buttons">
                      <a id="SearchCollapse" href="#">
                        <i class="fa fa-minus"></i>
                      </a>
                    </div>
                  </div>

                  <div class="widget-body">
                    <form id="frmSearch" method="post" action=" " onsubmit="return false;">
                      <div class="form-horizontal" role="form" id="ViewSetSearch">

                      </div>
                      <div class="clear"></div>
                      <hr style="margin-top:0; margin-bottom:15px;" />
                      <div class="text-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="flip-scroll">
              <table class="table table-bordered table-striped table-condensed flip-content">
                <thead id="thView" class="flip-content bordered-blue">
                </thead>

                <tbody id="tbView" style="display:none;">
                </tbody>
              </table>
            </div>

            <div class="row" id="PageBottom" style="padding-top:5px; text-align:right; display:none;">
              <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="dataTables_paginate paging_bootstrap" style="">
                  <ul class="pagination" id="lyPageBtm">

                  </ul>
                </div>
              </div>
            
              <div class="clear"></div>
            </div>

          </div>

        </div>
      </div>
    </div>      

  </div>

  <div id="tabaddedit" style="display:none;" class="page-body">

    <div class="row">
      <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget" style="margin-bottom:10px;">
          <div id="SearchHeadCollapse" class="widget-header bordered-bottom bordered-themeprimary">
            <span class="widget-caption" style="font-size:15px;" id="addedit_title"></span>
            <div class="widget-buttons buttons-bordered" id="addedit_back">
              <button id="btnEditBack" onclick="me.ViewList();" class="btn btn-warning btn-xs" type="button"><i class="fa fa-arrow-circle-left"></i>
                <?php echo $define['BACK'];?>
              </button>
            </div>
            <div class="widget-buttons buttons-bordered" id="addedit_pointer">
              <button id="btnEditFirst" onclick="me.First();" class="btn btn-primary btn-xs" type="button"><i class="fa fa-fast-backward"></i></button>
              <button id="btnEditPrev" onclick="me.Prev();" class="btn btn-primary btn-xs" type="button"><i class="fa fa-step-backward"></i></button>
              <button id="btnEditNext" onclick="me.Next();" class="btn btn-primary btn-xs" type="button"><i class="fa fa-step-forward"></i></button>
              <button id="btnEditLast" onclick="me.Last();" class="btn btn-primary btn-xs" type="button"><i class="fa fa-fast-forward"></i></button>
            </div>
            <div class="widget-buttons buttons-bordered" id="addedit_del">
              <?php if($per_del){?>
                <button id="btnEditDel" onclick="me.DelEdit();" class="btn btn-darkorange btn-xs" type="button"><i class="fa fa-trash-o"></i>
                  <?php echo $define['DEL'];?>
                </button>
              <?php } if($per_add){?>
                <button id="btnEditAdd" onclick="me.New();" class="btn btn-info btn-xs" type="button"><i class="fa fa-plus-circle"></i>
                  <?php echo $define['ADD'];?>
                </button>
              <?php }?>
            </div>
          </div>

          <div class="widget-body" id="lyAddEdit">
            <?php include "module/$mod/$mod.addedit.php";?>
            <div class="clear"></div>
            <hr style="margin-top:0; margin-bottom:15px;" />

            <div id="tooladd" class="text-right">

              <?php if($per_add){?>
                <button id="btnAddSave" onclick="me.Add();" class="btn btn-primary" type="button"><i class="fa fa-save"></i>
                  <?php echo $define['SAVE'];?>
                </button>
              <?php } ?>
              <button id="btnAddClear" onclick="me.Clear();" class="btn btn-primary" type="button"><i class="fa fa-file"></i>
                <?php echo $define['CLEAR'];?>
              </button>
            </div>              

            <div id="tooledit" class="text-right">

              <?php if($per_edit){?>
                <button id="btnEditSave" onclick="me.Edit();" class="btn btn-primary" type="button"><i class="fa fa-save"></i>
                  <?php echo $define['SAVE'];?>
                </button>
              <button id="btnEditClear" onclick="me.Clear();" class="btn btn-primary" type="button"><i class="fa fa-file"></i>
                <?php echo $define['CLEAR'];?>
              </button>
              <button id="btnEditSave" onclick="me.Copy();" class="btn btn-primary" type="button"><i class="fa fa-copy"></i>
                <?php echo $define['COPY'];?>
              </button>
              <?php } ?>
            </div>              

          </div>
        </div>
      </div>

    </div>    


    <div class="row" id="lyStatus" style="display:none;">
      <div class="col-lg-2 col-xs-2 col-sm-2">
        <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
          <div class="databox-top bg-themesecondary">
            <div class="databox-icon">
              <i class="fa fa-bullseye"></i> 
            </div>
          </div>
          <div class="databox-bottom text-align-center">
            <span class="databox-text"><b><?php echo $text['ID']; ?></b></span>
            <span class="databox-text"><input id="code" type="text" class="txtstatus" disabled="disabled" /></span>
          </div>
        </div>
      </div>                    
      <div class="col-lg-2 col-xs-2 col-sm-2">
        <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
          <div class="databox-top bg-themethirdcolor">
            <div class="databox-icon">
              <i class="fa fa-bell-o"></i> 
            </div>
          </div>
          <div class="databox-bottom text-align-center">
            <span class="databox-text"><b><?php echo $text['STATUS'];?></b></span>
            <span class="databox-text" id="text-status"></span>
          </div>
        </div>
      </div>                    
      <div class="col-lg-2 col-xs-2 col-sm-2">
        <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
          <div class="databox-top bg-themefourthcolor">
            <div class="databox-icon">
              <i class="fa fa-user"></i> 
            </div>
          </div>
          <div class="databox-bottom text-align-center">
            <span class="databox-text"><b><?php echo $text['USERCREATE']; ?></b></span>
            <span class="databox-text"><input id="user_create" type="text" class="txtstatus" disabled="disabled" /></span>
          </div>
        </div>
      </div>                    
      <div class="col-lg-2 col-xs-2 col-sm-2">
        <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
          <div class="databox-top bg-themefourthcolor">
            <div class="databox-icon">
              <i class="fa fa-user"></i> 
            </div>
          </div>
          <div class="databox-bottom text-align-center">
            <span class="databox-text"><b><?php echo $text['USERUPDATE']; ?></b></span>
            <span class="databox-text"><input id="user_update" type="text" class="txtstatus" disabled="disabled" /></span>
          </div>
        </div>
      </div>                    
      <div class="col-lg-2 col-xs-2 col-sm-2">
        <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
          <div class="databox-top bg-themefifthcolor">
            <div class="databox-icon">
              <i class="fa fa-clock-o"></i> 
            </div>
          </div>
          <div class="databox-bottom text-align-center">
            <span class="databox-text"><b><?php echo $text['DATECREATE']; ?></b></span>
            <span class="databox-text"><input id="date_create" type="text" class="txtstatus datetime" disabled="disabled" /></span>
          </div>
        </div>
      </div>                    
      <div class="col-lg-2 col-xs-2 col-sm-2">
        <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
          <div class="databox-top bg-themefifthcolor">
            <div class="databox-icon">
              <i class="fa fa-clock-o"></i> 
            </div>
          </div>
          <div class="databox-bottom text-align-center">
            <span class="databox-text"><b><?php echo $text['DATEUPDATE']; ?></b></span>
            <span class="databox-text"><input id="date_update" type="text" class="txtstatus datetime" disabled="disabled" /></span>
          </div>
        </div>
      </div>                    
    </div>    

  </div>
  <!-- /Page Body -->
</div>
<!-- /Page Content -->


<? 
  $ifm = strtoupper(md5('datafields')); 
  if(FRIENDLY_ADMIN){
    $url = $ifm.'.html';
  }else{
    $url = 'app.php?mod='.$ifm;
  }
?>
<div class="modal fade bs-example-modal-lg" id="ModalSub" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:95%;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Field</h4>
            </div>
            <div class="modal-body">
               <iframe id="ifmchild" name="ifmchild" src="<?php echo $url ?>" style="width:100%; height:600px; border:0;"></iframe>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<input type="hidden" id="sortby" value="code" />
<input type="hidden" id="sortorder" value="desc" />
<input type="hidden" id="firstcode" value="" />
<input type="hidden" id="prevcode" value="" />
<input type="hidden" id="nextcode" value="" />
<input type="hidden" id="lastcode" value="" />
<input type="hidden" id="cboLimit" value="10" />
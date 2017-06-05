
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
      <a class="sidebar-toggler" href="#">
        <i class="fa fa-arrows-h"></i>
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

  <div id="tabaddedit" class="page-body">

    <div class="row">
      <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget" style="margin-bottom:10px;">
          <div id="SearchHeadCollapse" class="widget-header bordered-bottom bordered-themeprimary">
            <span class="widget-caption" style="font-size:15px;" id="addedit_title"></span>

          </div>

          <div class="widget-body" id="lyAddEdit">
            <?php include "module/$mod/$mod.addedit.php";?>
            <div class="clear"></div>
            <hr style="margin-top:0; margin-bottom:15px;" />

            <div id="tooledit" class="text-right">

              <?php if($per_edit){?>
                <button id="btnEditSave" onclick="me.Edit();" class="btn btn-primary" type="button"><i class="fa fa-save"></i>
                  <?php echo $define['SAVE'];?>
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

<input type="hidden" id="sortby" value="code" />
<input type="hidden" id="sortorder" value="desc" />
<input type="hidden" id="firstcode" value="" />
<input type="hidden" id="prevcode" value="" />
<input type="hidden" id="nextcode" value="" />
<input type="hidden" id="lastcode" value="" />
<input type="hidden" id="cboLimit" value="10" />
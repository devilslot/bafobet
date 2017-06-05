<div id="content-viewlist" class="page-body" style="display:none;">
  <div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
      <div class="widget flat radius-bordered">
        <div class="widget-header bordered-bottom bordered-themeprimary">
          <span class="widget-caption"><i class="fa fa-th-list info"></i> <?php echo $define['VIEW'];?></span>

          <div id="ZoneViewNew" class="widget-buttons buttons-bordered">
            <button id="btnViewNew" onclick="me.New();" class="btn btn-blue btn-xs shiny"><i class="fa fa-plus-circle"></i> <?php echo $define['ADD'];?></button>
          </div>
        </div>
        <div class="widget-body">
          <div class="widget-main no-padding">
            <div id="row_search" class="panel-group accordion">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#row_search" href="#collapse_search" aria-expanded="true">
                      <i class="fa fa-search"></i> <?php echo $define['SEARCH'];?>
                    </a>
                  </h4>
                </div>
                <div id="collapse_search" class="panel-collapse collapse" aria-expanded="true">
                  <div class="panel-body bg-white" style="border-left:0;">
                    <form id="frmSearch" method="post" action=" " onsubmit="return false;">
                      <div class="form-horizontal" role="form" id="ViewSetSearch">

                      </div>
                      <div class="clear"></div>
                      <hr style="margin-top:65px; margin-bottom:25px;" />
                      <div class="text-right">
                        <button type="submit" class="btn btn-primary shiny"><i class="fa fa-search"></i> <?php echo $define['SEARCH'];?></button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div id="row_limit" class="row margin-bottom-10">
              <span id="block_limit" class="col-xs-6">
                <div class="btn-group btn-group-xs">
                  <button id="btnGroupLimit" class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                    <?php echo $text['DISPLAY'];?> &nbsp;&nbsp;10 <?php echo $text['ROW'];?>
                    <span class="fa fa-caret-down"></span></button>
                  <ul class="dropdown-menu">
                    <li><a id="limit_10" href="javascript:;" onclick="me.Limit(10, this);"><?php echo $text['DISPLAY'];?> &nbsp;&nbsp;10 <?php echo $text['ROW'];?></a></li>
                    <li><a id="limit_50" href="javascript:;" onclick="me.Limit(50, this);"><?php echo $text['DISPLAY'];?> &nbsp;&nbsp;50 <?php echo $text['ROW'];?></a></li>
                    <li><a id="limit_100" href="javascript:;" onclick="me.Limit(100, this);"><?php echo $text['DISPLAY'];?> 100 <?php echo $text['ROW'];?></a></li>
                    <li><a id="limit_500" href="javascript:;" onclick="me.Limit(500, this);"><?php echo $text['DISPLAY'];?> 500 <?php echo $text['ROW'];?></a></li>
                  </ul> <!-- / .dropdown-menu -->
                </div>
              </span>
              <div id="block_record" class="col-xs-6 text-align-right">
                <div class="badge badge-danger">
                  <span id="ViewRecord" class=""></span> &nbsp; <?php echo $text['ROW'];?>            
                </div>
              </div> <!-- / .panel-heading-controls -->
              <div class="clear"></div>
            </div> <!-- / .panel-heading -->


            <div id="PageTop" class="text-right">
              <ul class="pagination pagination-xs" id="lyPage">

              </ul>
            </div>
            <table class="table table-bordered table-striped table-condensed table-hover flip-content">

              <thead id="thView" class="flip-content bordered-blue">
              </thead>
              <tbody id="tbView">
              </tbody>
            </table>

            <div id="PageBottom" class="text-right margin-top-5">
              <ul class="pagination" id="lyPageBtm">

              </ul>
            </div> <!-- end view -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="content-addedit" class="page-body no-margin-bottom no-padding-bottom" style="display:none;">
  <div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
      <div class="widget flat radius-bordered no-margin-bottom">
        <div class="widget-header bordered-bottom bordered-themeprimary">
          <span id="add_title" class="widget-caption"><i class="fa fa-plus-circle warning"></i> <?php echo $define['ADD']; ?></span>
          <span id="edit_title" class="widget-caption"><i class="fa fa-edit success"></i> <?php echo $define['EDIT']; ?></span>

          <div class="widget-buttons buttons-bordered" id="addedit_back">
            <button id="btnEditBack" onclick="me.View();" class="btn btn-warning btn-xs" type="button"><i class="fa fa-arrow-circle-left"></i>
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
            <?php if($per_add){?>
              <button id="btnEditAdd" onclick="me.New();" class="btn btn-info btn-xs" type="button"><i class="fa fa-plus-circle"></i>
                <?php echo $define['ADD'];?>
              </button>
            <?php }?>
          </div>
        </div>
        <div class="widget-body">
          <div class="widget-main no-padding">
            <div id="tabaddedit">
              <div id="lyAddEdit">
                <?php include "module/$mod/$mod.addedit.php";?>
              </div>
              <div class="clear"></div>
              <hr style="margin-top:0; margin-bottom:15px;" />

              <div id="tooladd" class="text-right">

                <?php if($per_add){?>
                  <button id="btnAddSave" onclick="me.AddCheck();" class="btn btn-primary" type="button"><i class="fa fa-save"></i>
                    <?php echo $define['SAVE'];?>
                  </button>
                <?php }?>
                <button id="btnAddClear" onclick="me.Clear();" class="btn btn-primary" type="button"><i class="fa fa-file"></i>
                  <?php echo $define['CLEAR'];?>
                </button>
              </div>              

              <div id="tooledit" class="text-right" style="display:none;">

                <?php if($per_edit){?>
                  <button id="btnEditSave" onclick="me.EditCheck();" class="btn btn-primary" type="button"><i class="fa fa-save"></i>
                    <?php echo $define['SAVE'];?>
                  </button>
                  <button id="btnEditClear" onclick="me.Clear();" class="btn btn-primary" type="button"><i class="fa fa-file"></i>
                    <?php echo $define['CLEAR'];?>
                  </button>
                  <button id="btnEditCopy" onclick="me.Copy();" class="btn btn-primary" type="button"><i class="fa fa-copy"></i>
                    <?php echo $define['COPY'];?>
                  </button>
                <?php }?>
                <?php if($per_del){?>
                  <button id="btnEditDel" onclick="me.DelPopup();" class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i>
                    <?php echo $define['DEL'];?>
                  </button>
                <?php }?>
              </div>      

            </div> <!-- end add-edit -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="content-status" class="page-body" style="display:none;">
  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
        <div class="databox-top bg-themesecondary">
          <div class="databox-icon">
            <i class="fa fa-bullseye"></i> 
          </div>
        </div>
        <div class="databox-bottom text-align-center">
          <span class="databox-text"><b><?php echo $text['ID'];?></b></span>
          <span class="databox-text" id="status_code"></span>
        </div>
      </div>
    </div>                    
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
        <div class="databox-top bg-themethirdcolor">
          <div class="databox-icon">
            <i class="fa fa-bell-o"></i> 
          </div>
        </div>
        <div class="databox-bottom text-align-center">
          <span class="databox-text"><b><?php echo $text['STATUS'];?></b></span>
          <span class="databox-text" id="status_enable"></span>
        </div>
      </div>
    </div>                    
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
        <div class="databox-top bg-themefourthcolor">
          <div class="databox-icon">
            <i class="fa fa-user"></i> 
          </div>
        </div>
        <div class="databox-bottom text-align-center">
          <span class="databox-text"><b><?php echo $text['USERCREATE'];?></b></span>
          <span class="databox-text" id="status_user_create"></span>
        </div>
      </div>
    </div>                    
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
        <div class="databox-top bg-themefourthcolor">
          <div class="databox-icon">
            <i class="fa fa-user"></i> 
          </div>
        </div>
        <div class="databox-bottom text-align-center">
          <span class="databox-text"><b><?php echo $text['USERUPDATE'];?></b></span>
          <span class="databox-text" id=""></span>
        </div>
      </div>
    </div>                    
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
        <div class="databox-top bg-themefifthcolor">
          <div class="databox-icon">
            <i class="fa fa-clock-o" id="status_user_update"></i> 
          </div>
        </div>
        <div class="databox-bottom text-align-center">
          <span class="databox-text"><b><?php echo $text['DATECREATE'];?></b></span>
          <span class="databox-text" id="status_date_create"></span>
        </div>
      </div>
    </div>                    
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
        <div class="databox-top bg-themefifthcolor">
          <div class="databox-icon">
            <i class="fa fa-clock-o"></i> 
          </div>
        </div>
        <div class="databox-bottom text-align-center">
          <span class="databox-text"><b><?php echo $text['DATEUPDATE'];?></b></span>
          <span class="databox-text" id="status_date_update"></span>
        </div>
      </div>
    </div>                    
  </div>    
</div>

<input type="hidden" id="sortby" value="code" />
<input type="hidden" id="sortorder" value="desc" />
<input type="hidden" id="firstcode" value="" />
<input type="hidden" id="prevcode" value="" />
<input type="hidden" id="nextcode" value="" />
<input type="hidden" id="lastcode" value="" />
<input type="hidden" id="cboLimit" value="10" />
<input type="hidden" id="code" value="" />
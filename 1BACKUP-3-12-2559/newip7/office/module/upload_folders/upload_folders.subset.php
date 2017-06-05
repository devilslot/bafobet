<style>
  body,
  body:after,
  body:before,
  .widget-body{background-color:#ffffff;}
  .flat{margin:0;}
</style>

  <div id="tabviewlist" class="">
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <div class="widget flat">
          <div class="widget-header  with-footer" style="padding-left:0;">
            <div class="col-sm-3" style="padding-top:5px;">
              <div class="btn-group" style="width:100%;">
                <button id="btnGroupLimit" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <?php echo $text['DISPLAY'];?> &nbsp;&nbsp;10 <?php echo $text['ROW'];?> <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupLimit">
                  <li><a href="javascript:;" onclick="me.Limit(10, this);"><?php echo $text['DISPLAY'];?> &nbsp;&nbsp;10 <?php echo $text['ROW'];?></a></li>
                  <li><a href="javascript:;" onclick="me.Limit(50, this);"><?php echo $text['DISPLAY'];?> &nbsp;&nbsp;50 <?php echo $text['ROW'];?></a></li>
                  <li><a href="javascript:;" onclick="me.Limit(100, this);"><?php echo $text['DISPLAY'];?> 100 <?php echo $text['ROW'];?></a></li>
                  <li><a href="javascript:;" onclick="me.Limit(500, this);"><?php echo $text['DISPLAY'];?> 500 <?php echo $text['ROW'];?></a></li>
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
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $text['SEARCH']; ?></button>
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

  <div id="tabaddedit" style="display:none;" class="">

    <div class="row">
      <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget flat" style="margin-bottom:10px;">
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
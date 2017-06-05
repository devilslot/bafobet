

<div class="form-horizontal" role="form" id="ViewSetSearch">
  <div class="col-sm-6 col-md-6 col-lg-6"> 
    <div class="row">
    <div class="col-sm-6">
          
        <div class="radiobox">
          <label>
            <input type="radio" name="rdorun" id="rdorun1" class=" colored-blueberry" rel="1" checked="checked" value=""> 
            <span class="text"> Run iframe</span>
          </label>
        </div> 
      
    </div>
    <div class="col-sm-6">
      
        <div class="radiobox">
          <label>
            <input type="radio" name="rdorun" id="rdorun2" class=" colored-blueberry" rel="2" value=""> 
            <span class="text"> Run new window</span>
          </label>
        </div> 
      
    </div>
      </div>
    <div class="clear"></div>
    <div class="row">
      <div class="col-sm-12">  
        <input class="form-control input-sm mydata" id="name" name="name" type="text" placeholder="หัวข้อ" maxlength="100">
      </div>          
    </div>
    <div class="clear"></div>
    <br/>
    <div class="tabbable">
      <ul class="nav nav-tabs tabs-flat">
        <?php $first=true; for($i=1; $i <= 5; $i++){ 
          if($first){$active='class="active"';$first=false;}else{$active="";} 
          ?>
          <li <?php echo $active; ?>><a href="#tab_query<?php echo $i;?>" data-toggle="tab"><i class="fa fa-info-circle info"></i> Query <?php echo $i;?></a></li>
        <?php }?>

      </ul>
      <div class="tab-content tabs-flat">
        <?php $first=true; for($i=1; $i <= 5; $i++){
          if($first){$active='in active';$first=false;}else{$active="";} 
          ?>
          <div class="tab-pane <?php echo $active; ?>" id="tab_query<?php echo $i;?>"> 
            <form name="frm<?php echo $i;?>" id="frm<?php echo $i;?>" method="post" action="" target="_blank">
              <div class="row">
                <div class="col-sm-12">
                  <textarea class="form-control mydata" rows="13" id="query<?php echo $i;?>" name="query<?php echo $i;?>"></textarea>
                  <span id="ename_th" class="help-block err" style="display:none;">Please insert Query</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <button id="btnRun<?php echo $i;?>" type="button" class="btnnewwindow btn btn-info btn-block shiny btn-lg"><i class="fa fa-play"></i>Run</button>
                </div>
              </div>
              <input type="hidden" class="query_code" name="query_code" />
            </form>
          </div>
        <?php }?>
      </div>
    </div>
  </div>         
  <div class="col-sm-6 col-md-6 col-lg-6">  
    <div class="form-title">Table</div>
    <div style="height:340px; overflow:auto;">
	    <?php foreach($tb as $i=> $item){ ?>
	    <button class="btn shiny info btn-xs btn_table" style="margin-bottom:5px;"><?php echo $item;?></button>
	    <?php } ?>
    </div>
  </div>              
</div>

<div class="clear"></div>
<div class="form-title">Result</div>
<div class="row">
  <div class="col-md-12">
    <iframe id="ifm" name="ifm" style="width:100%; height:400px;" class="form-control"></iframe>
  </div>
</div>
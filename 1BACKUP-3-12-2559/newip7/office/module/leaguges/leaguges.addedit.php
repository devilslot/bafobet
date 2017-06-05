<div class="tabbable">
  <ul class="nav nav-tabs tabs-flat">
    <li class="active"><a id="titletab_info" href="#tab_info" data-toggle="tab">ข้อมูล</a></li>
    <li><a href="#tab_team" data-toggle="tab">ข้อมูลทีม</a></li>

  </ul>

  <div class="tab-content tabs-flat">

    <div class="tab-pane in active" id="tab_info">
      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('ชื่อ (TH)', 'name_th', 'mydata empty', '100');
            $app->PushText('ลำดับ', 'sort', 'mydata empty', '100');
            ?>      
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-horizontal" role="form">
            <?php
            $app->PushText('ชื่อ (EN)', 'name_en', 'mydata empty', '100');
            $app->PushRadio('การใช้งาน', 'enable', 'mydata', array('Y'=>'เปิด', 'N'=>'ปิด'));
            ?>  


          </div>
        </div>
      </div>
    </div>

    <div class="tab-pane" id="tab_team">
      <h4 class="page-header"><i class="fa fa-list-ul"></i> รายละเอียด</h4>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr bgcolor="#f2f2f2">
            <th width="30" class="text-center">ลำดับ.</th>
            <th width="100" class="text-center">ชื่อ (TH)</th>
            <th width="100" class="text-center">ชื่อ (EN)</th>
            <th width="120" class="text-center">
              <button id="" onclick="me.AddProduct();" class="btn btn-success" type="button"><i class="fa fa-plus"></i> เพื่มข้อมูล</button>
            </th>
          </tr>
        </thead>
        <tbody id="lyDetail">
        </tbody>
      </table>
    </div>



    
  </div>




</div>

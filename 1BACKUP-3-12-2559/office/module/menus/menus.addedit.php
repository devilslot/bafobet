
<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
      <?php
//      $app->PushSelect('เมนูหลัก', 'menu_code', 'mydata');
      $app->PushText('Module', 'id', 'mydata empty', '100');
      $app->PushText('ชื่อเต็ม (TH)', 'name_th', 'mydata empty', '255');
      $app->PushText('ชื่อย่อ (TH)', 'shortname_th', 'mydata empty', '255');
      $app->PushText('ชื่อเต็ม (EN)', 'name_en', 'mydata empty', '255');
      $app->PushText('ชื่อย่อ (EN)', 'shortname_en', 'mydata empty', '255');
//      $app->PushText('ลำดับ', 'sort', 'mydata num', '10', '0');
      $app->PushSelect('ต่อจากเมนู', 'after_code', 'mydata');
      $app->PushTextSelect('Icon', 'icon', 'mydata');
      $app->PushCheckbox('เมนูหลัก', 'main_menu', 'mydata');
      $app->PushCheckbox('แสดงผล', 'enable', 'mydata');
      ?>
    </div>
  </div>
  <div class="col-md-6">
    <table class="table table-bordered table-hover">
      <thead>
        <tr style="background-color:#f2f2f2">
          <th class="text-center"><b>Task</b></th>
          <th class="text-center" width="50">
              <label for="ChkAll-VIEW"><?php echo $define['VIEW'];?></label><br/>
              <label>
                <input id="ChkAll-VIEW" type="checkbox" class="colored-success"><span class="text"></span>
              </label>
          </th>
          <th class="text-center" width="50">
            <label for="ChkAll-ADD"><?php echo $define['ADD'];?></label><br/>
            <label>
              <input id="ChkAll-ADD" type="checkbox" class="colored-blue"><span class="text"></span>
            </label>
          </th>
          <th class="text-center" width="50">
            <label for="ChkAll-EDIT"><?php echo $define['EDIT'];?></label><br/>
            <label>
              <input id="ChkAll-EDIT" type="checkbox" class="colored-warning"><span class="text"></span>
            </label>
          </th>
          <th class="text-center" width="50">
            <label for="ChkAll-DEL"><?php echo $define['DEL'];?></label><br/>
            <label>
              <input id="ChkAll-DEL" type="checkbox" class="colored-danger"><span class="text"></span>
            </label>
          </th>
        </tr>
      </thead>
      <tbody>

        <?php
          foreach($task as $j => $item){
            echo "
                <tr>
                  <td><i class='fa fa-angle-double-right'></i> {$item["name_$lang"]}</td>
                <td class='text-center'>
                  <label>
                    <input type='checkbox' class='permdata perview colored-success' rel='{$item['code']}' />
                    <span class='text'></span>
                  </label>
                </td>
                <td class='text-center'>
                  <label>
                    <input type='checkbox' class='permdata peradd colored-blue' rel='{$item['code']}' />
                    <span class='text'></span>
                  </label>
                </td>
                <td class='text-center'>
                  <label>
                    <input type='checkbox' class='permdata peredit colored-warning' rel='{$item['code']}' />
                    <span class='text'></span>
                  </label>
                </td>
                <td class='text-center'>
                  <label>
                    <input type='checkbox' class='permdata perdel colored-danger' rel='{$item['code']}' />
                    <span class='text'></span>
                  </label>
                </td>
                </tr>
              ";
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="ModalIcon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:95%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Icon</h4>
      </div>
      <div class="modal-body" id="menuIcon">
        <?php include 'menus.icon.php'; ?>
      </div>
    </div>
  </div>
</div>
<div class="form-horizontal" role="form" id="ViewSetSearch">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('Module', 'id', 'mydata empty', '100');
$app->PushText('สิทธิ์การใช้ (TH)', 'name_th', 'mydata empty', '255');
$app->PushText('สิทธิ์การใช้ (EN)', 'name_en', 'mydata empty', '255');
//$app->PushSelect('Level', 'level', 'mydata', array('1'=>'User', '9'=>'Admin'));
//$app->PushText('Sort', 'sort', 'mydata num', '10', '0');
$app->PushCheckbox('แสดงผล', 'enable', 'mydata');
?>
    </div>
  </div>
      <div class="col-md-6" style="height:300px; overflow-y:auto;">
    <table class="table table-bordered table-hover">
      <thead>
        <tr style="background-color:#f2f2f2">
          <th class="text-center"><b>Position</b></th>
          <th class="text-center" width="50"><label><input type="checkbox" id="ChkAll" class="colored-danger" /><span class='text'></span></label></th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach((array)$task as $i => $subm){
            echo "
              <tr>
                <td> &nbsp; &nbsp; <i class='fa fa-angle-double-right'></i> {$subm['name_th']}</td>
              <td class='text-center'>
                <label>
                  <input type='checkbox' class='permdata colored-success' rel='{$subm['code']}' />
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

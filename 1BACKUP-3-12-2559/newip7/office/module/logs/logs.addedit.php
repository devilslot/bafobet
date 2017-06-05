<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('ประเภท', 'mode', 'readonly', '100');
$app->PushText('เมนู', 'menu', 'readonly', '100');
?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('Record', 'record', 'readonly', '100');
$app->PushText('IP', 'ip', 'readonly', '100');
?>   
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-striped">
      <thead class="bordered-darkorange">
        <tr>
          <th width="150">Field</th>
          <th>Data</th>
        </tr>
      </thead>
      <tbody id="tb_item">
        
      </tbody>
    </table>
  </div>
</div>

<br/>
<div class="row">
  <div class="col-md-12 text-align-right">
    <button type="button" onclick="me.RollBack();" class="btn btn-lg btn-warning shiny"><i class="fa fa-undo"></i> Rollback</button>
  </div>
</div>
<br/>

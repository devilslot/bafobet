<div class="tabbable">
  <ul class="nav nav-tabs tabs-flat">
    <li class="active"><a href="#tab_info" data-toggle="tab">Information</a></li>
    <li><a href="#tab_content" data-toggle="tab">Content</a></li>
  </ul>
  <div class="tab-content tabs-flat">
    <div class="tab-pane in active" id="tab_info">
<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('Name', 'name', 'mydata');
?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('Description', 'description', 'mydata');
?>   
    </div>
  </div>
</div>
    </div>
    <div class="tab-pane" id="tab_content">
<div class="row">
  <div class="col-md-12">
    <div class="form-horizontal" role="form">
<?php

?>
    </div>
  </div>
</div>
    </div>
  </div>
</div>

<div class="tabbable">
<ul class="nav nav-tabs tabs-flat">
  <li class="active"><a href="#tab_info" data-toggle="tab">ข้อมูล</a></li>
  <li><a href="#tab_picture" data-toggle="tab">รูปภาพ</a></li>
  <?php if($sess_permiss['OPEN']['emp_permission']){ ?>
  <li><a href="#tab_permission" data-toggle="tab">สิทธิ์การเข้าใช้งาน</a></li>
  <?php } ?>
</ul>
<div class="tab-content tabs-flat">
  <div class="tab-pane in active" id="tab_info">
<div class="row">
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('ชื่อ', 'name', 'mydata empty', '100');
$app->PushText('นามสกุล', 'surname', 'mydata empty', '100');
$app->PushText('เบอร์มือถือ', 'mobile', 'mydata', '30');
$app->PushSelect('ระดับการใช้งาน', 'task_code', 'mydata');
$app->PushCheckbox('เปิดใช้งาน', 'enable', 'mydata');
if($_SESSION[OFFICE]['DATA']['superadmin'] == 'Y'){
  $app->PushCheckbox('Super Admin', 'superadmin', 'mydata');
}
?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-horizontal" role="form">
<?php
$app->PushText('อีเมล์', 'email', 'mydata', '100');
$app->PushText('ชื่อผู้ใช้', 'user_name', 'mydata empty', '100');
$app->PushText('รหัสผ่าน', 'user_pass', 'mydata', '100');
$app->PushCheckbox('เปลี่ยนรหัสผ่าน', 'change_pass', 'mydata');
$app->PushText('เบอร์โทร', 'tel', 'mydata', '30');
?>    
    </div>
  </div>
</div>
  </div><!-- $customer -->
  
  <div class="tab-pane" id="tab_picture">
    <iframe id="uploadtarget" name="uploadtarget" src="" style="width:0px;height:0px;border:0"></iframe>
    <div class="row">
      <div class="col-md-6">
        <label class="col-sm-4"></label>
        <div class="col-sm-8">
          <a id="lnkUpload" href="../img/nopic.jpg" target="_blank"><img src="../img/nopic.jpg" class="img-responsive img-photo" /></a>
        </div>
      </div>
    </div>
    <br/>
    <div class="row">
      <div class="col-md-6">
        <div class="form-horizontal" role="form">
          <form name="frmUpload" id="frmUpload" method="post" action="<?php echo "module/$mod/$mod.upload.php"; ?>" enctype="multipart/form-data" target="uploadtarget" style="margin:0;" onsubmit="return me.UploadPic.Submit();">
            <div id="dvfilepic" class="form-group">
              <label id="lblfilepic" for="filepic" class="col-sm-4 control-label" style="white-space:nowrap">ไฟล์ภาพ :</label>
              <div class="col-sm-8">
                <div class="input-group">
                  <input class="form-control" id="fileupload" name="fileupload" type="file" />
                  <span class="input-group-btn"> 
                    <button id="btnUpload" class="btn btn-info" type="submit" style="padding:5px;"><i class="fa fa-upload"></i> Upload</button> 
                    <button type="button" id="btnLoading" style="display:none;padding:5px;" class="btn btn-default"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                    <button type="button" id="btnfiledel" style="display:none; padding:5px;" class="btn btn-danger" onclick="me.UploadPic.Clear();"><i class="fa fa-times"></i></button>
                  </span>
                </div>        
              </div>
            </div>  
          </form>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-horizontal" role="form">
    <?php
    $app->PushText('ชื่อรูปภาพ', 'filepic', 'mydata readonly', '100');
    ?>
        </div>
      </div>
    </div>
  </div><!-- $check -->
  
  <?php if($sess_permiss['OPEN']['emp_permission']){ ?>
  <div class="tab-pane" id="tab_permission">
    <div class="row">
      <div class="col-md-6">
    <table class="table table-bordered table-hover">
      <thead class="bordered-primary">
        <tr style="background-color:#f2f2f2">
          <th class="text-center"><b>สิทธิพื้นฐาน</b></th>
          <th class="text-center" width="50"><label><?php echo $define['VIEW']; ?><br/><input type="checkbox" id="ChkAll-VIEW" class="colored-danger" /><span class='text'></span></label></th>
          <th class="text-center" width="50"><label><?php echo $define['ADD']; ?><br/><input type="checkbox" id="ChkAll-ADD" class="colored-danger" /><span class='text'></span></label></th>
          <th class="text-center" width="50"><label><?php echo $define['EDIT']; ?><br/><input type="checkbox" id="ChkAll-EDIT" class="colored-danger" /><span class='text'></span></label></th>
          <th class="text-center" width="50"><label><?php echo $define['DEL']; ?><br/><input type="checkbox" id="ChkAll-DEL" class="colored-danger" /><span class='text'></span></label></th>
        </tr>
      </thead>
      <tbody>
        <?php
//        PrintR($menu);
        foreach((array)$menu as $i => $value){
            if(isset($menu_sub[$value['code']])){
              echo "
                <tr>
                  <td onclick='me.Accr(this)' id='linkpermiss_{$value['code']}' rel='{$value['code']}' style='cursor:pointer;'><i class='fa fa-plus-circle info'></i> <b>{$value["shortname_$lang"]}</b></td>
                  <td class='text-align-center'><b id='cntview_{$value['code']}' class='' style='display:none;'>0</b></td>
                  <td class='text-align-center'><b id='cntadd_{$value['code']}' class='' style='display:none;'>0</b></td>
                  <td class='text-align-center'><b id='cntedit_{$value['code']}' class='' style='display:none;'>0</b></td>
                  <td class='text-align-center'><b id='cntdel_{$value['code']}' class='' style='display:none;'>0</b></td>
                </tr>
              ";
              echo "<tbody id='menubody_{$value['code']}' class='menubody'>";
              foreach($menu_sub[$value['code']] as $j => $submenu){
                echo "
                  <tr id='trper_{$submenu['id']}' class='blockpermiss_{$value['code']}' style='display:none;'>
                    <td> &nbsp; &nbsp; <i class='fa fa-angle-double-right'></i> {$submenu["shortname_$lang"]}</td>
                    <td class='text-center'>
                      <label>
                        <input type='checkbox' class='permdata perview ".ClassLevel($submenu['level_view'])." colored-warning' rel='{$submenu['id']}-VIEW' parent='{$value['code']}' />
                        <span class='text'></span>
                      </label>
                    </td>
                    <td class='text-center'>
                      <label>
                        <input type='checkbox' class='permdata peradd ".ClassLevel($submenu['level_add'])." colored-warning' rel='{$submenu['id']}-ADD' parent='{$value['code']}' />
                        <span class='text'></span>
                      </label>
                    </td>
                    <td class='text-center'>
                      <label>
                        <input type='checkbox' class='permdata peredit ".ClassLevel($submenu['level_edit'])." colored-warning' rel='{$submenu['id']}-EDIT' parent='{$value['code']}' />
                        <span class='text'></span>
                      </label>
                    </td>
                    <td class='text-center'>
                      <label>
                        <input type='checkbox' class='permdata perdel ".ClassLevel($submenu['level_del'])." colored-warning' rel='{$submenu['id']}-DEL' parent='{$value['code']}' />
                        <span class='text'></span>
                      </label>
                    </td>
                  </tr>
                ";
              }
              echo "</tbody>";
            }else{
              echo "
                <tr>
                  <td><i class='fa fa-circle-o'></i> <b>{$value["shortname_$lang"]}</b></td>
                  <td class='text-center'>
                    <label>
                      <input type='checkbox' class='permdata perview ".ClassLevel($value['level_view'])." colored-success' rel='{$value['id']}-VIEW' />
                      <span class='text'></span>
                    </label>
                  </td>
                  <td class='text-center'>
                    <label>
                      <input type='checkbox' class='permdata peradd ".ClassLevel($value['level_add'])." colored-success' rel='{$value['id']}-ADD' />
                      <span class='text'></span>
                    </label>
                  </td>
                  <td class='text-center'>
                    <label>
                      <input type='checkbox' class='permdata peredit ".ClassLevel($value['level_edit'])." colored-success' rel='{$value['id']}-EDIT' />
                      <span class='text'></span>
                    </label>
                  </td>
                  <td class='text-center'>
                    <label>
                      <input type='checkbox' class='permdata perdel ".ClassLevel($value['level_del'])." colored-success' rel='{$value['id']}-DEL' />
                      <span class='text'></span>
                    </label>
                  </td>
                </tr>
              ";
            }
        }
        ?>
      </tbody>
    </table>
        
      </div>
      <div class="col-md-6">
        <?php if(!empty($permission)){ ?>
    <table class="table table-bordered table-hover">
      <thead class="bordered-blue">
        <tr style="background-color:#f2f2f2">
          <th class="text-center"><b><?php echo $define['PERMISSION_OTHER']; ?></b></th>
          <th class="text-center" width="50">
            <label><?php echo $define['OPEN']; ?><br/><input type="checkbox" id="ChkAll-OK" class="colored-danger" /><span class='text'></span></label>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach((array)$permission as $i => $value){
            echo "
              <tr class='blockpermiss_{$value['id']}'>
                <td><i class='fa fa-circle-o'></i> <b>{$value["name_$lang"]}</b></td>
                <td class='text-center'>
                  <label>
                    <input type='checkbox' class='permdata perok ".ClassLevel($value['level_open'])." colored-success' rel='{$value['id']}-OPEN' />
                    <span class='text'></span>
                  </label>
                </td>
              </tr>
            ";
        }
        ?>
      </tbody>
    </table>
        <?php } ?>
      </div>
    </div>
  </div><!-- $standard -->
  <?php } ?>
</div>
</div>

<div class="modal fade" id="boxImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="ShowImageTitle"></h4>
      </div>
      <div class="modal-body" id="ShowImage" style="background:url(../images/loading.gif) 50% 50% no-repeat;">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="boxUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Upload</h4>
      </div>
      <div class="modal-body" id="">
        <div id="uploader"></div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>
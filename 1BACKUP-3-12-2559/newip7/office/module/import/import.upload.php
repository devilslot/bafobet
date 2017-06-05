<?php
error_reporting(0);
error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once "../../../service/service.php";
require_once "../../../main/upload.class.php";

$type = CheckType($_FILES['fileupload']['name']);
if($type != 'xls'){
  echo '<script>';
  echo ' window.parent.me.Upload.Error("Please upload file xls.");';
  echo '</script>';
}else{
  if(is_file('../../../temp/excel_temp.xls'))unlink('../../../temp/excel_temp.xls');
  
  $filename = 'excel_temp';
  $handle = new Upload($_FILES['fileupload']);

  if ($handle->uploaded) {
      $handle->file_new_name_body = $filename;
      $handle->Process('../../../temp');
      if ($handle->processed) {
          echo '<script>';
          echo ' window.parent.me.Upload.Complete("'.$filename.'");';
          echo '</script>';
      } else {
          echo '<script>';
          echo ' window.parent.me.Upload.Error("'.$handle->error.'");';
          echo '</script>';
      }
      $handle-> Clean();

  } else {
      echo '<script>';
      echo ' window.parent.me.Upload.Error("'.$handle->error.'");';
      echo '</script>';
  }
}

?>

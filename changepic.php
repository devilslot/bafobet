<?
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";
if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
  @header('location: /index.php');
  exit;
}

//print_r($_FILES['image']);
if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_SESSION[MEMBER]['DATA']['username']."-".time().".jpg";
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
     // $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
 //echo $file_name;
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         @unlink("memberpic/".$_SESSION[MEMBER]['DATA']['photo']);
		 
	
		$images = $file_tmp;
		copy($file_tmp,"memberpic/".$file_name);
		$width=230; //*** Fix Width & Heigh (Autu caculate) ***//
		$size=GetimageSize($images);
		$height=round($width*$size[1]/$size[0]);
		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		ImageJPEG($images_fin,"memberpic/".$file_name);
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);
		
		$sql2 = " UPDATE members SET photo = '".$file_name."' WHERE code = '".$_SESSION[MEMBER]['DATA']['code']."' ";
    	mysql_query($sql2,$conn);
	
         //move_uploaded_file($file_tmp,"memberpic/".$_SESSION[MEMBER]['DATA']['username'].'.jpg');
		 $_SESSION[MEMBER]['DATA']['photo'] = $file_name;
         echo "Success";
      }
      else{
          echo '<script language="javascript">alert("ขนาดรูปเกิน 2 MB");</script>';
      }
   }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>เปลี่ยนรูปโปรไฟล์</title>
  <style type="text/css">
  <!--
  body {
   margin-left: 0px;
   margin-top: 0px;
   margin-right: 0px;
   margin-bottom: 0px;
   background-color: #000000;
   /*background:url(bg%20.jpg) top center no-repeat #000000;*/
 }
 .style1 {color: #FFFFFF}
 .style3 {font-family: Tahoma; font-size: 14px; }
 .style4 {
   font-family: Tahoma;
   font-size: 24px;
   color: #FF9900;
 }
 -->
 </style>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 <script type="text/javascript" src="main/main.func.js"></script>
 <script type="text/javascript" src="creation/creation.script.js"></script>


</head>

<body>
 <br />
 <div style=" background:url(bg-body.png); width:600px; padding:10px; border:#1d1d1d solid 1px; margin:auto;">
  <div align="center"><strong><span class="style4">เปลี่ยนรูปโปรไฟล์</span></strong><br />
    <br />
  </div>
   <form action="" method="POST" enctype="multipart/form-data">
  <table width="100%" border="0">
    <tr>
      <td colspan="2" align="center">
        <?php  if (file_exists("memberpic/".$_SESSION[MEMBER]['DATA']['photo'])) { ?>
          <img src="memberpic/<?php echo $_SESSION[MEMBER]['DATA']['photo'];?>" width="230"/>
        <?php }else{ ?>
          <img src="img/nopic.jpg" width="230"/>
        <?php } ?>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">เลือกรูป :&nbsp; </span></div></td>
      <td align="center">
        <input type="file" name="image"  id="image" style="color:#666666;" onChange="this.form.submit();"/><font color="#ff0000">* ขนาดรูป 230 x 230 px (jpg only)</font>
        
      </td>
    </tr>

    <tr>
      <td height="70" colspan="2"><div align="center">
        <!--<input type="submit" name="button" id="button" value="แก้ไข" style="width:100px; height:40px; background:#FF9900; color:#000000; font-size:14px; border:solid 1px #FFCC33" />-->
      </div></td>
    </tr>
  </table>
     </form>
</div>
</body>
</html>

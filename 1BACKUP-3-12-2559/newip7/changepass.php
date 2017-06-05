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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>เปลี่ยนรหัสผ่าน</title>
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
 <br /><br /><br />
 <div style=" background:url(bg-body.png); width:600px; padding:10px; border:#1d1d1d solid 1px; margin:auto;">
  <div align="center"><strong><span class="style4">เปลี่ยนรหัสผ่าน</span></strong><br />
    <br />
  </div>
  <table width="100%" border="0">
    <tr>
      <td width="40%" height="35"><div align="right" class="style3"><span class="style1">รหัสผ่านเก่า :&nbsp; </span></div></td>
      <td width="60%">
        <input type="password" class="mydata empty oldpass" name="oldpass" id="oldpass" style="width:250px; height:27px;"  />
        <span id='eoldpass' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ รหัสผ่านเก่า</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">รหัสผ่านใหม่ :&nbsp; </span></div></td>
      <td>
        <input type="password" name="newpass" class="mydata empty newpass" id="newpass" style="width:250px; height:27px;"  />
        <span id='enewpass' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ รหัสผ่านใหม่</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">ยืนยันรหัสผ่านใหม่ :&nbsp; </span></div></td>
      <td>
        <input type="password" name="repass" id="repass" class="mydata empty repass"  style="width:250px; height:27px;"/>
        <span id='erepass' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ ยืนยันรหัสผ่านใหม่</span>
      </td>
    </tr>

    <tr>
      <td height="70" colspan="2"><div align="center">
        <input type="button" onclick="me.ChangePass()" name="button" id="button" value="แก้ไข" style="width:100px; height:40px; background:#FF9900; color:#000000; font-size:14px; border:solid 1px #FFCC33" />
      </div></td>
    </tr>
  </table>
</div>
<script type="text/javascript">

me.ChangePass=function(){

  if(!me.CheckForm()){
    $('#lyAddEdit input').first().focus();
    setTimeout('me.ClearError();', 5000);
    return;
  }

  var myData = {
    data : ft.LoadForm('mydata')
  };
  
  $.ajax({
    url:me.url+'?mode=ChangePass&'+new Date().getTime(),
    type:'POST',
    dataType:'json',
    data:myData,
    success:function(data){
      switch(data.success){
        case 'COMPLETE' :
        alert('แก้ไขข้อมูลสำเร็จ')
        parent.jQuery.colorbox.close();
        break;
        case 'PASS' :
        alert('รหัสผ่านเก่าไม่ตรง')
        break;
        case 'PASSMATCH' :
        alert('รหัสผ่านใหม่ไม่ตรงกัน')
        break;
      }
    }
  });
};
</script>
</body>
</html>

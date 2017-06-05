<?
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";
//$slide = $ojc->LoadSlide();
//print_r($slide);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>สมัครสมาชิกใหม่</title>
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

<script src="jquery.colorbox.js"></script>

</head>

<body>
 <div align="center"><br />
   <img src="logo.png" width="250" />
   <br />
   <br />
 </div>
 <div style=" background:url(bg-body.png); width:600px; padding:10px; border:#1d1d1d solid 1px; margin:auto;">
  <div align="center"><strong><span class="style4">สมัครสมาชิกใหม่</span></strong><br />
    <br />
  </div>
  <table width="100%" border="0">
    <tr>
      <td width="40%" height="35"><div align="right" class="style3"><span class="style1">ชื่อ :&nbsp; </span></div></td>
      <td width="60%">
        <input type="text" class="mydata empty firstname" name="firstname" id="firstname" style="width:250px; height:27px;" />
        <span id='efirstname' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ ชื่อ</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">นามสกุล :&nbsp; </span></div></td>
      <td>
        <input type="text" name="lastname" class="mydata empty lastname" id="lastname" style="width:250px; height:27px;" />
        <span id='elastname' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ นามสกุล</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">อีเมลล์ :&nbsp; </span></div></td>
      <td>
        <input type="text" name="email" class="mydata empty email" id="email" style="width:250px; height:27px;" />
        <span id='eemail' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ อีเมลล์</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">เบอร์โทร :&nbsp; </span></div></td>
      <td>
        <input type="text" name="tel" class="mydata empty tel" id="tel" style="width:250px; height:27px;" />
        <span id='etel' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ เบอร์โทร</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1"> Username :&nbsp; </span></div></td>
      <td>
        <input type="text" name="username" class="mydata empty username" id="username" style="width:250px; height:27px;" />
        <span id='eusername' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ Username</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">Password :&nbsp; </span></div></td>
      <td>
        <input type="password" name="password" class="mydata empty password" id="password" style="width:250px; height:27px;" />
        <span id='epassword' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ Password</span>
      </td>
    </tr>

    <tr>
      <td height="70" colspan="2"><div align="center">
        <input type="button" onclick="me.Register()" name="button" id="button" value="ลงทะเบียน" style="width:100px; height:40px; background:#FF9900; color:#000000; font-size:14px; border:solid 1px #FFCC33" />
      </div></td>
    </tr>
  </table>
</div>
<script type="text/javascript">

me.Register=function(){

  /*if(!me.CheckForm()){
    $('#lyAddEdit input').first().focus();
    setTimeout('me.ClearError();', 5000);
    return;
  }

  var myData = {
    data : ft.LoadForm('mydata')
  };
  
  $.ajax({
    url:me.url+'?mode=Register&'+new Date().getTime(),
    type:'POST',
    dataType:'json',
    data:myData,
    success:function(data){
      switch(data.success){
        case 'COMPLETE' :
        alert('ลงทะเบียนสำเร็จ')
		window.location.href;
        parent.jQuery.colorbox.close();
        break;
        case 'EMAIL' :
        alert('อีเมลล์นี้มีอยู่ในระบบแล้ว')
        break;
        case 'USERNAME' :
        alert('Username นี้มีอยู่ในระบบแล้ว')
        break;
      }
    }
  });*/
  //$(window).colorbox.close();

  //parent.jQuery.colorbox.close();
  //window.location.href='index.php';
  
  jQuery.colorbox.close();
};
</script>
</body>
</html>

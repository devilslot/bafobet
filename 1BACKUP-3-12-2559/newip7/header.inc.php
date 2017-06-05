<?
@session_start();

include("core/core.php");
$db=Live::core("db");
$member=Live::member();
$moncredit=$member['moncredit'];
Live::close();/**/


require_once "service/service.php";
require_once "creation/creation.init.php";
//$slide = $ojc->LoadSlide();
//print_r($slide);

if(date('H')<12){
$datestart = strtotime('-1 day', strtotime(date('Y-m-d 12:00:00')));
$datestop = strtotime(date('Y-m-d 11:59:59'));

}else{
$datestart = strtotime(date('Y-m-d 12:00:00'));
$datestop = strtotime('+1 day', strtotime(date('Y-m-d 11:59:59')));
}

if(empty($_GET['dateMatch'])){
 	$datestart=$datestart;
	$datestop=$datestop;
}else{
  	$date = $_GET['dateMatch'];
	
	if(date('H')<12){
	$datestart=strtotime('-1 day', strtotime(date($_GET['dateMatch'].' 12:00:00')));
	$datestop=strtotime(date($_GET['dateMatch'].' 11:59:59'));
	
	}else{
	$datestart = strtotime(date($_GET['dateMatch'].' 12:00:00'));
	$datestop = strtotime('+1 day', strtotime(date($_GET['dateMatch'].' 11:59:59')));
	}
}

echo 'datestart '.date('Y-m-d H;i:s',$datestart).' | datestop '.date('Y-m-d H;i:s',$datestop);

$sql="SELECT * FROM members WHERE code = '".$_SESSION[MEMBER]['DATA']['code']."';";
$query=mysql_query($sql,$conn);
$memberdata=mysql_fetch_assoc($query);


if(isset($_GET['getpoint']) and $memberdata['getpoint']!=date('d')){

$sqlup="UPDATE members SET score=score+500, getpoint='".date('d')."' WHERE code = '".$_SESSION[MEMBER]['DATA']['code']."';";
$queryup=mysql_query($sqlup,$conn);


$sqlup2="insert into playgame (matchID,point,winloss,memberID,status,cal,gametype,user_create,user_update,date_create,date_update)value('GETPOINT','500','1.00','".$memberdata['code']."','1','1','point','".$memberdata['username']."','".$memberdata['username']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."') ";
$queryup2=mysql_query($sqlup2,$conn);

?>
<script>
    alert("เติม 500 Point สำเร็จ!");
	window.location="index.php";
</script>
<?
}else if(isset($_GET['getpoint']) and $memberdata['getpoint']==date('d')){
?>
<script>
    alert("ท่านได้ฟรี point ไปแล้ว!");
	window.location="index.php";
</script>
<?
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta property="og:image" content="https://www.bafobet.com/logot.png"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php if($_SESSION[MEMBER]['DATA']['username']!=''){ echo $_SESSION[MEMBER]['DATA']['username']." - ".$_SESSION[MEMBER]['DATA']['firstname']."  ".$_SESSION[MEMBER]['DATA']['lastname']; } echo $config['titles'];?></title>
  <meta name="description" content="<?php echo $config['descriptions'];?>"/>
  <meta name="keywords" content="<?php echo $config['keywordss'];?>"/>
  <meta name="author" content="bafobet.com">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.css" rel="stylesheet">

<script src="js/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="js/bootstrap.min.js"></script>

<script src="function.js"></script>
  <style type="text/css">
  <!--
  html {

}

  body {
  background-color:#333333;
   margin-left: 0px;
   margin-top: 0px;
   margin-right: 0px;
   margin-bottom: 0px;
   background:url(bg%20.jpg) top center;
   background-attachment:fixed;
   font-size:14px;
   font-family:Arial,Helvetica,sans-serif;
   
   color:#FFFFFF;
 }
a:link {
	color: #FFCC00;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #FFCC00;
}
a:hover {
	text-decoration: none;
	color: #FF9933;
}
a:active {
	text-decoration: none;
}
 .style18 {color: #FFFFFF;  font-size: 14px; }
 .style20 {color: #FFCC00;}
 .style22 {
   font-size: 14px;
   
   color: #FF9933;
 }
 .style5 {color: #FFFF00;
   font-weight: bold;
   
   font-size: 14px;
 }
 .style24 {color: #FFCC33}
 .style25 {font-size: 14px;  color: #FFCC00; }
 .style26 {font-size: 14px;  color: #FFCC33; }
 .style27 {color: #EDD881}
 .style28 {font-size: 14px; }
 .style29 {color: #FFFFFF}
 -->
 div {
  -webkit-border-radius:5px;
  -moz-border-radius:5px;
  border-radius:5px;
}
.style31 { font-size: 14px; }
.style54 {font-size: 14}
.style55 {font-weight: bold;  color: #FFFF00;}
.style56 { color: #000000; font-weight: bold;}
.style57 {font-family: Tahoma}
.style59 {font-size: 14px;  }
.style60 {font-size: 14px}
.style62 {color: #FF0000}
.style63 {
	color: #0066CC
}
.style64 {color: #9DB333}
.style65 {font-size: 14px;  color: #9DB333; }
.style67 {font-size: 14px}
.badge,.tag,.sign{background-color:#000;color:#fff;display:inline-block; padding:4px 6px; text-align:center; position:relative; top:0px; left:-14px; font-size:11px; font-family:tahoma; font-weight:bold;}
.badge{border-radius:50%}
.redc { color:#FFF; background:#B9282C; }
.blue { color:#FFF; background:#0C69DC; }
.yullow { color:#111; background:#FFCC00; }
input, select, textarea{
    color: #000000;
	font-weight:200;
}


</style>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
  }

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
    if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
    for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
      if(!x && d.getElementById) x=d.getElementById(n); return x;
  }

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>




<!-- jQuery library -->



</head>

<body onLoad="MM_preloadImages('images/menu2_01.png','images/menu2_02.png','images/menu2_03.png','images/menu2_04.png','images/menu2_05.png','images/menu2_06.png','images/menu2_07.png','images/menu2_08.png')">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.7&appId=892483494211866";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



  <style type="text/css">
/* [Object] modalregis
 * =============================== */
 .modal { z-index:399; }
 
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.bw {
  -webkit-transition: all 1s ease;
     -moz-transition: all 1s ease;
       -o-transition: all 1s ease;
      -ms-transition: all 1s ease;
          transition: all 1s ease;
}
 
.bw:hover {
  -webkit-filter: grayscale(50%);
}


</style>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content" style="background-color:#222222; color:#FFFFFF; padding:0;">
        <div class="modal-header" style="border-width:0;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="myModalcontent" style="margin:0; padding:0;">
        </div>
      </div>
      
    </div>
</div>
 <div class="style54" style="width:1050px; margin:auto;">
<?php if($_SESSION[MEMBER]['LOGIN'] != "ON") {?>
   <table width="100%" border="0">
    <tr>
      <td width="41%"><a href="index.php"><img src="logo.png" width="400"  /></a></td>
      <td width="59%"><div style="color:#FFFFFF; font-family:Tahoma;"><span class="style67">USERNAME :</span> 
        <input type="text" name="user" class="mydata" id="user" style="border:solid 1px #FECC56; background:#000000; width:115px; height: 27px; color:#FFFFFF;" />
        <span class="style67">PASSWORD :</span> 
        <input type="password" name="pass"  class="mydata" id="pass" style="border:solid 1px #FECC56; background:#000000; width:115px; height: 27px; color:#FFFFFF;" />
        &nbsp; 
        <input type="button" onClick="me.Login()" name="button" id="button" value="เข้าระบบ" style="border:solid 1px #FECC56; background:#FECC56; width:70px; height: 30px; color:#000;" />
        <!--<a class='iframe' href="register.php">-->
		<input type="button" style="border:solid 1px #FECC56; background:#000; width:120px; height: 30px; color:#fecc56; float:right; text-align:center; line-height:28px;" data-toggle="modal" data-target="#register_mo" value="สมัครสมาชิก" />
		
		<!--<input type="button" name="button2" id="button2" value="สมัครสมาชิก" style="border:solid 1px #FECC56; background:#000; width:70px; height: 30px; color:#fecc56;"/>
		</a>-->
      </div></td>
    </tr>
  </table>
<?php }else{ ?>
   <table width="100%" border="0">
    <tr>
      <td width="41%"><a href="index.php"><img src="logo.png" width="400"  /></a></td>
      <td width="59%" align="right"><div style="color:#FFFFFF; font-family:Tahoma;"> ยินดีต้อนรับ , <?php echo $_SESSION[MEMBER]['DATA']['username'];?> [Point <span style="color:#FFCC33;"><?php echo number_format($memberdata['score']);?></span> คะแนน] [Rank <span style="color:#FFCC33;"><?php echo $memberdata['rank'];?></span> คะแนน] <br />
      
    | <a href="javascript:;" onClick="openchangepass()" style="color:#FFCC33;">เปลี่ยนรหัส</a> 
    | <a href="javascript:;" onClick="openchangepic()" style="color:#FFCC33;">รูปโปรไฟล์</a> 
    | <a href="viewmemberplay.php?refID=<?php echo $_SESSION[MEMBER]['DATA']['code'];?>" style="color:#FFCC33;">ประวัติการทายผล</a> 
    | <a href="playbet.php" style="color:#FFCC33;">ฝากเงิน</a> | <a href="logout.php" style="color:#FFCC33;">Logout</a><br /><br />

<?php if($memberdata['getpoint']!=date('d')){ ?>
<div style="border:solid 1px #FECC56; background:#000; width:200px; height: 28px; color:#fecc56; text-align:center; line-height:28px;"><a href="<?=$_SERVER["REQUEST_URI"]?>?&getpoint=y" style="color:#FFCC33;">รับฟรี 500 Point ต่อวัน</a></div>
<?php }else{
?>
<div style="border:solid 1px #FECC56; background:#000; width:200px; height: 28px; color:#fecc56; text-align:center; line-height:28px;">รับฟรี Point ได้อีกครั้งพรุ่งนี้</div>
<?php
} ?>
      </div></td>
    </tr>
  </table>
<?php } ?>
</div>
<div class="style54" style="width:1050px; margin:auto;">
  <table id="Table_01" width="1050" height="71" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image8','','images/menu2_01.png',1)"><img src="images/menu_01.png" name="Image8" width="94" height="71" border="0" id="Image8" /></a></td>
      <td><a href="tryscore.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','images/menu2_02.png',1)"><img src="images/menu_02.png" name="Image9" width="99" height="71" border="0" id="Image9" /></a></td>
      <td><a href="tded.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image10','','images/menu2_03.png',1)"><img src="images/menu_03.png" name="Image10" width="108" height="71" border="0" id="Image10" /></a></td>
      <td><a href="champion.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image11','','images/menu2_04.png',1)"><img src="images/menu_04.png" name="Image11" width="109" height="71" border="0" id="Image11" /></a></td>
      <td><a href="zean.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image12','','images/menu2_05.png',1)"><img src="images/menu_05.png" name="Image12" width="149" height="71" border="0" id="Image12" /></a></td>
      <td><a href="week.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image13','','images/menu2_06.png',1)"><img src="images/menu_06.png" name="Image13" width="165" height="71" border="0" id="Image13" /></a></td>
      <td><a href="today.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image14','','images/menu2_07.png',1)"><img src="images/menu_07.png" name="Image14" width="151" height="71" border="0" id="Image14" /></a></td>
      <td><a href="history.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image15','','images/menu2_08.png',1)"><img src="images/menu_08.png" name="Image15" width="175" height="71" border="0" id="Image15" /></a></td>
    </tr>
  </table>
  
  
</div>
  


<!-- Modal -->
<div id="register_mo" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content" style="background-color:#222222; color:#FFFFFF; padding:0;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
 <div style=" background:url(bg-body.png); width:500px; padding:10px; border:#1d1d1d solid 1px; margin:auto;">
  <div align="center"><strong><span class="style4">สมัครสมาชิกใหม่</span></strong>
  </div>
      </div>
      <div class="modal-body">
        
        
  
  <table width="100%" border="0">
    <tr>
      <td width="40%" height="35"><div align="right" class="style3"><span class="style1">ชื่อ :&nbsp; </span></div></td>
      <td width="60%">
        <input type="text" class="mydata2 empty firstname" name="firstname" id="firstname" style="width:250px; height:27px; color:#000000;" />
        <span id='efirstname' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ ชื่อ</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">นามสกุล :&nbsp; </span></div></td>
      <td>
        <input type="text" name="lastname" class="mydata2 empty lastname" id="lastname" style="width:250px; height:27px; color:#000000;" />
        <span id='elastname' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ นามสกุล</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">อีเมลล์ :&nbsp; </span></div></td>
      <td>
        <input type="text" name="email" class="mydata2 empty email" id="email" style="width:250px; height:27px; color:#000000;" />
        <span id='eemail' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ อีเมลล์</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">เบอร์โทร :&nbsp; </span></div></td>
      <td>
        <input type="text" name="tel" class="mydata2 empty tel" id="tel" style="width:250px; height:27px; color:#000000;" />
        <span id='etel' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ เบอร์โทร</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1"> Username :&nbsp; </span></div></td>
      <td>
        <input type="text" name="username" class="mydata2 empty username" id="username" style="width:250px; height:27px; color:#000000;" />
        <span id='eusername' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ Username</span>
      </td>
    </tr>
    <tr>
      <td height="35"><div align="right" class="style3"><span class="style1">Password :&nbsp; </span></div></td>
      <td>
        <input type="password" name="password" class="mydata2 empty password" id="password" style="width:250px; height:27px; color:#000000;" />
        <span id='epassword' class='help-block err' style='display:none;color:yellow'>กรุณาใส่ Password</span>
      </td>
    </tr>

    <tr>
      <td height="70" colspan="2"><div align="center">
        <input type="button" onClick="me.Register()" name="button" id="button" value="ลงทะเบียน" style="width:100px; height:40px; background:#FF9900; color:#000000; font-size:14px; border:solid 1px #FFCC33" />
      </div></td>
    </tr>
  </table>
        
      </div>
      
    </div>

  </div>
</div>
    
     

</div>

<div class="modal fade" id="promotion" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content" style="background-color:#222222; color:#FFFFFF; padding:0;">
        <div class="modal-header" style="border-width:0;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
			<?php if($moncredit>=300){?>
			<div class="alert alert-success">
			  <strong>ท่านมีสิทธ์!</strong> ลุ้นรับ IPhone7 16GB เพียงทายผล Point ถูก 12 คู่ ติดกัน.
			</div>
			<?php }else{ ?>
			
			<div class="alert alert-danger">
			  <strong>ท่านยังไม่ได้รับสิทธ์!</strong><br /><?php if($moncredit==''){ echo 'ลุ้นรับ IPhone7 16GB กรุณาทำการสมัครสมาชิก <a href="playbet.php" style"color:red;">สมัครที่นี่</a>'; }else{ echo 'ทำการฝากเงินขั้นต่ำ 300 บาท ลุ้นรับ IPhone7 16GB เพียงทายผล Point ถูก 12 คู่ ติดกัน. <a href="playbet.php" style"color:red;">ฝากเงิน</a>';  } ?>
			</div>
			<?php } ?>
			
        </div>
      </div>
      
    </div>
</div>

  <div style="width:1030px; margin:auto;  overflow:hidden; background:url(bg-body.png);  ">
  
  <table width="1050" height="71" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><img src="images/logovegus.png" /></td>
      <td align="center"><img src="images/logosbobet.png" /></td>
      <td align="center"><img src="images/logogclub.png" /></td>
      <td align="center" ><a href="playbet.php"  ><img src="images/menu.png" class="bw" /></a></td>
    </tr>
  </table>
  <hr />
  <div style="color:green; font-size:36px; text-align:center;">ทายผล Point 12คู่ติด ลุ้น iPhone7 <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#promotion">ตรวจสอบสิทธิ์</button></div>
  <hr />
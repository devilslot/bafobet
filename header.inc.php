<?php
@session_start();

require_once "service/service.php";
require_once "creation/creation.init.php";
//$slide = $ojc->LoadSlide();

##cookie em##
if($_SESSION['cookieem']==''){
echo '
<img src="http://aff.512xiaojin.com/Accept.ashx?sid=003413af-5ba6-4091-841e-56f5b604763a&lang=th-th&aid=759&cid=c64af71a-bc4d-46e7-8ac2-acea90c5b938" width="1" height="1" />
<img src="http://banners.dfbanners.com/redirect.aspx?pid=6638&bid=3801&lpid=874" width="1" height="1" />';

$_SESSION['cookieem']='Sure';

echo '
<script> location.reload(); </script>';
}


//echo 'datestart '.date('Y-m-d H;i:s',$datestart).' | datestop '.date('Y-m-d H;i:s',$datestop);

$sql="SELECT * FROM members WHERE code = '".$_SESSION[MEMBER]['DATA']['code']."';";
$query=mysql_query($sql,$conn);
$memberdata=mysql_fetch_assoc($query);

$dgpt = date('d',strtotime('-12 hours', strtotime(date('Y-m-d H:i:s'))));
//echo $dgpt;

if(isset($_GET['getpoint']) and $memberdata['getpoint']!=$dgpt){

$sqlup="UPDATE members SET score=score+500, getpoint='".$dgpt."' WHERE code = '".$_SESSION[MEMBER]['DATA']['code']."';";
$queryup=mysql_query($sqlup,$conn);


$sqlup2="insert into playgame (matchID,point,winloss,memberID,status,cal,gametype,user_create,user_update,date_create,date_update)value('GETPOINT','500','1.00','".$memberdata['code']."','1','1','point','".$memberdata['username']."','".$memberdata['username']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."') ";
$queryup2=mysql_query($sqlup2,$conn);

?>
<script>
    alert("เติม 500 Point สำเร็จ!");
	window.location="index.php";
</script>
<?

}else if(isset($_GET['getpoint']) and $memberdata['getpoint']==$dgpt){
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

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $title; if($_SESSION[MEMBER]['DATA']['username']!=''){ echo $_SESSION[MEMBER]['DATA']['username']." - "; } ?>BAFOBET ทายผลบอล แทงบอลฟรี ผลบอลสด อัพเดทผลบอล โปรแกรมบอลวันนี้ ลิ้งค์บอลสด</title>
 
  	<meta property="og:title" content="BAFOBET ทายผลบอล แทงบอลฟรี ผลบอลสด อัพเดทผลบอล โปรแกรมบอลวันนี้ ลิ้งค์บอลสด" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://<?=$_SERVER[HTTP_HOST]?><?=$_SERVER[REQUEST_URI]?>" />
	<meta property="og:image" content="https://www.bafobet.com/images/log.png" />

  <meta name="description" content="<?php echo $des; ?>BAFOBET ทายผลบอล แทงบอลฟรี ผลบอลที่ไม่เหมือนใครมาก่อนเปลี่ยนสกอร์แบบเรียวไทม์หรือที่เรียกกันว่า ผลบอลสด ผลบอลภาษาไทย อ่านง่ายเข้าใจง่ายเช็คผลบอลวันนี้ก่อนใครที่นี่พร้อม ทีเด็ดบอล ที่แม่นที่สุดในเอเชียตะวันออกใต้ Livescore ภาษาไทยที่รวดเร็วที่สุดที่นี่ที่เดียว"/>
  <meta name="keywords" content="<?php echo $keyword; ?>true money , truewallet , ทรูมันนี่ , sbobet , vegus168 ,  gclub , truewallet sbobet , แทงบอลด้วยบัตรทรู">
  <meta name="author" content="bafobet.com">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.css" rel="stylesheet">

<script src="js/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="js/bootstrap.min.js"></script>

<script src="js/function.js"></script>
  <style type="text/css">
  <!--
  html {

}

  body {
  background-color:#333333;
   margin-left: 0px;
   <?php if($_SESSION[MEMBER]['LOGIN'] == "ON") { echo "margin-top: 40px;"; }else{ echo "margin-top: 0px;"; } ?>
   margin-right: 0px;
   margin-bottom: 0px;
   background:url(images/bg%20.jpg) top center;
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

#topline {
height:40px;
line-height:40px;
background-color:#333333;
border-bottom-width:1px;
border-bottom-style:solid;
border-bottom-color:#666;
position:fixed;
top:0;
right:0;
left:0;
 -webkit-border-radius:0px;
  -moz-border-radius:0px;
  border-radius:0px;
  z-index:999;
}
#topline .container {
max-width:1050px;
}

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

.table-bordered {
border-color:#333333;
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


<!--<div style="position:fixed; top:0; left:0; right:0; background-color:#FF0000; height:1000px; color:#FFFFFF; text-align:center; z-index:999;"><h3>ขณะนี้เว็บไซต์กำลังประสบปัญหาด้านเทคนิค อาจจะทำให้ไม่สามารถเข้าเว็บไซต์ได้เป็นระยะ </h3><h2>แจ้งปิดปรับปรุงเว็บไซต์ 00:20 น - 03:00 น.</h2></div>


<div style="position:fixed; height:300px; background-color:#FF0000; color:#FFFFFF; top:0; right:0; left:0; text-align:center;"><h1>ปิดปรับปรุงเว็บไซต์ 22:30น. - 23.59น.</h1></div>-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.7&appId=892483494211866";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


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

<?php if($_SESSION[MEMBER]['LOGIN'] == "ON") {?>
<div id="topline">
	  	<div class="container">
			<div style="float:left;">
				<span style="color:#FFFFFF; text-align:left;"><span class="glyphicon glyphicon-user"></span> ยินดีต้อนรับ <strong><?php echo $_SESSION[MEMBER]['DATA']['username'];?></strong></span>
			</div>
			<div style="float:right; text-align:right;">
				<button type="button" class="btn btn-primary btn-sm" onClick="openchangepass()"><span class="glyphicon glyphicon-refresh"></span> เปลี่ยนรหัส</button>
				<button type="button" class="btn btn-primary btn-sm" onClick="openchangepic()" ><span class="glyphicon glyphicon-picture"></span> รูปโปรไฟล์</button> 
				<a href="viewmemberplay.php?refID=<?php echo $_SESSION[MEMBER]['DATA']['code'];?>">
					<button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-align-justify"></span> ประวัติการทายผล</button>
				</a> 
				<a href="playbet.php"><button type="button" class="btn btn-primary-s btn-sm"><span class="glyphicon glyphicon-usd"></span> ฝากเงิน</button></a>
				<a href="logout.php" style="color:#FFCC33;">
					<button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ</button>
				</a> | 
			
	  	
		
			
<?php if($memberdata['getpoint']!=$dgpt){ ?>
<a href="<?=$_SERVER["REQUEST_URI"]?>?&getpoint=y" style="color:#FFCC33;"><button type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus-sign"></span> รับฟรี 500 Point ต่อวัน</button></a> 
<?php }else{
?>
<button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-plus-sign"></span> รับฟรี Point ได้อีกครั้ง 12:00 น.</button>
<?php
} 


if($member['bonus1']=='N'){
$sql="SELECT gametype FROM playgame WHERE memberID = '".$_SESSION[MEMBER]['DATA']['code']."' AND gametype='rank' limit 5; ";
$query=mysql_query($sql,$conn);
$bonrank = mysql_num_rows($query);

$sql2="SELECT gametype FROM playgame WHERE memberID = '".$_SESSION[MEMBER]['DATA']['code']."' AND gametype='point' limit 1; ";
$query2=mysql_query($sql2,$conn);
$bonpoint = mysql_num_rows($query2);


 if($bonrank>=5 and $bonpoint>=1){ ?>
<a href="playbet.php?&getpoint100=y" style="color:#FFCC33;"><button type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus-sign"></span> รับฟรี 100 เครดิต คลิกที่นี่</button></a>
<?php } } ?>
</div>
</div>
</div>
<?php } ?>


	  
 <div class="style54" style="width:1050px; margin:auto;">
<?php if($_SESSION[MEMBER]['LOGIN'] != "ON") {?>
   <table width="100%" border="0">
    <tr>
      <td width="41%"><a href="https://www.bafobet.com/"><img src="images/logo.png" width="400"  /></a></td>
      <td width="59%"><div style="color:#FFFFFF; font-family:Tahoma;"><span class="style67">USERNAME :</span> 
        <input type="text" name="user" class="mydata" id="user" style="border:solid 1px #FECC56; background:#000000; width:115px; height: 27px; color:#FFFFFF;" />
        <span class="style67">PASSWORD :</span> 
        <input type="password" name="pass"  class="mydata" id="pass" style="border:solid 1px #FECC56; background:#000000; width:115px; height: 27px; color:#FFFFFF;" />
        &nbsp; 
        <input type="button" onClick="me.Login()" name="button" id="button" value="เข้าระบบ" style="border:solid 1px #FECC56; background:#FECC56; width:70px; height: 30px; color:#000;" />
        <!--<a class='iframe' href="register.php">-->
		<a href="playbet.php"><input type="button" style="border:solid 1px #FECC56; background:#000; width:120px; height: 30px; color:#fecc56; float:right; text-align:center; line-height:28px;" value="สมัครสมาชิก" /></a>
		
		<!--<input type="button" name="button2" id="button2" value="สมัครสมาชิก" style="border:solid 1px #FECC56; background:#000; width:70px; height: 30px; color:#fecc56;"/>
		</a>-->
      </div></td>
    </tr>
  </table>
<?php }else{ ?>
   <table width="100%" border="0">
    <tr>
      <td width="41%"><a href="https://www.bafobet.com/"><img src="images/logo.png" width="400"  /></a></td>
      
      
	  <td width="40%">
	  
	  
	  
	  <div style="overflow:hidden; margin:10px 5px 0 -10px;">
	  
	  <div style="width:90px; height:90px; float:right; border:solid 1px #999999; margin:0px 0 0 10px; overflow:hidden;">
				<?php  if ( $_SESSION[MEMBER]['DATA']['photo']!='') { ?>
                 <img src="thumb.php?src=memberpic/<?php echo $_SESSION[MEMBER]['DATA']['photo'];?>&w=90&q=100" width="90" />
                  <?php }else{ ?>
                  <img src="thumb.php?src=images/pro-pic.jpg&w=90&q=100" width="90" />
                  <?php } ?>
	    </div>
				 
	  
	  
	  <div style="width:150px; float:right; margin-left:10px;">
		  <div class="panel-group">
			  <div class="panel" style="background-image:url(images/menu_bg.png);">
					<div class="panel-heading text-center" style="font-size:16px; font-weight:bold; color:#663300;">Rank</div>
					<div class="panel-body text-center" style="background-color:#000000;"><strong><?php echo number_format($memberdata['rank']); ?></strong> คะแนน</div>
			  </div>
		  </div>
	  <div class="clearfix"></div>
	  </div>
  
	<div style="width:150px; float:right; margin-left:10px;">
		  <div class="panel-group">
			  <div class="panel" style="background-image:url(images/menu_bg.png);">
					<div class="panel-heading text-center" style="font-size:16px; font-weight:bold; color:#663300;">Point</div>
					<div class="panel-body text-center" style="background-color:#000000;"><strong><?php echo number_format($memberdata['score']); ?></strong> คะแนน</div>
			  </div>
		  </div>
	  <div class="clearfix"></div>
	  </div>
	</div>
	  </td>
	  
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
        
 <div style=" background:url(images/bg-body.png); width:500px; padding:10px; border:#1d1d1d solid 1px; margin:auto;">
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
			
			
			<p>
			<h3>กติกาการชิงรางวัล iPhone7 32GB</h3><hr>
			1. <strong>สมาชิกที่จะเข้าร่วมกิจกรรมชิง iPhone7 32GB</strong> <br />
			- จะต้องเคยฝากเงินจริงกับ bafobet มากกว่า 300 บาท หรือบัตรเงินสด มากกว่า 350 บาท ขึ้นไป<br />
			<br />

			2. <strong>รางวัล iPhone7 32GB มีแค่ 1 รางวัลเท่านั้น</strong> <br />
			- ในกรณีที่มีผู้ชนะพร้อมกันเกิน 1 คน จะดูคะแนน rank ของเดือนนั้นๆแทน ใครคะแนนสูงกว่าถือเป็นผู้ได้รับรางวัล <br />
			- ถ้าเสมอกันให้นำ point มาคิดแทน <br />
			- ถ้าทั้ง rank และ point เท่ากันหมด  รางวัลจะถูกหารสอง<br /><br />

			3. <strong>การทายผล</strong> <br />
			- จะต้องเกิดขึ้นในวันเดียวกัน นับจาก 12:00 น. - 11:59 น. (เที่ยงวัน ถึง เที่ยงวัน)  <br />
			- ถ้ามีการข้ามวันถือว่า "โมฆะ"<br /><br />

			4. <strong>การรับรางวัล</strong> <br />
			- สมาชิกจะได้รับรางวัลเป็น "เครดิต" มูลค่าเทียบเท่า iPhone7 32GB<br />
			- สามารถถอนได้ทันที<br /><br />
			</p>
			
			<?php if($moncredit>=300){?>
			<div class="alert alert-success">
			  <strong>ท่านมีสิทธ์!</strong> ลุ้นรับ IPhone7 32GB เพียงทายผลถูก 10 คู่.
			</div>
			<?php }else{ ?>
			
			<div class="alert alert-danger">
			  <strong>ท่านยังไม่ได้รับสิทธ์!</strong><br /><?php if($moncredit==''){ echo 'ลุ้นรับ IPhone7 32GB กรุณาทำการสมัครสมาชิก <a href="playbet.php"><span style="color:red;">สมัครที่นี่</span></a>'; }else{ echo 'ทำการฝากเงินขั้นต่ำ 300 บาท เกิน 24 ชม. ลุ้นรับ IPhone7 32GB เพียงทายผล Point ถูก 10 คู่ <a href="playbet.php"><span  style="color:red;">ฝากเงิน</span></a>';  } ?>
			</div>
			<?php } ?>
        </div>
      </div>
      
    </div>
</div>

  <div style="width:1030px; margin:auto;  overflow:hidden; background:url(images/bg-body.png);  ">
  
  
  <table width="1000" align="center" class="table table-bordered" style="margin-top:10px;" height="71" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><a href="https://www.bafobet.com/vegus168" target="_blank"><img class="img-responsive" src="images/logovegus.png" /></a></td>
      <td align="center"><a href="https://www.bafobet.com/sbobet" target="_blank"><img class="img-responsive" src="images/logosbobet.png" /></a></td>
      <td align="center"><a href="https://www.bafobet.com/gclub" target="_blank"><img class="img-responsive" src="images/logogclub.png" /></a></td>
	  <td align="center"><a href="https://www.bafobet.com/tbsbet" target="_blank"><img class="img-responsive" src="images/logotbsbet.png" /></a></td>
	  <td align="center"><a href="https://www.bafobet.com/fifa55" target="_blank"><div style="background-color:#CCCCCC;"><img class="img-responsive" src="images/logofifa55.png" /></div></a></td>
	  <td align="center"><img class="img-responsive" src="images/truewallet.png" /></td>
      <td align="center" ><a href="playbet.php"  ><img src="images/menu2.png" class="bw" /></a></td>
    </tr>
  </table>
  
  <!--<div style="background-color:#F90; color:#930000; width:90%; margin:0 auto; text-align:center; padding:30px 0;">
  <h1>bafobet <strong>แจ้ง</strong> เวลาทำการ ช่วงเทศกาลปีใหม่</h1>
	  <p>ปิดถอน 2 วัน 31 ธันวาคม  - 1 มกราคม<br>
      </p>
	  <p>วันที่ 31 ธันวาคม ปิดให้บริการ 20.00 - 08.00<br>
      วันที่ 28 ธันวาคม - 2 มกราคม ปิดให้บริการ ฝาก 24.00 - 08.00 </p>
	  <p><strong>นอกนั้นเปิดทำการปกติ</strong></p>
  </div>
  <hr />-->
  <p align="center">
  เว็บ <a href="https://www.bafobet.com">ผลบอลสด</a> แจกเครดิต <a href="https://www.bafobet.com">แทงบอลฟรี</a> กับ <a href="https://www.bafobet.com">Bafobet.com</a></p>
  <hr />
  <p align="center" style="font-size:20px;">
  <span style="color:#FF0000;">***</span>Bafobet.com <strong style="color:#FFFF00; font-size:24px;"><u>ฝากเงิน</u></strong> ได้ตลอด 24 ชม. | <strong style="color:#FFFF00; font-size:24px;"><u>ถอนเงิน</u></strong> ได้เวลา 08:00 - 22:00 น.
  </p>
  <hr />
  <!--<div style="color:green; font-size:36px; text-align:center;">Bafobet เปิดระบบทายผล ปกติ</div>-->
  <div style="color:green; font-size:36px; text-align:center;">ทายผล 10 คู่ติด ลุ้น iPhone7 <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#promotion">ตรวจสอบสิทธิ์</button></div>
  <hr />
 
 <div style="width:700px; margin:0 auto; background-color:#8D6212; border:solid 2px #FFFF00; padding:15px;"> <h2 style="color:#FFFF00;"><span class="glyphicon glyphicon-usd"></span> โบนัสพิเศษ</h2> 1. โบนัสเงินฝาก 10% เทิร์นเพียง 1 เท่า | 2. แนะนำเพื่อน รับโบนัสสูงสุด 500 บาท <a href="#demo" data-toggle="collapse"><button type="button" class="btn btn-primary">รายละเอียด คลิกที่นี่</button></a><br />
<p align="center"><br><img src="images/lineba.png"><br>
 และ Chat หน้าเว็บไซด์ www.bafobet.com นะครับ</p>
  <div id="demo" class="collapse">
  <hr />
   <strong>1. โบนัสเงินฝาก 10% เทิร์นเพียง 1 เท่า</strong><br /><br />


<p>โบนัสพิเศษ สำหรับ ลูกค้า Bafobet.com</p>
        <p>รับฟรี โบนัสเงินฝาก 10%  รับได้สูงสุดไม่เกิน 100 บาท รับได้ทุกวัน </p>
		<p>
		<br /><br />
		<div align="center"><u>โปรโมชั่นโค้ด คูปอง</u><br />
		#####################################<br /><br />
		FREEBONUS10P<br /><br />
		#####################################<br />
		</div>
		</p>
        <p>*ฝากผ่านบัตรเงินสด และ True Wallet ไม่ร่วมรายการ<br />
          *ยอดเทิร์น 1 เท่า ถอนได้ทันที</p>
		  
		  <hr />
		  <p>
<h3>โบนัสแนะนำเพื่อน 5%</h3> สมาชิกจะได้รับ 5% จากยอดฝากครั้งแรกของเพื่อนที่สมัครผ่านท่านนะ     เมื่อท่านแนะนำ เพื่อนมาเล่นกับทางเรา หลังจากที่เพื่อนสมัครสมาชิกและฝากเงินครั้งแรกเสร็จ ให้สมาชิกติดต่อ พนักงาน Bafobet เพื่อรับ โบนัส 5% ได้ทันที		  </p>


<strong>มีข้อสงสัย แนะนำ ติดต่อได้ที  Line : bafobet และ Chat หน้าเว็บไซด์ www.bafobet.com นะครับ</strong>

  </div>
</div>
  <hr />
  
<a href="promotion.php?tab=1#cont"><div align="center"><img src="images/banner1.png" width="728" height="90" /></div></a>
<hr />
<a href="promotion.php?tab=2#cont"><div align="center"><img src="images/banner2.png" width="728" height="90" /></div></a>
<hr />
<?
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";
if(empty($_GET['dateMatch'])){
  $date= date('Y-m-d');
  //$dateminus1= strtotime('-1 day', date('Y-m-d'));
}else{
  $date = $_GET['dateMatch'];
}

if(empty($_GET['matchID'])){
  $matchidsql = '';
}else{
  $matchidsql = " AND matchID = '".$_GET['matchID']."' ";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $config['titles'];?></title>
  <meta name="description" content="<?php echo $config['descriptions'];?>"/>
  <meta name="keywords" content="<?php echo $config['keywordss'];?>"/>
  <meta name="author" content="bafobet.com">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta name="googlebot" content="index,follow">
  <meta name="googlebot" content="noodp">
  <meta name="robots" content="index,follow">
  <meta name="robots" content="noodp">
  <meta name="Revisit" content="1 days">
  <meta name="Revisit-after" content="1 days">
  <style type="text/css">
  <!--
  body {
   margin-left: 0px;
   margin-top: 0px;
   margin-right: 0px;
   margin-bottom: 0px;
   background:url(bg%20.jpg) top center;
 }
 .style18 {color: #FFFFFF; font-family: Tahoma; font-size: 13px; }
 .style20 {color: #FFCC00ว}
 .style22 {
   font-size: 14px;
   font-family: Tahoma;
   color: #FF9933;
 }
 .style5 {color: #FFFF00;
   font-weight: bold;
   font-family: Tahoma;
   font-size: 16px;
 }
 .style24 {color: #FFCC33}
 .style25 {font-size: 14px; font-family: Tahoma; color: #FFCC00; }
 .style26 {font-size: 14px; font-family: Tahoma; color: #FFCC33; }
 .style27 {color: #EDD881}
 .style28 {font-size: 12px; font-weight: bold; font-family: Tahoma;}
 .style29 {color: #FFFFFF}
 -->
 div {
  -webkit-border-radius:5px;
  -moz-border-radius:5px;
  border-radius:5px;
}
.style31 {font-family: Tahoma; font-size: 14px; }
.style54 {font-size: 12}
.style55 {font-weight: bold; font-family: Tahoma; color: #FFFF00;}
.style56 {font-family: Tahoma; color: #000000; font-weight: bold;}
.style57 {font-family: Tahoma}
.style59 {font-size: 12px; font-family: Tahoma; }
.style60 {font-size: 12px}
.style62 {color: #FF0000}
.style63 {
	color: #0066CC
}
.style64 {color: #9DB333}
.style65 {font-size: 12px; font-family: Tahoma; color: #9DB333; }
.style67 {font-size: 14px}
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



<link rel="stylesheet" href="colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="jquery.colorbox.js"></script>
<script>
$(document).ready(function(){

  $(".iframe").colorbox({iframe:true, width:"800px", height:"550px"});

				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
</script>

<style type="text/css">
<!--
.style68 {font-size: 12px; font-family: Tahoma; color: #CCCCCC; }
-->
</style>
<script language="javascript">
function fnPopUpWindow(matchID) {
  popupwindow("playgame.php?matchID="+matchID, "printViewer", "640", "480");
}

function fnPopUpWindow2(matchID) {
  popupwindow("comment.php?matchID="+matchID, "printViewer", "800", "600");
}


function popupwindow(url, title, w, h) {
  var left = Math.round((screen.width/2)-(w/2));
  var top = Math.round((screen.height/2)-(h/2));
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, '
    + 'menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w 
    + ', height=' + h + ', top=' + top + ', left=' + left);
}

function selec(){
  var ab=document.getElementById('se');
  location.href=ab.value;
}
</script>
</head>

<body onload="MM_preloadImages('images/menu2_01.png','images/menu2_02.png','images/menu2_03.png','images/menu2_04.png','images/menu2_05.png','images/menu2_06.png','images/menu2_07.png','images/menu2_08.png')">
 <?php include('header.php');?>
 <div style="width:1030px; margin:auto;  overflow:hidden; background:url(bg-body.png);  ">
  <?php include ('left.php');?>
  <div style="width:790px; float:right; ">
    <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">

      <tr>
        <td height="35" bgcolor="#000000">
          <?php
		  //AND DATE_FORMAT(date_create,'%Y-%m-%d') = '".$date."'
          $sqlm="
          SELECT
          memberID,matchID
          FROM
          playgame
          WHERE
          ".$matchidsql."
          ORDER BY
          code
          DESC
		  LIMIT 100
          ;";
       // echo $sql;
          $querym=mysql_query($sqlm);
          while($rowm=mysql_fetch_assoc($querym)){
            $user  = DisplayUser($rowm['memberID']);
            ?>

            <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
              <tr>
                <td width="100%" bgcolor="#000000" colspan="6" valign="top">
                  <div class="scroll">
                    <table width="100%" style="hight:100px;">
                      <tr>
                        <td  width="10%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทาย</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">แต้ม</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">สถานะ</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ได้-เสีย</span></div></td>
                      </tr>
                      <?php
                      $sql="
                      SELECT
                      md.*,pg.bet,pg.bet,pg.hdc,pg.point,pg.winloss,pg.status
                      FROM
                      matchHDC md,playgame pg
                      WHERE
                      md.MatchID = pg.matchID AND
                      pg.memberID = '".$rowm['memberID']."'
                      ORDER BY
                      pg.code
                      DESC
                      ;";
       // echo $sql;
                      $query=mysql_query($sql);
                      $loop=0;
                      while($row=mysql_fetch_assoc($query)){
                        $loop++;
                        if($loop % 2 == 0){
                          $bg ="#282828";
                        }else{
                          $bg ="#1D1D1D";
                        }
                        $current_time = $row['Date'];
                        $new_time = strtotime($current_time);
                        ?>
                        <tr>
                          <td height="35" bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php echo date('d/m/Y H:s',$new_time);?></span></div></td>
                          <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" ><span class="style18">
                            <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
                            <?php echo trim($row['HomeName']);?><br/>( <font color="#B1FB17"><?php echo trim($row['ScoreHomeFullTime']);?></font> )
                            <? if ($row['ratio'] == 1)  { ?></div><? } ?>
                          </span></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
                           <div align="center" class="style25"><?php echo $row['bet'] == '1' ? 'HOME' : 'ALWAY'; ?></div>                          </div></td>
                           <td bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18">
                            <? if ($row['ratio'] == 2) { ?><span class="red">* <? } ?>
                            <?php echo $row['AwayName'];?><br/>( <font color="#B1FB17"><?php echo trim($row['ScoreAwayFulltime']);?></font> )
                            <? if ($row['ratio'] == 2)  { ?></span><? } ?>
                          </span></div></td>
                          <?php 
                          if($row['status'] == 0){
                            $txt = "เสีย";
                            $color = "#F62217";
                          }else  if($row['status'] == 1){
                            $txt = "ได้";
                            $color = "#B1FB17";
                          }else{
                            $txt = "เสมอ";
                            $color = "#ffffff";
                          }
                          ?>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><?php echo $row['hdc'];?></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="#ffffff"><?php echo $row['point'];?></font></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $txt;?></font></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $row['winloss'];?></font></div></td>
                        </tr>
                        <?php 
                      } 
                      mysql_free_result($query);
                      ?>
                    </table>
                  </div>
                </table>
                <br />
                <?php 
              } 
              mysql_free_result($querym);

              ?>

            </td>
          </tr>
        </table>

      </div>
    </div>

    <?php include('footer.php');?>
  </body>
  </html>

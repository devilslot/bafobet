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
$data = $ojc->LoadMatch($_GET['matchID']); 
$c =$ojc->CountC($_GET['matchID']); 
$h =$ojc->CountH($_GET['matchID']); 
$a =$ojc->CountA($_GET['matchID']); 
// $d =$ojc->CountD($_GET['matchID']); 
if($c==0){
  $c=1;
}
$home = ceil(($h/$c)*100);

$alway = floor(($a/$c)*100);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ทายผลฟุตบอล</title>
  <style type="text/css">
  <!--
  body {
   margin-left: 0px;
   margin-top: 0px;
   margin-right: 0px;
   margin-bottom: 0px;
   background-color:#222222;
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
 .style18 {color: #FFFFFF; font-family: Tahoma; font-size: 13px; }
 .style20 {color: #FFCC00;}
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
 .style28 {font-size: 14px; font-weight: bold; font-family: Tahoma;}
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
.badge,.tag,.sign{background-color:#000;color:#fff;display:inline-block; padding:2px 6px; text-align:center; position:relative; top:-20px; left:-18px; font-size:11px; font-family:tahoma; font-weight:bold;}
.badge{border-radius:50%}
.redc { color:#FFF; background:#B9282C; }
.blue { color:#FFF; background:#0C69DC; }
.yullow { color:#111; background:#FFCC00; }
 -->
 </style>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 <script type="text/javascript" src="main/main.func.js"></script>
 <script type="text/javascript" src="creation/creation.script.js"></script>

</head>
<?php
$sql="SELECT * FROM members WHERE code = '".$_SESSION[MEMBER]['DATA']['code']."';";
$query=mysql_query($sql,$conn);
$memberdata=mysql_fetch_assoc($query);


?>
<body>
 <div style="  width:680px; min-height:450px; padding:10px;  margin:auto; background:url(images/bg-body.png); ">
  <table width="100%" border="0">
    <?php
    $new_time = strtotime($data['Date']);
    ?>
    <tr>
      <td height="35" colspan="5"><div align="center"><span class="style7"><?php echo $data['LeagueEngName'];?>&nbsp; - <?php echo date('H:i', $new_time);?> น.</span></div></td>
    </tr>
    <tr>
      <td width="35%" height="35" background="images/bg-menu1.jpg"><div align="center"><span class="style13">เจ้าบ้าน</span></div></td>
      <td colspan="3" background="images/bg-menu1.jpg"><div align="center"><span class="style13">ราคา</span></div></td>
      <td width="34%" background="images/bg-menu1.jpg"><div align="center"><span class="style13">ทีมเยือน</span></div></td>
    </tr>
    
    <tr>
      <td height="35"><div align="center"><span class="style5">
       <? if (strlen(number_format($data['AsianHandicap'],2))=='4') { ?><div style="color:red;"><? } ?>
       <?php echo $data['HomeName'];?>
       <? if (strlen(number_format($data['AsianHandicap'],2))=='4')  { ?>*</div><? } ?>
     </span></div></td>
     <td width="10%"><div align="center">
    </div></td>
    <td width="12%"><div align="center"><span class="style6"><?php echo $data['AsianHandicap'];?><input type="hidden" name="hdc" id="hdc" class="mydata" value="<?php echo $data['AsianHandicap'];?>"></span></div></td>
    <td width="9%"><div align="center">
    </div></td>
    <td align="center"><span class="style5">
     <? if (strlen(number_format($data['AsianHandicap'],2))=='5') { ?><span style="color:red;">* <? } ?>
     <?php echo $data['AwayName'];?>  
     <? if (strlen(number_format($data['AsianHandicap'],2))=='5')  { ?></span><? } ?>
   </span></td>
 </tr>
 <tr>
      <td height="35" colspan="5"><div align="center" style="color:#FF0000;">*ราคาติดลบคือทีมเยือนต่อ</div>        </td>
    </tr>
  <?php if($new_time >  time()){ ?>
  <tr>
  <td height="35" colspan="5">
    <table width="100%">
      <tr>
        <td align="center" style="width:50%; background-color:#AF7817;font-family: Tahoma; font-size: 18px; font-weight: bold; color: #ffffff;">เลือกทายผล</td>
        <td align="left" style="width:50%;" >
          <select name="bet" class="mydata" id="bet" style="background:#000000; font-size:20px; text-align:center; border:solid 1px #CCCCCC; width:120px; height:40px; color:#F88017;">
          <option value=''>--</option>
          <option value='1'>เจ้าบ้าน</option>
          <option value='2'>ทีมเยือน</option>
        </select></td>
      </tr>
    </table>  </tr>
 <tr>
  <td height="35" colspan="5">
    <table width="100%">
      <tr>
        <td align="center" style="width:50%; background-color:#AF7817;font-family: Tahoma; font-size: 18px; font-weight: bold; color: #ffffff;">จำนวนคะแนน 
        <?php if($_SESSION[MEMBER]['LOGIN'] == 'ON'){?>(เหลือ <?=$memberdata['score']?> Point)<?php } ?><br />
<SPAN style="size:11px; color:#FF0000;">*ทายผลต่อคู่ 100-2000 Point</SPAN></td>
        <td align="left" style="width:50%;"><input name="point" type="text" class="mydata" id="point" onkeyup="checkpoint()" style="background:#000000; font-size:20px; text-align:center; border:solid 1px #CCCCCC; width:90px; height:40px; color:#F88017;" maxlength="4" />
        <span style="color:#FF0000; font-size:12px;">* ทายผล Rank ไม่ต้องระบุช่องนี้</span></td>
      </tr>
    </table>  </tr>
  <?php }else{ ?>
  <tr>
      <td width="35%" height="45" ><div align="center" style="font-size:36px;" class="style25"><?php echo trim($data['ScoreHomeFullTime']);?></div></td>
      <td colspan="3"><div align="center" style="font-size:36px;"><span class="style13"> - </span></div></td>
      <td width="34%"><div align="center" style="font-size:36px;" class="style25"><?php echo trim($data['ScoreAwayFulltime']);?></div></td>
    </tr>
  <?php } ?>
  <tr>
    <td height="35" colspan="5">
      <table width="100%">
        <tr>
          <td align="center" style="width:<?php echo $home;?>%; background-color:#FF0013;font-family: Tahoma; font-size: 18px; font-weight: bold; color: #ffffff;"><?php echo $home;?>%</td>
          <td align="center" style="width:<?php echo $alway;?>%; background-color:#0665BA;font-family: Tahoma; font-size: 18px; font-weight: bold; color: #ffffff;"><?php echo $alway;?>%</td>
        </tr>
    </table>    </tr>
    

    <tr>
      <td height="50" colspan="5"><div align="center">
      <?php  if($new_time >  time() and $new_time < $datestop){ ?>
		  <br />
			<input type="hidden" name="matchID" id="matchID" class="mydata" value="<?php echo $_GET['matchID'];?>"/>
			<?php if($_SESSION[MEMBER]['LOGIN'] == "ON") {?>
			<?php
			$sqlpoint="
			  SELECT
			  code
			  FROM
			  playgame
			  WHERE
			  matchID = '".$_GET['matchID']."' AND gametype='point' AND gameeven='' AND memberID = '".$_SESSION[MEMBER]['DATA']['code']."'
			  ;";
			  //echo $sqlpoint;
			  $querypoint=mysql_query($sqlpoint) or die(mysql_error());  
			  $numpoint=mysql_num_rows($querypoint);
			 	$rowd=mysql_fetch_assoc($querypoint);
				
			  if($numpoint>0){ 
			  echo '<span style="color:#FF0000;">ทายผล Point ไปแล้ว</span>';
			  ?>
			  <input type="button" onclick="me.PlayGameA(<?=$rowd['code'];?>)" name="button" id="button" value="+Point" style="width:50px; height:30px; background:#FF9900; color:#000000; font-size:14px; border:solid 1px #FFCC33;" /> | 
			  <?php
			  }else{
			  ?>
			<input type="button" onclick="me.PlayGame()" name="button" id="button" value="ทายผล Point" style="width:100px; height:40px; background:#FF9900; color:#000000; font-size:14px; border:solid 1px #FFCC33;" />
			
			<?php
			}
			
			


			$sqlm="
			  SELECT
			  matchID
			  FROM
			  playgame
			  WHERE
			  memberID = '".$_SESSION[MEMBER]['DATA']['code']."' AND gametype='rank' AND unix_timestamp(date_create) > '".$datestart."'
			AND unix_timestamp(date_create) < '".$datestop."'
			  ;";
			  //echo $sqlm;
			  $querym=mysql_query($sqlm) or die(mysql_error());  
			  $num=mysql_num_rows($querym);
			
			  $num2 = (5-$num);
			  $stat =0;
			  while($rows=mysql_fetch_assoc($querym)){
				if($rows['matchID']==$_GET['matchID']){ $stat = 1; }
			  }
			 
			 if($stat==1){ echo '<span style="color:#FF0000;"> | ทายผล Rank ไปแล้ว | </span>'; }else{
			?>
			<input type="button" onclick="me.PlayGameRank()" <?php if($num2<=0 ){?> disabled="disabled" style="width:120px; height:40px; background-color:#CCCCCC;" <? } ?> name="button" id="button" value="ทายผล Rank [<?php echo  $num2; ?>]" style="width:120px; height:40px; background:#FF9900; color:#000000; font-size:14px; border:solid 1px #FFCC33;" />
			<?php }
			
			$sqlrank="
			  SELECT
			  code
			  FROM
			  playgame
			  WHERE
			  matchID = '".$_GET['matchID']."' AND gametype='point' AND gametype='point' AND gameeven='ip7' AND memberID = '".$_SESSION[MEMBER]['DATA']['code']."'
			  ;";
			  //echo $sqlpoint;
			  $queryrank=mysql_query($sqlrank) or die(mysql_error());  
			 	$rowr=mysql_fetch_assoc($queryrank);
				
			$sqlm="
			  SELECT
			  matchID
			  FROM
			  playgame
			  WHERE
			  memberID = '".$_SESSION[MEMBER]['DATA']['code']."' AND gametype='even' AND gameeven='ip7' AND unix_timestamp(date_create) > '".$datestart."'
			AND unix_timestamp(date_create) < '".$datestop."'
			  ;";
			  //echo $sqlm;
			  $querym=mysql_query($sqlm) or die(mysql_error());  
			  $num=mysql_num_rows($querym);
			
			  $num2 = (10-$num);
			  $stat =0;
			  while($rows=mysql_fetch_assoc($querym)){
				if($rows['matchID']==$_GET['matchID']){ $stat = 1; }
			  }
			 
			 if($stat==1){
			 echo '<span style="color:#FF0000;"> ทายผลลุ้น iPhone7 ไปแล้ว</span>';
			 }else{
			?>
			
			<input type="button" onclick="me.PlayGameEven()" <?php if($moncredit<300 or $num2<=0 ){?> disabled="disabled" style="width:160px; height:40px; background-color:#CCCCCC;" <? }else{ ?>style="width:160px; height:40px; background:#FF9900; color:#000000; font-size:14px; border:solid 1px #FFCC33;" <? } ?> name="button" id="button" value="ทายผลลุ้น iPhone [<?php echo  $num2; ?>]" />
			<?php
			
			}
			
		
		}else{ ?>
        <font color="#FDD017">* กรุณาเข้าสู๋ระบบก่อนทำการทายผล</font>
        <?php } 
		
		}else{
		
			if($new_time > $datestop){
				$txt = "ยังไม่เปิดทายผลคู่นี้";
			}else{
				$txt = "กำลังเริ่มการแข่ง หมดเวลาทายผล";
				if($data['Status']==1){ $txt = "กำลังแข่งครึ่งแรก"; }
				if($data['Status']==2){ $txt = "กำลังพักครึ่ง"; }
				if($data['Status']==3){ $txt = "กำลังแข่งครึ่งหลัง"; }
				if($data['Status']=='-1'){ $txt = "จบการแข่ง"; }
			}	
				echo'<font color="#FDD017">* '.$txt.'</font>';
			
		} ?>
      </div></td>
    </tr>
  </table>
  <br>
  <table width="100%" style="hight:100px;">
                        <tr  background="images/bg-menu1.jpg">
                          <td  width="15%" height="40" ><div align="center" class="style27"><span class="style28">เวลาทาย</span></div></td>
                          <td  width="30%"><div align="center" class="style27"><span class="style28">ผู้ที่ทายผล</span></div></td>
                          <td  width="15%"><div align="center" class="style27"><span class="style28">ทาย</span></div></td>
                          <td  width="15%"><div align="center" class="style27"><span class="style28">Point/Rank</span></div></td>
                          <td  width="15%"><div align="center" class="style27"><span class="style28">สถานะ</span></div></td>
                          <td  width="10%"><div align="center" class="style27"><span class="style28">ได้/เสีย</span></div></td>
                          
                        </tr>
                        <?php
                        $sql="
                        SELECT
                        *
                        FROM
                        playgame
                        WHERE
                  		matchID = '".$_GET['matchID']."'
                        ORDER BY
                        date_create DESC
                        ;";
       // echo $sql;
                        $query=mysql_query($sql);
                        $loop=0;
                        while($row=mysql_fetch_assoc($query)){
						if($row['gameeven']=='ip7'){ $streven='<img src="images/iphone.png" title="ร่วมกิจกรรมแจก iPhone7 32GB" width="16" height="24" />'; }else{ $streven=''; }
                          $loop++;
                          if($loop % 2 == 0){
                            $bg ="#282828";
                          }else{
                            $bg ="#1D1D1D";
                          }
                            $new_time = strtotime($row['date_create']);
                         ?>
                          <tr>
                            <td height="35" bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?></span></div></td>
                            <td bgcolor="<?php echo $bg;?>"><div align="center" ><span class="style25"><a href="viewmemberplay.php?refID=<?php echo $row['memberID'];?>" target="_blank"><?php echo trim($row['user_create']);?></a></span></div></td>
                            <td bgcolor="<?php echo $bg;?>"><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
                              
                              <div align="center" class="style25"><?php echo $row['bet'] == '1' ? 'เจ้าบ้าน' : 'ทีมเยือน'; ?></div>
                            </div></td>
                            
                            <td bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php if(trim($row['gametype'])=='point'){ echo $row['point']; }else if(trim($row['gametype'])=='rank'){ echo trim($row['gametype']); }else if(trim($row['gametype'])=='even'){ echo $streven; } ?></span></div></td>
                            
							
                            <?php 
                          if($row['status'] == 2){
                            $txt = "เสีย";
                            $color = "#F62217";
                          }else  if($row['status'] == 1){
                            $txt = "ได้";
                            $color = "#B1FB17";
                          }else if($row['status'] == 3){
                            $txt = "เสมอ";
                            $color = "#ffff00";
                          }else if($data['Status'] == '-1'){
						  	$txt = "รอคำนวณผล";
						  }else{
						  	$txt = "รอแข่ง";
                            if($data['Status']==1){ $txt = "1st"; }
							if($data['Status']==2){ $txt = "HT"; }
							if($data['Status']==3){ $txt = "2nd"; }
                            $color = "#ffffff";
							}
                          ?>
                            
                            <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $txt;?></font></div></td>
                          	<td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $row['winloss'];?></font></div></td>
                            
                          </tr>
                          <?php 
                        } 
                        mysql_free_result($query);
                        ?>
                  </table>
</div>
<script type="text/javascript">
$(document).ready(function () {
  //called when key is pressed in textbox
  $("#point").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message

        return false;
      }
    });
  $("#salway").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message

        return false;
      }
    });

});

function checkpoint()
{
    var point = $("#point").val();
    if(point>2000)
   {
       $("#point").val(2000);
   }
}

me.PlayGameEven=function(){

if($('#bet').val() == ""){
 alert('กรุณาเลือกคู่');
  return false;
}



var myData = {
  data : ft.LoadForm('mydata')
};


$.ajax({
  url:me.url+'?mode=PlayGameEven&'+new Date().getTime(),
  type:'POST',
  dataType:'json',
  data:myData,
  success:function(data){
    switch(data.success){
      case 'COMPLETE' :
      alert('ทายผลสำเร็จ!')
	  location.reload();
      break;
      case 'PLAY' :
      alert('คุณได้ทำการทายผลไปแล้ว!')
      break;
    }
  }
});


};


me.PlayGame=function(){

if($('#bet').val() == ""){
 alert('กรุณาเลือกคู่');
  return false;
}

if($('#point').val() == ""){
  alert('กรุณาใส่ จำนวนแต้ม');
  $('#point').focus()
  return false;
}

if($('#point').val()<100 || $('#point').val()>2000){
  alert('กรุณาใส่ ระหว่าง 100-2000 แต้ม');
  $('#point').focus()
  return false;
}


var myData = {
  data : ft.LoadForm('mydata')
};

$.ajax({
  url:me.url+'?mode=PlayGame&'+new Date().getTime(),
  type:'POST',
  dataType:'json',
  data:myData,
  success:function(data){
    switch(data.success){
      case 'COMPLETE' :
      alert('ทายผลสำเร็จ!')
	  location.reload();
      break;
      case 'POINT' :
      alert('จำนวนแต้มไม่เพียงพอ!')
      $('#point').val('')
       $('#point').focus()
      break;
      case 'PLAY' :
      alert('คุณได้ทำการทายผลไปแล้ว!')
      break;
    }
  }
});
};

me.PlayGameA=function(id){
//alert(id);
if($('#point').val() == ""){
  alert('กรุณาใส่ จำนวนแต้ม');
  $('#point').focus()
  return false;
}

if($('#point').val()<100 || $('#point').val()>2000){
  alert('กรุณาใส่ ระหว่าง 100-2000 แต้ม');
  $('#point').focus()
  return false;
}


var myData = {
  data : ft.LoadForm('mydata')
};

$.ajax({
  url:me.url+'?mode=PlayGameA&ID='+id+'&'+new Date().getTime(),
  type:'POST',
  dataType:'json',
  data:myData,
  success:function(data){
    switch(data.success){
      case 'COMPLETE' :
      alert('เพิ่ม Point สำเร็จ!')
	  location.reload();
      break;
	  
	   case 'POINTLIMIT' :
      alert('เพิ่ม Point ไม่ได้! Point ทายผลสูงสุดแล้ว!')
      break;
      case 'POINT' :
      alert('จำนวนแต้มไม่เพียงพอ!')
      $('#point').val('')
       $('#point').focus()
      break;
      case 'PLAY' :
      alert('คุณได้ทำการทายผลไปแล้ว!')
      break;
    }
  }
});
};


me.PlayGameRank=function(){

if($('#bet').val() == ""){
 alert('กรุณาเลือกคู่');
  return false;
}


var myData = {
  data : ft.LoadForm('mydata')
};

$.ajax({

  url:me.url+'?mode=PlayGameRank&'+new Date().getTime(),
  type:'POST',
  dataType:'json',
  data:myData,
  success:function(data){
  //alert(data.success);
    switch(data.success){
      case 'COMPLETE' :
      alert('ทายผลสำเร็จ!')
	   location.reload();
      break;
	   case 'LIMIT' :
      alert('ทายผล Rank ครบ5ครั้งแล้ว!')
      window.close();
      break;
      case 'PLAY' :
      alert('คุณได้ทำการทายผลไปแล้ว!')
      break;
    }
  }
});
};
</script>
</body>
</html>

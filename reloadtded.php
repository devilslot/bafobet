<?php
@session_start();
@header("Content-type: text/html; charset=utf-8");

$cachedir='cache'; // ชื่อแฟ้มเก็บไฟล์แคช 
$file='reloadtded.html'; // ชื่อไฟล์เว็บ
$cachefile=$cachedir.'/'.$file;
$cachetime =100;  // ระยะเวลา 100 วินาที 
// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
include($cachefile);
//echo " <p style='color:gray;font-size:0.7em;'> ข้อมูลเมื่อ ".date('jS F Y H:i', filemtime($cachefile))." </p> "; // แสดงข้อความเวลาที่บันทึก
//exit;
}else{

ob_start();


require_once "service/service.php";
require_once "creation/creation.init.php";

$date = date('Y-m-d');
$date1 = date("Y-m-d", strtotime("+1 day", strtotime($date)));
$date2 = date("Y-m-d", strtotime("-1 day", strtotime($date)));
?>



<table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
  <tr>
    <td height="42" colspan="9" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
      <div align="left">&nbsp;&nbsp;<span class="style24">บอลกำลังแข่งขัน</span></div>
    </div></td>
  </tr>
  <tr>
    <td width="8%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
    <td width="4%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">นาทีที่</span></div></td>
    <td width="8%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
    <td width="5%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
    <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
    <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">Comment</span></div></td>
    <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีเด็ด</span></div></td>
  </tr>
  <?php
  $sql="
  SELECT
      *
  FROM
  matchHDC
  WHERE
  Date >= '".$date." 00:00:00' AND Date <= '".$date." 23:59:59' AND Status!='-14' AND Status!='-1' AND Status!='0' AND (Status='1' or Status='2' or Status='3')
   ORDER BY
			Status = '1' asc,
			Status = '2' asc,
			Status = '3' asc,
			Date asc
  ;";
       // echo $sql;
  $query=mysql_query($sql);
  $tmpl ='';
  $loopp=0;
        while($row=mysql_fetch_assoc($query)){
		$loopp++;
                          if($loopp % 2 == 0){
                            $bgb ="#282828";
                          }else{
                            $bgb ="#1D1D1D";
                          }
         //$current_time = $row['time_match'];
   //$new_time = strtotime($row['Date']);
   $new_time = strtotime($row['Date']);
   
   				if($row['Status']=='0'){
					$statustime='';
					$ScoreHomeFullTime='?'; $ScoreAwayFulltime='?';
				} 
				
				if($row['Status']=='-1'){
					$statustime='FT';
					$ScoreHomeFullTime=$row['ScoreHomeFullTime'];
					$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
				} 
				
				if($row['Status']=='1'){
					
					if($row['ScoreHomeFullTime']==''){
						$ScoreHomeFullTime='0';
					}else{
					 	$ScoreHomeFullTime=$row['ScoreHomeFullTime'];
					}
					
					if($row['ScoreAwayFulltime']==''){
						$ScoreAwayFulltime='0';
					}else{
						$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
					}
					
					
					$statustime = (time() - $row['start'])/60;
	 				$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					
					
					if($statustime>='45'){ 
						$statustime = '45';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				if($row['Status']=='2'){
				
				if($row['ScoreHomeFullTime']==''){
						$ScoreHomeFullTime='0';
					}else{
					 	$ScoreHomeFullTime=$row['ScoreHomeFullTime'];
					}
					
					if($row['ScoreAwayFulltime']==''){
						$ScoreAwayFulltime='0';
					}else{
						$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
					}
					
					$statustime= 'HT';
				} 
				
				if($row['Status']=='3'){
				
				if($row['ScoreHomeFullTime']==''){
						$ScoreHomeFullTime='0';
					}else{
					 	$ScoreHomeFullTime=$row['ScoreHomeFullTime'];
					}
					
					if($row['ScoreAwayFulltime']==''){
						$ScoreAwayFulltime='0';
					}else{
						$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
					}
				
				 	
					$statustime = (time() - $row['halfstart'])/60; // 1 Hour =  60*60
	 				$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					$statustime= (46+$statustime);
					
					
					if($statustime>='90'){ 
						$statustime = '90';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				$sqlN="SELECT code FROM playgamerank WHERE matchID = '".$row['MatchID']."' AND date_create LIKE '".$date."%';";
  				$queryN=mysql_query($sqlN);
  				$num=mysql_num_rows($queryN);
				
				
  
				
   ?>

   <tr bgcolor="<?=$bgb?>">
    <td height="35"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?></span></div></td>
    <td><div align="center"><span  align="center" class="style18"><?php echo $statustime; ?></span></div></td>
    <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"  style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"  style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
   <td ><div align="right" style="padding-right:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4') { ?><div style="color:#FF2B30;">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4')  { ?></div><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:100%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php if($row['Predict']=='Y'){ echo str_replace("-", "", $row['AsianHandicap']); }else{ echo '-'; } ?></div>
            </div></td>
            
            
            <td ><div align="left" style="padding-left:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5') { ?><span style="color:#FF2B30;">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5')  { ?></span><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
    <td>
      <a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="images/brt2.png" width="70" height="35" border="0" /></a>
       <?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?>
      </td>
      <td><span class="style18"><?php echo $row['tded'];?> <?php 
	  if($row['MatchID']%2 == 0){
		echo trim($row['AwayName']);
		}
		else{
		echo trim($row['HomeName']);
		}

?></span></td>
    </tr>

    <?php 
  } 

  mysql_free_result($query);

  ?>
</table>

<table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
  <tr>
    <td height="42" colspan="9" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
      <div align="left">&nbsp;&nbsp;<span class="style24">ทีเด็ด ประจำวันที่ <?php  echo thai_date_fullmonth(time());?></span></div>
    </div></td>
  </tr>
  <tr>
    <td width="8%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
    <td width="4%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">นาทีที่</span></div></td>
    <td width="8%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
    <td width="5%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
    <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
    <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">Comment</span></div></td>
    <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีเด็ด</span></div></td>
  </tr>
  <?php
  $sql="
  SELECT
      *
  FROM
  matchHDC
  WHERE
  Date >= '".$date." 00:00:00' AND Date <= '".$date." 23:59:59' AND Status!='-14' AND Status!='-1' AND Status!='1' AND Status!='2' AND Status!='3'
   ORDER BY
			Date asc
  ;";
       // echo $sql;
  $query=mysql_query($sql);
  $tmpl ='';
  $loopp=0;
        while($row=mysql_fetch_assoc($query)){
		$loopp++;
                          if($loopp % 2 == 0){
                            $bgb ="#282828";
                          }else{
                            $bgb ="#1D1D1D";
                          }
         //$current_time = $row['time_match'];
   //$new_time = strtotime($row['Date']);
   $new_time = strtotime($row['Date']);
   
   				if($row['Status']=='0'){
					$statustime='';
					$ScoreHomeFullTime='?'; $ScoreAwayFulltime='?';
				} 
				
				if($row['Status']=='-1'){
					$statustime='FT';
					$ScoreHomeFullTime=$row['ScoreHomeFullTime'];
					$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
				} 
				
				if($row['Status']=='1'){
					
					if($row['ScoreHomeFullTime']==''){
						$ScoreHomeFullTime='0';
					}else{
					 	$ScoreHomeFullTime=$row['ScoreHomeFullTime'];
					}
					
					if($row['ScoreAwayFulltime']==''){
						$ScoreAwayFulltime='0';
					}else{
						$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
					}
					
					
					$statustime = (time() - $row['start'])/60;
	 				$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					
					
					if($statustime>='45'){ 
						$statustime = '45';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				if($row['Status']=='2'){
				
				if($row['ScoreHomeFullTime']==''){
						$ScoreHomeFullTime='0';
					}else{
					 	$ScoreHomeFullTime=$row['ScoreHomeFullTime'];
					}
					
					if($row['ScoreAwayFulltime']==''){
						$ScoreAwayFulltime='0';
					}else{
						$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
					}
					
					$statustime= 'HT';
				} 
				
				if($row['Status']=='3'){
				
				if($row['ScoreHomeFullTime']==''){
						$ScoreHomeFullTime='0';
					}else{
					 	$ScoreHomeFullTime=$row['ScoreHomeFullTime'];
					}
					
					if($row['ScoreAwayFulltime']==''){
						$ScoreAwayFulltime='0';
					}else{
						$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
					}
				
				 	
					$statustime = (time() - $row['halfstart'])/60; // 1 Hour =  60*60
	 				$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					$statustime= (46+$statustime);
					
					
					if($statustime>='90'){ 
						$statustime = '90';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				$sqlN="SELECT code FROM playgamerank WHERE matchID = '".$row['MatchID']."' AND date_create LIKE '".$date."%';";
  				$queryN=mysql_query($sqlN);
  				$num=mysql_num_rows($queryN);
				
				
  
				
   ?>

   <tr bgcolor="<?=$bgb?>">
    <td height="35"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?></span></div></td>
    <td><div align="center"><span  align="center" class="style18"><?php echo $statustime; ?></span></div></td>
    <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"  style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
    <td ><div align="right" style="padding-right:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4') { ?><div style="color:#FF2B30;">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4')  { ?></div><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:100%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php if($row['Predict']=='Y'){ echo str_replace("-", "", $row['AsianHandicap']); }else{ echo '-'; } ?></div>
            </div></td>
            
            
            <td ><div align="left" style="padding-left:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5') { ?><span style="color:#FF2B30;">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5')  { ?></span><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
    <td>
      <a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="images/brt2.png" width="70" height="35" border="0" /></a>
       <?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?></td>
      <td><span class="style18"><?php echo $row['tded'];?> 
      <?php 
	  if($row['MatchID']%2 == 0){
			if(($ScoreAwayFulltime-$ScoreHomeFullTime)>0 and $ScoreHomeFullTime!='?' ){
				$tdedcolor = 'style="background:#006600;"'; //green
			}else if(($ScoreAwayFulltime-$ScoreHomeFullTime)<0 and $ScoreHomeFullTime!='?' ){
				$tdedcolor = 'style="background:#CC3300;"';
			}else{
				$tdedcolor = '';
			}
			
			echo '<span '.$tdedcolor.'>'.trim($row['AwayName']).'</span>';
		}
		else{
		if(($ScoreHomeFullTime-$ScoreAwayFulltime)>0 and $ScoreHomeFullTime!='?' ){
				$tdedcolor = 'style="background:#006600;"'; //green
			}else if(($ScoreHomeFullTime-$ScoreAwayFulltime)<0 and $ScoreHomeFullTime!='?' ){
				$tdedcolor = 'style="background:#CC3300;"';
			}else{
				$tdedcolor = '';
			}
			
			echo '<span '.$tdedcolor.'>'.trim($row['HomeName']).'</span>';
		}

?></span></td>
    </tr>

    <?php 
  } 

  mysql_free_result($query);

  ?>
</table>


<table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
  <tr>
    <td height="42" colspan="9" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
      <div align="left">&nbsp;&nbsp;<span class="style24">ทีเด็ด ประจำวันที่ <?php  echo thai_date_fullmonth(strtotime("+1 day", strtotime($date)));?></span></div>
    </div></td>
  </tr>
  <tr>
    <td width="8%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
    <td width="4%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">นาทีที่</span></div></td>
    <td width="8%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
    <td width="5%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
    <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
    <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">Comment</span></div></td>
    <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีเด็ด</span></div></td>
  </tr>
  <?php
  $sql="
  SELECT
      *
  FROM
  matchHDC
  WHERE
  Date >= '".$date1." 00:00:00' AND Status = '0'
  ORDER BY
		
			Status = '0' asc,
			
  Date asc
  ;";
        //echo $sql;
  $query=mysql_query($sql);
  $tmpl ='';
  $loopp=0;
        while($row=mysql_fetch_assoc($query)){
		$loopp++;
                          if($loopp % 2 == 0){
                            $bgb ="#282828";
                          }else{
                            $bgb ="#1D1D1D";
                          }
         //$current_time = $row['time_match'];
   //$new_time = strtotime($row['Date']);
   $new_time = strtotime($row['Date']);
   
   				if($row['Status']=='0'){
					$statustime='';
					$ScoreHomeFullTime='?'; $ScoreAwayFulltime='?';
				} 
   ?>

   <tr bgcolor="<?=$bgb?>">
    <td height="35"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?></span></div></td>
    <td><div align="center"><span  align="center" class="style18"><?php echo $statustime; ?></span></div></td>
    <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"  style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
    <td ><div align="right" style="padding-right:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4') { ?><div style="color:#FF2B30;">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4')  { ?></div><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:100%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php if($row['Predict']=='Y'){ echo str_replace("-", "", $row['AsianHandicap']); }else{ echo '-'; } ?></div>
            </div></td>
            
            
            <td ><div align="left" style="padding-left:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5') { ?><span style="color:#FF2B30;">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5')  { ?></span><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
    <td>
      <a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="images/brt2.png" width="70" height="35" border="0" /></a>
       <?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?></td>
      <td><span class="style18"><?php echo $row['tded'];?> 
      <?php 
	  if($row['MatchID']%2 == 0){
		echo trim($row['AwayName']);
		}
		else{
		echo trim($row['HomeName']);
		}

?></span></td>
    </tr>

    <?php 
  } 

 mysql_free_result($query);
   

  ?>
</table>



<table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
  <tr>
    <td height="42" colspan="9" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
      <div align="left">&nbsp;&nbsp;<span class="style24">ทีเด็ด ย้อนหลัง</span></div>
    </div></td>
  </tr>
  <tr>
    <td width="12%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
    
    <td width="8%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
    <td width="5%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
    <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
    <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">Comment</span></div></td>
    <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีเด็ด</span></div></td>
  </tr>
  <?php
  $sql="
  SELECT
      *
  FROM
  matchHDC
  WHERE
  Date >= '".$date2." 00:00:00' AND (Status = '-1'
  OR
			Status='Und')
  ORDER BY
			
  Date asc
  ;";
        //echo $sql;
  $query=mysql_query($sql);
  $tmpl ='';
  $loopp=0;
        while($row=mysql_fetch_assoc($query)){
		$loopp++;
                          if($loopp % 2 == 0){
                            $bgb ="#282828";
                          }else{
                            $bgb ="#1D1D1D";
                          }
         //$current_time = $row['time_match'];
   //$new_time = strtotime($row['Date']);
   $new_time = strtotime($row['Date']);
   
   				if($row['Status']=='-1'){
					$statustime='';
					$ScoreHomeFullTime=$row['ScoreHomeFullTime']; 
					$ScoreAwayFulltime=$row['ScoreAwayFulltime'];
				} 
   ?>

   <tr bgcolor="<?=$bgb?>">
    <td height="35"><div align="center"><span class="style18"><?php echo date('d/m/Y H:i', $new_time);?></span></div></td>
    <td height="35"><div align="center"><span class="style18"><?php if($row['Status']=='-1'){ echo 'FT'; }
				if($row['Status']=='Und'){ echo 'Und.'; } ?></span></div></td>
    <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"  style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
    <td ><div align="right" style="padding-right:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4') { ?><div style="color:#FF2B30;">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4')  { ?></div><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:100%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php if($row['Predict']=='Y'){ echo str_replace("-", "", $row['AsianHandicap']); }else{ echo '-'; } ?></div>
            </div></td>
            
            
            <td ><div align="left" style="padding-left:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5') { ?><span style="color:#FF2B30;">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5')  { ?></span><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
    <td>
      <a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="images/brt2.png" width="70" height="35" border="0" /></a>
       <?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?></td>
      <td><span class="style18"><?php echo $row['tded'];?> 
      <?php 
	  if($row['MatchID']%2 == 0){
			if(($ScoreAwayFulltime-$ScoreHomeFullTime)>0 and $ScoreHomeFullTime!='?' ){
				$tdedcolor = 'style="background:#006600;"'; //green
			}else if(($ScoreAwayFulltime-$ScoreHomeFullTime)<0 and $ScoreHomeFullTime!='?' ){
				$tdedcolor = 'style="background:#CC3300;"';
			}else{
				$tdedcolor = '';
			}
			
			echo '<span '.$tdedcolor.'>'.trim($row['AwayName']).'</span>';
		}
		else{
		if(($ScoreHomeFullTime-$ScoreAwayFulltime)>0 and $ScoreHomeFullTime!='?' ){
				$tdedcolor = 'style="background:#006600;"'; //green
			}else if(($ScoreHomeFullTime-$ScoreAwayFulltime)<0 and $ScoreHomeFullTime!='?' ){
				$tdedcolor = 'style="background:#CC3300;"';
			}else{
				$tdedcolor = '';
			}
			
			echo '<span '.$tdedcolor.'>'.trim($row['HomeName']).'</span>';
		}

?></span></td>
    </tr>

    <?php 
  } 

 mysql_free_result($query);
   

  ?>
</table>
<?php
$cachedata = ob_get_contents(); 





// BOTTOM of your script
$fp = fopen($cachefile, 'w'); // open the cache file for writing
fwrite($fp, $cachedata); // save the contents of output buffer to the file
fclose($fp); // close the file
ob_end_clean();
ob_end_flush(); // Send the output to the browser

echo $cachedata;
}

?>
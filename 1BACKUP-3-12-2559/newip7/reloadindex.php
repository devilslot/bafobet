<?php

@session_start();
@header("Content-type: text/html; charset=utf-8");


$cachedir='cache'; // ชื่อแฟ้มเก็บไฟล์แคช 
$file='reloadindex.html'; // ชื่อไฟล์เว็บ
$cachefile=$cachedir.'/'.$file;
$cachetime =20;  // ระยะเวลา 5 นาที 
// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
include($cachefile);
//echo " <p style='color:gray;font-size:0.7em;'> ข้อมูลเมื่อ ".date('jS F Y H:i', filemtime($cachefile))." </p> "; // แสดงข้อความเวลาที่บันทึก
//exit;
}else{

ob_start();
?>
Hello World
<?php 




require_once "service/service.php";
require_once "creation/creation.init.php";
?>
<link href="css/bootstrap.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="function.js"></script>
<?php


$date = date('Y-m-d');
$date1 = date("Y-m-d", strtotime("-1 day", strtotime($date)));
?>
      <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
        <tr>
          <td height="42" colspan="9" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
            <div align="left">&nbsp;&nbsp;<span class="style24">ทีเด็ดฟุตบอล</span><span class="style70"> กำลังทำการแข่งขัน</span></div>
          </div></td>
        </tr>
        <tr>
          <td width="7%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
		  <td width="5%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">นาทีที่</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27">ลีก</div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
          <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลทาย</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">สรุป</span></div></td>
          <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">COMMENT</span></div></td>
        </tr>
        <?php
		
        
		
		
		$sql="
        SELECT
      		*
        FROM
        	matchHDC
       Where
	    Date >= '".$date1." 00:00:00' AND Date <= '".$date." 23:59:59' AND Status!='-1' AND Status!='0' AND (Status='1' or Status='2' or Status='3')
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
          $c =$ojc->CountC($row['MatchID']); 
          $h =$ojc->CountH($row['MatchID']); 
          $a =$ojc->CountA($row['MatchID']); 
          //$d =$ojc->CountD($row['MatchID']); 
          if($c==0){
            $c=1;
          }
          $home = ceil(($h/$c)*100);
          $alway = floor(($a/$c)*100);

          //$current_time = $row['time_match'];
          //$new_time = strtotime($current_time . "+7hours");
          $new_time = strtotime($row['Date']);
			
			if(!empty($_SESSION['SHFT_'.$row['MatchID'].'']) and $_SESSION['SHFT_'.$row['MatchID'].'']!=$row['ScoreHomeFullTime']){
			echo '
			<audio style="display:none;" controls autoplay>
  			<source src="sound/sound.mp3" type="audio/mpeg">
			</audio>';
			
			$trcolorh = '#648325';
			}else{
			$trcolorh =  $bgb;
			}
			
			if(!empty($_SESSION['SAFT_'.$row['MatchID'].'']) and $_SESSION['SAFT_'.$row['MatchID'].'']!=$row['ScoreAwayFulltime']){
			echo '
			<audio style="display:none;" controls autoplay>
  			<source src="sound/sound.mp3" type="audio/mpeg">
			</audio>';
			
			$trcolora = '#648325';
			}else{
			$trcolora =  $bgb;
			}
			
			$_SESSION['SHFT_'.$row['MatchID'].''] = $row['ScoreHomeFullTime'];
			$_SESSION['SAFT_'.$row['MatchID'].''] = $row['ScoreAwayFulltime'];
          ?>
          <tr bgcolor="<?=$bgb?>">
            <td height="35"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?>  <?php if($row['Status']=='1' or $row['Status']=='2' or $row['Status']=='3'){ echo '<img src="images/goal.gif" />'; } ?></span></div></td>
			<td height="35">
			
			<div align="center"><span class="style18">
			
				<?php 
				
				//echo $sql;
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
					
					if($row['start']==''){
					@mysql_query("UPDATE matchHDC SET start='".time()."',ScoreHomeFullTime='0',ScoreAwayFulltime='0'   WHERE code=".$row['code']." ");
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
				
				if($row['halfstart']==''){
					@mysql_query("UPDATE matchHDC SET halfstart='".time()."' WHERE code=".$row['code']." ");
					}
				 	
					$statustime = (time() - $row['halfstart'])/60; // 1 Hour =  60*60
	 				$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					$statustime= (46+$statustime);
					
					
					if($statustime>='90'){ 
						$statustime = '90';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				echo $statustime;
				?>
				
			</span></div>
			
			</td>
            <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>" style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
            
            <td bgcolor="<?php echo $trcolorh; ?>"><div align="right" style="padding-right:5px"><span class="style18">
              <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if ($row['ratio'] == 1)  { ?></div><? } ?>
            </span></div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
            <td bgcolor="<?php echo $trcolora; ?>"><div align="left" style="padding-left:5px"><span class="style18">
              <? if ($row['ratio'] == 2) { ?><span class="red">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if ($row['ratio'] == 2)  { ?></span><? } ?>
            </span></div></td>
           <td><div style=" width:100px; margin:auto;  padding:5px; border:solid 1px #B00000; background:#950000">
              <div align="center" class="style57 style29 style67"><?php echo $home;?>% / <?php echo $alway;?>%</div>
            </div></td>
            <td>
              <div align="center"><?php if($h>0 or $a>0){?><a  href="javascript:;" onclick="openplaygame(<?php echo $row['MatchID'];?>)"><img src="images/pie-chart-icon.png" width="24" height="24" /></a>
              <?php }?>
            </div></td>
            <td><a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="brt2.png" width="70" height="35" /></a><?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?></td>
          </tr>

          <?php 
        } 

        mysql_free_result($query);

        ?>

      </table>
	  
	  
<?php
$date = date('Y-m-d');
$date1 = date("Y-m-d", strtotime("-1 day", strtotime($date)));
?>
      <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
        <tr>
          <td height="42" colspan="9" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
            <div align="left">&nbsp;&nbsp;<span class="style24">ทีเด็ดฟุตบอล</span><span class="style70"> ประจำวันที่ <?php  echo thai_date_fullmonth(time());?></span></div>
          </div></td>
        </tr>
        <tr>
          <td width="7%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
		  <td width="5%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">นาทีที่</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27">ลีก</div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
          <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลทาย</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">สรุป</span></div></td>
          <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">COMMENT</span></div></td>
        </tr>
        <?php
		
        
		
		
		$sql="
        SELECT
      		*
        FROM
        	matchHDC
       Where
	    Date >= '".$date." 00:00:00' AND Date <= '".$date." 23:59:59' AND Status='0'
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
          $c =$ojc->CountC($row['MatchID']); 
          $h =$ojc->CountH($row['MatchID']); 
          $a =$ojc->CountA($row['MatchID']); 
          //$d =$ojc->CountD($row['MatchID']); 
          if($c==0){
            $c=1;
          }
          $home = ceil(($h/$c)*100);
          $alway = floor(($a/$c)*100);

          //$current_time = $row['time_match'];
          //$new_time = strtotime($current_time . "+7hours");
          $new_time = strtotime($row['Date']);


          ?>
          <tr bgcolor="<?=$bgb?>">
            <td height="35"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?>  <?php if($row['Status']=='1' or $row['Status']=='2' or $row['Status']=='3'){ echo '<img src="images/goal.gif" />'; } ?></span></div></td>
			<td height="35">
			
			<div align="center"><span class="style18">
			
				<?php 
				//echo $sql;
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
					
					if($row['start']==''){
					@mysql_query("UPDATE matchHDC SET start='".time()."',ScoreHomeFullTime='0',ScoreAwayFulltime='0'   WHERE code=".$row['code']." ");
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
				
				if($row['halfstart']==''){
					@mysql_query("UPDATE matchHDC SET halfstart='".time()."' WHERE code=".$row['code']." ");
					}
				 	
					$statustime = (time() - $row['halfstart'])/60; // 1 Hour =  60*60
	 				$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					$statustime= (46+$statustime);
					
					
					if($statustime>='90'){ 
						$statustime = '90';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				echo $statustime;
				?>
				
			</span></div>
			
			</td>
            <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"  style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
            
            <td><div align="right" style="padding-right:5px"><span class="style18">
              <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if ($row['ratio'] == 1)  { ?></div><? } ?>
            </span></div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
            <td><div align="left" style="padding-left:5px"><span class="style18">
              <? if ($row['ratio'] == 2) { ?><span class="red">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if ($row['ratio'] == 2)  { ?></span><? } ?>
            </span></div></td>
            <td><div style=" width:100px; margin:auto;  padding:5px; border:solid 1px #B00000; background:#950000">
              <div align="center" class="style57 style29 style67"><?php echo $home;?>% / <?php echo $alway;?>%</div>
            </div></td>
            <td>
              <div align="center"><?php if($h>0 or $a>0){?><a  href="javascript:;" onclick="openplaygame(<?php echo $row['MatchID'];?>)"><img src="images/pie-chart-icon.png" width="24" height="24" /></a>
              <?php }?>
            </div></td>
             <td><a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="brt2.png" width="70" height="35" /></a><?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?></td>
          </tr>

          <?php 
        } 

        mysql_free_result($query);

        ?>

      </table>
	  
	  
	  
	   <?php
$date = date('Y-m-d');
$date1 = date("Y-m-d", strtotime("+1 day", strtotime($date)));
?>
      <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
        <tr>
          <td height="42" colspan="9" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
            <div align="left">&nbsp;&nbsp;<span class="style24">ทีเด็ดฟุตบอล</span><span class="style70"> ประจำวันที่ <?php  echo thai_date_fullmonth(strtotime("+1 day", strtotime($date)));?></span></div>
          </div></td>
        </tr>
        <tr>
         <td width="7%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
		  <td width="5%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">นาทีที่</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27">ลีก</div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
          <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลทาย</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">สรุป</span></div></td>
          <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">COMMENT</span></div></td>
        </tr>
        <?php
		
        
		
		
		$sql="
        SELECT
      		*
        FROM
        	matchHDC
       Where
	    Date >= '".$date1." 00:00:00' AND Date <= '".$date1." 23:59:59' AND Status='0'
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
          $c =$ojc->CountC($row['MatchID']); 
          $h =$ojc->CountH($row['MatchID']); 
          $a =$ojc->CountA($row['MatchID']); 
          //$d =$ojc->CountD($row['MatchID']); 
          if($c==0){
            $c=1;
          }
          $home = ceil(($h/$c)*100);
          $alway = floor(($a/$c)*100);

          //$current_time = $row['time_match'];
          //$new_time = strtotime($current_time . "+7hours");
          $new_time = strtotime($row['Date']);


          ?>
          <tr bgcolor="<?=$bgb?>">
            <td height="35"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?>  <?php if($row['Status']=='1' or $row['Status']=='2' or $row['Status']=='3'){ echo '<img src="images/goal.gif" />'; } ?></span></div></td>
			<td height="35">
			
			<div align="center"><span class="style18">
			
				<?php 
				
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
					
					if($row['start']==''){
					@mysql_query("UPDATE matchHDC SET start='".time()."',ScoreHomeFullTime='0',ScoreAwayFulltime='0'   WHERE code=".$row['code']." ");
					
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
				
				if($row['halfstart']==''){
					@mysql_query("UPDATE matchHDC SET halfstart='".time()."' WHERE code=".$row['code']." ");
					}
				 	
					$statustime = (time() - $row['halfstart'])/60; // 1 Hour =  60*60
	 				$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					$statustime= (46+$statustime);
					
					
					if($statustime>='90'){ 
						$statustime = '90\'';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				echo $statustime;
				?>
				
			</span></div>
			
			</td>
            <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"  style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
            
            <td><div align="right" style="padding-right:5px"><span class="style18">
              <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if ($row['ratio'] == 1)  { ?></div><? } ?>
            </span></div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
            <td><div align="left" style="padding-left:5px"><span class="style18">
              <? if ($row['ratio'] == 2) { ?><span class="red">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if ($row['ratio'] == 2)  { ?></span><? } ?>
            </span></div></td>
            <td><div style=" width:100px; margin:auto;  padding:5px; border:solid 1px #B00000; background:#950000">
              <div align="center" class="style57 style29 style67"><?php echo $home;?>% / <?php echo $alway;?>%</div>
            </div></td>
            <td>
              <div align="center"><?php if($h>0 or $a>0){?><a  href="javascript:;" onclick="openplaygame(<?php echo $row['MatchID'];?>)"><img src="images/pie-chart-icon.png" width="24" height="24" /></a>
              <?php }?>
            </div></td>
             <td><a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="brt2.png" width="70" height="35" /></a><?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?></td>
          </tr>

          <?php 
        } 

        mysql_free_result($query);

        ?>

      </table>
	  
	  
	  
	  <?php
$date = date('Y-m-d H:i:s');
$date1 = strtotime("-2 day", strtotime($date));
$date1 = date("Y-m-d H:i:s", strtotime("+16 hours", $date1));

?>
      <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
        <tr>
          <td height="42" colspan="9" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
            <div align="left">&nbsp;&nbsp;<span class="style24">ผลบอลย้อนหลัง</span><span class="style70"></span></div>
          </div></td>
        </tr>
        <tr>
         <td width="7%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
		  <td width="5%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">นาทีที่</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27">ลีก</div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
          <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลทาย</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">สรุป</span></div></td>
          <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">COMMENT</span></div></td>
        </tr>
        <?php
		
        
		
		
		$sql="
        SELECT
      		*
        FROM
        	matchHDC
       Where
	    	Date >= '".$date1."'
		AND
			Status='-1'
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
          $c =$ojc->CountC($row['MatchID']); 
          $h =$ojc->CountH($row['MatchID']); 
          $a =$ojc->CountA($row['MatchID']); 
          //$d =$ojc->CountD($row['MatchID']); 
          if($c==0){
            $c=1;
          }
          $home = ceil(($h/$c)*100);
          $alway = floor(($a/$c)*100);

          //$current_time = $row['time_match'];
          //$new_time = strtotime($current_time . "+7hours");
          $new_time = strtotime($row['Date']);


          ?>
          <tr bgcolor="<?=$bgb?>">
            <td height="35"><div align="center"><span class="style18"><?php echo date('d/m/Y H:i', $new_time);?>  <?php if($row['Status']=='1' or $row['Status']=='2' or $row['Status']=='3'){ echo '<img src="images/goal.gif" />'; } ?></span></div></td>
			<td height="35">
			
			<div align="center"><span class="style18">
			
				<?php 
				
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
					
					if($row['start']==''){
					@mysql_query("UPDATE matchHDC SET start='".time()."',ScoreHomeFullTime='0',ScoreAwayFulltime='0'   WHERE code=".$row['code']." ");
					
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
				
				if($row['halfstart']==''){
					@mysql_query("UPDATE matchHDC SET halfstart='".time()."' WHERE code=".$row['code']." ");
					}
				 	
					$statustime = (time() - $row['halfstart'])/60; // 1 Hour =  60*60
	 				$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					$statustime= (46+$statustime);
					
					
					if($statustime>='90'){ 
						$statustime = '90\'';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				echo $statustime;
				?>
				
			</span></div>
			
			</td>
            <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"  style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
            
            <td><div align="right" style="padding-right:5px"><span class="style18">
              <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if ($row['ratio'] == 1)  { ?></div><? } ?>
            </span></div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
            <td><div align="left" style="padding-left:5px"><span class="style18">
              <? if ($row['ratio'] == 2) { ?><span class="red">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if ($row['ratio'] == 2)  { ?></span><? } ?>
            </span></div></td>
            <td><div style=" width:100px; margin:auto;  padding:5px; border:solid 1px #B00000; background:#950000">
              <div align="center" class="style57 style29 style67"><?php echo $home;?>% / <?php echo $alway;?>%</div>
            </div></td>
            <td>
              <div align="center"><?php if($h>0 or $a>0){?><a  href="javascript:;" onclick="openplaygame(<?php echo $row['MatchID'];?>)"><img src="images/pie-chart-icon.png" width="24" height="24" /></a>
              <?php }?>
            </div></td>
            <td><a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="brt2.png" width="70" height="35" /></a><?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?></td>
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
}

?>
<hr>


<hr>
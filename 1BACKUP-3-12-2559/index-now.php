<?php

@session_start();
@header("Content-type: text/html; charset=utf-8");

if($_GET['my']=='me'){ $myme='-me'.$_SESSION[MEMBER]['DATA']['code']; }else{ $myme=''; } 
		  
$cachedir='cache'; // ชื่อแฟ้มเก็บไฟล์แคช 
$file='index-now'.$myme.'.html'; // ชื่อไฟล์เว็บ
$cachefile=$cachedir.'/'.$file;
$cachetime =50;  // ระยะเวลา 100 วินาที 
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
$date1 = date("Y-m-d", strtotime("-1 day", strtotime($date)));
?>
      <table width="770" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
        <tr>
          <td width="7%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
		  <td width="5%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">นาทีที่</span></div></td>
          <td width="7%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
          <td width="5%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
		  <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ครึ่งแรก</span></div></td>
          <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
          <td width="13%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลทาย</span></div></td>
          <td width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">สรุป</span></div></td>
        </tr>
        <?php
		
        
		
		if($_GET['my']=='me'){ 
		
		$sql="SELECT
                      md.*,pg.bet
                      FROM
                      matchHDC md,playgame pg
                      WHERE
                      md.MatchID = pg.matchID AND
                      pg.memberID = '".$_SESSION[MEMBER]['DATA']['code']."' 
					  AND md.Date >= '".$date1." 00:00:00' AND md.Date <= '".$date." 23:59:59' AND md.Status!='-1' AND md.Status!='0' AND (md.Status='1' or md.Status='2' or md.Status='3')
					  GROUP BY md.MatchID
        ORDER BY
			md.Status = '1' asc,
			md.Status = '2' asc,
			md.Status = '3' asc,
			md.Date asc; ";
		
		}else{
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
		}
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
		  
		 
			
			if(!empty($_SESSION['SHF'][''.$row['MatchID'].'']) and $_SESSION['SHF'][''.$row['MatchID'].'']!=$row['ScoreHomeFullTime']){
			echo '
			<audio style="display:none;" controls autoplay>
  			<source src="sound/sound.mp3" type="audio/mpeg">
			</audio>';
			
			$trcolorh = '#FFFF00';
			$colorh = ' style="color:#000000;" ';
			}else{
			$trcolorh =  $bgb;
			$colorh = ' ';
			}
			
			if(!empty($_SESSION['SAF'][''.$row['MatchID'].'']) and $_SESSION['SAF'][''.$row['MatchID'].'']!=$row['ScoreAwayFulltime']){
			echo '
			<audio style="display:none;" controls autoplay>
  			<source src="sound/sound.mp3" type="audio/mpeg">
			</audio>';
			
			$trcolora = '#FFFF00';
			$colora = ' style="color:#000000;" ';
			}else{
			$trcolora =  $bgb;
			$colora = ' ';
			}
			
			

		  
		  
			$_SESSION['SHF'][''.$row['MatchID'].''] = $row['ScoreHomeFullTime'];
			$_SESSION['SAF'][''.$row['MatchID'].''] = $row['ScoreAwayFulltime'];
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
	 				//$statustime = round($statustime, 0, PHP_ROUND_HALF_DOWN);
					$statustime= (46+$statustime);
					
					
					if($statustime>='90'){ 
						$statustime = '90';
					}
						$statustime = '<span style="color:#CCCC33; text-decoration:blink;">'.$statustime.'\'</span>';
					
				} 
				
				//echo $statustime;
				/*if (strlen(number_format($row['Playtime'],0))=='2') {*/ echo $row['Playtime']."'"; /*}*/ 
				?>
				
			</span></div>
			
			</td>
            <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>" style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
            
            <td bgcolor="<?php echo $trcolorh; ?>"><div align="right" style="padding-right:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4' and $row['AsianHandicap']!=0 ) { ?><div style="color:#FF2B30;">* <? } ?>
              <span <?=$colorh?>><?php echo trim($row['HomeName']);?></span>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4' and $row['AsianHandicap']!=0)  { ?></div><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:100%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php if($row['Predict']=='Y'){ echo str_replace("-", "", $row['AsianHandicap']); }else{ echo '-'; } ?></div>
            </div></td>
            
            
            <td bgcolor="<?php echo $trcolora; ?>"><div align="left" style="padding-left:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5' and $row['AsianHandicap']!=0) { ?><span style="color:#FF2B30;">* <? } ?>
              <span <?=$colora?>><?php echo $row['AwayName'];?></span>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5' and $row['AsianHandicap']!=0)  { ?></span><? } ?>
            </span></div></td>
            
			<td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $row['ScoreHomeHalfTime'];?> - <?php echo $row['ScoreAwayHalfTime'];?></div>
            </div></td>
			
			
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $ScoreHomeFullTime;?> - <?php echo $ScoreAwayFulltime;?></div>
            </div></td>
            
           <td width="80"><div style=" width:100px; margin:auto;  padding:5px; border:solid 1px #B00000; background:#950000">
              <div align="center" class="style57 style29 style67"><?=$h?> คน / <?=$a?> คน</div>
            </div></td>
            <td>
              <div align="center"><?php if($h>0 or $a>0){?>
              <a  href="javascript:;" onclick="openplaygame(<?php echo $row['MatchID'];?>)"><img src="images/pie-chart-icon.png" width="24" height="24" /></a>
              <?php }?>
            <a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="images/comment24.png" width="24" height="24" /><?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge" style="background-color:#FF0000;">'.Countcomment($row['MatchID']).'</span >'; } ?></a></div></td>
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
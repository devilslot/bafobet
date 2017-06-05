<?php

@session_start();
@header("Content-type: text/html; charset=utf-8");

if($_GET['my']=='me'){ $myme='-me'.$_SESSION[MEMBER]['DATA']['code']; }else{ $myme=''; } 
		  
$cachedir='cache'; // ชื่อแฟ้มเก็บไฟล์แคช 
$file='index-back'.$myme.'.html'; // ชื่อไฟล์เว็บ
$cachefile=$cachedir.'/'.$file;
$cachetime =0;  // ระยะเวลา 100 วินาที 
// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
include($cachefile);
//echo " <p style='color:gray;font-size:0.7em;'> ข้อมูลเมื่อ ".date('jS F Y H:i', filemtime($cachefile))." </p> "; // แสดงข้อความเวลาที่บันทึก
//exit;
}else{

ob_start();


require_once "service/service.php";
require_once "creation/creation.init.php";


$date = date('Y-m-d 00:00:00');
$date1 = strtotime("-1 day", strtotime($date));
$date1 = date("Y-m-d",  $date1);

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
					  AND md.Date >= '".$date1."' AND
						(md.Status='-1'
							OR
						md.Status='Und')
                      ORDER BY
                      unix_timestamp(md.Date)
                      ASC; ";
		
		}else{
		 $sql="
		select * from (

        SELECT
      		*
        FROM
        	matchHDC
       Where
	    	Date >= '".$date1."' 
		AND
			(Status='-1'
		OR
			Status='Und')
        ORDER BY
			Date desc
			
			limit 100
			
			) tmp order by tmp.Date asc
		
        ;"; 
		 
		 } 
		
		
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
				if($row['Status']=='Und'){ echo 'Und.'; }else{ echo 'FT'; }
				?>
				
			</span></div>
			
			</td>
            <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>" style="color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
            
            <td ><div align="right" style="padding-right:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4' and $row['AsianHandicap']!=0) { ?><div style="color:#FF2B30;">* <? } ?>
              <?php echo trim($row['HomeName']);?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='4' and $row['AsianHandicap']!=0)  { ?></div><? } ?>
            </span></div></td>
            
            <td><div class="style20" style="width:100%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php if($row['Predict']=='Y'){ echo str_replace("-", "", $row['AsianHandicap']); }else{ echo '-'; } ?></div>
            </div></td>
            
            
            <td ><div align="left" style="padding-left:5px"><span class="style18">
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5' and $row['AsianHandicap']!=0) { ?><span style="color:#FF2B30;">* <? } ?>
              <?php echo $row['AwayName'];?>
              <? if (strlen(number_format($row['AsianHandicap'],2))=='5' and $row['AsianHandicap']!=0)  { ?></span><? } ?>
            </span></div></td>
            
			<td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php echo $row['ScoreHomeHalfTime'];?> - <?php echo $row['ScoreAwayHalfTime'];?></div>
            </div></td>
			
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
              <div align="center" class="style25"><?php  echo $row['ScoreHomeFullTime']." - ".$row['ScoreAwayFulltime']; ?></div>
            </div></td>
            
           <td><div style=" width:100px; margin:auto;  padding:5px; border:solid 1px #B00000; background:#950000">
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
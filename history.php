<?


if(empty($_GET['memberid'])){
  $memberidsql = '';
}else{
  $memberidsql = " AND memberid = '".$_GET['memberid']."' ";
}

if(empty($_GET['matchID'])){
  $matchidsql = '';
}else{
  $matchidsql = " AND pg.matchID = '".$_GET['matchID']."' ";
}
?>


<script language="javascript">
function selec(){
  var ab=document.getElementById('se');
  location.href=''+ab.value+'';
}
</script>
<?php include ('header.inc.php');

$cachedir='cache'; // ชื่อแฟ้มเก็บไฟล์แคช 
$file='history'.$_GET['dateMatch'].'.html'; // ชื่อไฟล์เว็บ
$cachefile=$cachedir.'/'.$file;
$cachetime =200;  // ระยะเวลา 100 วินาที 
// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
include($cachefile);
//echo " <p style='color:gray;font-size:0.7em;'> ข้อมูลเมื่อ ".date('jS F Y H:i', filemtime($cachefile))." </p> "; // แสดงข้อความเวลาที่บันทึก
//exit;
}else{

ob_start();
?>
  <div style="">
    <table width="1030" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
      <tr>
        <td height="42" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
          <div align="left">&nbsp;&nbsp;<span class="style24">สรุป</span>การทายผลย้อนหลัง 
            <select name="se" id="se" onchange="selec();">
              <option>++เลือกวันที่++</option>
              <?php
              $sqld="
              SELECT
              DATE_FORMAT(date_create,'%Y-%m-%d') AS datem
              FROM
              playgame
			  WHERE matchID!='GETPOINT'
              GROUP BY 
              DATE_FORMAT(date_create,'%Y-%m-%d')
              ORDER BY
              date_create
              DESC
              ;";
        //echo $sqld;
              $queryd=mysql_query($sqld);
              while($rowd=mysql_fetch_assoc($queryd)){
                ?>
                <option value="history.php?dateMatch=<?php echo $rowd['datem'];?>" <?php echo $rowd['datem'] == $date ? 'selected' : ''; ?> >วันที่ <?php  echo thai_date_fullmonth(strtotime($rowd['datem']));?></option>
                <?php  
              }
              mysql_free_result($queryd);
              ?>

            </select>
          </div>
        </div></td>
      </tr>
      <tr>
        <td height="35" bgcolor="#000000">
          <?php
          $sqlm="
          SELECT DISTINCT
            memberID
          FROM
          playgame
          WHERE
          UNIX_TIMESTAMP(date_create) >= '".$datestart."'
			AND  UNIX_TIMESTAMP(date_create) <= '".$datestop."' AND matchID!='GETPOINT'
         
          ORDER BY
          code
          DESC
          ;";
       //echo $sqlm;
          $querym=mysql_query($sqlm);
		  $num = mysql_num_rows($querym);
		  if(empty($num)){
			  echo "<div style='color:#FFF; text-align:center;'>ไม่มีสรุปผลย้อนหลังของวันนี้</div>";
		  }else{
		  $loopp=0;
          while($rowm=mysql_fetch_assoc($querym)){
            //$user  = DisplayUser($rowm['memberID']);
			$query_photo=mysql_query("SELECT username,photo FROM members WHERE code = '".$rowm['memberID']."' ;",$conn);
          $row_photo=mysql_fetch_assoc($query_photo);
			$loopp++;
                          if($loopp % 2 == 0){
                            $bgb ="#101010";
                          }else{
                            $bgb ="#555555";
                          }
			
            ?>
            <table width="1000" border="0" align="center" cellspacing="1" bgcolor="<?php echo $bgb; ?>" style="margin-top:5px;">
              <tr>
                <td width="150" rowspan="6" valign="top"  bgcolor="<?php echo $bgb; ?>"><div class="style54" style="width:140px; max-height:140px; margin:10px auto; border:solid 3px #CCCCCC; overflow:hidden;">
                  
				  <?php  if ( $row_photo['photo']!='') { ?>
                 <div style="width:140px; height:140px; border:solid 1px #999999; overflow:hidden;"><img src="thumb.php?src=memberpic/<?php echo $row_photo['photo'];?>&w=140&q=100" width="140" /></div>
                  <?php }else{ ?>
                  <div style="width:140px; height:140px; border:solid 1px #999999; overflow:hidden;"><img src="thumb.php?src=images/pro-pic.jpg&w=140&q=100" width="140" /></div>
                  <?php } ?>
				  
                </div>
				
                <div class="style54" style="width:140px; height:40px; line-height:40px; background: #222222; font-size:16px; margin:0 auto 10px auto;">
                  <div align="center"><strong><a href="viewmemberplay.php?refID=<?=$rowm['memberID']?>"><?php echo $row_photo['username'];?></a></strong></div>
                </div></td>
                <td width="850"  bgcolor="<?php echo $bgb; ?>" colspan="6" valign="top">
                   <table width="840" style="hight:100px; margin:5px;">
					  <!--<tr>
						<td height="42" colspan="9" bgcolor="#004000"><div align="center" class="style5">
            <div align="left">&nbsp;&nbsp;<span class="style24">สรุป</span>การทายผล</div>
          </div></td>
					 </tr>-->
                        <tr>
                          <td  width="10%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
                          <td  width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
                          <td  width="20%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
                          <td  width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทาย</span></div></td>
                          <td  width="20%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
                          <td  width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">Point/Rank</span></div></td>
                          <td  width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">สถานะ</span></div></td>
                          <td  width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ได้/เสีย</span></div></td>
                          
                        </tr>
                        <?php
                        $sql="
                        SELECT
                        md.*,pg.*
                        FROM
                        matchHDC md,playgame pg
                        WHERE
                        md.MatchID = pg.matchID  AND pg.matchID!='GETPOINT' AND 
                        pg.memberID = '".$rowm['memberID']."' AND
                        UNIX_TIMESTAMP(pg.date_create) >= '".$datestart."'
			AND  UNIX_TIMESTAMP(pg.date_create) <= '".$datestop."' 
                        ORDER BY
                        pg.code
                        DESC
                        ;";
       //if($_GET['t']=='t'){ echo $sql; }
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
                          $current_time = $row['time_match'];
                            $new_time = strtotime($row['Date']);
                         // $new_time = strtotime($current_time . "+7hours");
                          ?>
                          <tr>
                            <td height="35" bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php echo date('d-m-Y H:i', $new_time);?></span></div></td>
                            <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"><div align="center" class="style28" style="cursor:pointer; color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
                            <td bgcolor="<?php echo $bg;?>"><div align="center" ><span <?php if($row['bet']=='1'){ echo 'class="style25"'; }else{ echo 'class="style18"'; } ?>>
                              <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
                              <?php echo trim($row['HomeName']);?><br/>( <font color="#B1FB17"><?php echo trim($row['ScoreHomeFullTime']);?></font> )
                              <? if ($row['ratio'] == 1)  { ?></div><? } ?>
                            </span></div></td>
                            <td bgcolor="<?php echo $bg;?>"><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
                              
                              <div align="center" class="style25"><?php echo $row['bet'] == '1' ? 'HOME' : 'ALWAY'; ?></div>
                            </div></td>
                            <td bgcolor="<?php echo $bg;?>"><div align="center"><span <?php if($row['bet']=='2'){ echo 'class="style25"'; }else{ echo 'class="style18"'; } ?>>
                              <? if ($row['ratio'] == 2) { ?><span class="red">* <? } ?>
                              <?php echo $row['AwayName'];?><br/>( <font color="#B1FB17"><?php echo trim($row['ScoreAwayFulltime']);?></font> )
                              <? if ($row['ratio'] == 2)  { ?></span><? } ?>
                            </span></div></td>
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
                          }else if($row['Status'] == '-1'){
						  	$txt = "รอคำนวณผล";
						  }else{
						  	$txt = "รอแข่ง";
                            if($row['Status']==1){ $txt = "1st"; }
							if($row['Status']==2){ $txt = "HT"; }
							if($row['Status']==3){ $txt = "2nd"; }
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
                    
					
						
              </table>
                <br />
                <?php 
           } 
			  } 
		  
              mysql_free_result($querym);

              ?>

            </td>
          </tr>
        </table> </div>
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
     
 <?php include('footer.inc.php');?>
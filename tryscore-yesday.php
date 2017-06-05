<?php
@session_start();
@header("Content-type: text/html; charset=utf-8");

$cachedir='cache'; // ชื่อแฟ้มเก็บไฟล์แคช 
$file='tryscore-yesday.html'; // ชื่อไฟล์เว็บ
$cachefile=$cachedir.'/'.$file;
$cachetime =120;  // ระยะเวลา 100 วินาที 
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
?>

<table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
  <tr>
    <td height="42" colspan="9" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
      <div align="left">&nbsp;&nbsp;<span class="style24">ผลบอลและทายสกอร์ ประจำวันที่ <?php  echo thai_date_fullmonth(strtotime("+1 day", strtotime($date)));?></span></div>
    </div></td>
  </tr>
  <tr>
    <td width="8%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
    <td width="8%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
    <td width="5%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
    <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
  
    <td width="14%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทายผล</span></div></td>
    <td width="12%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">Comment</span></div></td>
    <td width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทรรศนะ</span></div></td>
  </tr>
  <?php
  $sql="
  SELECT
      *
  FROM
  matchHDC
  WHERE
  Date >= '".$date1." 00:00:00'  AND Predict='Y'
  ORDER BY
			Status = '1' asc,
			Status = '2' asc,
			Status = '3' asc,
			Status = '0' asc,
			Status = '-1' asc,
			
  Date asc
  ;";
        //echo $sql;
  $query=mysql_query($sql);
  $tmpl ='';
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
   
   ?>

   <tr bgcolor="<?=$bgb?>">
    <td height="35"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?></span></div></td>
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
            
            
    <td>
      <?php //if($ScoreHomeFullTime ==  '?'){ 
	  if($new_time >  time() and $new_time < $datestop){ 
	  ?>
      <a  href="javascript:;" onclick="openplaygame(<?php echo $row['MatchID'];?>)"><img src="images/brt1.png" width="70" height="35" border="0" /></a>
      <?php }else{  ?>
      <a  href="javascript:;" onclick="openplaygame(<?php echo $row['MatchID'];?>)"><img src="images/off.png" width="70" height="35" border="0" /></a>
      <?php } ?>
     <?php if(Counttry($row['MatchID'])>0){ echo '<span class="badge yullow">'.Counttry($row['MatchID']).'</span >'; } ?>
       </td>
      <td>
      <a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="images/brt2.png" width="70" height="35" border="0" /></a>
       <?php if(Countcomment($row['MatchID'])>0){ echo '<span class="badge redc">'.Countcomment($row['MatchID']).'</span >'; } ?>
      </td>
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

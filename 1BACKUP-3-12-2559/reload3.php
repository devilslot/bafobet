<?php
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";
?>

<link rel="stylesheet" href="colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="jquery.colorbox.js"></script>
<script>
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

$(document).ready(function(){
  $(".iframe").colorbox({iframe:true, width:"800px", height:"650px"});

        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function(){ 
          $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
          return false;
        });
      });




</script>
        <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
          <tr>
            <td height="42" colspan="9" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
              <div align="left">&nbsp;&nbsp;<span class="style24">ทีเด็ดฟุตบอล</span><span class="style70"> ประจำวันที่ <?php  echo thai_date_fullmonth(time());?></span></div>
            </div></td>
          </tr>
          <tr>
            <td width="7%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
            <td width="8%" bgcolor="#000000"><div align="center" class="style27">นาทีที่</div></td>
            <td width="16%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
            <td width="16%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
            <td width="6%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลบอล</span></div></td>
            <td width="16%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
            <td width="17%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ผลทาย / %</span></div></td>
            <td width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีเด็ด</span></div></td>
            <td width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">COMMENT</span></div></td>
            
          </tr>
          <?php
		  //md.ScoreHomeFullTime = ''
          $sql="
          SELECT
      *
  FROM
  matchHDC
  WHERE
  Date >= '".('Y-m-d')." 00:00:00'
  ORDER BY
			Status = '1' asc,
			Status = '2' asc,
			Status = '3' asc,
			Status = '0' asc,
			Status = '-1' asc,
  Date asc
          ;";
       // echo $sql;
          $query=mysql_query($sql);
          $tmpl ='';
          while($row=mysql_fetch_assoc($query)){
            $c =$ojc->CountC($row['MatchID']); 
            $h =$ojc->CountH($row['MatchID']); 
            $a =$ojc->CountA($row['MatchID']); 
            //$d =$ojc->CountD($row['MatchID']); 
            if($c==0){
              $c=1;
            }
            $home = ceil(($h/$c)*100);
            $alway = floor(($a/$c)*100);
           // $current_time = $row['time_match'];
           // $new_time = strtotime($current_time . "+7hours");
            $new_time = strtotime($row['Date']);
            ?>
            <tr>
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
              <div align="center" style="color:#FFF;"><?php echo $row['tded'];?> 
      <?php 
	  if($row['MatchID']%2 == 0){
		echo trim($row['AwayName']);
		}
		else{
		echo trim($row['HomeName']);
		}

?>
            </div></td>
            <td><div align="center"><span class="style18">&nbsp;<a  href="javascript:;" onclick="opencomment(<?php echo $row['MatchID'];?>)"><img src="brt2.png" width="70" height="35" /></a></span></div></td>
          </tr>

            <?php 
          } 

         // mysql_free_result($query);
          mysql_close($query);

          ?>
        </table>
      
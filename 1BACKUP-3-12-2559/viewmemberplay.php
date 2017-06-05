<?php include ('header.inc.php');?>
<!--<div class="style29" style="width:240px; float:left;">
<?php //include ('left.php');?>
</div>-->


<?
if(empty($_GET['dateMatch'])){
  $date= date('Y-m-d');
  //$dateminus1= strtotime('-1 day', date('Y-m-d'));
}else{
  $date = $_GET['dateMatch'];
}


if($_POST['gtype']=='point'){
$sqltype = " AND gametype='point' ";
}else if($_POST['gtype']=='rank'){
$sqltype = " AND gametype='rank' ";
}else{
$sqltype = " ";
}

if($_POST['year']!=''){ $yearp=$_POST['year']; }else{ $yearp=date('Y'); }

if($_POST['month']!=''){ $monthp=$_POST['month']; }else{ $monthp=date('m'); }
?>
<style type="text/css">
<!--
.style68 {font-size: 12px; font-family: Tahoma; color: #CCCCCC; }
-->
</style>
<script language="javascript">

function selec(){
  var ab=document.getElementById('se');
  location.href=ab.value;
}
</script>

  <div style="width:1040px; float:right; ">
  <table width="1000" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
              <tr>
        <td height="42" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
          <div align="left">&nbsp;&nbsp;<span class="style24"></span>ผู้ที่ทายผล 
          
            
          
            
          </div>
        </div></td>
      </tr>
              <tr>
                <td width="100%" bgcolor="#000000" colspan="6" valign="top">
                  <div class="scroll">
                    <table width="100%" style="hight:100px;">
                      <tr>
                        <td  width="10%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">Pic</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">Username</span></div></td>
                       
                      </tr>
          <?php
		  //AND DATE_FORMAT(date_create,'%Y-%m-%d') = '".$date."'
          $sqlm="
          SELECT
          *
          FROM
          members
          WHERE
          code = '".$_GET['refID']."'
          ;";
       // echo $sql;
          $querym=mysql_query($sqlm);
          while($rowm=mysql_fetch_assoc($querym)){
		   $loop++;
                        if($loop % 2 == 0){
                          $bg ="#282828";
                        }else{
                          $bg ="#1D1D1D";
                        }
            $user  = DisplayUser($rowm['memberID']);
            ?>

            
                      
                        <tr>
                         <?php  if (file_exists("memberpic/".$rowm['username'].'.jpg')) { ?>
                  <td width="13%" bgcolor="<?php echo $bg;?>"><div style="width:200px; height:200px; border:solid 1px #999999; overflow:hidden; margin:0 auto;"><img src="memberpic/<?php echo $rowm['username'];?>.jpg" width="200" /></div></td>
                  <?php }else{ ?>
                  <td width="13%" bgcolor="<?php echo $bg;?>"><div style="width:200px; height:200px; border:solid 1px #999999; overflow:hidden; margin:0 auto;"><img src="pro-pic.jpg" width="200" /></div></td>
                  <?php } ?>
                          
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style27"><span class="style28"><?php echo $rowm['username'];?></span></div></td>
                          
                          
                           
                        </tr>
                       
                <?php 
              } 
              mysql_free_result($querym);



 		if(empty($_GET['date'])){
		  	$date = date("Y-m-d");
		  }else{
			 $date = $_GET['date']; 
		  }
		  $dminus[0] = $date;
		  $dminus[1] = date("Y-m-d", strtotime("-1 day", strtotime($date)));
		  $dminus[2] = date("Y-m-d", strtotime("-2 day", strtotime($date)));
		  $dminus[3] = date("Y-m-d", strtotime("-3 day", strtotime($date)));
		  $dminus[4] = date("Y-m-d", strtotime("-4 day", strtotime($date)));
		  $dminus[5] = date("Y-m-d", strtotime("-5 day", strtotime($date)));
		  $dminus[6] = date("Y-m-d", strtotime("-6 day", strtotime($date)));
              ?>

                    </table>
                  </div>
                
            </td>
          </tr>
        </table>
        
    <table width="1000" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">

      <tr>
        <td height="35" bgcolor="#000000">
        <table width="990" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
            <tr>
              <td height="42" colspan="9" background="images/bg-menu1.jpg" bgcolor="#004000">
              <div align="center" class="style5">
                <div align="left">
              <form action="" method="post">
              
              &nbsp;&nbsp;<span class="style24">ประวัติการทายผล <?php echo $type; ?></span><span class="style70"> ประจำเดือน </span>
              <?php
			  $years=date("Y");
			  
			  ?>
              
  <select name="month" id="month">
  <option value=" ">เดือน</option>
  <?PHP $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");?>
  <?PHP for($i=1; $i<sizeof($month); $i++) {?>
  <option <?php if($_POST['month']==$i or ($_POST['month']=='' and date('m')==$i)){ echo 'selected="selected"'; } ?> value="<?PHP if(strlen($i)==1){ echo "0".$i; }else{ echo $i; } ?>">
  <?PHP echo $month[$i-1]?></option>
  <?PHP }?>
</select>

<select name="year" id="year">
  <option value=" ">ปี</option>
  <?PHP for( $i=$years;$i;$i--) {?>
  <option <?php if($_POST['year']==$i or ($_POST['year']=='' and date('Y')==$i)){ echo 'selected="selected"'; } ?> value="<?PHP echo $i?>"><?PHP echo $i+543?></option>
  <?PHP 
  if ($i == 2015) {
        break;
    }
  }?>
</select>

<select name="gtype" id="gtype">
  <option value="" <?php if($_POST['gtype']==''){ echo 'selected="selected"'; } ?>>รายการทายผลทั้งหมด</option>
  <option value="point" <?php if($_POST['gtype']=='point'){ echo 'selected="selected"'; } ?>>รายการทายผล Point</option>
  <option value="rank" <?php if($_POST['gtype']=='rank'){ echo 'selected="selected"'; } ?>>รายการทายผล Rank</option>
</select>

<input name="sub" type="submit" value="แสดงรายการ" />

</form>

</div>
              </div>
              </td>
        	</tr>
              <tr>
                <td width="100%" bgcolor="#000000" colspan="6" valign="top">
                  <div class="scroll">
                    <table width="100%" style="hight:100px;">
                    <?php
                     /*      $sql="
                      SELECT
                      point,winloss,gametype,status,matchID,cal
                      FROM
                      playgame
                      WHERE
                      memberID = '".$_GET['refID']."' 
					  AND date_create like '".$yearp."-".$monthp."%'
					  ORDER BY date_create ASC
                      
                      ;";
        
                      $query=mysql_query($sql);
                      $c = 0;
					  $sumpoint=0;
                      while($row=mysql_fetch_assoc($query)){
						if($row['gametype']=='point'){
						$c++;
						if($c=='1'){
							$sumpoint = $sumpoint+$row['point'];
						}
									  
							  
							  if($row['matchID']!='GETPOINT'){
							  	if($row['cal']!='0'){
									  
									$sumpoint = ($sumpoint+($row['point']*$row['winloss']));
									  
							  	}
							  }
							  
							  if($row['matchID']=='GETPOINT'){ $sumpoint=$sumpoint+$row['point']; }
							  if($row['cal']=='0'){ $sumpoint=$sumpoint-$row['point']; }
							  
							  if($_GET['p']=='p'){ echo "status ".$row['status']." | point ".$row['point']."|".$sumpoint."<br>"; }
							 // if($row['winloss']=='0.00' and $row['status']==''){ $sumpoint=$sumpoint-$row['point'];  }
						  }
						  
						   if($row['gametype']=='rank'){
						  		$sumrank = $sumrank+$row['winloss'];
							}
                      }*/
					  
					  $sqlmscore="
                      SELECT
                      *
                      FROM
                      members_score
                      WHERE
                      memberID = '".$_GET['refID']."' 
					  AND months = ".$monthp." AND 	years = ".$yearp."
                      ;";
        
                      $querymscore=mysql_query($sqlmscore);
                      $row_mscore=mysql_fetch_assoc($querymscore);
                      ?>
                    <tr>
                        <td height="40" colspan="9" align="right" style="color:#FFF;">สรุปผลทั้งเดือนได้ <?=$row_mscore['point']?> Point | <?=$row_mscore['rank']?> Rank</td>
                    </tr>
                      <tr>
                     	 <td  width="13%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลาทาย</span></div></td>
                        <td  width="13%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลาแข่ง</span></div></td>
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
		 
		  //AND DATE_FORMAT(date_create,'%Y-%m-%d') = '".$date."'
          /*$sqlm="
          SELECT
          memberID,matchID
          FROM
          playgame
          WHERE
          memberID = '".$_GET['refID']."' 
          AND date_create like '".."'
          ORDER BY
          code
          DESC
		  LIMIT 100
          ;";
       // echo $sql;
          $querym=mysql_query($sqlm);
          while($rowm=mysql_fetch_assoc($querym)){
            $user  = DisplayUser($rowm['memberID']);
			*/
			
			//for($i=0;$i<6;$i++){
			
			
			?>

            
                      <?php
                      $sql="
                      SELECT
                      md.*,pg.bet,pg.bet,pg.hdc,pg.point,pg.winloss,pg.status,pg.gametype,pg.date_create,pg.gameeven
                      FROM
                      matchHDC md,playgame pg
                      WHERE
                      md.MatchID = pg.matchID AND
                      pg.memberID = '".$_GET['refID']."' 
					  ".$sqltype."
					  AND pg.date_create like '".$yearp."-".$monthp."%'
                      ORDER BY
                      unix_timestamp(pg.date_create)
                      DESC
                      ;";
        //echo $sql;
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
						
						$c_time = $row['date_create'];
                        $n_time = strtotime($c_time);
						if($row['gameeven']=='ip7'){ $streven='<img src="images/iphone.png" title="ร่วมกิจกรรมแจก iPhone7 32GB" width="16" height="24" />'; }else{ $streven=''; }
                        ?>
                        <tr>
                         <td height="35" bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php echo date('d/m/Y H:i',$n_time);?></span></div></td>
                          <td height="35" bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php if($row['HomeName']!='GETPOINT'){ echo date('d/m/Y H:s',$new_time); } ?></span></div></td>
                          <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"><div align="center" class="style28" style="cursor:pointer; color:<?php echo color_inverse(CheckColor($row['LeagueShortName'])); ?>;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" ><span <?php if($row['bet']=='1'){ echo 'class="style25"'; }else{ echo 'class="style18"'; } ?>>
                            <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
                            <?php echo trim($row['HomeName']);?><br/>( <font color="#B1FB17"><?php echo trim($row['ScoreHomeFullTime']);?></font> )
                            <? if ($row['ratio'] == 1)  { ?></div><? } ?>
                          </span></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
                           <div align="center" class="style25"><?php if($row['HomeName']=='GETPOINT'){ echo 'GETPOINT'; }else{ echo $row['bet'] == '1' ? 'HOME' : 'ALWAY'; } ?></div>                          </div></td>
                           <td bgcolor="<?php echo $bg;?>"><div align="center"><span <?php if($row['bet']=='2'){ echo 'class="style25"'; }else{ echo 'class="style18"'; } ?>>
                            <? if ($row['ratio'] == 2) { ?><span class="red">* <? } ?>
                            <?php echo $row['AwayName'];?><br/>( <font color="#B1FB17"><?php echo trim($row['ScoreAwayFulltime']);?></font> )
                            <? if ($row['ratio'] == 2)  { ?></span><? } ?>
                          </span></div></td>
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
							if($row['Status']=='Und'){ $txt = "เลือนการแข่งขัน"; }
                            $color = "#ffffff";
							}
                          ?>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><?php echo $row['hdc'];?></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="#ffffff"><?php if(trim($row['gametype'])=='point'){ echo $row['point']; }else if(trim($row['gametype'])=='rank'){ echo trim($row['gametype']); }else if(trim($row['gametype'])=='even'){ echo $streven; } ?></font></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $txt;?></font></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $row['winloss'];?></font></div></td>
                        </tr>
                        <?php 
                      } 
                      mysql_free_result($query);
                      
                      
               
           //   } 
            //  mysql_free_result($querym);

              ?>
 </table>
                  </div>
                </table>
                <br />
            </td>
          </tr>
        </table>

      </div>
      
    <?php  include('footer.inc.php');?>

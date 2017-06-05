<?php
$cachedir='cache'; // ชื่อแฟ้มเก็บไฟล์แคช 
$file='left.html'; // ชื่อไฟล์เว็บ
$cachefile=$cachedir.'/'.$file;
$cachetime =5;  // ระยะเวลา 100 วินาที 
// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
include($cachefile);
//echo " <p style='color:gray;font-size:0.7em;'> ข้อมูลเมื่อ ".date('jS F Y H:i', filemtime($cachefile))." </p> "; // แสดงข้อความเวลาที่บันทึก
//exit;
}else{

ob_start();
?>    
	<div style="margin-top:6px;">
      
      
      
      
      
      <table width="100%" border="0" cellspacing="0" bgcolor="#252525">
        <tr>
          <td height="38" colspan="2" background="bg-menu1.jpg" class="style54"><table width="100%" border="0">
            <tr>
              <td width="88%"><div align="center" class="style55">
                <div align="center" style="wi"><span class="style24">สรุปบอลเต็ง Rank 5 คู่ติด (<?php echo date('d-m-Y');?>)</span></div>
              </div></td>
              <td width="12%"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="67%" height="33" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">&nbsp;USERNAME</font></div></td>
          <td width="33%" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">คะแนน</font></div></td>
        </tr>
        <?php
		
		$dateminus1 = strtotime('-1 day', $datestart);
		$dateminus2 = strtotime('-1 day', $datestop);
		
        $sqls="
        SELECT
        playgame.memberID,members.username
        FROM
        playgame
		JOIN members
		ON members.code=playgame.memberID
		WHERE 
			unix_timestamp(playgame.date_create) > '".$dateminus1."'
			AND unix_timestamp(playgame.date_create) < '".$dateminus2."'
			AND playgame.gametype='rank'
			
        GROUP BY playgame.memberID
        ;";
       //echo $sqls;
        $querys=mysql_query($sqls,$conn);
        while($rows=mysql_fetch_assoc($querys)){
		
			$sqls2="
			SELECT
			getbonus,winloss
			FROM
			playgame
			WHERE 
				memberID='".$rows['memberID']."' AND
			unix_timestamp(date_create) > '".$dateminus1."'
			AND unix_timestamp(date_create) < '".$dateminus2."'
			
			AND gametype='rank'
			ORDER BY date_create DESC
				LIMIT 5
			;";
			
			$querys2=mysql_query($sqls2,$conn);
			$wdl='';
			$winlosss=0;
			$sumbo=0;
			while($rows2=mysql_fetch_assoc($querys2)){
			$winlosss = $winlosss+$rows2['winloss'];
			$sumbo = $sumbo+$rows2['getbonus'];
			if($rows2['winloss']=='1.00'){ $wdl[]='W'; }else
			if($rows2['winloss']=='0.50'){ $wdl[]='w'; }else
			if($rows2['winloss']=='0.00'){ $wdl[]='D'; }else
			if($rows2['winloss']=='-0.50'){ $wdl[]='l'; }else
			if($rows2['winloss']=='-1.00'){ $wdl[]='L'; }
			
			
			}
		$allw = $wdl[0].$wdl[1].$wdl[2].$wdl[3].$wdl[4];
		
		
		if(strtoupper($allw)=='WWWWW'){
		
          ?>
          <tr>
            <td colspan="2" class="style54">
            
            <div class="style57" style="min-height:30px; padding:5px; border:solid #999999; border-width:1px 0 0 0;">
              <table width="100%" border="0">
                <tr>
                  <?php  if (file_exists("memberpic/".$rows['username'].'.jpg')) { ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="memberpic/<?php echo $rows['username'];?>.jpg" width="20" /></div></td>
                  <?php }else{ ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="pro-pic.jpg" width="20" /></div></td>
                  <?php } ?>
                  <td width="57%" style="color:#ffffff;"><a href="viewmemberplay.php?refID=<?=$rows['memberID']?>"><?php echo $rows['username'];?></a> 
				  <?php if($winlosss=='5' and $rows2['sumbo']=='0' and $rows['memberID']==$_SESSION[MEMBER]['DATA']['code'] ){ ?>
                  <a href="playbet.php?freebonus=100" class="btn btn-success btn-xs" style="color:#FFFFFF;">รับโบนัส</a>
                  <?php }else if($sumbo=='0' and $rows['memberID']==$_SESSION[MEMBER]['DATA']['code']){
				  ?>
                  <a href="playbet.php?freebonus=50" class="btn btn-success btn-xs" style="color:#FFFFFF;">รับโบนัส</a>
                  <?php
				  } ?></td>
                  <td width="30%" style="color:#00FF00;"><div align="center"><?php echo $allw;?>  
                  
                  </div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <?php 
        } 
		}

        mysql_free_result($querys);

        ?>
       
      </table>

      <br />
      
      
      <table width="100%" border="0" cellspacing="0" bgcolor="#252525">
        <tr>
          <td height="38" colspan="2" background="bg-menu1.jpg" class="style54"><table width="100%" border="0">
            <tr>
              <td width="88%"><div align="center" class="style55">
                <div align="center" style="wi"><span class="style24">ทำเนียบ Rank 7 วันล่าสุด</span></div>
              </div></td>
              <td width="12%"> <!--<div style="border:solid 1px #FFcc33; padding:5px; background:#FFCC33"> 
               <div align="center" class="style56"><a href="rank.php"><span style="color:#000000;">ทั้งหมด</span></a></div>
              </div>--></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="67%" height="33" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">&nbsp;USERNAME</font></div></td>
          <td width="33%" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">Win/Loss</font></div></td>
        </tr>
        <?php
        $sql="
      SELECT
         *,SUM(winloss) AS total
      FROM
      playgame
      WHERE
      cal = '1' AND
	  gametype='rank'
	  AND
      date_create > DATE_SUB(DATE(NOW()), INTERVAL 1 WEEK) 

      GROUP BY
      memberID
      ORDER BY
      total
      DESC
	  limit 10
      ;";
       // echo $sql;
      $query=mysql_query($sql,$conn);
      while($rows=mysql_fetch_assoc($query)){
        $user  = DisplayUser($rows['memberID']);
          ?>
          <tr>
            <td colspan="2" class="style54"><div class="style57" style="height:30px; padding:5px; border:solid #999999; border-width:1px 0 0 0;">
              <table width="100%" border="0">
                <tr>
                  <?php  if (file_exists("memberpic/".$user.'.jpg')) { ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="memberpic/<?php echo $user;?>.jpg" width="20" /></div></td>
                  <?php }else{ ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="pro-pic.jpg" width="20" /></div></td>
                  <?php } ?>
                  <td width="57%" style="color:#ffffff;"><a href="viewmemberplay.php?refID=<?=$rows['memberID']?>"><?php echo $user;?></a></td>
                  <td width="30%" style="color:#00FF00;"><div align="center"><?php echo number_format($rows['total']*2);?></div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <?php 
        } 

        ?>
      </table>
	  
	  <br />
	  
      <table width="100%" border="0" cellspacing="0" bgcolor="#252525">
        <tr>
          <td height="38" colspan="2" background="bg-menu1.jpg" class="style54"><table width="100%" border="0">
            <tr>
              <td width="88%"><div align="center" class="style55">
                <div align="center" style="wi"><span class="style24">ทำเนียบ Point 7 วันล่าสุด</span></div>
              </div></td>
              <td width="12%"><!--<div style="border:solid 1px #FFcc33; padding:5px; background:#FFCC33"> 
                <div align="center" class="style56"><a href="point.php"><span style="color:#000000;">ทั้งหมด</span></a></div>
              </div>--></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="67%" height="33" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">&nbsp;USERNAME</font></div></td>
          <td width="33%" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">Win/Loss</font></div></td>
        </tr>
        <?php
        $sql="
      SELECT
         *,SUM(point) AS total
      FROM
      playgame
      WHERE
      cal = '1' AND
	  status = '1' AND
	  gametype='point'
	  AND
      date_create > DATE_SUB(DATE(NOW()), INTERVAL 1 WEEK) 

      GROUP BY
      memberID
      ORDER BY
      total
      DESC
      ;";
       // echo $sql;
      $query=mysql_query($sql,$conn);
      while($rows=mysql_fetch_assoc($query)){
	  $sqld="
                      SELECT
                      point,winloss,gametype,status,matchID,cal
                      FROM
                      playgame
                      WHERE
                      memberID = '".$rows['memberID']."' 
					  AND
					  cal = '1' AND
					  gametype='point'
					  AND
					  date_create > DATE_SUB(DATE(NOW()), INTERVAL 1 WEEK) 
					  ORDER BY date_create ASC
                      
                      ;";
        
                      $queryd=mysql_query($sqld,$conn);
                      $c = 0;
					  $sumpoint=0;
                      while($rowd=mysql_fetch_assoc($queryd)){
						if($rowd['gametype']=='point'){
						$c++;
						if($c=='1'){
							$sumpoint = $sumpoint+$rowd['point'];
						}
									  
							  
							  if($rowd['matchID']!='GETPOINT'){
							  	if($rowd['cal']!='0'){
									  
									$sumpoint = ($sumpoint+($rowd['point']*$rowd['winloss']));
									  
							  	}
							  }
							  
							  if($rowd['matchID']=='GETPOINT'){ $sumpoint=$sumpoint+$rowd['point']; }
							  if($rowd['cal']=='0'){ $sumpoint=$sumpoint-$rowd['point']; }
							  
							  //if($_GET['p']=='p'){ echo "status ".$rowd['status']." | point ".$rowd['point']."|".$sumpoint."<br>"; }
							 // if($row['winloss']=='0.00' and $row['status']==''){ $sumpoint=$sumpoint-$row['point'];  }
						  }
                      }
					  $sumpoint = round($sumpoint);
					   $sumpoi[] = $sumpoint.".".$rows['memberID'];
					   $memberid[$sumpoint.".".$rows['memberID']] = $rows['memberID'];
	  }
	  
	  	@rsort($sumpoi);
		$tmp=0;
		foreach($sumpoi as $x=>$x_value)if ($tmp++ < 10){
		
		//if($_GET['p']='p'){ print_r($x_value); }
		
        $user  = DisplayUser($memberid[$x_value]);
		
          ?>
          <tr>
            <td colspan="2" class="style54"><div class="style57" style="height:30px; padding:5px; border:solid #999999; border-width:1px 0 0 0;">
              <table width="100%" border="0">
                <tr>
                  <?php  if (file_exists("memberpic/".$user.'.jpg')) { ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="memberpic/<?php echo $user;?>.jpg" width="20" /></div></td>
                  <?php }else{ ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="pro-pic.jpg" width="20" /></div></td>
                  <?php } ?>
                  <td width="57%" style="color:#ffffff;"><a href="viewmemberplay.php?refID=<?=$memberid[$x_value]?>&T=R"><?php echo $user;?></a></td>
                  <td width="30%" style="color:#00FF00;"><div align="center"><?php 
				  echo number_format($x_value,0);
                      
                      ?>
				  
				  </div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <?php 
       }
        ?>
       
      </table>

      <br />
      
      
      
      
       <table width="100%" border="0" cellspacing="0" bgcolor="#252525">
        <tr>
          <td height="38" colspan="2" background="bg-menu1.jpg" class="style54"><table width="100%" border="0">
            <tr>
              <td width="68%"><div align="center" class="style55">
                <div align="center" style="wi"><span class="style24">ทำเนียบ Rank<br />ประจำเดือน</span></div>
              </div></td>
              <td width="32%"><div style="border:solid 1px #FFcc33; padding:5px; background:#FFCC33"> 
                <div align="center" class="style56"><a href="rank.php"><span style="color:#000000;">ทั้งหมด</span></a></div>
              </div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="67%" height="33" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">&nbsp;USERNAME</font></div></td>
          <td width="33%" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">คะแนน</font></div></td>
        </tr>
        <?php
        $sqls="
        SELECT
        *
        FROM
        members_score
		where months='".date('m')."' AND years='".date('Y')."'
        ORDER BY
        rank
        DESC
        LIMIT 10
        ;";
        $querys=mysql_query($sqls,$conn);
        while($rows=mysql_fetch_assoc($querys)){
          ?>
          <tr>
            <td colspan="2" class="style54"><div class="style57" style="height:30px; padding:5px; border:solid #999999; border-width:1px 0 0 0;">
              <table width="100%" border="0">
                <tr>
                  <?php  if (file_exists("memberpic/".$rows['username'].'.jpg')) { ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="memberpic/<?php echo $rows['username'];?>.jpg" width="20" /></div></td>
                  <?php }else{ ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="pro-pic.jpg" width="20" /></div></td>
                  <?php } ?>
                  <td width="57%" style="color:#ffffff;"><a href="viewmemberplay.php?refID=<?=$rows['memberID']?>&T=R"><?php echo $rows['username'];?></a></td>
                  <td width="30%" style="color:#00FF00;"><div align="center"><?php echo number_format($rows['rank']);?></div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <?php 
        } 

        mysql_free_result($querys);

        ?>
      </table>
	  
	  <br />
	  
      <table width="100%" border="0" cellspacing="0" bgcolor="#252525">
        <tr>
          <td height="38" colspan="2" background="bg-menu1.jpg" class="style54"><table width="100%" border="0">
            <tr>
              <td width="68%"><div align="center" class="style55">
                <div align="center" style="wi"><span class="style24">ทำเนียบ Point<br />ประจำเดือน</span></div>
              </div></td>
              <td width="32%"><div style="border:solid 1px #FFcc33; padding:5px; background:#FFCC33"> 
                <div align="center" class="style56"><a href="point.php"><span style="color:#000000;">ทั้งหมด</span></a></div>
              </div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="67%" height="33" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">&nbsp;USERNAME</font></div></td>
          <td width="33%" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">คะแนน</font></div></td>
        </tr>
        <?php
        $sqls="
        SELECT
        *
        FROM
        members_score
		where months='".date('m')."' AND years='".date('Y')."'
        ORDER BY
        point
        DESC
        LIMIT 10
        ;";
        $querys=mysql_query($sqls,$conn);
        while($rows=mysql_fetch_assoc($querys)){
          ?>
          <tr>
            <td colspan="2" class="style54"><div class="style57" style="height:30px; padding:5px; border:solid #999999; border-width:1px 0 0 0;">
              <table width="100%" border="0">
                <tr>
                  <?php  if (file_exists("memberpic/".$rows['username'].'.jpg')) { ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="memberpic/<?php echo $rows['username'];?>.jpg" width="20" /></div></td>
                  <?php }else{ ?>
                  <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999; overflow:hidden;"><img src="pro-pic.jpg" width="20" /></div></td>
                  <?php } ?>
                  <td width="57%" style="color:#ffffff;"><a href="viewmemberplay.php?refID=<?=$rows['memberID']?>"><?php echo $rows['username'];?></a></td>
                  <td width="30%" style="color:#00FF00;"><div align="center"><?php echo number_format($rows['point']);?></div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <?php 
        } 

        mysql_free_result($querys);

        ?>
       
      </table>

      <br />
    <!--  <table width="100%" border="0" cellspacing="0" bgcolor="#252525">
        <tr>
          <td height="38" colspan="2" background="bg-menu1.jpg" class="style54"><table width="100%" border="0">
            <tr>
              <td width="68%"><div align="center" class="style55">
                <div align="center" style="wi"><span class="style24">5 อันดับสูงสุด</span> สัปดาห์</div>
              </div></td>
              <td width="32%"><div style="border:solid 1px #FFcc33; padding:5px; background:#FFCC33">
                <div align="center" class="style56">ทั้งหมด</div>
              </div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="67%" height="33" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">&nbsp;USERNAME</font></div></td>
          <td width="33%" bgcolor="#131313" class="style54"><div align="center" class="style60"><font color="#9DB333" face="Tahoma">คะแนน</font></div></td>
        </tr>
        <tr>
          <td colspan="2" class="style54"><div class="style57" style="height:30px; padding:5px; border:solid 1px #999999;">
            <table width="100%" border="0">
              <tr>
                <td width="13%"><div style="width:20px; height:20px; border:solid 1px #999999;"><img src="pro-pic.jpg" width="20" /></div></td>
                <td width="57%" style="color:#ffffff;">MAXDRIVE</td>
                <td width="30%"  style="color:#00FF00;"><div align="center">198</div></td>
              </tr>
            </table>
          </div></td>
        </tr>
      </table>-->
	  
	  
	  <div class="fb-page" data-href="https://www.facebook.com/bafobet/" data-tabs="timeline" data-width="240" data-height="600" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/bafobet/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/bafobet/">Bafobet</a></blockquote></div>
	  
	  <br><br>
	  <center>
	  <a href='http://aff.512xiaojin.com/Accept.ashx?sid=df193591-98be-4a2c-92fa-99b0ca16acec&lang=th-th&aid=759&cid=c64af71a-bc4d-46e7-8ac2-acea90c5b938'><img src='http://aff.512xiaojin.com/Collateral.ashx?sid=df193591-98be-4a2c-92fa-99b0ca16acec&lang=th-th&id=c64af71a-bc4d-46e7-8ac2-acea90c5b938' width="240" border='0'></a>
<br /><br />
<a href='http://aff.512xiaojin.com/Accept.ashx?sid=082c9f3a-41a8-4d30-b827-a5f7414ca6c8&lang=id-id&aid=759&cid=732c5955-ec92-4bae-93d8-9666c853d573'><img src='http://aff.512xiaojin.com/Collateral.ashx?sid=082c9f3a-41a8-4d30-b827-a5f7414ca6c8&lang=id-id&id=732c5955-ec92-4bae-93d8-9666c853d573' width="240" border='0'></a>

<br /><br />

<a href='http://aff.512xiaojin.com/Accept.ashx?sid=2aa52cfc-8562-49a5-b921-0d9a5bad3e8b&lang=th-th&aid=759&cid=3fa8cd22-34c5-43c2-94a1-e62abdc31a3d'><img src='http://aff.512xiaojin.com/Collateral.ashx?sid=2aa52cfc-8562-49a5-b921-0d9a5bad3e8b&lang=th-th&id=3fa8cd22-34c5-43c2-94a1-e62abdc31a3d' width="240" border='0'></a>


</center>
    </div>
	
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

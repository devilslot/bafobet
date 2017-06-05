<?php include ('header.inc.php');?>

<div class="style29" style="width:240px; float:left;">
<?php include ('left.php');?>
</div>


<?
if(empty($_GET['dateMatch'])){
  $date= date('Y-m-d');
  //$dateminus1= strtotime('-1 day', date('Y-m-d'));
}else{
  $date = $_GET['dateMatch'];
}
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
  <div style="width:790px; float:right; ">
  <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
              <tr>
        <td height="42" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
          <div align="left">&nbsp;&nbsp;<span class="style24"></span> บอลที่แข่งขัน 
           
          </div>
        </div></td>
      </tr>
              <tr>
                <td width="100%" bgcolor="#000000" colspan="6" valign="top">
                  <div class="scroll">
                    <table width="100%" style="hight:100px;">
                      <tr>
                        <td  width="10%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28"></span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">สถานะ</span></div></td>
                        
                      </tr>
                      <?php
                      $sql="
                      SELECT
                      *
                      FROM
                      matchHDC
                      WHERE
                      MatchID = '".$_GET['matchID']."'
					  
                      ;";
       // echo $sql;
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
                        ?>
                        <tr>
                          <td height="35" bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php echo date('d/m/Y H:s',$new_time);?></span></div></td>
                          <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"><div align="center" class="style28" style="cursor:pointer;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" ><span class="style18">
                            <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
                            <?php echo trim($row['HomeName']);?><br/>
                            <? if ($row['ratio'] == 1)  { ?></div><? } ?>
                          </span></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div class="style20" style="width:70%; margin:auto; padding:5px; background: #333333;">
                           <div align="center" class="style25"><?php if($row['Status'] != '0'){ echo trim($row['ScoreHomeFullTime']);?> - <?php echo trim($row['ScoreAwayFulltime']); }else{ echo "? - ?"; } ?> </div>                          </div></td>
                           <td bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18">
                            <? if ($row['ratio'] == 2) { ?><span class="red">* <? } ?>
                            <?php echo $row['AwayName'];?><br/>
                            <? if ($row['ratio'] == 2)  { ?></span><? } ?>
                          </span></div></td>
                           <td bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18">
                           
                            <?php 
							 echo number_format($row['AsianHandicap'],2); 
							?>
                            
                          </span></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18">
                           
                            <?php 
							
							if($row['Status'] == '0'){ echo 'รอแข่ง'; }else 
							if($row['Status'] == '1'){ echo '1st'; }else 
							if($row['Status'] == '2'){ echo 'HT'; }else 
							if($row['Status'] == '3'){ echo '2rd'; }else 
							if($row['Status'] >= '-1'){ echo 'จบเกมส์'; }
							?>
                            
                          </span></div></td>
                          
                          
                        </tr>
                        <?php 
                      } 
                      mysql_free_result($query);
                      ?>
                    </table>
                  </div>
                </table>
    
        
        <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
              <tr>
        <td height="42" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
          <div align="left">&nbsp;&nbsp;<span class="style24">สรุป</span>ผู้ที่ทายผล
            
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
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทาย</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">Point/Rank</span></div></td>
                      </tr>
          <?php
		  //AND DATE_FORMAT(date_create,'%Y-%m-%d') = '".$date."'
          $sqlm="
          SELECT
          *
          FROM
          playgame
          WHERE
          matchID = '".$_GET['matchID']."'
          ORDER BY
          code
          DESC
		  LIMIT 100
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
                         <?php  if (file_exists("memberpic/".$rowm['user_create'].'.jpg')) { ?>
                  <td width="13%" bgcolor="<?php echo $bg;?>"><div style="width:50px; height:50px; border:solid 1px #999999; overflow:hidden; margin:0 auto;"><img src="memberpic/<?php echo $rowm['user_create'];?>.jpg" width="50" /></div></td>
                  <?php }else{ ?>
                  <td width="13%" bgcolor="<?php echo $bg;?>"><div style="width:50px; height:50px; border:solid 1px #999999; overflow:hidden; margin:0 auto;"><img src="pro-pic.jpg" width="50" /></div></td>
                  <?php } ?>
                          
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style27"><span class="style28"><a href="viewmemberplay.php?refID=<?=$rowm['memberID']?>"><?php echo $rowm['user_create'];?></a></span></div></td>
                          
                          <td bgcolor="<?php echo $bg;?>">
                           <div align="center" class="style25"><?php echo $rowm['bet'] == '1' ? 'เจ้าบ้าน' : 'ทีมเยือน'; ?></div>
                           </td>
                           
                            <td bgcolor="<?php echo $bg;?>">
                           <div align="center"><span class="style18"><?php if(trim($rowm['gametype'])=='point'){ echo $rowm['point']; }else{ echo trim($rowm['gametype']); }; ?></span></div></td>
                           
                        </tr>
                       
                <?php 
              } 
              mysql_free_result($querym);

              ?>

                    </table>
                  </div>
                
            </td>
          </tr>
        </table>

      </div>
    <?php include('footer.inc.php');?>

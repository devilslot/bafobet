<?php include ('header.inc.php');?>
<div class="style29" style="width:240px; float:left;">
<?php include ('left.php');?>
</div>

<?php
if(empty($_GET['dateMatch'])){
  $date= date('Y-m-d');
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

function selec2(){
  var ab=document.getElementById('se2');
  location.href=ab.value;
}
</script>

  <div style="width:790px; float:right; ">
    <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
      <tr>
        <td height="42" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
          <div align="left">&nbsp;&nbsp;<span class="style24">สรุป</span>การทายผลย้อนหลัง [ Rank | ชิงอันดับ ]
            <select name="se" id="se" onchange="selec();">
              <option>++เลือกวันที่++</option>
              <?php
              $sqld="
              SELECT
              DATE_FORMAT(date_create,'%Y-%m-%d') AS datem
              FROM
              playgamerank
              WHERE
              memberID = '".$_SESSION[MEMBER]['DATA']['code']."'
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
                <option value="historymember.php?dateMatch=<?php echo $rowd['datem'];?>" <?php echo $rowd['datem'] == $date ? 'selected' : ''; ?> >วันที่ <?php  echo thai_date_fullmonth(strtotime($rowd['datem']));?></option>
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
          SELECT
          memberID,matchID
          FROM
          playgamerank
          WHERE
          memberID = '".$_SESSION[MEMBER]['DATA']['code']."' AND
          DATE_FORMAT(date_create,'%Y-%m-%d') = '".$date."'
          GROUP BY 
          DATE_FORMAT(date_create,'%Y-%m-%d')
          ORDER BY
          code
          DESC
          ;";
        //echo $sqlm;
          $querym=mysql_query($sqlm);
          while($rowm=mysql_fetch_assoc($querym)){
            $user  = DisplayUser($rowm['memberID']);
            ?>

            <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
              <tr>
                <td width="100%" bgcolor="#000000" colspan="6" valign="top">
                  <div class="scroll">
                    <table width="100%" style="hight:100px;">
                      <tr>
                        <td  width="10%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลีก</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเจ้าบ้าน</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทาย</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทีมเยือน</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ราคา</span></div></td>
                      
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">สถานะ</span></div></td>
                        <td   bgcolor="#000000"><div align="center" class="style27"><span class="style28">ได้-เสีย</span></div></td>
                      </tr>
                      <?php
                      $sql="
                      SELECT
                      md.*,pg.bet,pg.bet,pg.hdc,pg.point,pg.winloss,pg.status
                      FROM
                      matchHDC md,playgamerank pg
                      WHERE
                      md.MatchID = pg.matchID AND
					  md.Date LIKE '".$date."%' AND
                      pg.memberID = '".$rowm['memberID']."'
                      ORDER BY
                      pg.code
                      DESC
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
                        //$current_time = $row['time_match'];
                        $new_time = strtotime($row['Date']);
                        ?>
                        <tr>
                          <td height="35" bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);;?></span></div></td>
                          <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"><div align="center" class="style28" style="cursor:pointer; color:#333333;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" ><span class="style18">
                            <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
                            <?php echo trim($row['HomeName']);?><br/>( <font color="#B1FB17"><?php echo trim($row['ScoreHomeFullTime']);?></font> )
                            <? if ($row['ratio'] == 1)  { ?></div><? } ?>
                          </span></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
                           <div align="center" class="style25"><?php echo $row['bet'] == '1' ? 'HOME' : 'ALWAY'; ?></div>                          </div></td>
                           <td bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18">
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
                            $color = "#F3FF00";
                          }else if($row['status'] == 0){
						  	$txt = "รอแข่ง";
                            if($row['Status']==1){ $txt = "1st"; }
							if($row['Status']==2){ $txt = "HT"; }
							if($row['Status']==3){ $txt = "2nd"; }
                            $color = "#ffffff";
                          }
                          ?>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><?php echo $row['hdc'];?></div></td>
                          
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $txt;?></font></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $row['winloss'];?></font></div></td>
                        </tr>
                        <?php 
                      } 
                      mysql_free_result($query);
                      ?>
                    </table>
                  </div>
                </table>
                <br />
                <?php 
              } 
              mysql_free_result($querym);

              ?>

            </td>
          </tr>
        </table>

      </div>
   
    <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
      <tr>
        <td height="42" background="bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
          <div align="left">&nbsp;&nbsp;<span class="style24">สรุป</span>การทายผลย้อนหลัง [ Point | แต้ม ] 
            <select name="se2" id="se2" onchange="selec2();">
              <option>++เลือกวันที่++</option>
              <?php
              $sqld="
              SELECT
              DATE_FORMAT(date_create,'%Y-%m-%d') AS datem
              FROM
              playgame
              WHERE
              memberID = '".$_SESSION[MEMBER]['DATA']['code']."'
              GROUP BY 
              DATE_FORMAT(date_create,'%Y-%m-%d')
              ORDER BY
              date_create
              DESC
              ;";
        
              $queryd=mysql_query($sqld);
              while($rowd=mysql_fetch_assoc($queryd)){
                ?>
                <option value="historymember.php?dateMatch=<?php echo $rowd['datem'];?>" <?php echo $rowd['datem'] == $date ? 'selected' : ''; ?> >วันที่ <?php  echo thai_date_fullmonth(strtotime($rowd['datem']));?></option>
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
          SELECT
          memberID,matchID
          FROM
          playgame
          WHERE
          memberID = '".$_SESSION[MEMBER]['DATA']['code']."' AND
          DATE_FORMAT(date_create,'%Y-%m-%d') = '".$date."'
          GROUP BY 
          DATE_FORMAT(date_create,'%Y-%m-%d')
          ORDER BY
          code
          DESC
          ;";
        //echo $sqlm;
          $querym=mysql_query($sqlm);
          while($rowm=mysql_fetch_assoc($querym)){
            $user  = DisplayUser($rowm['memberID']);
            ?>

            <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
              <tr>
                <td width="100%" bgcolor="#000000" colspan="6" valign="top">
                  <div class="scroll">
                    <table width="100%" style="hight:100px;">
                      <tr>
                        <td  width="10%" height="40" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เวลา</span></div></td>
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
                      $sql="
                      SELECT
                      md.*,pg.bet,pg.bet,pg.hdc,pg.point,pg.winloss,pg.status
                      FROM
                      matchHDC md,playgame pg
                      WHERE
                      md.MatchID = pg.matchID AND
					  md.Date LIKE '".$date."%' AND
                      pg.memberID = '".$rowm['memberID']."'
                      ORDER BY
                      pg.code
                      DESC
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
                        //$current_time = $row['time_match'];
                        $new_time = strtotime($row['Date']);
                        ?>
                        <tr>
                          <td height="35" bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18"><?php echo date('H:i', $new_time);?></span></div></td>
                          <td bgcolor="<?php echo CheckColor($row['LeagueShortName']);?>"><div align="center" class="style28" style="cursor:pointer; color:#333333;" title="<?php echo $row['LeagueEngName'];?>"><?php echo $row['LeagueShortName'];?></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" ><span class="style18">
                            <? if ($row['ratio'] == 1) { ?><div class="red">* <? } ?>
                            <?php echo trim($row['HomeName']);?><br/>( <font color="#B1FB17"><?php echo trim($row['ScoreHomeFullTime']);?></font> )
                            <? if ($row['ratio'] == 1)  { ?></div><? } ?>
                          </span></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div class="style20" style="width:80%; margin:auto; padding:5px; background: #333333;">
                           <div align="center" class="style25"><?php echo $row['bet'] == '1' ? 'HOME' : 'ALWAY'; ?></div>                          </div></td>
                           <td bgcolor="<?php echo $bg;?>"><div align="center"><span class="style18">
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
                            $color = "#F3FF00";
                          }else if($row['status'] == 0){
                           $txt = "รอแข่ง";
                            if($row['Status']==1){ $txt = "1st"; }
							if($row['Status']==2){ $txt = "HT"; }
							if($row['Status']==3){ $txt = "2nd"; }
                            $color = "#ffffff";
                          }
                          ?>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><?php echo $row['hdc'];?></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="#ffffff"><?php echo $row['point'];?></font></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $txt;?></font></div></td>
                          <td bgcolor="<?php echo $bg;?>"><div align="center" class="style25"><font color="<?php echo $color;?>"><?php echo $row['winloss'];?></font></div></td>
                        </tr>
                        <?php 
                      } 
                      mysql_free_result($query);
                      ?>
                    </table>
                 </div>
                </table>
                <br />
                <?php 
              } 
              mysql_free_result($querym);

              ?>

            </td>
          </tr>
        </table>

      </div>
        <?php include('footer.inc.php');?>
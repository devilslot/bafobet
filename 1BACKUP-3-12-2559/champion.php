<?php include ('header.inc.php');?>
<div class="style29" style="width:240px; float:left;">
<?php include ('cache/left.html');?>
</div>

<?php
$cachedir='cache'; // ชื่อแฟ้มเก็บไฟล์แคช 
$file='champion.html'; // ชื่อไฟล์เว็บ
$cachefile=$cachedir.'/'.$file;
$cachetime =21600;  // ระยะเวลา 5 นาที 
//$cachetime =0;  // ระยะเวลา 5 นาที 
// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
include($cachefile);
echo " <p style='color:gray;font-size:0.7em;'> ข้อมูลเมื่อ ".date('jS F Y H:i', filemtime($cachefile))." </p> "; // แสดงข้อความเวลาที่บันทึก
//exit;
}else{

ob_start();

?>

<style type="text/css">
<!--
.style68 {font-size: 12px; font-family: Tahoma; color: #CCCCCC; }
.style74 {
	font-size: 18px;
	font-weight: bold;
	color: #FF9621;
}
.style79 {
	font-size: 24px;
	color: #FFB12D;
}
.style80 {color: #0099CC}
.style81 {color: #00FF00}
-->
</style>


    <div style="width:790px; float:right; ">
        <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
        <tr>
          <td height="42" colspan="8" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
            <div align="left">&nbsp;&nbsp;<span class="style24">ทำเนียบแชมป์ Point ประจำเดือน 25 อันดับ</span></div>
          </div></td>
        </tr>
        <tr>
          <td width="7%" height="41" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลำดับ</span></div></td>
          <td width="9%" bgcolor="#000000"><div align="center" class="style27">AVATAR</div></td>
          <td width="22%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">USERNAME</span></div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทายทั้งหมด</span></div></td>
          <td width="11%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ชนะ</span></div></td>
          <td width="11%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เสมอ</span></div></td>
          <td width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">แพ้</span></div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">แต้มทั้งหมด</span></div></td>
        </tr>
        <?php
        $sql="
        SELECT
         *,SUM(winloss) AS total
        FROM
        playgame
		JOIN members
		ON members.code=playgame.memberID
        WHERE
        cal = '1' AND
        playgame.date_create like '".date('Y-m')."%'
AND playgame.gametype='point'
        GROUP BY
        memberID
        ORDER BY
        members.score
        DESC
		LIMIT 25
        ;";
       // echo $sql;
        $query=mysql_query($sql);
        $loop =0;
        while($row=mysql_fetch_assoc($query)){
          $loop++;
		  if($loop % 2 == 0){
                            $bgb ="#282828";
                          }else{
                            $bgb ="#1D1D1D";
                          }
          $user  = DisplayUser($row['memberID']);
   //$new_time = strtotime($row['Date']);
        // $new_time = strtotime($row['Date']);
          ?>
          <tr bgcolor="<?=$bgb?>">
            <td height="35"><div align="center"><span class="style18 style74"><span class="style79"><?php echo $loop;?></span></span></div></td>
            <td> 
			<?php  if (file_exists("memberpic/".$user.'.jpg')) { ?>
                 <div style="width:50px; height:50px; border:solid 1px #999999; overflow:hidden;"><img src="memberpic/<?php echo $user;?>.jpg" width="50" /></div>
                  <?php }else{ ?>
                  <div style="width:50px; height:50px; border:solid 1px #999999; overflow:hidden;"><img src="images/pro-pic.jpg" width="50" /></div>
                  <?php } ?>
			</td>
            <td><div align="center"><span class="style67 style18"><strong><span class="style67"><a style="color:#FFCC33;" href="viewmemberplay.php?refID=<?php echo $row['memberID'];?>"><?php echo $user;?></a> </span></strong></span></div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px;  border:solid 1px #FFFF00 ">
              <div align="center" class="style25"><?php echo CountPlay($row['memberID']);?></div>
            </div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; border:solid 1px #00FF00 ">
              <div align="center" class="style25 style81"><?php echo CountWin($row['memberID']);?></div>
            </div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; border:solid 1px #0099CC ">
              <div align="center" class="style25 style80"><?php echo CountDraw($row['memberID']);?></div>
            </div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; border:solid 1px #FF0000 ">
              <div align="center" class="style25 style62"><?php echo CountLoss($row['memberID']);?></div>
            </div></td>
            <td><span class="style18"></span>
              <div class="style20" style="width:80%; margin:auto; padding:5px;  border:solid 1px #FFFF00 ">
                <div align="center" class="style25"><?php echo number_format($row['score']);?></div>
              </div></td>
            </tr>
            <?php 
          } 

          mysql_free_result($query);

          ?>

        </table>
        
      <table width="780" border="0" align="center" cellspacing="1" bgcolor="#202020" style="margin-top:5px;">
        <tr>
          <td height="42" colspan="8" background="images/bg-menu1.jpg" bgcolor="#004000"><div align="center" class="style5">
            <div align="left">&nbsp;&nbsp;<span class="style24">ทำเนียบแชมป์ Rank ประจำเดือน 25 อันดับ</span></div>
          </div></td>
        </tr>
        <tr>
          <td width="7%" height="41" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ลำดับ</span></div></td>
          <td width="9%" bgcolor="#000000"><div align="center" class="style27">AVATAR</div></td>
          <td width="22%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">USERNAME</span></div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ทายทั้งหมด</span></div></td>
          <td width="11%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">ชนะ</span></div></td>
          <td width="11%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">เสมอ</span></div></td>
          <td width="10%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">แพ้</span></div></td>
          <td width="15%" bgcolor="#000000"><div align="center" class="style27"><span class="style28">แต้มทั้งหมด</span></div></td>
        </tr>
        <?php
        $sql="
        SELECT
         *,SUM(winloss) AS total
        FROM
        playgame
		JOIN members
		ON members.code=playgame.memberID
        WHERE
        cal = '1' AND
        playgame.date_create like '".date('Y-m')."%' 
AND playgame.gametype='rank'
        GROUP BY
        memberID
        ORDER BY
        members.rank
        DESC
		LIMIT 25
        ;";
       // echo $sql;
        $query=mysql_query($sql);
        $loop =0;
        while($row=mysql_fetch_assoc($query)){
          $loop++;
		  if($loop % 2 == 0){
                            $bgb ="#282828";
                          }else{
                            $bgb ="#1D1D1D";
                          }
          $user  = DisplayUser($row['memberID']);
   //$new_time = strtotime($row['Date']);
        // $new_time = strtotime($row['Date']);
          ?>
          <tr bgcolor="<?=$bgb?>">
            <td height="35"><div align="center"><span class="style18 style74"><span class="style79"><?php echo $loop;?></span></span></div></td>
            <td> <div class="style54" style="width:50px; height:50px; overflow:hidden; margin:auto; border:solid 3px #CCCCCC; background:url(pro-pic.jpg);"><?php echo FilePicUser($user,50);?></div></td>
            <td><div align="center"><span class="style67 style18"><strong><span class="style67"><a style="color:#FFCC33;" href="history.php?memberid=<?php echo $row['memberID'];?>"><?php echo $user;?></a> </span></strong></span></div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px;  border:solid 1px #FFFF00 ">
              <div align="center" class="style25"><?php echo CountPlay($row['memberID']);?></div>
            </div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; border:solid 1px #00FF00 ">
              <div align="center" class="style25 style81"><?php echo CountWin($row['memberID']);?></div>
            </div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; border:solid 1px #0099CC ">
              <div align="center" class="style25 style80"><?php echo CountDraw($row['memberID']);?></div>
            </div></td>
            <td><div class="style20" style="width:80%; margin:auto; padding:5px; border:solid 1px #FF0000 ">
              <div align="center" class="style25 style62"><?php echo CountLoss($row['memberID']);?></div>
            </div></td>
            <td><span class="style18"></span>
              <div class="style20" style="width:80%; margin:auto; padding:5px;  border:solid 1px #FFFF00 ">
                <div align="center" class="style25"><?php echo number_format($row['total']*2);?></div>
              </div></td>
            </tr>
            <?php 
          } 

          mysql_free_result($query);

          ?>

        </table>
        
		<?php
        $cachedata = ob_get_contents(); 
		//$cachedata=str_replace('<img src="','<img src="cachepic.php?url=',$cachedata);




// BOTTOM of your script
$fp = fopen($cachefile, 'w'); // open the cache file for writing
fwrite($fp, $cachedata); // save the contents of output buffer to the file
fclose($fp); // close the file
ob_end_clean();
ob_end_flush(); // Send the output to the browser

echo $cachedata;
}

?>
        
      </div>
 <?php include('footer.inc.php');?>

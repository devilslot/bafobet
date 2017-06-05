<?php include ('header.inc.php');?>
<?php
if($_GET['p']=='p'){
		  echo '<pre>';print_r($_SESSION);echo '</pre>';
		  }
		  ?>
<div class="style29" style="width:240px; float:left;">
<?php include ('left.php');?>
</div>

<script>
function update() {
  $("#notice_div").html('Loading..'); 
  $.ajax({
    type: 'GET',
    url: 'reloadindex2.php',
    timeout: 4000,
    success: function(data) {
      $("#reload").html(data);
	  
      //$("#notice_div").html(''); 
      window.setTimeout(update, 60000);
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
     // $("#notice_div").html('Timeout contacting server..');
     window.setTimeout(update, 60000);
   }
 });
}

$(document).ready(function(){
  update();
  });
</script>

<style type="text/css">



</style>

    <div style="width:790px; float:right; ">
	
	<div style="padding:5px;">
	<table width="100%" border="0" cellspacing="0" bgcolor="#252525">
        <tr>
          <td height="38" colspan="2" background="bg-menu1.jpg" class="style54"><table width="100%" border="0">
            <tr>
              <td width="88%"><div align="center" class="style55">
                <div align="center" style="wi"><span class="style24">สรุปบอลเต็ง POINT 12 คู่ติด ได้รับรางวัล Iphone7 16GB (<?php echo date('d-m-Y');?>)</span></div>
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
		$dateminus2 = strtotime('0 day', $datestop);
		
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
			AND playgame.gametype='point'
			
        GROUP BY playgame.memberID
        ;";
      
        $querys=mysql_query($sqls);
        while($rows=mysql_fetch_assoc($querys)){
		
			$sqls2="
			SELECT
			getbonus,winloss
			FROM
			playgame
			WHERE 
				memberID='".$rows['memberID']."'
			AND unix_timestamp(date_create) > '".$dateminus1."'
			AND unix_timestamp(date_create) < '".$dateminus2."'
			
			AND gametype='point'
			ORDER BY date_create DESC
				LIMIT 12
			;";
			
			$querys2=mysql_query($sqls2);
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
		$allw = $wdl[0].$wdl[1].$wdl[2].$wdl[3].$wdl[4].$wdl[5].$wdl[6].$wdl[7].$wdl[8].$wdl[9].$wdl[10].$wdl[11];
		
		
		if(strtoupper($allw)=='WWWWWWWWWWWW'){
		
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
				  <?php if($winlosss=='12' and $rows2['sumbo']=='0' and $rows['memberID']==$_SESSION[MEMBER]['DATA']['code'] ){ ?>
                  <a href="javascript:;" class="btn btn-success btn-xs" style="color:#FFFFFF;">รับรางวัล ติดต่อแชท</a>
                  <?php }else if($sumbo=='0' and $rows['memberID']==$_SESSION[MEMBER]['DATA']['code']){
				  ?>
                  <a href="javascript:;" class="btn btn-success btn-xs" style="color:#FFFFFF;">รับรางวัล ติดต่อแชท</a>
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
</div>
      
	  
      <div id="reload">
        <div align="center"><br />
            <br />
          <img src="images/loading-bar.gif" width="192" height="12" />          <br />
          <span class="style29">กำลังโหลด Live Score </span><br />
          <br />
          <br />
        </div>
      </div>
    </div>
    

    <?php include('footer.inc.php');?>
 
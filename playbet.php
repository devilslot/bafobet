<?
@session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
/*if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
 echo '<script> alert("กรุณาเข้าระบบ หรือ สมัครสมาชิกก่อนค่ะ!"); window.location="index.php"; </script>';
  exit;
}*/

require_once "service/service.php";
require_once "creation/creation.init.php";

$user = base64_decode(base64_decode($_GET['token']));
$user = explode("-", $user);
if($_GET['p']=='p'){
	echo '<pre>';print_r($_SESSION);echo '</pre>'.$user[0];
}
//
if($_GET['token']!='' and date('dmyH')==$user[2]){
	
	
	
  	//$table = 'members';
  	$datenow = DateNow();
  	//$obj = new clsCreation($table);
  
  	//$login = $obj->LoadOne('members',array('username' => $user,'enable'=>'Y'));
	$sqlmembers="SELECT * FROM members where username='".$user[1]."' AND mainid=".$user[0]." AND enable='Y';";
	if($_GET['p']=='p'){ echo $sqlmembers; echo"<pre>";print_r($_SESSION);echo"</pre>"; }
    $querysqlmembers=mysql_query($sqlmembers,$conn);
	$a=0;
	$login=mysql_fetch_assoc($querysqlmembers);
  
  	$_SESSION[MEMBER]['LOGIN'] = 'OFF';
  	$_SESSION[MEMBER]['DATA'] = array();

    	$_SESSION[MEMBER]['LOGIN'] = 'ON';
    	$_SESSION[MEMBER]['DATA'] = $login;
		$_SESSION["username"] = $login['username'];
		$_SESSION["mid"] = $login['mainid'];
    	//$obj->Edit($table,array('lastIP' => IP(),'lastLogin' => $datenow),array('code'=>$_SESSION[MEMBER]['DATA']['code']));
		mysql_query("UPDATE members SET lastIP='".IP()."',lastLogin='".$datenow."' WHERE code='".$_SESSION[MEMBER]['DATA']['code']."' ",$conn);
		?>
		<script>
			//window.location="playbet.php";
		</script>
		<? 
  	
}elseif($_GET['token']!=''){ 
?>
<script>
    alert("Token หมดอายุ!! กรุณารีเฟรชหน้ารายชื่อสมาชิกอีกครั้ง");
	window.location="playbet.php";
</script>
<? 
}
//echo date('H')."<='07' or ".date('H').">='22'";

	
	/*if(date('H')>=00 and date('H')<07){
			if(date('Hi')>0011){
				echo '<script type="text/javascript">'; 
				echo 'alert("ฝากถอน ได้อีกครั้ง  08.00 น.");'; 
				echo 'window.location= "index.php";';
				echo '</script>';
				exit();
			}
		}*/
		
?>

<?php include('header.inc.php'); 

$db=Live::core("db");
$member=Live::member();
$resx = $db->GetRow("select * from tmtopup where used = '1'");


/*if(!$member){ 
			header ('HTTP/1.1 301 Moved Permanently');
			header ('Location: index.php');
}
*/
if($member['locked'] == 'lock'){
	$status['status'] = "0";
		header ('Location: index.php');
		exit();
}

$added=time();

$row = $db->GetRow("SELECT sum(amount) AS Total FROM paylogs where owner='".$member['id']."' AND froms like 'T:%' AND tos NOT LIKE 'W88:%' AND added > '".strtotime(date('Y-m-d 00:00:00'))."'");

$row88 = $db->GetRow("SELECT sum(amount) AS Total FROM paylogs where owner='".$member['id']."' AND froms like 'T:%' AND tos like 'W88:%' AND added > '".strtotime(date('Y-m-d 00:00:00'))."'");

$tmsum = $row['Total'];
$tmsumw88 = $row88['Total'];

if($member['active']=='Y' and !empty($_GET['mbonus'])){

 $dateb=date('Y-m-d H:i:s');
	if(date('d')=='01' and date('H')<'12'){
		$date_monb=date('m', strtotime("-2 months",strtotime($dateb)));
		$date_yearb=date('Y', strtotime("-2 months",strtotime($dateb)));	
	}else{
		$date_monb=date('m', strtotime("-1 months",strtotime($dateb)));
		$date_yearb=date('Y', strtotime("-1 months",strtotime($dateb)));	
	}
##rank ##
if($_GET['types']=='rank'){
        $sqls="
        SELECT
        *
        FROM
        members_score
			where months='".$date_monb."' AND years='".$date_yearb."'
        ORDER BY
        rank
        DESC
        LIMIT 3
        ;";
        $querys=mysql_query($sqls,$conn);
		$a=0;
		while($rows=mysql_fetch_assoc($querys)){
			$a++;
			
				
				if($a==1){ $credit=1000; }else if($a==2){ $credit=500; }else if($a==3){ $credit=300; }else{ $credit=0; }
				if($_SESSION[MEMBER]['DATA']['code']==$rows['memberID']){
					if($rows['getbonusr']==0){
						mysql_query("UPDATE members_score SET getbonusr='1' WHERE id='".$rows['id']."' ",$conn);
						$db->Execute("INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,status,added,added2,added3,added4,sure,toporder,q,personnel,ip,webroot,dep_bef,dep_aft) VALUES ('".$member['id']."','".$member['name']."','".$member['username']."','".$member['phone']."','coupon','CODE:MONTHFRD".$credit."B','MONEYBAG".$row['id']."','".$credit."','confirmed','".$added."','".$added."','".$added."','".$added."','1','','รางวัลบาโฟรายเดือน ".$credit." บาท','','','bafobet','".$member['moneybag']."','".($member['moneybag']+$credit)."')");
						$db->Execute("UPDATE member SET moneybag = moneybag+".$credit." where id= ".$member['id']." ");
				  		echo '<script> alert("ท่านได้รับโบนัส '.$credit.' บาท!"); window.location="playbet.php"; </script>';
					}else{
						echo '<script> alert("ท่านรับโบนัสไปแล้ว!"); window.location="playbet.php"; </script>';
					}
				}else if($a==3){
					echo '<script> alert("ท่านไม่ได้รับโบนัส!"); window.location="playbet.php"; </script>';
				}
				
			
        } 

        mysql_free_result($querys);
}


##rank ##
if($_GET['types']=='point'){
        $sqls="
        SELECT
        *
        FROM
        members_score
			where months='".$date_monb."' AND years='".$date_yearb."'
        ORDER BY
        point
        DESC
        LIMIT 3
        ;";
        $querys=mysql_query($sqls,$conn);
		$a=0;
		while($rows=mysql_fetch_assoc($querys)){
			$a++;
			
				
				if($a==1){ $credit=1000; }else if($a==2){ $credit=500; }else if($a==3){ $credit=300; }else{ $credit=0; }
				if($_SESSION[MEMBER]['DATA']['code']==$rows['memberID']){
					if($rows['getbonusp']==0){
					mysql_query("UPDATE members_score SET getbonusp='1' WHERE id='".$rows['id']."' ",$conn);
					$db->Execute("INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,status,added,added2,added3,added4,sure,toporder,q,personnel,ip,webroot,dep_bef,dep_aft) VALUES ('".$member['id']."','".$member['name']."','".$member['username']."','".$member['phone']."','coupon','CODE:MONTHFRD".$credit."B','MONEYBAG".$row['id']."','".$credit."','confirmed','".$added."','".$added."','".$added."','".$added."','1','','รางวัลบาโฟรายเดือน ".$credit." บาท','','','bafobet','".$member['moneybag']."','".($member['moneybag']+$credit)."')");
					$db->Execute("UPDATE member SET moneybag = moneybag+".$credit." where id= ".$member['id']." ");
				  	echo '<script> alert("ท่านได้รับโบนัส '.$credit.' บาท!"); window.location="playbet.php"; </script>';
				}else{
						echo '<script> alert("ท่านรับโบนัสไปแล้ว!"); window.location="playbet.php"; </script>';
					}
				}else if($a==3){
					echo '<script> alert("ท่านไม่ได้รับโบนัส!"); window.location="playbet.php"; </script>';
				}
        } 

        mysql_free_result($querys);
}
       

}

if($member['active']=='Y' and !empty($_GET['getpoint100'])){
/*
$sql="SELECT gametype FROM playgame WHERE memberID = '".$_SESSION[MEMBER]['DATA']['code']."' AND gametype='rank' limit 5; ";
$query=mysql_query($sql,$conn);
$bonrank = mysql_num_rows($query);

$sql2="SELECT gametype FROM playgame WHERE memberID = '".$_SESSION[MEMBER]['DATA']['code']."' AND gametype='point' limit 6; ";
$query2=mysql_query($sql2,$conn);
$bonpoint = mysql_num_rows($query2);

if($member['banknumber_conf']=='Y'){
if($member['bonus1']=='N'){
 if($bonrank>=5 and $bonpoint>=5){ 
 
 	$db->Execute("INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,status,added,added2,added3,added4,sure,toporder,q,personnel,ip,webroot,dep_bef,dep_aft) VALUES ('".$member['id']."','".$member['name']."','".$member['username']."','".$member['phone']."','coupon','CODE:FREE100CREDIT','MONEYBAG".$row['id']."','100','confirmed','".$added."','".$added."','".$added."','".$added."','1','','รางวัลบาโฟ 100 บาทครั้งเดียว','','','bafobet','".$member['moneybag']."','".($member['moneybag']+100)."')");
	$db->Execute("UPDATE member SET moneybag = moneybag+100 , bonus1='Y' where id= ".$member['id']." ");
	echo '<script> alert("ท่านได้รับโบนัส 100 บาท!"); window.location="playbet.php"; </script>';
 
 }
}else{
	echo '<script> alert("ท่านรับโบนัสไปแล้ว!"); window.location="playbet.php"; </script>';
}
}else{*/
	echo '<script> alert("กรุณาติดต่อเจ้าหน้าที่ ที่ LINE : @bafobet "); window.location="playbet.php"; </script>';
//}
 
}
 
 
if($member['active']=='Y' and !empty($_GET['freebonus'])){
		
		$datetime = date('His');
		//$timestamp = time();
		$dateminus9hr = strtotime('-12 hours', time());
		//$dateminus1 = strtotime('-1 day', $timestamp);
		//$dateminus2 = strtotime('-2 day', $timestamp);
		$timesta = time();
		$timestamp = strtotime(date('Y-m-d 00:00:00'));
		$dateminus1 = strtotime('-1 day', $datestart);
		$dateminus2 = strtotime('-1 day', $datestop);
		
		$strday = date('d',$dateminus9hr);

		
			$sqls2="
			SELECT
			matchID,getbonus,winloss
			FROM
			playgame
			WHERE 
				memberID='".$_SESSION[MEMBER]['DATA']['code']."'
			AND unix_timestamp(date_create) > '".$dateminus1."'
			AND unix_timestamp(date_create) < '".$dateminus2."'
			AND cal='1'
			AND gametype='rank'
			ORDER BY date_create DESC
				LIMIT 5
			;";
			$querys2=mysql_query($sqls2,$conn);
			$wdl='';
			$winlosss=0;
			$sumbo=0;
			while($rows2=mysql_fetch_assoc($querys2)){
			$matchid[]= $rows2['matchID'];
			$winlosss = $winlosss+$rows2['winloss'];
			$sumbo = $sumbo+$rows2['getbonus'];
			if($rows2['winloss']=='1.00'){ $wdl[]='W'; }else
			if($rows2['winloss']=='0.50'){ $wdl[]='w'; }else
			if($rows2['winloss']=='0.00'){ $wdl[]='D'; }else
			if($rows2['winloss']=='-0.50'){ $wdl[]='l'; }else
			if($rows2['winloss']=='-1.00'){ $wdl[]='L'; }
			}
			
			
		$allw = $wdl[0].$wdl[1].$wdl[2].$wdl[3].$wdl[4];
		//echo $winlosss;
		
		if(strtoupper($allw)=='WWWWW'){
		
           
				if($winlosss=='5' and $sumbo=='0'){ 
				  	for($i=0;$i<=5;$i++){
					mysql_query("UPDATE playgame SET getbonus='1' WHERE matchID='".$matchid[$i]."' AND memberID='".$_SESSION[MEMBER]['DATA']['code']."' AND gametype='rank' ",$conn);
					}
					
					if($member['mactive']=='Y'){ $bonusamount=200; }else{ $bonusamount=100; }
					
					$db->Execute("INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,status,added,added2,added3,added4,sure,toporder,q,personnel,ip,webroot,dep_bef,dep_aft) VALUES ('".$member['id']."','".$member['name']."','".$member['username']."','".$member['phone']."','coupon','CODE:WWWWW".$bonusamount."B','MONEYBAG".$row['id']."','".$bonusamount."','confirmed','".$added."','".$added."','".$added."','".$added."','1','','รางวัลบาโฟW5ตัวใหญ่ ".$bonusamount." บาท','','','bafobet','".$member['moneybag']."','".($member['moneybag']+$bonusamount)."')");
					$db->Execute("UPDATE member SET moneybag = moneybag+$bonusamount where id= ".$member['id']." "); 
				  	echo '<script> alert("ท่านได้รับโบนัส '.$bonusamount.' บาท!"); window.location="playbet.php"; </script>';
				}
				else if($sumbo=='0'){ 
				  	// Code bonus 50
					for($i=0;$i<=5;$i++){
					mysql_query("UPDATE playgame SET getbonus='1' WHERE matchID='".$matchid[$i]."' AND memberID='".$_SESSION[MEMBER]['DATA']['code']."' AND gametype='rank' ",$conn);
					}
					if($member['mactive']=='Y'){ $bonusamount=100; }else{ $bonusamount=50; }
					$db->Execute("INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,status,added,added2,added3,added4,sure,toporder,q,personnel,ip,webroot,dep_bef,dep_aft) VALUES ('".$member['id']."','".$member['name']."','".$member['username']."','".$member['phone']."','coupon','CODE:WwWwW".$bonusamount."B','MONEYBAG".$row['id']."','".$bonusamount."','confirmed','".$added."','".$added."','".$added."','".$added."','1','','รางวัลบาโฟW5ตัวผสม ".$bonusamount." บาท','','','bafobet','".$member['moneybag']."','".($member['moneybag']+$bonusamount)."')");
					$db->Execute("UPDATE member SET moneybag = moneybag+$bonusamount where id= ".$member['id']." ");
				  	echo '<script> alert("ท่านได้รับโบนัส '.$bonusamount.' บาท!"); window.location="playbet.php"; </script>';
				}
				  else{ echo '<script> alert("ท่านรับโบนัสไปแล้ว!"); window.location="playbet.php"; </script>'; } 
				  
        }else{ echo '<script> alert("ท่านไม่ได้รับโบนัส!"); window.location="playbet.php"; </script>'; }
    

}

?>
 
<script>
function include(scriptPath, callback){
	jQuery.ajax({
	    async:false, // กำหนด พารามิเตอร์ asynchronous ของฟังก์ชัน ajax ให้เป็น false
	    type:'GET', // ตั้งเมธอด เป็น GET
	    url:scriptPath, // กำหนดตำแหน่งสคริป (ทั้ง Local และ Remote)
	    data:null, // ไม่ต้องส่งข้อมูลใดๆออกไป (ไม่ต้องใส่ก็ได้)
	    success: callback, // Callback ที่จะทำงานหลังโหลดสคริปเสร็จ
	    dataType:'script', // กำหนดชนิดของข้อมูลเป็น script
	    error: function(xhr, textStatus, errorThrown) {
					// ถ้าเกิดข้อผิดพลาดขึ้น สามารถเรียกใช้งานตัวแปร textStatus เพื่อแสดงข้อความผิดพลาดได้ 
					// หรือใช้งานตัวแปร errorThrown ที่เป็นตัวแปร Callback เพื่อดักข้อผิดพลาดได้เช่นกัน
    	}
	});
}


	
	
	function onsubm(){
		
		//alert('onlick');
		$(document).ready(function(){	
		
		 var strt = $('#true_gameprovider option:selected').text();
		var str =  $( "#true_gameuser option:selected" ).val();
		var tmn =  $( "#tmn_password" ).val();
		//alert(''+tmn.length+'');
		//alert('str'+str+'');
		//alert('strt'+strt+'');
		
		if(str=='NEWUSER'){
			
			if(strt=='โปรดเลือกค่ายเกมส์'){ 
				alert('ท่านไม่ได้เลือกค่ายที่ต้องการสมัคร');
				return false
			}else{
				$("#ref2").val("NEWUSER:"+strt+"");
				
				if(tmn.length==14){  
				include('https://www.tmtopup.com/topup/3rdTopup.php?uid=<?php echo $resx['tmid']; ?>'); // Include ไฟล์ test.js ที่โฟลเดอร์ js
			$(".btn-submit").text("กรุณารอซักครู่.....");
			setTimeout( "submit_tmnc()", 4000);
				return false
				 }else{ alert('กรุณาระบุทรูมันนี่ให้ครบ 14 หลัก'); return false }
			}
			return false
		}else{
			
			if(str==''){
				alert('ท่านไม่ได้เลือกบัญชีเกมส์ที่ต้องการ');
				return false 
			}else {
				
				
				if(tmn.length==14){  
				include('https://www.tmtopup.com/topup/3rdTopup.php?uid=<?php echo $resx['tmid']; ?>'); // Include ไฟล์ test.js ที่โฟลเดอร์ js
			$(".btn-submit").text("กรุณารอซักครู่.....");
			setTimeout( "submit_tmnc()", 4000);
			
			return false
			 }else{ alert('กรุณาระบุทรูมันนี่ให้ครบ 14 หลัก'); return false }
			}
			return false
		}
	});
	}
	
	function onsubmw88(){
		
		//alert('onlick');
		$(document).ready(function(){	
		
		var str =  $( "#w88true_gameuser option:selected" ).text();
		var tmn =  $( "#tmn_password" ).val();
		//alert(''+tmn.length+'');
		//alert('str'+str+'');
		//alert('strt'+strt+'');
		
		if(str=='เลือกบัญชี'){
			alert('ท่านไม่ได้เลือกบัญชี W88');
			return false
		}else{
			if(tmn.length==14){ 
			
			
			include('https://www.tmtopup.com/topup/3rdTopup.php?uid=<?php echo $resx['tmid']; ?>'); // Include ไฟล์ test.js ที่โฟลเดอร์ js
			$(".btn-submit").text("กรุณารอซักครู่.....");
			setTimeout( "submit_tmnc()", 4000);
			
			return false
			
			 }else{  alert('กรุณาระบุทรูมันนี่ให้ครบ 14 หลัก'); return false }
		}
		
		
	});
	}
	
	
	
	

</script>

  
<script type="text/javascript">

    $(document).ready(function() {
        document.title = '<?php if($member['active']==''){ echo "ลงทะเบียนฝากเงิน"; }else{ echo "(".$member['id'].") ".strtoupper($member['name']); } ?> - <?php echo $config['titles'];?>';
    });
	
	
	function newusergames(pv){
	$('#myModalBet').modal('show');
	$('#myModalBetContent').html('<hr><br><br><center><img agiln="center" src="images/loading2.gif" width="100" /></center>');
	var url="playbet_newgameid.php";
		var dataSet={ act:true,prov:pv };
		$.post(url,dataSet,function(data){
		
			if(data.status == '0'){
			}else if(data.status == '1'){
				$('#myModalBetContent').html(data.html);
			}
 		 }, "json");
	}
	
		function deptm(){
	$('#myModalBet').modal('show');
	$('#myModalBetContent').html('<hr><br><br><center><img agiln="center" src="images/loading2.gif" width="100" /></center>');
	$('#myModalBetContent').html('<iframe frameborder="0" style="width:100%; border-width:0;" height="450" src="playbet_tm.php"></iframe>');
	/*var url="playbet_tm.php";
		var dataSet={ act:true };
		$.post(url,dataSet,function(data){
		
			if(data.status == '0'){
			}else if(data.status == '1'){
				$('#myModalBetContent').html(data.html);
			}
 		 }, "json");*/
	}

	function depbank(){
	$('#myModalBet').modal('show');
	$('#myModalBetContent').html('<hr><br><br><center><img agiln="center" src="images/loading2.gif" width="100" /></center>');
	//$('#myModalBetContent').html('<iframe frameborder="0" style="width:100%; border-width:0;" height="450" src="playbet_bank.php?prov='+pv+'"></iframe>');
	//$('#myModalBetContent').load( "playbet_bank.php?prov="+pv+"" );
	var url="playbet_bank.php";
		var dataSet={ act:true };
		$.post(url,dataSet,function(data){
		
			if(data.status == '0'){
			}else if(data.status == '1'){
				$('#myModalBetContent').html(data.html);
			}
 		 }, "json");
	}

	function tranmoney(pv){
	$('#myModalBet').modal('show');
$('#myModalBetContent').html('<hr><br><br><center><img agiln="center" src="images/loading2.gif" width="100" /></center>');
//alert('5123');
	var url="playbet_tran.php";
		var dataSet={ act:true,prov:pv };
		$.post(url,dataSet,function(data){
		//alert(data.html);
			if(data.status == '0'){
			}else if(data.status == '1'){
				$('#myModalBetContent').html(data.html);
			}
 		 }, "json");
	}

	function wimoney(pv){
	$('#myModalBet').modal('show');
	$('#myModalBetContent').html('<hr><br><br><center><img agiln="center" src="images/loading2.gif" width="100" /></center>');
	var url="playbet_wi.php";
		var dataSet={ act:true,prov:pv };
		$.post(url,dataSet,function(data){
		
			if(data.status == '0'){
			}else if(data.status == '1'){
				$('#myModalBetContent').html(data.html);
			}
 		 }, "json");
	}


</script>


<style type="text/css">
<!--
html { color:#FFFFFF; }
body { color:#FFFFFF; }
.modal-content {
	background-color:#333333;
	}
	
	.clearfix {
  overflow: auto;
}
.tablew {
background-color:#FFFFFF;
color:#000000;
}
.tablew td {
color:#000000;
}
.tablew th {
color:#000000;
}

.menuss{
    list-style-type: none;
    margin: 0;
    padding: 0 0 0 15px;
    overflow: hidden;
    background-color: #333;
	background-image:url(images/menu_bg.png);
	-webkit-border-radius:5px;
    -moz-border-radius:5px;
    border-radius:5px;
	
}

.menuss li{
    float: left;
	border-right-color:#666666;
	border-right-style:solid;
	border-right-width:1px;
	color:#333333;
}

.menuss li a{
    display: block;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
	color:#000000;
}

.menuss li a:hover:not(.active){
    background-color: #444;
	color:#FFFFFF;
}

.menuss .active{
    background-color: #222;
	color:#FFFFFF;
}

.menuss .active a{
	color:#FFFFFF;
}

.colow { color:#FFFFFF; }
-->

.buttonbet-pv{
background-image:url(images/betselect.png); width:200px; height:60px;  text-align:center;
margin:5px 0; float:left;

}
.buttonbet{
background-image:url(images/betselect.png); width:600px; height:60px;  text-align:center;
margin:5px 0; float:left;

}

.gtb{
background-image:url(images/gt.png); background-position:center; background-repeat:no-repeat; width:50px; height:60px; margin:auto 0;
margin:5px 0 0 0; float:left;

}

.dep-button{
height:57px; font-size:16px; background-image:url(images/menu_bg.png); background-position:top; border-color:#C49402;
color:#993300;
}

.dep-button:hover{
 background-position:bottom;
 border-color:#C49402;
color:#993300;
}

.dep-button a{
color:#993300;
}

.dep-button a:hover{
color:#993300;
}

.dep-button a:visited {
	text-decoration: none;
	color: #993300;
}

.dep-button a:active {
	text-decoration: none;
}
</style>
<div style="width:1000px; margin:auto;  overflow:hidden; background:url(bg-body.png);">

<?php

//echo '<pre>';print_r($_SESSION);echo '</pre>';


if($member['active']=='Y'){
?><div class="panel-group">
<div class="panel panel-danger" >
      <div class="panel-heading"><h3>***ข้อมูลสำคัญ*** เงื่อนไขในการให้บริการของเว็บไซต์</h3></div>
      <div class="panel-body" style="background-color:#333333;">
	  	<p>
			1. การฝากเงิน   <br />
			- ต้องฝากมาจากบัญชีของตัวเองเท่านั้น (บัญชีที่ชื่อเดียวกันกับที่ลงทะเบียนไว้) ห้ามทิ้งสลิปจนกว่าเงินจะเข้าไอดี  <br />
			- การฝากเงินจากตู้เงินสด จะต้องเก็บสลิปตัวจริง เพื่อส่งหลักฐานการโอนเงิน ห้ามทิ้งสลิปจนกว่ายอดเงินจะเข้าไอดี  <br />
			- หากตรวจสอบว่าเงินที่โอนมามีความผิดปกติ ทางเราขออนุญาตยึดเงินไว้สำหรับตรวจสอบ 5-7 วันทำการ (ซึ่งอาจจะโอนกลับไปยังบัญชีต้นทางที่โอนมา หรือ ถูกยึด)    <br />
			<br />
			2. ยอดเทิร์น (ยอดเล่น) ต้องมากกว่า 1 เท่า ของยอดฝาก (สำหรับการฝากปกติ แบบไม่ได้รับโบนัสพิเศษใดๆ)    <br />
			<br />
			3. การนับยอดเทิร์น       <br />
			-บิลที่ ราคาต่ำกว่า 0.5  จะไม่นับเป็นยอดเทิร์น       <br />
			-บิลที่เสมอ คืนเงิน ไม่มีการได้เสีย จะไม่นับเป็นยอดเทิร์น    <br />
			<br />
			4. ถอนเงินขั้นต่ำ 500 บาท  เทิร์น 1 เท่า สำหรับยอดฝากปกติ โดยโอนเข้าบัญชีธนาคาร ไม่หักค่าธรรมเนียม หรือ ค่าบริการใดๆ ได้ยอดเงินเต็ม 100%    <br />
			<br />
			5. หากตรวจสอบว่ามีการเล่นที่ไม่ปกติ มีการปั่นเพื่อเอาโบนัส เงินทั้งหมดจะถูกยึด    <br />
			<br />
			6. ชื่อเข้าใช้งาน และ รหัสผ่านต่างๆ กรุณาเก็บเป็นความลับ   ทางเวปไม่มีนโยบายขอรหัสผ่าน หรือ แจ้งให้โอนเงินให้ทางโทรศัพท์ โปรดระวังมิจฉาชีพ    <br />
			<br />
			7. การตัดสินใจของเว็ป ถือเป็นที่สิ้นสุด
		</p>
	  </div>
    </div>
  </div>
<div style="width:700px; float:left;">
  <div class="panel-group">
      <div class="panel" style="background-image:url(images/menu_bg.png);">
      		<div class="panel-heading text-center" style="font-size:24px; font-weight:bold; color:#663300;">ถุงเงินฝาก</div>
      		<div class="panel-body text-center" style="background-color:#000000;"><h3><?php echo number_format($member['moneybag']); ?> บาท</h3></div>
      </div>
  </div>
  <div class="clearfix"></div>
  </div>
  <div style="width:290px; float:right;">
  	<button type="button" <?php if($webclose=='Y'){ echo ' disabled="disabled" '; } ?> style="margin:0px auto 5px auto;" class="btn btn-warning btn-block dep-button" onclick="deptm()"><span class="glyphicon glyphicon-plus-sign"></span> ฝากบัตรเงินสดเข้าถุงเงิน</button>
  	<br />
    <button type="button" <?php if($webclose=='Y'){ echo ' disabled="disabled" '; } ?> class="btn btn-warning btn-block dep-button" onclick="depbank()"><span class="glyphicon glyphicon-plus-sign"></span>  ฝากเงินธนาคารเข้าถุงเงิน</button>
  </div>
  
  
  </div>
  
  
  
  <div style="width:1000px; margin:auto;  overflow:hidden; background:url(bg-body.png); min-height:500px;">
  	 <?php if($member['suped']=='sup'){ ?>
        
        <div class="alert alert-danger">
  <strong>แจ้งเตือน!</strong> ขณะนี้ท่านถูกระงับการทำรายการ กรุณาติดต่อแชท
</div>
		 <?php } 
		 
		 $dcb = '';
		 $dca = '';
		 $ck1 = $db->GetAll("select member.id,member.mactive,gameusers.* from member left join gameusers on gameusers.owner=member.id where member.id = '".$member['id']."'  and member.webroot='bafobet' AND member.mactive='N' ");
		 
		 //echo '<pre>';print_r($_SESSION);echo '</pre>';
		 
		 if($ck1[0]['gameuser']!='' and $ck1[0]['mactive']=='N'){
		 $dcb = ' disabled="disabled" ';
		 
		 }else if($ck1[0]['mactive']=='N'){
		 
		 $dca = ' disabled="disabled" ';
		 }
		 
		 
		 ?>
 
 
<div class="panel" style="background-image:url(images/menu_bg.png);">
    <div class="panel-heading text-center" style="font-size:24px; font-weight:bold; color:#663300;">คาสิโน ออนไลน์</div>
    <div class="panel-body text-center" style="background-color:#000000;">
<table width="850" border="0" align="center" style="margin-bottom:15px;">
  <tr>
    <td height="70" align="center">
    	<div class="buttonbet-pv">
        	<img src="images/logogclub.png" width="160" />
            
        </div>
    </td>
    <td><div class="gtb"></div>
    	<div class="buttonbet">
        <?php
		$checkgame = $db->GetRow("select gameuser from gameusers where owner = '".$member['id']."' AND provider='GCLUB' ");
		?>
        <a href="http://98f.gclub168.com/" target="_blank" style="margin:14px 20px 0px auto; color:#FFFFFF;" class="btn btn-success">ทางเข้าเล่น</a>
        <button <?php if($checkgame['gameuser']!='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-primary" onclick="newusergames('GCLUB')" <?php echo $dcb;?>>เปิดไอดีเกมส์</button>
        <button <?php if($checkgame['gameuser']=='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-info" onclick="tranmoney('GCLUB')" <?php echo $dca;?>>โยกย้ายเงิน</button>
        <button <?php if($checkgame['gameuser']=='' or $webclosewi=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-danger" onclick="wimoney('GCLUB')" <?php echo $dca;?>>ถอนเงิน</button></div></td>
  </tr>
  </table>
  </div>
  </div>
  
  <div class="panel" style="background-image:url(images/menu_bg.png);">
    <div class="panel-heading text-center" style="font-size:24px; font-weight:bold; color:#663300;">กีฬา ออนไลน์</div>
    <div class="panel-body text-center" style="background-color:#000000;">
  <table width="850" border="0" align="center" style="margin-bottom:15px;">
  <tr>
    <td height="70" width="200" align="center">
    	<div class="buttonbet-pv">
        	<img src="images/logovegus.png" width="160" />
        </div>
    </td>
    <td><div class="gtb"></div>
    	<div class="buttonbet">
        <?php
		$checkgame = $db->GetRow("select gameuser from gameusers where owner = '".$member['id']."' AND provider='Vegus168' ");
		?>
        <a href="http://www.vegus88.com/" target="_blank" style="margin:14px 20px 0px auto; color:#FFFFFF;" class="btn btn-success">ทางเข้าเล่น</a>
        <button <?php if($checkgame['gameuser']!='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?> type="button" style="margin:14px 20px 0px auto;" class="btn btn-primary" onclick="newusergames('Vegus168')" <?php echo $dcb;?>>เปิดไอดีเกมส์</button>
        <button <?php if($checkgame['gameuser']=='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?> type="button" style="margin:14px 20px 0px auto;" class="btn btn-info" onclick="tranmoney('Vegus168')" <?php echo $dca;?>>โยกย้ายเงิน</button>
        <button <?php if($checkgame['gameuser']=='' or $webclosewi=='Y'){ echo ' disabled="disabled" '; } ?> type="button" style="margin:14px 20px 0px auto;" class="btn btn-danger" onclick="wimoney('Vegus168')" <?php echo $dca;?>>ถอนเงิน</button></div></td>
  </tr>
  <tr>
    <td height="70" align="center">
    	<div class="buttonbet-pv">
        	<img src="images/logosbobet.png" width="160"  />
        </div>
    </td>
  <td><div class="gtb"></div>
    	<div class="buttonbet">
        <?php
		$checkgame = $db->GetRow("select gameuser from gameusers where owner = '".$member['id']."' AND provider='SBOBET' ");
		?>
        <a href="http://www.pic5678.com/th-th/betting.aspx" target="_blank" style="margin:14px 20px 0px auto; color:#FFFFFF;" class="btn btn-success">ทางเข้าเล่น</a>
        <button <?php if($member['mactive']!='Y' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-primary" onclick="newusergames('SBOBET')" <?php echo $dcb;?>>เปิดไอดีเกมส์</button>
        <button <?php if($checkgame['gameuser']=='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-info" onclick="tranmoney('SBOBET')" <?php echo $dca;?>>โยกย้ายเงิน</button>
        <button <?php if($checkgame['gameuser']=='' or $webclosewi=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-danger" onclick="wimoney('SBOBET')" <?php echo $dca;?>>ถอนเงิน</button></div></td>
  </tr>
  <tr>
    <td height="70" width="200" align="center">
    	<div class="buttonbet-pv">
        	<img src="images/logofifa55.png" width="160" />
        </div>
    </td>
    <td><div class="gtb"></div>
    	<div class="buttonbet">
        <?php
		$checkgame = $db->GetRow("select gameuser from gameusers where owner = '".$member['id']."' AND provider='FIFA55' ");
		?>
        <a href="http://www.fifa1234.com" target="_blank" style="margin:14px 20px 0px auto; color:#FFFFFF;" class="btn btn-success">ทางเข้าเล่น</a>
        <button <?php if($checkgame['gameuser']!='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-primary" onclick="newusergames('FIFA55')" <?php echo $dcb;?>>เปิดไอดีเกมส์</button>
        <button <?php if($checkgame['gameuser']=='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-info" onclick="tranmoney('FIFA55')" <?php echo $dca;?>>โยกย้ายเงิน</button>
        <button <?php if($checkgame['gameuser']=='' or $webclosewi=='Y'){ echo ' disabled="disabled" '; } ?>  type="button" style="margin:14px 20px 0px auto;" class="btn btn-danger" onclick="wimoney('FIFA55')" <?php echo $dca;?>>ถอนเงิน</button></div></td>
  </tr>
  <tr>
    <td height="70" width="200" align="center">
    	<div class="buttonbet-pv">
        	<img src="images/logotbsbet.png" width="160" />
        </div>
    </td>
    <td><div class="gtb"></div>
    	<div class="buttonbet">
        <?php
		$checkgame = $db->GetRow("select gameuser from gameusers where owner = '".$member['id']."' AND provider='TBSBET' ");
		?>
        <a href="http://www.tbsbet8.com" target="_blank" style="margin:14px 20px 0px auto; color:#FFFFFF;" class="btn btn-success">ทางเข้าเล่น</a>
        <button<?php if($checkgame['gameuser']!='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?> type="button" style="margin:14px 20px 0px auto;" class="btn btn-primary" onclick="newusergames('TBSBET')" <?php echo $dcb;?>>เปิดไอดีเกมส์</button>
        <button<?php if($checkgame['gameuser']=='' or $webclose=='Y'){ echo ' disabled="disabled" '; } ?> type="button" style="margin:14px 20px 0px auto;" class="btn btn-info" onclick="tranmoney('TBSBET')" <?php echo $dca;?>>โยกย้ายเงิน</button>
        <button<?php if($checkgame['gameuser']=='' or $webclosewi=='Y'){ echo ' disabled="disabled" '; } ?> type="button" style="margin:14px 20px 0px auto;" class="btn btn-danger" onclick="wimoney('TBSBET')" <?php echo $dca;?>>ถอนเงิน</button></div></td>
  </tr>
</table>
</div>
</div>





<!-- Modal -->
<div id="myModalBet" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content" style="background-color:#222222; color:#FFFFFF; padding:0;">
      <div class="modal-header" style="border-width:0;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div id="myModalBetContent" class="modal-body" style="overflow:visible;" >      </div>
    </div>
  </div>
</div>


<hr />


  
    
   
    <div style="width:1000px; overflow:hidden; padding:5px 10px;">
      
        <!-- Modal -->
<div id="f_loading_new" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <p id="loading_msg_new" style="color:#fff;"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>




			
			
	

			<div class="clearfix"></div>
				
				
				<?php if($_GET['route']==''){ ?>
				
				<h3>ประวัติทำรายการ</h3>
                                <table class="table table-bordered table-hover tablew" align="center">
                                     <tbody >
                                            <tr style="color:#000;">
                                                <td width="20%" class="active"><label>เวลา</label></td>
												<td width="10%" class="active"><label>รายการ</label></td>
                                                <td width="10%" class="active"><label>จาก</label></td>
                                                <td width="10%" class="active"><label>เข้า</label></td>
                                                <td width="15%" class="active"><label>จำนวน</label></td>
												<td width="5%"class="active"><label>สถานะ</label></td>
												<td width="15%" class="active"><label>หมายเหตุ</label></td>
                                            </tr>
                                    </tbody>
                                    <tbody >
									<?php
									$tim = strtotime('-1 day', time());
										$res=$db->GetAll("select * from paylogs where owner = '".$member['id']."' and types != 'change'and types != 'repass' and added > '".$tim."' order by added desc limit 10");
										if($res){
											foreach($res as $x){
											$q = '';
												if($x['types'] == 'deposit'){
													$type = 'ฝาก';
													$color = 'success';
													$q = $x['q'];
												}elseif($x['types'] == 'coupon'){
													$type = 'คูปอง';
													$color = 'warning';
													$q = $x['q'];
												}elseif($x['types'] == 'withdrawal'){
													$type = 'ถอน';
													$color = 'danger';
												}elseif($x['types'] == 'transfer'){
													$type = 'โยก';
													$color = 'info';
												}										
												if($x['status'] == 'pending'){ $staticon = 'icon-status-doing.gif'; }elseif($x['status'] == 'confirmed'){ $staticon = 'icon-status-true.png'; }elseif($x['status'] == 'cancle'){ $staticon = 'icon-status-false.png'; }
												echo '
													<tr>
														<td >'.date("d-m-Y H:i",$x['added']).'</td>
														<td ><span class="text-'.$color.'">'.$type.'</span></td>
														<td ><span class="label label-default">'.strtoupper($x['froms']).'</span></td>
														<td ><span class="label label-default">'.strtoupper($x['tos']).'</span></td>
														<td ><span class="label label-'.$color.'">'.number_format($x['amount']).'</span></td>
														<td ><img src="images/'.$staticon.'"  align="center" alt="" class="" width="20"></td>
														<td>'.$q.'</td>
													</tr>
												';
											}
										}
									?>
                                    </tbody>																					
                                </table>								
								
			
			
			
			
			
		
		<?php } ?>
		
    </div>
    

     
<?php }else{ ?>
   <script>
   function sendregister(){

	if($("#passworda").val() != $("#conpassword").val()){
		alert("รหัสผ่านไม่ตรงกัน");
		document.frmRegister.cpassword.focus();
		return false;
	}	
	
		var url="action.php";
		var dataSet={ openaccount: true,
			name: $("#name").val(),
			phone: $("#phone").val(),
			lineid: $("#lineid").val(),
			username: $("#username_a").val(),
			password : $("#conpassword").val(),
			recom: $("#recom").val(),
			bankname: $("#bankname option:selected").val(),
			banknumber: $("#banknumber").val()};
		$.post(url,dataSet,function(data){
			if(data.status == '0'){
				alert(data.msg);
			}else if(data.status == '1'){
				alert(data.msg);
				if($("#getpoint").val()==''){
				
				window.location='playbet.php?token='+data.token+'&session='+data.session+''
				}else{
				location.reload();
				}
			}
 		 }, "json");
	}
    </script>
    
   <div class="row" style="width:1000px; margin:0 auto;">
			<h2 style="padding:10px 0 0 10px;" class="colow"><?php if($_SESSION[MEMBER]['LOGIN'] != 'ON'){ echo 'สมัครสมาชิก'; }else{ echo 'อัพเดทข้อมูล'; } ?></h2><hr>
			<p class="colow"><h3 class="colow">หมายเหตุ</h3><br>
            <span class="colow">1. สมาชิกไม่สามารถเปลี่ยนแปลง ชื่อบัญชีผู้ถอนเงินได้ทุกกรณี<br>
            2. ชื่อนามสกุล กับชื่อบัญชี ต้องเป็นชื่อเดียวกัน<br>
            3. ถ้าโอนเงินมาจาก บัญชี ผู้อื่น หรือ ไม่สามารถส่งหลักฐานได้ ทางทีมงาน ขอปฏิเสธการเติมเงิน เผื่อตรวจสอบ และอาจจะใช้เวลา ไม่เกิน 7 วัน ในการโอนเงินคืนบัญชีต้นทาง<br></span>
            </p>
		<hr>
	<form class="form-horizontal"  action="" method="POST">

<div class="panel-group">
    <div class="panel"  style="background-image:url(images/menu_bg.png); color:#000000;">
      <div class="panel-heading">ข้อมูลเข้าสู่ระบบ</div>
      <div class="panel-body" style="background-color:#000000;">
	  
	  <div class="form-group">

						<label class="col-md-3 control-label colow" for="username">บัญชีเข้าใช้งาน</label>

						<div class="col-md-4"><input type="text" id="username_a" name="username"  class="form-control input-sm" value="<?php echo $memberdata['username']; ?>"></div>
                        <?php if($_SESSION[MEMBER]['LOGIN'] == 'ON'){ ?><div class="col-md-4" style="color:#FF0000;">****หาก Username ของท่านห้ามใช้ให้เปลี่ยนที่นี่ได้เลย</div>
                        <? } ?>

		  </div>	

					  

<?php if($_SESSION[MEMBER]['LOGIN'] != 'ON'){ ?>

					 <div class="form-group">

						<label class="col-md-3 control-label colow" for="password">รหัสผ่าน</label>

						<div class="col-md-4"><input type="password" id="passworda" name="passworda" value="" class="form-control input-sm" placeholder="ระบุรหัสผ่าน"></div>

		  </div>	
					  
					  
					  <div class="form-group">

						<label class="col-md-3 control-label colow" for="password">รหัสผ่านอีกครั้ง</label>

						<div class="col-md-4"><input type="password" id="conpassword" name="conpassword" value="" class="form-control input-sm" placeholder="ระบุรหัสผ่าน"></div>

					  </div>
					  
					<?php } ?>  
					  <div class="form-group" style="margin-top:10px;">

						<label class="col-md-3 control-label colow" for="name">โทร</label>
						<div class="col-md-4"><input type="text" id="phone" name="phone" class="form-control input-sm" value="<?php echo $memberdata['tel']; ?>"></div>

					  </div>	



					  <div class="form-group">

						<label class="col-md-3 control-label colow" for="username">LINE ID</label>

						<div class="col-md-4"><input type="text" id="lineid" name="lineid" class="form-control input-sm" ></div>

					  </div>
	  
	  </div>
    </div>
					  
					  
					  
					  
					  
					  <div class="panel" style="background-image:url(images/menu_bg.png);  color:#000000;">
      <div class="panel-heading">ข้อมูลสำคัญ (แก้ไขภายหลังไม่ได้)</div>
      <div class="panel-body" style="background-color:#000000;">
	  
	  <div class="form-group" style="margin-top:10px;">

						<label class="col-md-3 control-label colow" for="name">ชื่อ - นามสกุล</label>

						<div class="col-md-4"><input type="text" id="name" name="name" class="form-control input-sm"  value="<?php echo $memberdata['firstname']; ?> <?php echo $memberdata['lastname']; ?>"></div>
						<div class="col-md-4" style="color:#FF0000;">***ข้อมูลนี้ ไม่สามารถแก้ไขได้ภายหลัง ชื่อบัญชี กับ เลขบัญชี ไม่ตรงกัน ไม่สามารถ ถอนเงินได้ทุกกรณี</div>

		  </div>	
					  



					  <div class="form-group">

						<label class="col-sm-3 control-label colow" for="bankname">ธนาคารลูกค้า</label>

						<div class="col-sm-4">

                                        <select id="bankname" name="bankname" class="form-control input-sm">

                                            <option value="">โปรดเลือก ธนาคาร</option>

											<option value="กสิกรไทย">ธนาคาร กสิกรไทย</option>

											<option value="ไทยพาณิชย์">ธนาคาร ไทยพาณิชย์</option>

											<option value="กรุงไทย">ธนาคาร กรุงไทย</option>

                                            <option value="กรุงเทพ">ธนาคาร กรุงเทพ</option>

                                            <option value="กรุงศรีอยุธยา">ธนาคาร กรุงศรีอยุธยา</option>

                                            <option value="ธนชาต">ธนาคาร ธนชาต</option>

                                            <option value="ทหารไทย">ธนาคาร ทหารไทย</option>

                                            <option value="ซีไอเอ็มบีไทย">ธนาคาร ซีไอเอ็มบีไทย</option>

                                            <option value="ออมสิน">ธนาคาร ออมสิน</option>

                                            <option value="LHBANK">ธนาคาร LH Bank</option>

											<option value="ยูโอบี">ธนาคาร ยูโอบี</option>
                                        </select>
						</div>
						
						<div class="col-sm-4">
						<input type="text" id="banknumber" name="banknumber" value="" maxlength="12" class="form-control input-small" data-toggle="tooltip" title="ระบุเลขบัญชีเป็นตัวเลขเท่านั้น ใช้สำหรับรับเงิน" placeholder="เลขบัญชีธนาคาร">
						</div>

					  </div>
	  
	  </div>
    </div>
					  
					  
					  
					  
					  	



<input name="recom" id="recom" type="hidden" value="<?php echo $decode;?>">
<input name="getpoint" id="getpoint" type="hidden" value="<?php echo $_GET['getpoint'];?>">
 
 <div class="panel panel-success">
      <div class="panel-body" style="background-color:#000000;">
			<button type="button" onclick="sendregister()" class="center-block btn btn-primary"><?php if($_SESSION[MEMBER]['LOGIN'] != 'ON'){ echo 'สมัครสมาชิก'; }else{ echo 'อัพเดทข้อมูล'; } ?></button>
      </div>
 </div>
					  

            </form>
			<div class="clearfix"></div>
					</div>     
        
<?php } ?>
		
	
    </div>
<div class="clearfix"></div>


	<script src="js/member.js"></script>
													<script>
														$('#dep_time').val('<?=date("d", time())?>');
														$('#dep_time1').val('<?=date("m", time())?>');	
														$('#dep_time2').val(<?= (543 + date("Y", time()))?>);	
													</script>
	<script>
	
	
	$('#tmn_password').keypress(function (e) {
  if (e.which == 13) {
    onsubm();
    return false;    //<---- Add this line
  }
});

	$(document).ready(function(){
		  $('img#tooltip').tooltip('hide');
		  $('a#tooltip').tooltip('hide');
		  $("#c_loading").click(function(){
			$("#f_loading").hide(0);
		  });
		  var column_height = $(document).height();
		  var column_width = $(window).width();
		  $("#f_loading").css("height",column_height+"px");
		  $("#loading_box").css("left",((column_width - 750) / 2)+"px");
		  var top = $('body').offset().top - parseFloat($('body').css('margin-top').replace(/auto/, 0));
		  $(window).scroll(function (event) {
			var y = $(this).scrollTop();
			if (y >= top) {
			$('#loading_box').css('margin-top',(y - ($(window).height() / 2)));
			}
	  });
	});
	</script>

    <?php include('footer.inc.php');?>
  
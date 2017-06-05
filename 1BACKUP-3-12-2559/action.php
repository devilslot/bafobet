<?php
session_start();
include("service/service.php");
include("creation/creation.init.php");
//include("core/core.php");
set_time_limit(0);
$status=array();
$db=Live::core("db");
//$ip=$_SERVER['REMOTE_ADDR'];
if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){
//$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
}else{
//$ip=$_SERVER['REMOTE_ADDR'];
}

$webroot='bafobet';

$member=Live::member();

if(isset($_POST['cheackWd'])){
	$member=Live::member();
	if(!$member){
		$status['status'] = "0";
		$status['msg'] = "หมดเวลาในระบบ กรุณาล๊อคอินใหม่อีกครั้ง";
		echo json_encode($status);
		exit();
	}
	
	if($member['suped'] == 'sup'){
		$status['status'] = "0";
		$status['msg'] = "การทำรายการถูกระงับ ไม่สามารถทำรายการได้ โปรดติดต่อสอบถามพนักงาน ตามช่องทางที่สะดวก";
		echo json_encode($status);
		exit();
	}	
	
	$owner = $member['id'];
	$id = 0 + trim($_POST['rowid']);
	$row = $db->GetRow("select * from paylogs where owner = '$owner' and id = '$id'");
	if($row['status'] == 'pending'){
		$status['status'] = "0";
		echo json_encode($status);
		exit();
	}elseif($row['status'] == 'confirmed'){
		$status['status'] = "1";
		echo json_encode($status);
		exit();
	}elseif($row['status'] == 'cancle'){
		$status['status'] = "2";
		echo json_encode($status);
		exit();
	}
}

if(isset($_POST['sendWD'])){
	$member=Live::member();
	if(!$member){
		$status['status'] = "0";
		$status['msg'] = "หมดเวลาในระบบ กรุณาล๊อคอินใหม่อีกครั้ง";
		echo json_encode($status);
		exit();
	}
	
	if($member['suped'] == 'sup'){
		$status['status'] = "0";
		$status['msg'] = "การทำรายการถูกระงับ ไม่สามารถทำรายการได้ โปรดติดต่อสอบถามพนักงาน ตามช่องทางที่สะดวก";
		echo json_encode($status);
		exit();
	}
	$tranfers = trim($_POST['tranfers']);
	$owner = $member['id'];
	$name = $member['name'];
	$username = $_POST['gameuser'];
	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$bank = $member['bankname'];
	$banknumber = $member['banknumber'];
	$phone = $member['phone'];
	$added = time();
	
	if(trim($_POST['gameuser']) == ''){
		$status['status'] = "0";
		$status['msg'] = "โปรดเลือก บัญชีเกมส์หรือถุงเงิน";
		echo json_encode($status);
		exit();
	}	
	
	
	if(trim($tranfers) == $username){
		$status['status'] = "0";
		$status['msg'] = "เลือกบัญชีเกมส์ซ้ำกันเหมือนกัน";
		echo json_encode($status);
		exit();
	}	

	if($tranfers == ''){
	
	if($username=='moneybag'){
			$status['status'] = "0";
			$status['msg'] = "ไม่สามารถถอนเข้าธนาคารได้";
			echo json_encode($status);
			exit();
		}	
		
		
		$time = 0 + date("H",$added);
		if($time >= '22'){
			$status['status'] = "0";
			$status['msg'] = "ขออภัยช่วงเวลา 22.00 - 08.00 ไม่สามารถทำรายการถอนได้ค่ะ";
			echo json_encode($status);
			exit();
		}
		if($time <= '7'){
			$status['status'] = "0";
			$status['msg'] = "ขออภัยช่วงเวลา 22.00 - 08.00 ไม่สามารถทำรายการถอนได้ค่ะ";
			echo json_encode($status);
			exit();
		}
		
		$date = strtotime(date("d-m-Y",time()).' 00:00');
		$cklm = $db->GetAll("select * from paylogs where added >= '$date' and status = 'confirmed' and types = 'withdrawal' and owner = '$owner'");
            if((count($cklm) >= 2)and(($owner!='434')or($owner!='115')or($owner!='114'))){
			if($owner!='203'){
				$status['status'] = "0";
				$status['msg'] = "คุณสามารถทำรายการถอนได้เพียงวันล่ะ 2 ครั้งเท่านั้น ";
				echo json_encode($status);
				exit();
				}
            }

		$ckp = $db->GetOne("select * from paylogs where owner = '$owner' and status = 'pending'");
		if($ckp[0]){
			$status['status'] = "0";
			$status['msg'] = "โปรดรอสักครู่ ขณะนี้คุณมีรายการค้าง รอประมวลผลอยู่ สามารถรีเฟรชเพื่อดูสถานะรายการได้ค่ะ";
			echo json_encode($status);
			exit();
		}
		
		/*if($phone != $member['phone']){
			$status['status'] = "0";
			$status['msg'] = "เบอร์โทรที่ระบุไม่ถูกต้องกรุณาตรวจสอขอีกครั้ง";
			echo json_encode($status);
			exit();
		}*/

		if(!preg_match('/^[0-9]+$/', $amount)){
			$status['status'] = "0";
			$status['msg'] = "โปรดระบุเฉพาะตัวเลขเท่านั้น";
			echo json_encode($status);
			exit();
		}

		if($amount == 0){
			$status['status'] = "0";
			$status['msg'] = "โปรดระบุยอดเงินที่ต้องการ";
			echo json_encode($status);
			exit();
		}

		if($amount < 500){
			$status['status'] = "0";
			$status['msg'] = "ถอนขั้นต่ำ 500 บาทค่ะ";
			echo json_encode($status);
			exit();
		}

		if($banknumber == '0'){
			$status['status'] = "0";
			$status['msg'] = "โปรดระบุเลขบัญชีธนาคารที่ทำการโอนเงินเข้า";
			echo json_encode($status);
			exit();
		}
		
		


		$rowid = $db->Execute("INSERT INTO paylogs (owner,name,username,phone,types,froms,tos,amount,added,ip,webroot) VALUES ('$owner','$name','".$member['username']."','$phone','withdrawal','$username','$bank:$banknumber','$amount','$added','$ip','$webroot')");
		if($rowid){
			$status['status'] = "1";
			$status['rid'] = $rowid;
			$status['msg'] = "รายการถอนเงินได้รับการบันทึกเรียบร้อย";
			echo json_encode($status);
			exit();
		}
	}else{
		
		$ckp = $db->GetOne("select * from paylogs where owner = '$owner' and status = 'pending'");
		if($ckp[0]){
			$status['status'] = "0";
			$status['msg'] = "โปรดรอสักครู่ ขณะนี้คุณมีรายการค้าง รอประมวลผลอยู่ สามารถรีเฟรชเพื่อดูสถานะรายการได้ค่ะ";
			echo json_encode($status);
			exit();
		}
		
		if($username == $tranfers){
			$status['status'] = "0";
			$status['msg'] = "ท่านเลือกปลายทางผิด กรุณาเลือกใหม่ค่ะ";
			echo json_encode($status);
			exit();
		}
		
		/*if($phone != $member['phone']){
			$status['status'] = "0";
			$status['msg'] = "เบอร์โทรที่ระบุไม่ถูกต้องกรุณาตรวจสอขอีกครั้ง";
			echo json_encode($status);
			exit();
		}*/

		if(!preg_match('/^[0-9]+$/', $amount)){
			$status['status'] = "0";
			$status['msg'] = "โปรดระบุเฉพาะตัวเลขเท่านั้น";
			echo json_encode($status);
			exit();
		}

		if($amount == 0){
			$status['status'] = "0";
			$status['msg'] = "โปรดระบุยอดเงินที่ต้องการ";
			echo json_encode($status);
			exit();
		}

		if($amount < 5){
			$status['status'] = "0";
			$status['msg'] = "โยกเงินขั้นต่ำ 5 บาทค่ะ";
			echo json_encode($status);
			exit();
		}	
		if($username=='moneybag'){
		if($amount > $member['moneybag']){
			$status['status'] = "0";
			$status['msg'] = "ยอดเงินในถุงเงินไม่เพียงพอค่ะ";
			echo json_encode($status);
			exit();
		}	
		$usernameorg = 'moneybag';
		$username = 'moneybag'.$owner.'';
		}else{
		$usernameorg = '';
		}
		
		
		$rowid = $db->Execute("INSERT INTO paylogs (owner,name,username,phone,types,froms,tos,amount,added,ip,webroot) VALUES ('$owner','$name','".$member['username']."','$phone','transfer','$username','$tranfers','$amount','$added','$ip','$webroot')");
		if($rowid){
		
			if($usernameorg=='moneybag'){ 
				$db->Execute("UPDATE member SET moneybag = '".($member['moneybag']-$amount)."' where id= ".$member['id']." ");
				$db->Execute("UPDATE paylogs SET added2 = '".time()."', transfrom='confirmed',wd_bef='".$member['moneybag']."' ,wd_aft='".($member['moneybag']-$amount)."' where id= ".$rowid." "); 
			}
			$status['status'] = "1";
			$status['rid'] = $rowid;
			$status['msg'] = "รายการโยกเงินได้รับการบันทึกเรียบร้อย";
			echo json_encode($status);
			exit();
		}
	}
}

if(isset($_POST['sendDep'])){	
	$member=Live::member();
	if(!$member){
		$status['status'] = "0";
		$status['msg'] = "หมดเวลาในระบบ กรุณาล๊อคอินใหม่อีกครั้ง";
		echo json_encode($status);
		exit();
	}
	
	if($member['suped'] == 'sup'){
		$status['status'] = "0";
		$status['msg'] = "การทำรายการถูกระงับ ไม่สามารถทำรายการได้ โปรดติดต่อสอบถามพนักงาน ตามช่องทางที่สะดวก";
		echo json_encode($status);
		exit();
	}	
	
	$owner = $member['id'];
	$name = $member['name'];
	$username = $member['username'];
	$added = time();
	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$bank = trim($_POST['bankname']);
	$coupon = trim($_POST['coupon']);
	$gameuser = trim($_POST['gameuser']);
	$q = trim($_POST['q']);
	$time = trim($_POST['time']);
	
	 	 
		
		$mbtimes2 = str_replace((date('Y')+543),date('Y'),$time);
		$timestampp = strtotime($mbtimes2);
		
		
		$tim = time();
	
	
	if($timestampp > $tim){
		$status['status'] = "0";
		
		$status['msg'] = "วันที่ หรือ เวลา ไม่ตรงกับความเป็นจริง";
	
		echo json_encode($status);
		exit();
	}
	
	
	
	
	if(trim($_POST['gameuser']) == ''){
		$status['status'] = "0";
		$status['msg'] = "โปรดเลือก บัญชีเกมส์ ".$timestampp3." <= ".time()."";
		echo json_encode($status);
		exit();
	}
	
	$ckp = $db->GetOne("select * from deposit where owner = '$owner' and status = 'pending'");
	if($ckp[0]){
		$status['status'] = "0";
		$status['msg'] = "โปรดรอสักครู่ ขณะนี้คุณมีรายการค้าง รอประมวลผลอยู่ สามารถรีเฟรชเพื่อดูสถานะรายการได้ค่ะ";
		echo json_encode($status);
		exit();
	}

	if(empty($gameuser)){
		$status['status'] = "0";
		$status['msg'] = "โปรดเลือกบัญชีเกมส์";
		echo json_encode($status);
		exit();
	}
	
	if(empty($bank)){
		$status['status'] = "0";
		$status['msg'] = "โปรดเลือกบัญชีธนาคาร";
		echo json_encode($status);
		exit();
	}
	
	if(!preg_match('/^[0-9]+$/', $amount)){
		$status['status'] = "0";
		$status['msg'] = "โปรดระบุเฉพาะตัวเลขเท่านั้น";
		echo json_encode($status);
		exit();
	}

	if($amount <= 0){
		$status['status'] = "0";
		$status['msg'] = "โปรดระบุยอดเงินที่ทำการโอนเข้ามา";
		echo json_encode($status);
		exit();
	}

	if($bank == '0'){
		$status['status'] = "0";
		$status['msg'] = "โปรดระบุธนาคารที่ทำการโอนเข้ามา";
		echo json_encode($status);
		exit();
	}
	
	if($coupon!=''){
	$ckp = $db->GetRow("select * from coupon where couponcode = '$coupon'");
		
		if($ckp['couponcode']==''){
			$status['status'] = "0";
			$status['msg'] = "รหัสคูปองนี้ไม่มีในระบบ";
			echo json_encode($status);
			exit();
		}
		
		if(($ckp['type']=='baht')and($ckp['owner']!=0)){
			$status['status'] = "0";
			$status['msg'] = "รหัสคูปองนี้ถูกใช้ไปแล้ว";
			echo json_encode($status);
			exit();
		}
		$tim = time();
		if(($ckp['exp']!='0')and($ckp['exp']<$tim)){
			$status['status'] = "0";
			$status['msg'] = "รหัสคูปองนี้หมดอายุแล้ว ";
			echo json_encode($status);
			exit();
		}
		
		
		if($ckp['type']=='percent'){
			$ckcp = $db->GetRow("select * from couponlogs where couponcode = '".$coupon."' AND owner=".$member['id']." AND status != 'cancle'");
		
			if($ckcp['owner']!=''){
				$status['status'] = "0";
				if($ckcp['status']=='confirmed'){
				$status['msg'] = "รหัสคูปองนี้ถูกใช้ไปแล้ว";
				}
				if($ckcp['status']=='pending'){
				$status['msg'] = "คูปองนี้อยู่ระหว่างตรวจสอบ";
				}
				echo json_encode($status);
				exit();
			}
		
			$type='%';
			
			
			$db->Execute("INSERT INTO couponlogs (coupon,couponcode,amount,befam,aftam,type,owner,name,added,status) VALUES ('".$ckp['id']."','".$coupon."','".$ckp['amount']."','".$amount."','".($amount+($amount*$ckp['amount']/100))."','".$ckp['type']."','".$member['id']."','".$member['name']."','".time()."','pending')");
			
			
			$amountt = ($amount*$ckp['amount']/100);
			if($amountt>1000){ $amountt=1000; }
			$qsys = 'คูปองC:'.$coupon.' โบนัส'.$ckp['amount'].'% มูลค่า '.$amountt.' บาท | ';
		}else{
			$type='บาท';
			$db->Execute("INSERT INTO couponlogs (coupon,couponcode,amount,befam,aftam,type,owner,name,added,status) VALUES ('".$ckp['id']."','".$coupon."','".$ckp['amount']."','".$member['moneybag']."','".($member['moneybag']+$ckp['amount'])."','".$ckp['type']."','".$member['id']."','".$member['name']."','".time()."','pending')");
			$db->Execute("UPDATE coupon SET owner = '".$member['id']."', name='".$member['name']."',added2='".time()."' where id= ".$ckp['id']." "); 
			
			
			$amountt = $ckp['amount'];
			$qsys = 'โบนัส คูปองC:'.$coupon.' มูลค่า '.$amountt.' บาท |';
		}
		}
		
	$rowid = $db->Execute("INSERT INTO deposit (owner,name,gameuser,username,bank,added,times,amount,bonus,q,coupon,ip,webroot) VALUES ('$owner','$name','$gameuser','$username','$bank','$added','$timestampp','$amount','$amountt','".$qsys."".$q."','".$ckp['id']."','$ip','$webroot')");
	if($rowid){
				
				
			
		$status['status'] = "1";
		$status['rid'] = $rowid;
		$status['msg'] = "รายการฝากเงินได้รับการบันทึกเรียบร้อย โปรดรอสักครู่ ......... ทีมงานกำลังตรวจสอบราย";
		echo json_encode($status);
		exit();
	}
	
}

if(isset($_POST['cheackdeposit'])){
	$member=Live::member();
	if(!$member){
		$status['status'] = "0";
		$status['msg'] = "หมดเวลาในระบบ กรุณาล๊อคอินใหม่อีกครั้ง";
		echo json_encode($status);
		exit();
	}
	if($member['suped'] == 'sup'){
		$status['status'] = "0";
		$status['msg'] = "การทำรายการถูกระงับ ไม่สามารถทำรายการได้ โปรดติดต่อสอบถามพนักงาน ตามช่องทางที่สะดวก";
		echo json_encode($status);
		exit();
	}	
	
	$owner = $member['id'];
	$id = $_POST['rowid'];
	$row = $db->GetRow("select * from deposit where owner = '$owner' and id = '$id'");
	if($row['status'] == 'pending'){
		$status['status'] = "0";
		echo json_encode($status);
		exit();
	}elseif($row['status'] == 'confirmed'){
		$status['status'] = "1";
		echo json_encode($status);
		exit();
	}elseif($row['status'] == 'cancle'){
		$status['status'] = "2";
		echo json_encode($status);
		exit();
	}
}







if(isset($_POST['sendBO'])){
	$member=Live::member();
	if(!$member){
		$status['status'] = "0";
		$status['msg'] = "หมดเวลาในระบบ กรุณาล๊อคอินใหม่อีกครั้ง";
		echo json_encode($status);
		exit();
	}
	
	if($member['suped'] == 'sup'){
		$status['status'] = "0";
		$status['msg'] = "การทำรายการถูกระงับ ไม่สามารถทำรายการได้ โปรดติดต่อสอบถามพนักงาน ตามช่องทางที่สะดวก";
		echo json_encode($status);
		exit();
	}	
	
	$couponcode = $_POST['couponcode'];
	$owner = $member['id'];
	$name = $member['name'];
	$added = time();
	
		
		$ckp = $db->GetRow("select * from coupon where couponcode = '$couponcode'");
		
		if($ckp['couponcode']==''){
			$status['status'] = "0";
			$status['msg'] = "รหัสคูปองนี้ไม่มีในระบบ";
			echo json_encode($status);
			exit();
		}
		
		if(($ckp['type']=='baht')and($ckp['owner']!=0)){
			$status['status'] = "0";
			$status['msg'] = "รหัสคูปองนี้ถูกใช้ไปแล้ว";
			echo json_encode($status);
			exit();
		}
		$tim = time();
		if(($ckp['exp']!='0')and($ckp['exp']<$tim)){
			$status['status'] = "0";
			$status['msg'] = "รหัสคูปองนี้หมดอายุแล้ว ";
			echo json_encode($status);
			exit();
		}
		
		
		if($ckp['type']=='percent'){
		
				$status['status'] = "0";
				$status['msg'] = "คูปอง % ใช้สำหรับเมนูฝากเงินเท่านั้น";
				echo json_encode($status);
				exit();
		
			$type='%';
			
			
			/*$db->Execute("INSERT INTO couponlogs (couponcode,amount,befam,aftam,type,owner,name,added) VALUES ('".$couponcode."','".$ckp['amount']."','".$member['moneybag']."','".($member['moneybag']+($member['moneybag']*$ckp['amount']/100))."','".$ckp['type']."','".$member['id']."','".$member['name']."','".time()."')");
			
			$amounttotal = ($member['moneybag']+($member['moneybag']*$ckp['amount']/100));
			$amountt = ($member['moneybag']*$ckp['amount']/100);
			if($amountt>1000){ $amountt=1000; }
			$ttam = "มูลค่า ".$amountt." บาท";
			$db->Execute("UPDATE member SET moneybag = '".$amounttotal."' where id= ".$member['id']." ");*/
		}else{
			$type='บาท';
			$db->Execute("INSERT INTO couponlogs (coupon,couponcode,amount,befam,aftam,type,owner,name,added,status) VALUES ('".$ckp['id']."','".$couponcode."','".$ckp['amount']."','".$member['moneybag']."','".($member['moneybag']+$ckp['amount'])."','".$ckp['type']."','".$member['id']."','".$member['name']."','".time()."','confirmed')");
			$db->Execute("UPDATE coupon SET owner = '".$member['id']."', name='".$member['name']."',added2='".time()."' where id= ".$ckp['id']." "); 
			
			$amounttotal = ($member['moneybag']+$ckp['amount']);
			$amountt = $ckp['amount'];
			$db->Execute("UPDATE member SET moneybag = '".$amounttotal."' where id= ".$member['id']." ");
		}
				
				$db->Execute("INSERT INTO paylogs (
			owner,name,username,phone,types,froms,tos,amount,added,added4,dep_bef,dep_aft,status,q,ip,webroot
			) VALUES (
			".$member['id'].",'".$member['name']."','".$member['username']."','".$member['phone']."','coupon','CODE:".$couponcode."','monneybag".$member['id']."','".$amountt."',$added,$added,'".$member['moneybag']."',".($member['moneybag']+$amounttotal).",'confirmed','คูปอง ".$ckp['amount']." ".$type." ','$ip','$webroot'
			)");
			
			$status['status'] = "1";
			$status['rid'] = $rowid;
			$status['msg'] = "คุณได้รับโบนัส/คูปอง ".$ckp['amount']." ".$type." $ttam ";
			echo json_encode($status);
			exit();
		
	}




if(isset($_POST['sendeuro'])){
	$member=Live::member();
	if(!$member){
		$status['status'] = "0";
		$status['msg'] = "หมดเวลาในระบบ กรุณาล๊อคอินใหม่อีกครั้ง";
		echo json_encode($status);
		exit();
	}
	
	if($member['suped'] == 'sup'){
		$status['status'] = "0";
		$status['msg'] = "การทำรายการถูกระงับ ไม่สามารถทำรายการได้ โปรดติดต่อสอบถามพนักงาน ตามช่องทางที่สะดวก";
		echo json_encode($status);
		exit();
	}	
	
	$sit = $_POST['sit'];
	$sel = $_POST['seleuros'];
	$owner = $member['id'];
	$name = $member['name'];
	$added = time();
	
		
		if($member['euro']==0){
			$status['status'] = "0";
			$status['msg'] = "ท่านมี 0 สิทธิ์ ไม่สามารถทายผลฟุตบอลยูโรได่";
			echo json_encode($status);
			exit();
		}
		
		if($sel==''){
			$status['status'] = "0";
			$status['msg'] = "กรุณาเลือกทีมที่ชนะ";
			echo json_encode($status);
			exit();
		}
		
		
			$eur = ($member['euro']-1);
			$db->Execute("INSERT INTO eurologs (owner,name,phone,team,route,added) VALUES ('".$member['id']."','".$member['name']."','".$member['phone']."','".$sel."','ทายผลฟุตบอลยูโร','".$added."')");
			$db->Execute("UPDATE member SET euro = '".$eur."' where id= ".$member['id']." "); 
			
			
			$status['status'] = "1";
			$status['rid'] = $rowid;
			$status['msg'] = "ท่านได้ทายผลทีม ".$sel."สำเร็จ";
			echo json_encode($status);
			exit();
		
	}





if(isset($_POST['selecbacc'])){




$bank = $_POST['bank'];


	$msg = '<option value="">โปรดเลือก</option>';
	$true_res = $db->GetAll("select * from bank where bank = '".$bank."' and onsite='1' AND webroot='bafobet'");
	if($true_res){
	
		foreach($true_res as $row){
		
		$msg .= '<option value="'.$row['bank'].'-'.$row['bankacc'].'">'.$row['bankacc'].' - XXXXXX'.$row['banknumber'].'</option>';
		}
	
	$status['status'] = "1";
	$status['msg'] = $msg;
	echo json_encode($status);	
	exit();
			
	}

		
}


if(isset($_POST['sele_tf_game'])){

$gameuser = $_POST['gameuser'];
$memberid = $_POST['memberid'];

$status['html'] .= '<option value="">เลือกบัญชีเกมส์ หรือ ธนาคารที่ต้องการ</option>';
if($gameuser!='moneybag'){ $status['html'] .= '<option value="" id="tobank">บัญชีธนาคาร</option>'; }


	$true_res = $db->GetAll("select * from gameusers where owner = '".$memberid."' and provider != 'W88'");
	foreach($true_res as $x){
		if($gameuser!=$x['gameuser']){
		$status['html'] .= '<option value="'.$x['gameuser'].'">'.strtoupper($x['gameuser']).'</option>';
		}
	}

$status['html'] .= '<option value="NEWUSER">เปิดบัญชีใหม่</option>';

	$status['status'] = "1";
	//$status['msg'] = $msg;
	echo json_encode($status);	
	exit();
}


if(isset($_POST['gift'])){
	$member=Live::member();
	if(!$member){
		$status['status'] = "0";
		$status['msg'] = "หมดเวลาในระบบ กรุณาล๊อคอินใหม่อีกครั้ง";
		echo json_encode($status);
		exit();
	}
	
	if($member['suped'] == 'sup'){
		$status['status'] = "0";
		$status['msg'] = "การทำรายการถูกระงับ ไม่สามารถทำรายการได้ โปรดติดต่อสอบถามพนักงาน ตามช่องทางที่สะดวก";
		echo json_encode($status);
		exit();
	}	
	
	$owner = $member['id'];
	$name = $member['name'];
	$added = time();
	
		
		if($member['euro']==0){
			$status['status'] = "0";
			$status['msg'] = "ท่านมี 0 สิทธิ์ ไม่สามารถจับรางวัลได้";
			
			echo json_encode($status);
			exit();
		}
		
		
		if(time()>='1473958800'){
			$status['status'] = "0";
			$status['msg'] = "หมดเขตการจับรางวัลแล้ว";
			
			echo json_encode($status);
			exit();
		}
		
		
			function getbounsCode($length = "")
			{
  			$code = md5(uniqid(rand(), true));
  			$code = strtoupper($code);
			$codefinal = substr($code, 0, $length);
			
			return $codefinal;
			}
			
			$timedate = strtotime(''.date('d-m-Y').' 00:00:00');
			$sql = $db->GetAll("select * from couponlogs where added > '".$timedate."'");
			$sqlnum = count($sql);
			$countgift = 3;
			$sel = rand(1,$countgift);
			$gift = getbounsCode(17);
			/*for($i=0;$i=<count($countgift);$i++){*/
				if($sel==1){ $amount = 5; }
				if($sel==2){ $amount = 10; }
				if($sel==3){ $amount = 15; }
				if($sqlnum%15==0 and $sqlnum!=0 and $sqlnum!=''){ $amount = 20; }
				if($sqlnum%25==0 and $sqlnum!=0 and $sqlnum!=''){ $amount = 25; }
				if($sqlnum%35==0 and $sqlnum!=0 and $sqlnum!=''){ $amount = 30; }
				if($sqlnum%45==0 and $sqlnum!=0 and $sqlnum!=''){ $amount = 35; }
				if($sqlnum%55==0 and $sqlnum!=0 and $sqlnum!=''){ $amount = 40; }
				if($sqlnum%65==0 and $sqlnum!=0 and $sqlnum!=''){ $amount = 45; }
				if($sqlnum%75==0 and $sqlnum!=0 and $sqlnum!=''){ $amount = 50; }
			//}
			
			$db->Execute("insert INTO coupon (couponcode, amount, type,q,personnel,added) VALUES ('".$gift."','".$amount."','baht','กิจกรรมจับรางวัล','','".$added."')");
			
			$eur = ($member['euro']-1);
			$db->Execute("INSERT INTO eurologs (owner,name,phone,team,route,added) VALUES ('".$member['id']."','".$member['name']."','".$member['phone']."','คูปองมูลค่า ".$amount." บาท รหัสคูปอง : ".$gift."','จับรางวัล','".$added."')");
			$db->Execute("UPDATE member SET euro = '".$eur."' where id= ".$member['id']." "); 
			
			
			$status['status'] = "1";
			$status['rid'] = $rowid;
			$status['msg'] = "คูปองมูลค่า ".$amount." บาท<br>รหัสคูปอง : ".$gift."<br>";
			$status['sit'] = $eur;
			echo json_encode($status);
			exit();
		
	}
	
	if(isset($_POST['openaccount'])){
	
	$owner = $_POST['owner'];
	
	$name = $_POST['name'];

	$phone = $_POST['phone'];
	
	$lineid = $_POST['lineid'];

	$username = $_POST['username'];

	$password = $_POST['password'];

	$bankname = $_POST['bankname'];

	$banknumber = $_POST['banknumber'];
	
	$recom = $_POST['recom'];

	$added = time();


	$ck1 = $db->GetAll("select * from member where username = '$username'  and webroot='bafobet' ");
	$sql="SELECT username FROM members WHERE username = '".$username."' AND code != '".$_SESSION[MEMBER]['DATA']['code']."' ;";
		$query=mysql_query($sql,$conn);
		$memberU=mysql_fetch_assoc($query);

	if($ck1['username']!='' or $memberU['username']!=''){

		$status['status'] = "0";

		$status['msg'] = "Username มีในระบบแล้ว ";

		echo json_encode($status);

		exit();

	}
	
	if(empty($username)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุ ชื่อบัญชีเข้าใช้งาน";

		echo json_encode($status);

		exit();		

	}

	

	if(empty($name)){

		$status['status'] = "0";

		$status['msg'] = "กรุณาระบุ ชื่อ-นามสกุล ";

		echo json_encode($status);

		exit();

	}
	
	
	if(strlen($phone) != 10 or !preg_match('/^[0-9]+$/', $phone)){

		$status['status'] = "0";

		$status['msg'] = "เบอร์โทรศัพท์ ต้องระบุเป็นตัวเลข 10 หลัก เท่านั้น";

		echo json_encode($status);

		exit();

	}

	/*
	$true_res = $db->GetAll("select * from gameusers where owner = '".$memberid."' and provider != 'W88'");
	foreach($true_res as $x){
	*/
	$ck3 = $db->GetAll("select * from member where phone = '$phone' and webroot='bafobet' ");

	if($ck3){

		$status['status'] = "0";

		$status['msg'] = "เบอร์โทรนี้ มีในระบบแล้ว ";

		echo json_encode($status);

		exit();

	}
	
	
	
	

	

	if(empty($bankname)){

		$status['status'] = "0";

		$status['msg'] = "โปรดเลือกธนาคารของลูกค้า ";

		echo json_encode($status);

		exit();		

	}
	
if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
if(empty($password)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุรหัสผ่าน";

		echo json_encode($status);

		exit();		
	}
	}else{
	
		$sql="SELECT password FROM members WHERE code = '".$_SESSION[MEMBER]['DATA']['code']."';";
		$query=mysql_query($sql,$conn);
		$memberdata=mysql_fetch_assoc($query);
		$password = $memberdata['password'];
		
	}
	
	$true_res = $db->GetAll("select gamesidname from gamesid");
	foreach($true_res as $ck){
	
		if(strstr($username,$ck['gamesidname'])){
			$status['status'] = "0";
			$status['msg'] = "ห้ามใช้ '".$ck['gamesidname']."' เป็นส่วนประกอบใน Username";
			echo json_encode($status);
			exit();
		}
		}
	
	if((strlen($banknumber) > 12 and strlen($banknumber) < 10) or !preg_match('/^[0-9]+$/', $banknumber)){

		$status['status'] = "0";

		$status['msg'] = "เลขบัญชีธนาคาร ต้องระบุเป็นตัวเลข 10 หลัก เท่านั้น";

		echo json_encode($status);

		exit();

	}
	
	
	
	$ck2 = $db->GetAll("select * from member where banknumber = '$banknumber' and webroot='bafobet' ");

	if($ck2){

		$status['status'] = "0";

		$status['msg'] = "เลขบัญชีธนาคารนี้ มีในระบบแล้ว ";

		echo json_encode($status);

		exit();

	}
	
	



	

		
		
		
		$rowid = $db->Execute("INSERT INTO member (name,username,password,phone,lineid,bankname,banknumber,added,recom,active, webroot) VALUES ('$name','$username','".md5($password)."', '$phone','$lineid', '$bankname', '$banknumber','$added','$recom','Y' ,'bafobet')");
		
		//$last_id = mysql_insert_id($db);
		$res = $db->GetRow("select * from member where username = '".$username."' and password='".md5($password)."' ");
		
		if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
			mysql_query("INSERT INTO members (tel,username,password,enable,user_create,date_create,score,mainid)VALUES('".$phone."','".$username."','".$password."','Y','".$username."','".date('Y-m-d H:i:s')."','1000','".$res['id']."') ",$conn);
		}else{
			mysql_query("UPDATE members SET username='".$username."', mainid='".$res['id']."' where code='".$_SESSION[MEMBER]['DATA']['code']."' ",$conn);
		}
		
	

	if($rowid){
		

		//$lastid = mysql_insert_id($db)
		$status['status'] = "1";
		$status['token'] = base64_encode(base64_encode($res['id']."-".$username."-".date('dmyH')));
        
		$status['msg'] = "เพิ่มบัญชีลูกค้าใหม่เรียบร้อย";

		echo json_encode($status);

		exit();

	}

}






if(isset($_POST['opennewgames'])){
	$member=Live::member();
	if(!$member){
		$status['status'] = "0";
		$status['msg'] = "หมดเวลาในระบบ กรุณาล๊อคอินใหม่อีกครั้ง";
		echo json_encode($status);
		exit();
	}
	
	if($member['suped'] == 'sup'){
		$status['status'] = "0";
		$status['msg'] = "การทำรายการถูกระงับ ไม่สามารถทำรายการได้ โปรดติดต่อสอบถามพนักงาน ตามช่องทางที่สะดวก";
		echo json_encode($status);
		exit();
	}
	
	$owner = $member['id'];
	$name = $member['name'];
	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$added = time();
	$tranfers = trim($_POST['tranfers']);
		
		$ckp = $db->GetOne("select * from paylogs where owner = '$owner' and status = 'pending'");
		if($ckp[0]){
			$status['status'] = "0";
			$status['msg'] = "โปรดรอสักครู่ ขณะนี้คุณมีรายการค้าง รอประมวลผลอยู่ สามารถรีเฟรชเพื่อดูสถานะรายการได้ค่ะ";
			echo json_encode($status);
			exit();
		}
		
		

		if(!preg_match('/^[0-9]+$/', $amount)){
			$status['status'] = "0";
			$status['msg'] = "โปรดระบุเฉพาะตัวเลขเท่านั้น";
			echo json_encode($status);
			exit();
		}

		if($amount == 0){
			$status['status'] = "0";
			$status['msg'] = "โปรดระบุยอดเงินที่ต้องการ";
			echo json_encode($status);
			exit();
		}

		if($amount < 40){
			$status['status'] = "0";
			$status['msg'] = "เปิดบัญชีขั้นต่ำ 40 บาทค่ะ";
			echo json_encode($status);
			exit();
		}	
		
		if($amount > $member['moneybag']){
			$status['status'] = "0";
			$status['msg'] = "ยอดเงินในถุงเงินไม่เพียงพอค่ะ";
			echo json_encode($status);
			exit();
		}	
		$usernameorg = 'moneybag';
		$username = 'moneybag'.$owner.'';
		
		
		
		$rowid = $db->Execute("INSERT INTO paylogs (owner,name,username,phone,types,froms,tos,amount,added,ip,webroot) VALUES ('$owner','$name','".$member['username']."','$phone','transfer','$username','$tranfers','$amount','$added','$ip','$webroot')");
		if($rowid){
		
			
				$db->Execute("UPDATE member SET moneybag = '".($member['moneybag']-$amount)."' where id= ".$member['id']." ");
				$db->Execute("UPDATE paylogs SET added2 = '".time()."', transfrom='confirmed',wd_bef='".$member['moneybag']."' ,wd_aft='".($member['moneybag']-$amount)."' where id= ".$rowid." "); 
			
			$status['status'] = "1";
			$status['rid'] = $rowid;
			$status['msg'] = "รายการเปิด ID เกมส์ได้รับการบันทึกเรียบร้อย";
			echo json_encode($status);
			exit();
		}
	//}
}
?>
<?php
session_start();

require('database.class.php');

set_time_limit(0);


	$added = time();
	$id = $_COOKIE["PID"];
	$usern = $_COOKIE["PUSERNAME"];
	if($id!=$_SESSION['ps']['id']){
	$sql1 = "select * from personnel where id = '".$id."' and username = '".$usern."'";
	$result1 = $conn->query($sql1);
	$ps = $result1->fetch_assoc();
	$_SESSION['ps']=$ps;
	}
	$status=array();



if(isset($_POST['onecheck'])){

	if(($_COOKIE['PCLASS']=='Account')or($_COOKIE['PCLASS']=='Admin')or($checkbank=='Y')){
	############## DEPOSIT ###################

	$dpcount=0;
	$cont = '';
	#old
	//$sql = "select * from deposit where status = 'pending'";
	#New
	$sql3 = "select id from deposit where status = 'pending' order by id desc";
	$result3 = $conn->query($sql3);
	
	$statusmun = $result3->num_rows;
	
		if ($statusmun > 0) {

			//$statusmun = $result->num_rows;

		while($row = $result3->fetch_assoc()) {
		
			$bid = $row['id'];
	
		}

	}
	############## DEPOSIT ###################

		$boldid = $_SESSION['boldid'];
		
		$status['boldid'] = $boldid;

		$_SESSION['boldid'] = $bid;

		$status['bpid'] = $bid;
				

		$status['status'] = "1";

		$status['statusmun'] = $statusmun;
	}
		echo json_encode($status);

		exit();

}




if(isset($_POST['withcheck'])){
	if(($_COOKIE['PCLASS']=='Account')or($_COOKIE['PCLASS']=='Admin')or($withdrawal=='Y')){
	$statusmun = 0;
	
	$sql1 = "select id from paylogs where status = 'pending' AND types='withdrawal' AND withdrawal='confirmed' order by id desc limit 50";
	$result1 = $conn->query($sql1);
	$statusmun = $result1->num_rows;
	//echo $sql1;
	
	//$sql2 = "select * from paylogs where status = 'pending' AND types='withdrawal' order by id desc limit 1";
	//$result2 = $conn->query($sql2);
	
	while($row2 = $result1->fetch_assoc()){
	
		
        $oldid = $row2['id'];
	
		$oldid = $_SESSION['poldid'];
		$_SESSION['poldid'] = $row2['id'];
	
	
	$status['ppid'] = $row2['id'];
	
	}
		
		//$status['sqll'] = $sql1."|".$result9->num_rows;
		$status['poldid'] = $oldid;	
		$status['status'] = "1";
		$status['statusmun'] = $statusmun;
	}
		echo json_encode($status);
		exit();

}


if(isset($_POST['acheck'])){
	$statusmun = 0;
	
	if(($_COOKIE['PCLASS']=='Account')or($_COOKIE['PCLASS']=='Admin')){
	$sql1 = "select * from paylogs where status='pending' AND withdrawal='pending' order by added desc limit 50";
	}else{
	$sql1 = "select * from paylogs where status='pending'  AND withdrawal='pending' AND ($sqlre or $sqlree) $spaesql order by added desc limit 50";
	}
	$result1 = $conn->query($sql1);
	
	while($row1 = $result1->fetch_assoc()){
	if(($_COOKIE['PCLASS']=='Account')or($_COOKIE['PCLASS']=='Admin')){
	
	$statusmun = $result1->num_rows;
	
	}else{	
	
	if($row1['types']=='transfer'){
	
	if(strstr(strtoupper($row1['tos']),strtoupper('NEWUSER:'))){
		$statusmun = $statusmun+1;
	}else{
	
for($x = 0; $x < count($usesel); $x++) {

    if(strstr(strtoupper($row1['froms']),strtoupper($usesel[$x]))and($row1['transfrom']=='pending')){
	$statusmun = $statusmun+1;
   }
   
   
   
   if(strstr(strtoupper($row1['tos']),strtoupper($usesel[$x]))and($row1['transfrom']=='confirmed')){
	$statusmun = $statusmun+1;
   }
}
}
}else{
	$statusmun = $statusmun+1;
}

	}
	}
	
	//echo $sql1;
	
	if(($_COOKIE['PCLASS']=='Account')or($_COOKIE['PCLASS']=='Admin')){
		$sql2 = "select id from paylogs where status='pending' AND withdrawal='pending' order by id desc limit 1";
	}else{
		$sql2 = "select id from paylogs where status='pending' AND withdrawal='pending' AND ($sqlre or $sqlree) order by id desc limit 1";
	}
	$result2 = $conn->query($sql2);
	
	while($row2 = $result2->fetch_assoc()){
	
		
        $oldid = $row2['id'];
	
		$oldid = $_SESSION['aoldid'];
		$_SESSION['aoldid'] = $row2['id'];
	
	
	$status['apid'] = $row2['id'];
	
	}
		
		//$status['sqll'] = $sql1;
		$status['aoldid'] = $oldid;	
		$status['status'] = "1";
		$status['statusmun'] = $statusmun;
		echo json_encode($status);
		exit();
}




if(isset($_POST['updatebackwd'])){

$pid = $_POST['pid'];

$mid = $_POST['mid'];

if(!empty($id)){
        $sql2 = "select bankname,banknumber from member where id = $mid";

	$result2 = $conn->query($sql2);
	
	$row2 = $result2->fetch_assoc();

        $upd =  $conn->query("update paylogs set tos='".$row2['bankname'].":".$row2['banknumber']."' where id = $pid ");
}

if($upd){		
$status['status'] = "1";
		
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ/โอนเงิน', 'ID $pid | กดปุ่มอัพเดทเลขที่บัญชี owner ".$mid."')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}else{
$status['status'] = "0";
$status['msg'] = "ผิดพลาด ".$sql3."";
echo json_encode($status);	
exit();
}
}

if(isset($_POST['addotherpay'])){

	$type = $_POST['type'];
	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$fee = $_POST['fee'];
	$bank = $_POST['bank'];
	$bankacc = $_POST['bankacc'];
	$datetran = $_POST['datetran'];
	$h = $_POST['h'];
	$hi = $_POST['hi'];
	$q = $_POST['q'];

	if(empty($type)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้เลือกรายการ";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($amount)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุยอดเงิน";
		echo json_encode($status);	
	exit();	
	}
	
	
	if(empty($bank)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้เลือกธนาคาร";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($bankacc)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้เลือกบัญชีธนาคาร";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($datetran)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุวันที่";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($h)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุเวลา";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($hi)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุเวลา";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($q)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุหมายเหตุ";
		echo json_encode($status);	
	exit();	
	}
	
	 	$tis = "".$datetran." ".$h.":".$hi.""; 
		
	 	


			$sql3 = "INSERT INTO otherpay (type, amount, fee,bank,bankacc,datetran,q,personnel,added) VALUES ('".$type."','".$amount."','".$fee."','".$bank."','".$bankacc."','".$tis."','".$q."','".$_SESSION['ps']['name']."','".$added."')";

$conn->query($sql3);
$insertid = $conn->insert_id;


		

		$status['status'] = "1";

		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'ค่าใช้จ่ายอื่นๆ', 'ID : $insertid | เพิ่มข้อมูลค่าใช้จ่ายอื่นๆ ชนิด:".$type.",จำนวน:".$amount.",ค่าธรรมเนียม:".$fee.",ธนาคาร:".$bank.",บัญชี:".$bankacc.",เวลา:".$tis.",หมายเหตุ:".$q." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	

}


if(isset($_POST['sendaddorder'])){

	$gameuser = strtolower(trim($_POST['gameid']));

	$amount = 0 + str_replace(",","",trim($_POST['amount']));

	$type = trim($_POST['type']);

	$bank = trim($_POST['bank']);

	$q = ' '.trim($_POST['q']);
	
	$timem = time();



	if(empty($type)){

			$status['msg'] = 'โปรดเลือกรูปแบบ';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}



	if(empty($bank)){

			$status['msg'] = 'โปรดเลือกธนาคาร';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}



	if(empty($q)){

			$status['msg'] = 'โปรดใส่หมายเหตุ';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}



	if($amount <= 0){

			$status['msg'] = 'โปรดระบุยอดเงิน';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}



	

	$sql = "select * from gameusers where LOWER(gameuser) = '$gameuser'";

	$result = $conn->query($sql);

	$ck = $result->fetch_assoc();



	if($ck){

		$owner = $ck['owner'];

		$gameuser = $ck['gameuser'];

		

		$sql2 = "select * from member where id = '$owner'";

		$result2 = $conn->query($sql2);

		$member = $result2->fetch_assoc();



		$name = $member['name'];

		$username = $member['username'];


		$time = $q;

			$rowid = $conn->query("INSERT INTO deposit (owner,name,gameuser,username,bank,added,times,q2,amount,q) VALUES ('$owner','$name','$gameuser','$username','$bank','$added','$timem','$q','$amount','$type.$q')");

$insertid = $conn->insert_id;

			if($rowid){
		
				$status['status'] = "1";

		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เช็คแบงค์', 'ID : $insertid | ลอยยอดใหม่ Gameuser:$gameuser Username:$username จำนวน $amount หมายเหตุ $q')");
		##insert Log##
		
		
				$status['msg'] = "รายการฝากเงินได้รับการบันทึกเรียบร้อย";

				echo json_encode($status);

				exit();

			}

	}else{

			$status['msg'] = 'ไม่พบบัญชีเกมส์นี้ในระบบ';

			$status['status'] = 0;

			echo json_encode($status);

			exit();



	}

}



if(isset($_POST['getusername'])){

$usern = $_POST['usern'];

if(!empty($usern)){
$sql2 = "select * from gameusers where gameuser = '$usern'";
$result2 = $conn->query($sql2);
$member = $result2->fetch_assoc();

$sql3 = "select * from member where id = '".$member['owner']."'";
$result3 = $conn->query($sql3);
$member3 = $result3->fetch_assoc();
}

if($member3){		
$status['status'] = "1";

		//$status['status'] = $sql3;
		$status['msg'] = "".$member3['name']." , ".$member3['username']." , ".$member3['phone']."";
		$status['msg'] .= "<input name='name' id='name' type='hidden' value='".$member3['name']."' />";
		$status['msg'] .= "<input name='owner' id='owner' type='hidden' value='".$member3['id']."' />";
		
		echo json_encode($status);	
		exit();
}else{
$status['status'] = "0";
$status['msg'] = "ไม่มี";
echo json_encode($status);	
exit();
}
}


if(isset($_POST['getusername2'])){

$usern = $_POST['usern'];

if(!empty($usern)){
$sql2 = "select * from gameusers where gameuser = '$usern'";
$result2 = $conn->query($sql2);
$member = $result2->fetch_assoc();

$sql3 = "select * from member where id = '".$member['owner']."'";
$result3 = $conn->query($sql3);
$member3 = $result3->fetch_assoc();
}

if($member3){		
$status['status'] = "1";

		//$status['status'] = $sql3;
		$status['msg'] = "".$member3['name']." , ".$member3['username']." , ".$member3['phone']."";
		//$status['msg'] .= "<input name='name2' id='name2' type='hidden' value='".$member3['name']."' />";
		//$status['msg'] .= "<input name='owner2' id='owner2' type='hidden' value='".$member3['id']."' />";
		
		echo json_encode($status);	
		exit();
}else{
$status['status'] = "0";
$status['msg'] = "ไม่มี";
echo json_encode($status);	
exit();
}
}


if(isset($_POST['askcredit'])){

	$owner = $_POST['owner'];
	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$name = $_POST['name'];
	$usern = $_POST['usern'];
	$q = $_POST['q'];
	

	if(empty($owner)){
		$status['status'] = "0";
		$status['msg'] = "id game ไม่ถูกต้อง";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($amount)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุยอดเงิน";
		echo json_encode($status);	
	exit();	
	}
	
	
	if(empty($name)){
		$status['status'] = "0";
		$status['msg'] = "id game ไม่ถูกต้อง";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($usern)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุ ID Game";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($q)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุหมายเหต";
		echo json_encode($status);	
	exit();	
	}
	
$sql4 = "select * from credit where owner = '".$owner."' order by added desc limit 1";
$result4 = $conn->query($sql4);
$member4 = $result4->fetch_assoc();

$balance = $member4['balance']+$amount;
$credit = $member4['credit']+$amount;

			$sql3 = "INSERT INTO credit (owner, name, username, tos, credit, q, personnel, added) VALUES ('".$owner."','".$name."','".$usern."','".$usern."','$amount','$q','".$_SESSION['ps']['name']."','".$added."')";

$conn->query($sql3);
$insertid = $conn->insert_id;


		

		$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เครดิต', 'ID : $insertid | ขอเบิกเครดิต $usern(".$name.") จำนวน $amount บาท หมายเหตุ $q')");
		##insert Log##
		
		
		//$status['msg'] = "insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เครดิต', 'ID : $insertid | ขอเบิกเครดิต $usern(".$name.") จำนวน $amount บาท หมายเหตุ $q')";

		echo json_encode($status);	

}


if(isset($_POST['refundcredit'])){

	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$q = $_POST['q'];
	$id = $_POST['id'];
	$amold = $_POST['amold'];
	$cre = $_POST['cre'];
	
	if(empty($amount)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุยอดเงิน";
		echo json_encode($status);	
	exit();	
	}
	
	
	if(empty($id)){
		$status['status'] = "0";
		$status['msg'] = "รายการไม่ถูกต้อง";
		echo json_encode($status);	
	exit();	
	}
	
	
	if(empty($q)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุหมายเหต";
		echo json_encode($status);	
	exit();	
	}
	
	
	if($cre<($amold+$amount)){
		$status['status'] = "0";
		$status['msg'] = "ยอดคืนมากกว่ายอดเบิก";
		echo json_encode($status);	
	exit();	
	}


			$sql3 = "update credit set refund='".($amold+$amount)."', q2='".$q."', personnel2='".$_SESSION['ps']['name']."', added2=".$added." where id=$id ";

$conn->query($sql3);



		

		$status['status'] = "1";
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เครดิต', 'ID : $id | คืนเครดิต $usern(".$name.") จำนวน $amount บาท หมายเหตุ $q')");
		##insert Log##
		
		//$status['msg'] = "insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เครดิต', 'คืนเครดิต $usern(".$member4['username'].") จำนวน $amount หมายเหตุ $q')";

		echo json_encode($status);	

}

if(isset($_POST['updateorder'])){

$id = $_POST['id'];

$fee = $_POST['fee'];

$commissions = $_POST['commissions'];

$bonus = $_POST['bonus'];

$qq = $_POST['qq'];



if($fee>30){
		$status['status'] = "0";
		$status['msg'] = "ค่าธรรมเนียมเกิน 30 บาทแล้ว เช็คด้วยสิ!!";
		echo json_encode($status);	
	exit();	
	}


if(!empty($id)){
$sql3 = "update deposit set fee = '$fee' ,commissions = '$commissions',bonus = '$bonus',qq = '$qq' where id = $id";

$upd = $conn->query("update deposit set fee = '$fee' ,commissions = '$commissions',bonus = '$bonus',qq = '$qq' where id = $id");
}

if($upd){		
$status['status'] = "1";

		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เช็คแบงค์', 'ID : $id | ลอยยอด $gameuser ค่าธรรมเนียม $fee, ค่าคอม $commissions โบนัส $bonus, หมายเหตุ $qq')");
		##insert Log##
		
		//$status['status'] = $sql3;
		//$status['msg'] = $sql3;
		
		echo json_encode($status);	
		exit();
}else{
$status['status'] = "0";
$status['msg'] = "ผิดพลาด ".$sql3."";
echo json_encode($status);	
exit();
}
}



if(isset($_POST['selecbacc'])){

$msg = '';

$bank = $_POST['bank'];


$sql = "select * from bank where bank = '".$bank."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
$msg .= '<option value="'.$row['bankacc'].'">'.$row['bankacc'].'</option>';
}

		
}

		
		$status['status'] = "1";

		$status['msg'] = $msg;
		
		echo json_encode($status);	
		exit();
		
}



                          
							  
							  
if(isset($_POST['depositadmin'])){

	$id = $_POST['uid'];

	$statuss = $_POST['status'];

	$q = trim($_POST['qq']);

	

	

	

	$sql = "select * from deposit where id = $id";

	$result = $conn->query($sql);

	$row = $result->fetch_assoc();

	$ip = $row['ip'];


	$am = ($row['amount']+$row['fee']+$row['commissions']+$row['bonus']);
	
	if(preg_match('/^[a-z0-9]+$/i',$key)){
	if(strstr($row['times'],'/')){
	
	 	$tis = $row['times']; 
		 $mbtimes = str_replace('/','-',$tis);
		$mbtimes2 = str_replace((date('Y')+543),date('Y'),$mbtimes);
		$timestampp = strtotime($mbtimes2);
	 
	 }else{ 
	 
	 $timestampp = $row['added']; 
	 
	 }
	}else{
		
		 $timestampp = $added; 
	 }
	





	$sql2 = "select * from member where id = '".$row['owner']."'";

	$result2 = $conn->query($sql2);

	$member = $result2->fetch_assoc();

	if($member['webroot']=='tryscore'){ $username = $member['username']; }else{ $username = $member['username_bafo']; }

	if($row['status'] == 'pending'){

		if($statuss == 'conf'){

			#insert paylogs

			if($row['gameuser']=='moneybag'){
			
				$sql3 = "INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,status,added,added2,added3,added4,sure,toporder,q,personnel,ip,webroot,dep_bef,dep_aft) VALUES ('".$member['id']."','".$member['name']."','".$username."','".$member['phone']."','deposit','B:".$row['bank']."','MONEYBAG".$row['owner']."','".$am."','confirmed','".$timestampp."','".$row['added']."','".$added."','".$added."','1','".$row['id']."','".$q."','".$_SESSION['ps']['name']."','$ip','".$row['webroot']."','".$member['moneybag']."','".($member['moneybag']+$am)."')";
			$conn->query($sql3);
				$conn->query("update member set moneybag = moneybag+".$am.", mactive='Y' where id = ".$row['owner']." ");
			}else{
			$sql3 = "INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,status,added,added2,added3,sure,toporder,q,personnel,ip,webroot) VALUES ('".$member['id']."','".$member['name']."','".$username."','".$member['phone']."','deposit','B:".$row['bank']."','".$row['gameuser']."','".$am."','pending','".$timestampp."','".$row['added']."','".$added."','1','".$row['id']."','".$q."','".$_SESSION['ps']['name']."','$ip','".$row['webroot']."')";
			
			$conn->query($sql3);
			}

			if($row['coupon']!='0'){
			#update coupon

			$conn->query("update couponlogs set status = 'confirmed' where coupon = ".$row['coupon']." AND status='pending'");
			
			}
			
			#update deposit

			$conn->query("update deposit set status = 'confirmed' where id = $id");
			
			##insert Log##
			$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เช็คแบงค์', 'ID : $id | ยืนยันรายการ $gameuser จำนวน $am บาท หมายเหตุ $q')");
			##insert Log##


		}else{

			$sql3 = "INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,added,added2,added3,added4,sure,toporder,status,q,personnel,webroot) VALUES ('".$member['id']."','".$member['name']."','".$username."','".$member['phone']."','deposit','B:".$row['bank']."','".$row['gameuser']."','".$am."','".$timestampp."','".$row['added']."','".$added."','".$added."','1','".$row['id']."','cancle','$q','".$_SESSION['ps']['name']."','".$row['webroot']."')";

			$conn->query($sql3);

			
			if($row['coupon']!='0'){
			#update coupon

			$conn->query("update couponlogs set status = 'cancle' where coupon = ".$row['coupon']." AND status='pending'");
			$conn->query("UPDATE coupon SET owner = '0', name='',added2='' where id= ".$row['coupon']." "); 
			}
			
			$conn->query("update deposit set status = 'cancle' where id = $id");
			
		
			##insert Log##
			$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เช็คแบงค์', 'ID : $id | ยกเลิกรายการ $gameuser จำนวน $am บาท หมายเหตุ $q')");
			##insert Log##

		}

		$status['status'] = "1";

		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	

	}

}





if(isset($_POST['depok'])){

			
			

	if(!$_SESSION['ps']){

			$status['msg'] = 'ล๊อคอินเข้างานใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	



	}

	$oid = 0 + $_POST['oid'];

	$depbef = 0 + str_replace(",","",trim($_POST['depbef']));

	$depaft = 0 + str_replace(",","",trim($_POST['depaft']));

	if($depaft == 0){

		$status['status'] = 0;

		$status['msg'] = 'โปรดระบุยอดหลังทำ';

		echo json_encode($status);

		exit();			

	}

	

	$sql2 = "select * from paylogs where id = $oid";

	$result2 = $conn->query($sql2);

	

	$row = $result2->fetch_assoc();

	$amount = $row['amount'];

	$member = $row['owner'];

	$gameuser = $row['tos'];

	$perso = $row['personnel'];

	

	$sql3 = "select * from gameusers where gameuser = '".str_replace("W88:","",$gameuser)."'";

	$result3 = $conn->query($sql3);

	

	$resx = $result3->fetch_assoc();

	

				if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

					if(($depbef - $amount) != $depaft){

						$status['status'] = 0;

						$status['msg'] = 'โปรดตรวจสอบยอดหลังทำอีกครั้งเนื่องจากยอดไม่ถูกต้อง '.$depaft.'-';

						echo json_encode($status);

						exit();	

					}

				}else{	

					if(($depbef + $amount) != $depaft){

						$status['status'] = 0;

						$status['msg'] = 'โปรดตรวจสอบยอดหลังทำอีกครั้งเนื่องจากยอดไม่ถูกต้อง +';

						echo json_encode($status);

						exit();	

					}

				}

	##check euro##
		/*if($row['status']=='pending'){
		$getpoint = 0;
		$result1 = $conn->query("select giftlog,euro from member where id = '$member' ");
		$rowgift = $result1->fetch_assoc();
		$giftlog = explode("-",$rowgift['giftlog']);
		
		if($giftlog[0]==date('d')){
			if($giftlog[1]<10){
				$getpoint = 1;
				$giftpoint = $giftlog[1];
			}else{
				$getpoint = 0;
			}
		}else{
			$getpoint = 1;
			$giftpoint = 0;
		}
		
		
		if($getpoint==1){
		
		$tteuro = floor($amount/500);
		$giftpoint2 = ($giftpoint+$tteuro);
		if($giftpoint2<10){ $tteuro = $tteuro; }else{ $tteuro = (10-$giftpoint); }
		
		if($tteuro>0){
			
			$eurott = $rowgift['euro']+$tteuro;
			$eurott = floor($eurott);
			
			$conn->query("update member set euro = '".$eurott."' , giftlog = '".date('d')."-".($tteuro+$giftpoint)."' where id='$member' ");
			$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'สิทธิ์จับรางวัล', 'ID PAY : $oid | Owner : $member | จำนวนสิทธิ์คงเหลือ ".$rowgift['euro']." ได้สิทธ์เพิ่ม ".$tteuro." เป็น  ".$eurott." สิทธ์ จากการเติมเงินเข้า $gameuser จำนวน $amount บาท ')");
		}
		}
		}*/
		##check euro##
		##check euro##

	$conn->query("update paylogs set status = 'confirmed', dep_bef = '$depbef', dep_aft = '$depaft', personnel = '".$perso.",".$_SESSION['ps']['name']."', added4 = '".time()."' where id = ".$oid."");

	

	if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

					

					$sql4 = "select * from agent where provider in ('GCLUB','TBSBET','ASIA855','ROYAL1688','W88')";

	$result4 = $conn->query($sql4);

	

	while( $rowgz = $result4->fetch_assoc()){

					

						if(preg_match("#".strtolower($rowgz['name'])."#",strtolower($gameuser))){

							$conn->query("update agent set credit = '$depaft' where id = '".$rowgz['id']."'  AND provider ='".$resx['provider']."' ");

						}

					}

	}else{

		$conn->query("update gameusers set credit = '$depaft' where gameuser = '$gameuser' AND owner = $member");

	}				

		



		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : $oid | ยืนยันการฝาก $gameuser จำนวน $amount ยอดก่อน $depbef , ยอดหลัง $depaft, หมายเหตุ $q')");
		##insert Log##
		
		##check active##
		$conn->query("update member set mactive = 'Y' where id=$member ");
		##check active##
		
		
		
		$status['status'] = 1;
		//$status['msg'] = ''.$tteuro.''.$eurott.'';
		
		echo json_encode($status);

		exit();	

}



if(isset($_POST['Depcancel'])){

	

	if(!$_SESSION['ps']){

			$status['msg'] = 'ล๊อคอินเข้างานใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	



	}	

	$oid = 0 + $_POST['oid'];

	$q=trim($_POST['qq']);

	$sql2 = "select * from paylogs where id = $oid";

	$result2 = $conn->query($sql2);

	

	$row = $result2->fetch_assoc();

	$perso = $row['personnel'];

	$toporder = $row['toporder'];

	$res = $conn->query("update deposit set status = 'cancle' where id = '$toporder'");

	$conn->query("update paylogs set status = 'cancle', q = '$q', personnel = '".$perso.",".$_SESSION['ps']['name']."', added4 = '".time()."' where id = ".$oid."");

		$status['status'] = 1;


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : $oid | ยกเลิกการฝาก หมายเหตุ $q')");
		##insert Log##
		
		
		echo json_encode($status);

		exit();	

}







if(isset($_POST['TFFcheck'])){

	$oid = 0 + $_POST['oid'];

	$tffbef = 0 + str_replace(",","",trim($_POST['tffbef']));

	$tffaft = 0 + str_replace(",","",trim($_POST['tffaft']));

	$tfftnf = 0 + str_replace(",","",trim($_POST['tfftnf']));



	

	$sql1 = "select * from paylogs where id = '$oid' and transfrom = 'pending'";

	$result1 = $conn->query($sql1);

	

	$row = $result1->fetch_assoc();

	

	$member = $row['owner'];

	$gameuser = $row['froms'];

	$amount = $row['amount'];

	

			
		if($gameuser=='moneybag'.$member.''){
			$sql2 = "select * from member where id = '".$row['owner']."'";
			}else{
			$sql2 = "select * from gameusers where gameuser = '".str_replace("W88:","",$gameuser)."'";
			}

	$result2 = $conn->query($sql2);

	

	$resx = $result2->fetch_assoc();

				if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

					if(($tffbef + $amount) != $tffaft){

						$status['status'] = 0;

						$status['msg'] = 'โปรดตรวจสอบยอดหลังทำอีกครั้งเนื่องจากยอดไม่ถูกต้อง +=';

						echo json_encode($status);

						exit();

					}

				}else{

					if((($tffbef + $tfftnf) - $amount) != $tffaft){

						$status['status'] = 0;

						$status['msg'] = 'โปรดตรวจสอบยอดหลังทำอีกครั้งเนื่องจากยอดไม่ถูกต้อง+-= '.$amount.'';

						echo json_encode($status);

						exit();	

					}

				}	

	

	if($row){

	

	$conn->query("update paylogs set transfrom = 'confirmed', wd_bef = '$tffbef', wd_aft = '$tffaft', wd_trf = '$tfftnf', added2='".$added."', personnel = '".$_SESSION['ps']['name']."' where id = ".$oid."");

		if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

						

						$sql4 = "select * from agent where provider in ('GCLUB','TBSBET','ASIA855','ROYAL1688','W88')";

	$result4 = $conn->query($sql4);

	

	while( $rowgz = $result4->fetch_assoc()){

					

						

							if(preg_match("#".strtolower($rowgz['name'])."#",strtolower($gameuser))){

								$conn->query("update agent set credit = '$tffaft' where id = '".$rowgz['id']."' AND provider ='".$resx['provider']."'");

							}

						}		

		}else{

			
			if($gameuser=='moneybag'.$member.''){ 
			$conn->query("update member set moneybag = '$tffaft' where id = $member"); 
			}else{
			$conn->query("update gameusers set credit = '$tffaft' where gameuser = '$gameuser' AND owner = $member");
			}

		}

		$status['status'] = 1;
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : $oid | ยืนยันการโยกออกจาก $gameuser จำนวน $amount  ยอดก่อน $tffbef, ยอดทรานเฟอร์ $tfftnf, ยอดหลัง $tffaft,  หมายเหตุ $q')");
		##insert Log##
		
		
		echo json_encode($status);

		exit();	

	}else{

		$status['status'] = 0;

		$status['msg'] = 'รายการนี้ได้รับการยืนยันเป็นที่เรียบร้อยแล้ว';

		echo json_encode($status);

		exit();	

	}

}







if(isset($_POST['TFTcheck'])){

	$oid = 0 + $_POST['oid'];

	$tftbef = 0 + str_replace(",","",trim($_POST['tftbef']));

	$tftaft = 0 + str_replace(",","",trim($_POST['tftaft']));



	

	$sql1 = "select * from paylogs where id = $oid";

	$result1 = $conn->query($sql1);

	

	$row = $result1->fetch_assoc();

	if($row['transfrom'] == 'pending'){

		$status['status'] = 0;

		$status['msg'] = 'โปรดทำรายการและยืนยันยอดถอนให้เรียบร้อยก่อน';

		echo json_encode($status);

		exit();	

	}

	$amount = $row['amount'];

	$member = $row['owner'];

	$gameuser = $row['tos'];
	
	$gamefroms = $row['froms'];



	

	$sql2 = "select * from gameusers where gameuser = '".str_replace("W88:","",$gameuser)."'";

	$result2 = $conn->query($sql2);

	

	$resx = $result2->fetch_assoc();

				if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

					if(($tftbef - $amount) != $tftaft){

						$status['status'] = 0;

						$status['msg'] = 'โปรดตรวจสอบยอดหลังทำอีกครั้งเนื่องจากยอดไม่ถูกต้อง '.$tftbef.'-'.$amount.' -';

						echo json_encode($status);

						exit();	

					}

				}else{	

					if(($tftbef + $amount) != $tftaft){

						$status['status'] = 0;

						$status['msg'] = 'โปรดตรวจสอบยอดหลังทำอีกครั้งเนื่องจากยอดไม่ถูกต้อง +';

						echo json_encode($status);

						exit();	

					}

				}	

	

	$sql3 = "select * from paylogs where id = '$oid' and transto = 'pending'";

	$result3 = $conn->query($sql3);

	

	$rowz = $result3->fetch_assoc();

	if($rowz){	

		

		$conn->query("update paylogs set transto = 'confirmed', dep_bef = '$tftbef', dep_aft = '$tftaft' , added3='".$added."',personnel='".$row['personnel'].",".$_SESSION['ps']['name']."' where id = ".$oid."");

		

		

		if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

						

						$sql4 = "select * from agent where provider in ('GCLUB','TBSBET','ASIA855','ROYAL1688','W88')";

	$result4 = $conn->query($sql4);

	

	while( $rowgz = $result4->fetch_assoc()){

						

							if(preg_match("#".strtolower($rowgz['name'])."#",strtolower($gameuser))){

								$conn->query("update agent set credit = '$tftaft' where id = '".$rowgz['id']."' AND provider ='".$resx['provider']."'");

							}

						}

		}else{

							$conn->query("update gameusers set credit = '$tftaft' where gameuser = '$gameuser' AND owner = $member");

						}

		

		$status['status'] = 1;


##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : $oid | ยืนยันการโยกจาก ".$gamefroms." เข้า $gameuser จำนวน $amount  ยอดก่อน $tftbef, ยอดหลัง $tftaft,  หมายเหตุ $q')");
		##insert Log##
		
		
		echo json_encode($status);

		exit();	

	}else{

		$status['status'] = 0;

		$status['msg'] = 'รายการนี้ได้รับการยืนยันเป็นที่เรียบร้อยแล้ว';

		echo json_encode($status);

		exit();	

	}		

}





if(isset($_POST['TFok'])){

	

	if(!$_SESSION['ps']){

			$status['msg'] = 'ล๊อคอินเข้างานใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	



	}	

	$oid = 0 + $_POST['oid'];

	

			$sql2 = "select * from paylogs where id = '$oid' and (transto = 'pending' or transfrom = 'pending')";

			$result2 = $conn->query($sql2);

	

			$row = $result2->fetch_assoc();

	if($row){

		$status['status'] = 0;

		$status['msg'] = 'โปรดยืนยันการทำรายการ ถอนและเติมเงิน บัญชีเกมส์ ให้เรียบร้อยก่อน';

		echo json_encode($status);

		exit();		

	}

	

	$conn->query("update paylogs set status = 'confirmed', added4 = '".time()."' where id = ".$oid."");

		$status['status'] = 1;
		
		##insert Log##
		//$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : $oid | ยืนยันการโยกสำเร็จ')");
		##insert Log##
		
		echo json_encode($status);

		exit();	

}





if(isset($_POST['WDcheck'])){

	$oid = 0 + $_POST['oid'];

	$wdbef = 0 + str_replace(",","",trim($_POST['wdbef']));

	$wdaft = 0 + str_replace(",","",trim($_POST['wdaft']));	

	$wdtnf = 0 + str_replace(",","",trim($_POST['wdtnf']));

	

	

			$sql1 = "select * from paylogs where id = $oid";

			$result1 = $conn->query($sql1);

	

			$row = $result1->fetch_assoc();

			

	$member = $row['owner'];

	$gameuser = $row['froms'];

	$amount = $row['amount'];

			

			$sql2 = "select * from gameusers where gameuser = '".str_replace("W88:","",$row['froms'])."'";

			$result2 = $conn->query($sql2);

	

			$resx = $result2->fetch_assoc();

				if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

					if(($wdbef + $row['amount']) != $wdaft){

						$status['status'] = 0;

						$status['msg'] = 'โปรดตรวจสอบยอดหลังทำอีกครั้งเนื่องจากยอดไม่ถูกต้อง #'.($wdbef + $row['amount']);

						echo json_encode($status);

						exit();	

					}

				}else{

					if((($wdbef + $wdtnf) - $amount) != $wdaft){

						$status['status'] = 0;

						$status['msg'] = 'โปรดตรวจสอบยอดหลังทำอีกครั้งเนื่องจากยอดไม่ถูกต้อง';

						echo json_encode($status);

						exit();	

					}

				}	

	

	

			$sql3 = "select * from paylogs where id = '$oid' and withdrawal = 'pending'";

			$result3 = $conn->query($sql3);

	

			$rowz = $result3->fetch_assoc();

	if($rowz){

	

	$conn->query("update paylogs set withdrawal = 'confirmed', wd_bef = '$wdbef', wd_aft = '$wdaft', wd_trf = '$wdtnf', added3='".$added."' where id = ".$oid."");

	if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

					$sql4 = "select * from agent where provider in ('GCLUB','TBSBET','ASIA855','ROYAL1688','W88')";

	$result4 = $conn->query($sql4);

	

	while( $rowgz = $result4->fetch_assoc()){

						if(preg_match("#".strtolower($rowgz['name'])."#",strtolower($row['froms']))){

							$conn->query("update agent set credit = '$wdaft' where id = '".$rowgz['id']."' AND provider ='".$resx['provider']."'");
$conn->query("update gameusers set credit = '$wdaft' where gameuser = '$gameuser' AND owner = $member");

						}

					}		

	}else{

		$conn->query("update gameusers set credit = '$wdaft' where gameuser = '$gameuser' AND owner = $member");

	}

		$status['status'] = 1;



##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : $oid | ยืนยันการถอนออก ".$gameuser." จำนวน $amount  ยอดก่อน $wdbef, ยอดทราน $wdtnf, ยอดหลัง $wdaft,  หมายเหตุ $q')");
		##insert Log##
		
		
		
		echo json_encode($status);

		exit();	

	}else{

		$status['status'] = 0;

		$status['msg'] = 'รายการนี้ได้รับการยืนยันเป็นที่เรียบร้อยแล้ว';

		echo json_encode($status);

		exit();	

	}

}





if(isset($_POST['WDok'])){


	if(!$_SESSION['ps']){

			$status['msg'] = 'ล๊อคอินเข้างานใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	



	}	

	$oid = 0 + $_POST['oid'];

	$frombank = trim($_POST['frombank']);

	$q = trim($_POST['qq']);

	

	$sql2 = "select * from paylogs where id = '$oid' and withdrawal = 'pending'";

			$result2 = $conn->query($sql2);

	

			$row = $result2->fetch_assoc();

	if($row){

		$status['status'] = 0;

		$status['msg'] = 'โปรดยืนยันการทำรายการ ถอนเงินจาก บัญชีเกมส์ ให้เรียบร้อยก่อน';

		echo json_encode($status);

		exit();		

	}

	

	$conn->query("update paylogs set status = 'confirmed', frombank = '$frombank', q = '$q', personnel = '".$_SESSION['ps']['name']."', added4 = '".time()."' where id = ".$oid."");

		$status['status'] = 1;



##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'โอนเงิน', 'ID : $oid | ยืนยันการถอน $oid เข้า ".$frombank." ')");
		##insert Log##
		
		
		
		echo json_encode($status);

		exit();	

}



if(isset($_POST['WDcancel'])){

	

	if(!$_SESSION['ps']){

			$status['msg'] = 'ล๊อคอินเข้างานใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	



	}	

	$oid = 0 + $_POST['oid']; 

	

	$conn->query("update paylogs set status = 'cancle', personnel = '".$_SESSION['ps']['name']."', added4 = '".time()."' where id = ".$oid."");

		$status['status'] = 1;



##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'โอนเงิน', 'ID : $oid | ยกเลิกโอนเงิน')");
		##insert Log##
		
		
		
		echo json_encode($status);

		exit();	

}



if(isset($_POST['Depcancel'])){

	

	if(!$_SESSION['ps']){

			$status['msg'] = 'ล๊อคอินเข้างานใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	



	}	

	$oid = 0 + $_POST['oid'];

	$q=trim($_POST['qq']);

	$sql2 = "select * from paylogs where id = '$oid'";

			$result2 = $conn->query($sql2);

	

			$row = $result2->fetch_assoc();

	$toporder = $row['toporder'];

	$res = $db->query("update deposit set status = 'cancle' where id = '$toporder'");

	

	$conn->query("update paylogs set status = 'cancle', q = '$q', personnel = '".$_SESSION['ps']['name']."', added4 = '".time()."' where id = ".$oid."");

		$status['status'] = 1;



##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เช็คแบงค์', 'ID : $oid | ยกเลิกเช็คแบงค์')");
		##insert Log##
		
		
		
		echo json_encode($status);

		exit();	

}







#เริ่ม รอทำรายการ เปิดบัญชีใหม่#

if(isset($_POST['savenewgameusr'])){

	$gameusr = trim($_POST['gameusr']);

	$oid = 0 + $_POST['oid'];

	

	$sql1 = "select * from paylogs where id = '$oid'";

	$result1 = $conn->query($sql1);

	$row = $result1->fetch_assoc();

	

	$gp = explode(":",$row['tos']);

	$provider = $gp[1];

	$owner = $row['owner'];

	$name = $row['name'];

	$username = $row['username'];

	$phone = $row['phone'];



	if($gameusr == ''){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุบัญชีเกมส์";

		echo json_encode($status);

		exit();

	}



	

	$sql2 = "select * from gameusers where gameuser = '$gameusr' AND owner != '$owner'";

	$result2 = $conn->query($sql2);

	$ck = $result2->fetch_assoc();

	

	if($ck){

		$status['status'] = "0";

		$status['msg'] = "บัญชีเกมส์นี้ มีอยู่ในระบบ แล้ว";

		echo json_encode($status);

		exit();

	}

	

	

	$sql3 = "select * from gameusers where gameuser = '$gameusr' AND owner = '$owner'";

	$result3 = $conn->query($sql3);

	$ckz = $result3->fetch_assoc();

	

	if($ckz){

		

		$conn->query("update paylogs set tos = '$gameusr' where id = ".$oid."");

		$status['status'] = "1";



		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : No | Owner : $owner | PayID : $oid | อัพเดทบัญชีเกมส์ $gameusr')");
		##insert Log##
		
		
		
		echo json_encode($status);

		exit();

	}



	$rowid = $conn->query("INSERT INTO gameusers (owner, gameuser, provider, added) VALUES ('$owner','$gameusr','$provider','".time()."')");
	$insertid = $conn->insert_id;
	if($rowid){

		$conn->query("update paylogs set tos = '$gameusr' where id = ".$oid."");

		$status['status'] = "1";




##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : $insertid | Owner : $owner | PayID : $oid | เพิ่มบัญชีเกมส์ $gameusr')");
		##insert Log##
		
		
		
		
		echo json_encode($status);

		exit();

	}else{

		$status['status'] = "0";

		$status['msg'] = "เกิดข้อผิดพลาดโปรดลองใหม่อีกครั้ง";

		echo json_encode($status);

		exit();

	}

}

#จบ รอทำรายการ เปิดบัญชีใหม่#





if(isset($_POST['sendaddgameuser'])){

	$mid = 0 + $_POST['mid'];

	$gameprovider = $_POST['provider'];

	$gameuser = $_POST['gameuser'];

	

	

	$sql2 = "select * from gameusers where gameuser = '$gameuser'";

	$result2 = $conn->query($sql2);

	$ck = $result2->fetch_assoc();

	

	if($ck){

		$status['status'] = "0";

		$status['msg'] = "บัญชีเกมส์นี้ มีอยู่ในระบบ แล้ว";

		echo json_encode($status);

		exit();

	}

	

	if(empty($gameprovider)){

		$status['status'] = "0";

		$status['msg'] = "โปรดเลือกค่ายเกมส์";

		echo json_encode($status);

		exit();

	}

	

	if(empty($gameuser)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุบัญชีเกมส์";

		echo json_encode($status);

		exit();

	}

	

	if(empty($mid)){

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

		echo json_encode($status);

		exit();

	}

	

	$rowid = $conn->query("INSERT INTO gameusers (owner, gameuser,provider,added) VALUES ('$mid','$gameuser','$gameprovider','".time()."')");
	$insertid = $conn->insert_id;
	if($rowid){

		$status['status'] = "1";




##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $insertid | owner : $mid | เพิ่มบัญชีเกมส์ $gameuser ค่าย $gameprovider')");
		##insert Log##
		
		
		
		
		
		$status['msg'] = "เพิ่มบัญชีเกมส์ลูกค้าใหม่เรียบร้อย";

		echo json_encode($status);

		exit();

	}	

}





if(isset($_POST['sendchcredit'])){

	$chcredit = str_replace(",","",trim($_POST['chcredit']));

	$chcreditid = trim($_POST['chcreditid']);

	$chcredittype = trim($_POST['chcredittype']);

	$chcreditstyle = trim($_POST['chcreditstyle']);

	$chcreditbefore = 0 + str_replace(",","",trim($_POST['chcreditbefore']));

	$chcreditq = trim($_POST['chcreditq']);

	

	

	if(!$_SESSION['ps']){

			$status['msg'] = 'ล๊อคอินเข้างานใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	



	}	

	

	if($chcredit == 0){

			$status['msg'] = 'โปรดระบุยอดที่ทำรายการด้วย';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}

	if(empty($chcreditid) or empty($chcredittype) or empty($chcreditstyle)){

			$status['msg'] = 'ข้อมูลถูกส่งมาไม่ครบลองรีเฟชรหน้าแล้วทำรายการใหม่';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}

	

	

	$sql2 = "select * from agent where id = '$chcreditid'";

	$result2 = $conn->query($sql2);

	

	$row = $result2->fetch_assoc();

	if(!$row){

			$status['msg'] = 'ข้อมูลถูกส่งมาไม่ครบลองรีเฟชรหน้าแล้วทำรายการใหม่';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}

	

	$agentname = $row['name'];

	$provider = $row['provider'];

	$rowid = $conn->query("INSERT INTO agentlogs (name,provider,credit,beforecredit,tables,types,added,personnel,q) VALUES ('$agentname','$provider','$chcredit','$chcreditbefore','$chcreditstyle','$chcredittype','".time()."','".$_SESSION['ps']['name']."','$chcreditq')");

	if($rowid){

		if($chcredittype == 'plus'){
			$logam = $chcreditbefore + $chcredit;
			$conn->query("update agent set $chcreditstyle = $chcreditstyle + $chcredit, updates = '".time()."' where id = '$chcreditid'");

		}else{
			$logam = $chcreditbefore - $chcredit;
			$conn->query("update agent set $chcreditstyle = $chcreditstyle - $chcredit, updates = '".time()."' where id = '$chcreditid'");

		}	

		$status['status'] = "1";



		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'บัญชีเอเย่น', 'ID : $chcreditid | $chcreditstyle:$agentname $chcredittype $chcredit ก่อนเติม $chcreditbefore หลังเติม $logam หมายเหตุ:$chcreditq ')");
		##insert Log##
		
		
		
		$status['msg'] = "ทำรายการเรียบร้อย";

		echo json_encode($status);

		exit();

	}else{

			$status['msg'] = 'ไม่สามารถทำรายการได้ โปรดลองใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}	

}







if(isset($_POST['sendaddagent'])){

	$provider = trim($_POST['provider']);

	$agnetid = trim($_POST['agnetid']);

	$agentcredit = 0 + str_replace(",","",trim($_POST['agentcredit']));

	$agentbalance = 0 + str_replace(",","",trim($_POST['agentbalance']));

	$agenttype = trim($_POST['agenttype']);

	if(empty($provider) or empty($agnetid) or empty($agenttype)){

			$status['msg'] = 'โปรดระบุข้อมูลให้ครบทุกช่อง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();

	}

	

	$rowid = $conn->query("INSERT INTO agent (name,provider,credit,balance,types) VALUES ('$agnetid','$provider','$agentcredit','$agentbalance','$agenttype')");
$insertid = $conn->insert_id;
	if($rowid){

		$status['status'] = "1";



		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'บัญชีเอเย่น', 'ID : $insertid | เพิ่มบัญชีเอเย่น $agnetid, $provider, $agentcredit, $agentbalance, $agenttype')");
		##insert Log##
		
		
		
		$status['msg'] = "เพิ่มบัญชีเอเย่นใหม่เรียบร้อย";

		echo json_encode($status);

		exit();

	}		

}



if(isset($_POST['TFcancel'])){

	$oid = 0 + $_POST['oid'];

	$sql2 = "select * from paylogs where id = '$oid'";

	$result2 = $conn->query($sql2);

	$row = $result2->fetch_assoc();
	
	$sql3 = "select * from member where id = '".$row['owner']."'";

	$result3 = $conn->query($sql3);

	$row3 = $result3->fetch_assoc();
	
	if($row['transfrom']=='confirmed'){
		if(strstr($row['tos'],'W88:')){
			if($row['amount']=='42'){ $tamount = '45'; }
			if($row['amount']=='76'){ $tamount = '81'; }
			if($row['amount']=='127'){ $tamount = '135'; }
			if($row['amount']=='255'){ $tamount = '270'; }
			if($row['amount']=='425'){ $tamount = '450'; }
			if($row['amount']=='850'){ $tamount = '900'; }
		}else{
		 	$tamount = $row['amount'];
		}
		$conn->query("update member set moneybag = '".($tamount+$row3['moneybag'])."' where id = '".$row['owner']."' ");
	}
	
	$conn->query("update paylogs set status = 'cancle' ,added4 = '".$added."' where id = $oid");
	
		$status['status'] = 1;



		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID : $oid | ยกเลิกรายการโยก')");
		##insert Log##
		
		
		
		echo json_encode($status);

		exit();	

}


if(isset($_POST['saveeditcredit'])){

	

	if(!$_SESSION['ps']){

			$status['msg'] = 'ล๊อคอินเข้างานใหม่อีกครั้ง';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	



	}

	$gameid = 0 + trim($_POST['gameid']);

	$credit = 0 + str_replace(",","",trim($_POST['credit']));

	

	$sql2 = "select * from gameusers where id = '$gameid'";

	$result2 = $conn->query($sql2);

	

	$row = $result2->fetch_assoc();

	

	$oldcredit = $row['credit'];

	$owner = $row['owner'];

	

	$sql3 = "select * from member where id = '$owner'";

	$result3 = $conn->query($sql3);

	

	$member = $result3->fetch_assoc();

	

	$name = $member['name'];

	$username = $row['gameuser'];

	$amount = str_replace("-", "", ($oldcredit - $credit));

	$q = trim($_POST['qq']);

	$rowid = $conn->query("INSERT INTO paylogs (owner,name,username,phone,types,froms,tos,amount,added,added4,status,dep_bef,dep_aft,q,personnel) VALUES ('$owner','$name','".$member['username']."','$phone','change','$username','$username','$amount','".time()."','".time()."','confirmed','$oldcredit','$credit','$q','".$_SESSION['ps']['name']."')");

	if($gameid){

		$res=$conn->query("update gameusers set credit = '$credit' where id = '$gameid'");

		if($res){

			$status['credit'] = $credit;

			$status['status'] = 1;



		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $gameid จำนวน $amount  ก่อนปรับ $oldcredit หลังปรับ $credit')");
		##insert Log##
		
		
		
			echo json_encode($status);

			exit();	

		}else{

			$status['msg'] = 'เกิดข้อผิดพลาดไม่สามารถอัพเดทข้อมูลได้';

			$status['status'] = 0;

			echo json_encode($status);

			exit();	

		}

	}

}






if(isset($_POST['saveeditmember'])){

	$mid = 0 + $_POST['mid'];

	$name = $_POST['name'];

	$phone = $_POST['phone'];
	
	$phoneold = $_POST['phoneold'];

	$username = $_POST['username'];

	$bankname = $_POST['bankname'];

	$banknumber = $_POST['banknumber'];
	
	$edittm = $_POST['edittm'];
	
	$edittm88 = $_POST['edittm88'];
	
	$webrootin = $_POST['webroot'];

	

	if(empty($name)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุชื่อบัญชี";

		echo json_encode($status);

		exit();

	}

	

	if(empty($username)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุ ชื่อบัญชีเข้าใช้งาน";

		echo json_encode($status);

		exit();		

	}

	

	if(empty($bankname)){

		$status['status'] = "0";

		$status['msg'] = "โปรดเลือกธนาคารของลูกค้า";

		echo json_encode($status);

		exit();		

	}

	



	$sql2 = "select * from member where (phone = '$phoneold' or banknumber = '$banknumber' or username = '$username') AND webroot='$webrootin' and id != '$mid'";

	$result2 = $conn->query($sql2);

	

	$ck = $result2->fetch_assoc();

	if($ck){

		$status['status'] = "0";

		$status['msg'] = "บัญชีใช้งาน เบอร์โทร หรือ เลขบัญชีธนาคารนี้ มีในระบบแล้ว";

		echo json_encode($status);

		exit();

	}
	


	$sql3 = "select * from member where id = '$mid'";

	$result3 = $conn->query($sql3);
	$ck3 = $result3->fetch_assoc();
		
		

if(strstr($phone,"XXXXX"))
{
  $phone=$ck3['phone'];
}


	$res = $conn->query("update member set name = '$name', phone = '$phone', username='$username' , bankname = '$bankname', banknumber = '$banknumber' ,tmlimit = '$edittm' ,tm88limit = '$edittm88' where id = '$mid'");
	
	if($webrootin=='bafobet'){
	$cbaf = new mysqli($servername2, $username2, $password2, $dbname2);
	$cbaf -> query("SET names utf8");
	$cbaf->query("update members set tel = '$phone', username='$username' where mainid = '$mid'");
	}

	if($res){

		$status['status'] = "1";



		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $mid | แก้ไขข้อมูลสมาชิก (ก่อนเปลี่ยน ชื่อ:".$ck3['name']." เบอร์:".$ck3['phone']." username:".$ck3['username']." บัญชีธนาคาร:".$ck3['bankname']." เลขที่บัญชี:".$ck3['banknumber'].") | (หลังเปลี่ยน ชื่อ:".$name." เบอร์:".$phone." username:".$username." บัญชีธนาคาร:".$bankname." เลขที่บัญชี:".$banknumber.")')");
		##insert Log##
		
		
		
		$status['msg'] = "บักทึกข้อมูลใหม่เรียบร้อย";

		echo json_encode($status);

		exit();	

	}else{

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถทำรายการได้ #ข้อมูลไม่เปลี่ยน";

		echo json_encode($status);

		exit();		

	}

}







if(isset($_POST['editmember'])){

	$mid = 0 + $_POST['mid'];

	if($mid){

		

		$sql2 = "select * from member where id = '$mid'";

		$result2 = $conn->query($sql2);

	

		$row = $result2->fetch_assoc();
		
		if($row['webroot']=='tryscore'){
			$username = $row['username'];
		}else{
			$username = $row['username'];
		}
		
		
		$data = '
		

		  <div class="modal-header">

			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

			<h4 class="modal-title">แก้ใขบัญชีคุณ '.$row['name'].'</h4>

		  </div>

		  <div class="modal-body">

			<div id="saveeditmember_msg"></div>

				<form class="form-horizontal"><input type="hidden" id="webroot" name="webroot" value="'.$row['webroot'].'">

						  <div class="form-group" style="margin-top:10px;">

							<label class="col-md-3 control-label" for="editname">ชื่อ - นามสกุล</label>

							<div class="col-md-7"><input type="text" id="editname" name="editname" value="'.$row['name'].'" class="form-control input-small" placeholder=""></div>

						  </div>	



						  <div class="form-group">

							<label class="col-md-3 control-label" for="editphone">เบอร์โทร</label>

							<div class="col-md-4"><input type="text" id="editphone" name="editphone" value="0XXXXX'.substr($row['phone'], 6, 4).'" class="form-control input-small" placeholder="">
							<input type="hidden" id="editphone_old" name="editphone_old" value="'.$row['phone'].'" class="form-control input-small" placeholder="">
							</div>

						  </div>	



						  <div class="form-group">

							<label class="col-md-3 control-label" for="editusername">บัญชีเข้าใช้งาน</label>

							<div class="col-md-4"><input type="text" id="editusername" name="editusername" value="'.$username.'" class="form-control input-small" placeholder=""></div>

						  </div>	



						  <div class="form-group">

							<label class="col-md-3 control-label" for="editbankname">ธนาคารลูกค้า</label>

							<div class="col-md-4">

											<select id="editbankname" name="editbankname" class="form-control input-small">

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

						  </div>	

						  

						  <div class="form-group" style="margin-top:10px;">

							<label for="editbanknumber" class="col-xs-3 col-md-3 control-label">เลขบัญชีธนาคาร</label>

							<div class="col-xs-7 col-md-7"><input type="text" id="editbanknumber" name="editbanknumber" value="'.$row['banknumber'].'" maxlength="12" class="form-control input-small" data-toggle="tooltip" title="ระบุเลขบัญชีเป็นตัวเลขเท่านั้น ใช้สำหรับรับเงิน" placeholder="โปรดระบุ">

							</div>

						  </div>			
						  
						  
						   <div class="form-group" style="margin-top:10px;">

							<label for="editbanknumber" class="col-xs-3 col-md-3 control-label">จำกัดการเติมTMต่อวัน</label>

							<div class="col-xs-7 col-md-7"><input type="text" id="edittm" name="edittm" value="'.$row['tmlimit'].'" maxlength="12" class="form-control input-small" data-toggle="tooltip" title="" placeholder="โปรดระบุ">

							</div>

						  </div>			
						  
						  
						  
						   <div class="form-group" style="margin-top:10px;">

							<label for="editbanknumber" class="col-xs-3 col-md-3 control-label">จำกัดการเติมTM W88 ต่อวัน</label>

							<div class="col-xs-7 col-md-7"><input type="text" id="edittm88" name="edittm88" value="'.$row['tm88limit'].'" maxlength="12" class="form-control input-small" data-toggle="tooltip" title="" placeholder="โปรดระบุ">

							</div>

						  </div>					  

						  

				</form>

		  </div>

		  <div class="modal-footer">

			<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

			<button type="button" class="btn btn-primary" id="saveeditmember" onClick="saveeditmember(\''.$row['id'].'\')"><span class="glyphicon glyphicon-floppy-saved"></span> บันทึก</button>

		  </div>	

		';

		$bank = $row['bankname'];

			$status['status'] = "1";

			$status['html'] = $data;

			$status['bank'] = $bank;

			echo json_encode($status);

			exit();			

	}else{

			$status['status'] = "0";

			$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

			echo json_encode($status);

			exit();	

	}

}



if(isset($_POST['sendchpass'])){

	$mid = 0 + $_POST['mid'];

	$chpass = $_POST['chpass'];

	if(!empty($mid) AND !empty($chpass)){

		
		$sql1 = "select * from member where id = '".$mid."' ";
		$result1 = $conn->query($sql1);
		$x = $result1->fetch_assoc();

		$res = $conn->query("update member set password = '".MD5($chpass)."' where id = '$mid'");
		
		if($x['webroot']=='bafobet'){
		$cbaf = new mysqli($servername2, $username2, $password2, $dbname2);
		$cbaf -> query("SET names utf8");
		$cbaf->query("update members set password='".$chpass."' where mainid = '$mid'");
		}
		
		if($res){

			$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $mid | แก้ไขรหัสผ่าน')");
		##insert Log##
		
		
			$status['msg'] = "บันทึกรหัสผ่านใหม่เรียบร้อย";

			echo json_encode($status);

			exit();	

		}else{

			$status['status'] = "0";

			$status['msg'] = "รหัสผ่านไม่ถูกเปลี่ยน เนื่องจาก ซ้ำของเดิม";

			echo json_encode($status);

			exit();	

		}

	}else{

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

		echo json_encode($status);

		exit();	

	}

}





if(isset($_POST['sendaddq'])){

	$mid = 0 + $_POST['mid'];

	$q = $_POST['q'];

	

	if(empty($mid)){

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

		echo json_encode($status);

		exit();

	}	



	if(empty($q)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุข้อความ";

		echo json_encode($status);

		exit();

	}

	

	$rowid = $conn->query("INSERT INTO q (owner, q, added) VALUES ('$mid', '$q', '".time()."')");
	$insertid = $conn->insert_id;
	if($rowid){

		$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $insertid | Owner : $mid | เพิ่มหมายเหตุ : $q')");
		##insert Log##
		
		
		
		$status['msg'] = "เพิ่มข้อความลูกค้าใหม่เรียบร้อย";

		echo json_encode($status);

		exit();

	}		

	

}





if(isset($_POST['delgameuser'])){

	$mid = 0 + $_POST['mid'];

	if($mid != 0){

		$sql1 = "select * from gameusers where id = '$mid'";
		$result1 = $conn->query($sql1);
		$x = $result1->fetch_assoc();
		
		$row = $conn->query("DELETE FROM gameusers where id = '$mid'");

		if($row){

			$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $mid | Owner : ".$x['owner']." | ลบบัญชีเกมส์ ".$x['provider'].":".$x['gameuser']." เครดิตคงเหลือ ".$x['credit']."')");
		##insert Log##
		
		
			echo json_encode($status);

			exit();

		}else{

			$status['status'] = "0";

			$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

			echo json_encode($status);

			exit();					

		}

	}else{

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

		echo json_encode($status);

		exit();		

	}

}





if(isset($_POST['delq'])){

	$mid = 0 + $_POST['mid'];

	if($mid != 0){
		$sql1 = "select * from q where id = '$mid'";
		$result1 = $conn->query($sql1);
		$x = $result1->fetch_assoc();
		
		$row = $conn->query("DELETE FROM q where id = '$mid'");

		if($row){

			$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $mid | ลบหมายเหตุ ข้อความ:".$x['q']."')");
		##insert Log##
		
		
			echo json_encode($status);

			exit();

		}else{

			$status['status'] = "0";

			$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

			echo json_encode($status);

			exit();					

		}

	}else{

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

		echo json_encode($status);

		exit();		

	}

}





if(isset($_POST['delmember'])){

	$mid = 0 + $_POST['mid'];

	if($mid != 0){
		
		$sql1 = "select * from member where id = '$mid'";
		$result1 = $conn->query($sql1);
		$ck3 = $result1->fetch_assoc();
		
		$sql2 = "select * from gameusers where owner = '$mid'";
		$result2 = $conn->query($sql2);
		$cont ='';
		while($ck2 = $result2->fetch_assoc()){
		$cont .="".$ck2['provider'].":".$ck2['gameuser']."  คงเหลือ".$ck2['credit']." | ";
		}
		
		$row = $conn->query("DELETE FROM member where id = '$mid'");

		if($row){

			$conn->query("DELETE FROM gameusers where owner = '$mid'");	

			$status['status'] = "1";

		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $mid | ลบข้อมูลสมาชิก ( ชื่อ:".$ck3['name']." เบอร์:".$ck3['phone']." username:".$ck3['username']." บัญชีธนาคาร:".$ck3['bankname']." เลขที่บัญชี:".$ck3['banknumber'].") บัญชีเกมส์ ( $cont )')");
		##insert Log##
		
			echo json_encode($status);

			exit();

		}else{

			$status['status'] = "0";

			$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

			echo json_encode($status);

			exit();					

		}

	}else{

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถทำรายการได้ ลองรีเฟชร หน้านี้ แล้วลองใหม่อีกครั้ง";

		echo json_encode($status);

		exit();		

	}

}





if(isset($_POST['getmemberdetail'])){

	$mid = 0 + $_POST['mid'];

	$data = '';

	

	$sql1 = "select * from gameusers where owner = '$mid'";

	$result1 = $conn->query($sql1);

	

	if ($result1->num_rows > 0) {

	

		$data .= '

	

			<div class="col-xs-6">

			<h4>บัญชีเกมส์</h4>

			<table class="table table-bordered" id="editgameusertable" style="margin-top:10px;">

						<tbody>

						  <tr>

							<td class="active">ค่าย</td>

							<td class="active">บัญชีเกมส์</td>

							<td class="active">เครดิตล่าสุด</td>

							<td class="active">เพิ่มเมื่อ</td>

							<td class="active">Action</td>

						  </tr>

						</tbody>

						<tbody id="gameuserlist">		

		';

		while($x = $result1->fetch_assoc()) {

			$data .= '



							  <tr id="gameuser_'.$x['id'].'">

								<td>'.$x['provider'].'</td>

								<td><span class="label label-default">'.strtoupper($x['gameuser']).'</span></td>

								<td id="td_credit_'.$x['id'].'"><span class="label label-success">'.$x['credit'].'</span> <span onclick="editcredit(\''.$x['credit'].'\',\''.$x['id'].'\')" class="glyphicon glyphicon-edit" style="cursor:pointer;"></span></td>

								<td>'.date("d-m-Y H:i:s",$x['added']).'</td>

								<td><a href="javascript:;" onClick="delgameuser(\''.$x['id'].'\')" class="btn btn-danger btn-xs" title="ลบ"><span class="glyphicon glyphicon-trash"></span></a></td>

							  </tr>		

			';

		}

		$data .= '

							</tbody>

			</table>			

			</div>			

		';

	}

	

	

  

	$sql2 = "select * from q where owner = '$mid' order by added";

	$result2 = $conn->query($sql2);

	$data .= '

			<div class="col-xs-6">
			';

	if ($result2->num_rows > 0) {

			

		$data .= '

			

			<h4>หมายเหตุ</h4>

			<table class="table table-bordered" id="editqusertable" style="margin-top:10px;">

						<tbody>

						  <tr>

							<td class="active">ข้อความ</td>

							<td class="active">เพิ่มเมื่อ</td>
							
							<td class="active">แสดงตอนทำรายการ</td>

							<td class="active">Action</td>

						  </tr>

						</tbody>

						<tbody id="quserlist">		

		';

		while($x = $result2->fetch_assoc()) {

		if($x['status']=='1'){ $checs = 'checked="checked"'; }else{ $checs = ''; }
			$data .= '



							  <tr id="q_'.$x['id'].'">

								<td>'.$x['q'].'</td>

								<td>'.date("d-m-Y H:i:s",$x['added']).'</td>
								
								<td><input name="showq_'.$x['id'].'" id="showq_'.$x['id'].'" '.$checs.'  type="checkbox" value="1" onClick="membershowq(\''.$x['id'].'\')"  /></td>

								<td><a href="javascript:;" onClick="delq(\''.$x['id'].'\')" class="btn btn-danger btn-xs" title="ลบ"><span class="glyphicon glyphicon-trash"></span></a></td>

							  </tr>		

			';

		}

		$data .= '

							</tbody>

			</table>			


			
				

		';

	}
	
	
	

	$sql2 = "select * from fileslip where owner = '$mid' order by added";

	$result2 = $conn->query($sql2);

	

	if ($result2->num_rows > 0) {

			

		$data .= '


			<h4>ไฟล์สลิป</h4>

			<table class="table table-bordered" id="editqusertable" style="margin-top:10px;">

						<tbody>

						  <tr>

							<td class="active">วันที่</td>

							<td class="active">เรียดดู</td>

							<td class="active">พนักงาน</td>

						  </tr>

						</tbody>

						<tbody id="quserlist">		

		';

		while($x = $result2->fetch_assoc()) {

		if($x['status']=='1'){ $checs = 'checked="checked"'; }else{ $checs = ''; }
		
		
		

$data .= '<div class="modal fade" id="openfilebox_'.$x['id'].'">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-body">
			
			<center><img src="uploads/'.$x['filename'].'" width="300" />	</center>	

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>

      </div>

    </div>

  </div>

</div>

<!-- chpassuser -->';


			$data .= '



							  <tr id="q_'.$x['id'].'">

								<td>'.date("d-m-Y H:i:s",$x['added']).'</td>
								
								<td><a href="javascript:;" data-toggle="modal" data-target="#openfilebox_'.$x['id'].'" class="btn btn-info pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-upload"></span> <span class="modal-title">เรียกดู</span></a></td>

								<td>'.$x['personnel'].'</td>

							  </tr>		

			';

		}

		$data .= '

							</tbody>

			</table>			
		

		';

	}

	$data .= '
			</div>			

		';

	if($data == ''){

		$status['status'] = "0";

		echo json_encode($status);

		exit();

	}else{

		$status['status'] = "1";

		$status['html'] = $data;

		echo json_encode($status);

		exit();		

	}

}



if(isset($_POST['addpersonnelacc'])){

	$name = trim($_POST['name']);

	$username = trim($_POST['username']);

	$password = trim($_POST['password']);

	if(empty($name)){

		$status['status'] = "0";

		$status['msg'] = "ยังไม่ระบุชื่อเล่น";

		echo json_encode($status);

		exit();

	}



	if(empty($username)){

		$status['status'] = "0";

		$status['msg'] = "ยังไม่ระบุบัญชีเข้าใช้งาน";

		echo json_encode($status);

		exit();

	}



	if(empty($password)){

		$status['status'] = "0";

		$status['msg'] = "ยังไม่ได้ตั้งรหัสเข้าใช้งาน";

		echo json_encode($status);

		exit();

	}

	$added = time();

	$rowid = $conn->query("INSERT INTO personnel (name,username,password,added,classs) VALUES (

			'$name',

			'$username',

			'$password',

			'$added',

			'Personnel')");
$insertid = $conn->insert_id;
	if($rowid){

		$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อพนักงาน', 'ID : $insertid | เพิ่มบัญชีพนักงานใหม่ (ชื่อ:$name Username:$username)')");
		##insert Log##
		
		
		echo json_encode($status);

		exit();

	}else{

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถเพิ่มบัญชีใหม่ได้";

		echo json_encode($status);

		exit();

	}

}

if(isset($_POST['savepersonnels'])){

	$id = 0 + trim($_POST['uid']);

	$name = trim($_POST['name']);

	$username = trim($_POST['username']);

	$password = trim($_POST['password']);

	if(empty($name)){

		$status['status'] = "0";

		$status['msg'] = "ยังไม่ระบุชื่อเล่น";

		echo json_encode($status);

		exit();

	}



	if(empty($username)){

		$status['status'] = "0";

		$status['msg'] = "ยังไม่ระบุบัญชีเข้าใช้งาน";

		echo json_encode($status);

		exit();

	}



	if(empty($password)){

		$status['status'] = "0";

		$status['msg'] = "ยังไม่ได้ตั้งรหัสเข้าใช้งาน";

		echo json_encode($status);

		exit();

	}



	$rowid = $conn->query("update personnel set name = '$name', username = '$username', password = '$password' where id = $id");



	if($rowid){

		$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อพนักงาน', 'ID : $id | แก้ไขบัญชีพนักงาน (ชื่อ:$name Username:$username)')");
		##insert Log##
		
		
		$status['msg'] = "บันทึกการแก้ใขเรียบร้อย";

		echo json_encode($status);

		exit();

	}else{

		$status['status'] = "0";

		$status['msg'] = "ไม่สามารถบันทึกบัญชีใหม่ได้";

		echo json_encode($status);

		exit();

	}

}



if(isset($_POST['delpersonnel'])){

	$id = 0 + trim($_POST['uid']);

	
	$sql = "select * from personnel where id = $id";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	if($row){

		$s = $conn->query("DELETE FROM personnel where id = $id");

		if($s){

				$status['status'] = "1";


##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อพนักงาน', 'ID : $id | ลบบัญชีพนักงาน (ชื่อ:".$row['name']." Username:".$row['username'].")')");
		##insert Log##
		
		
				echo json_encode($status);

				exit();

		}else{

				$status['status'] = "0";

				$status['msg'] = 'เกิดข้อผิดพลาดไม่สามารถลบ รายการนี้ได้';

				echo json_encode($status);

				exit();

		}

	}else{

				$status['status'] = "0";

				$status['msg'] = 'ไม่พบบีญชีใช้งานนี้';

				echo json_encode($status);

				exit();

	}

}





if(isset($_POST['editpersonnel'])){

	$id = 0 + trim($_POST['uid']);

	
	$sql = "select * from personnel where id = $id";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

		$detail = '

				  <div class="modal-header">

					<h4><span class="glyphicon glyphicon-pencil"></span> แก้ใขบัญชีพนักงาน</h4>

				  </div>

				  <div class="modal-body">

						<div id="personnel_msg"></div>



						<form class="form-horizontal">



						  <div class="form-group">

							<label class="col-md-4 control-label" for="username">ชื่อเล่น</label>

							<div class="col-md-7">

							  <input type="text" class="form-control input-small" id="personnelname" value="'.$row['name'].'" placeholder="ระบุ ชื่อเล่น พนักงาน" required>

							</div>

						  </div>



						  <div class="form-group">

							<label class="col-md-4 control-label" for="username">ชื่อบัญชี</label>

							<div class="col-md-7">

							  <input type="text" class="form-control input-small" id="personnelusername" value="'.$row['username'].'" placeholder="ระบุ ชื่อบัญชี พนักงาน" required>

							</div>

						  </div>



						  <div class="form-group">

							<label class="col-md-4 control-label" for="inputPassword">รหัสผ่านบัญชี พนักงาน</label>

							<div class="col-md-7">

							  <input type="password" class="form-control input-small" id="personnelpassword" value="'.$row['password'].'" placeholder="ระบุ รหัสผ่านบัญชี พนักงาน" required>

							</div>

						  </div>

						</form>



				  </div>

				  <div class="modal-footer">

					<a href="#" class="btn btn-default btn-small" data-dismiss="modal" aria-hidden="true">Close</a>

					<a href="#" class="btn btn-primary btn-small" onClick="savepersonnels(\''.$row['id'].'\')">บันทึกแก้ใข</a>

				  </div>

		';

		$status['status'] = "1";

		$status['html'] = $detail;

		echo json_encode($status);

		exit();

}


if(isset($_POST['sendnewtmid'])){

	$tmid = trim($_POST['tmid']);

	$key = trim($_POST['keys']);

	if(empty($tmid) or empty($key)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุข้อมูลให้ครบถ้วน";

		echo json_encode($status);

		exit();

	}

		$rowid = $conn->query("INSERT INTO tmtopup (tmid, keyz) VALUES ('$tmid', '$key')");
		$insertid = $conn->insert_id;
		if($rowid){

			$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'การตั้งค่า', 'ID : $insertid | เพิ่มบัญชี TMTOPUP (TM:".$tmid." | KEY:".$key.")')");
		##insert Log##
		
		
		
			$status['msg'] = "บันทึกบัญชี TMTopup เรียบร้อย";

			echo json_encode($status);

			exit();

		}else{

			$status['status'] = "0";

			$status['msg'] = "ไม่สามารถบันทึกข้อมูลได้";

			echo json_encode($status);

			exit();

		}

}


if(isset($_POST['deltmtopup'])){

	$tmid = trim($_POST['tmid']);

	
	$sql = "select * from tmtopup where id = $tmid";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	if($row){

		$s = $conn->query("DELETE FROM tmtopup where id = $tmid");

		if($s){

				$status['status'] = "1";


##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'การตั้งค่า', 'ID : $tmid | ลบบัญชี TMTOPUP (TM:".$tmid." | KEY:".$row['keyz'].")')");
		##insert Log##
		
		
				echo json_encode($status);

				exit();

		}else{

				$status['status'] = "0";

				$status['msg'] = 'เกิดข้อผิดพลาดไม่สามารถลบ รายการนี้ได้';

				echo json_encode($status);

				exit();

		}

	}else{

				$status['status'] = "0";

				$status['msg'] = 'ไม่พบบีญชีใช้งานนี้';

				echo json_encode($status);

				exit();

	}

}

if(isset($_POST['settopup'])){

	$tmid = trim($_POST['tmid']);

	if($tmid){

		

		$reset = $conn->query("update tmtopup set used = '0'");

			$res = $conn->query("update tmtopup set used = '1' where id = '$tmid'");

			if($res){

				$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'การตั้งค่า', 'ID : $tmid | เปิดใช้บัญชี TMTOPUP (TM:".$tmid.")')");
		##insert Log##
		
		
				$status['msg'] = "บันทึกการเปิดใช้งานเรียบร้อย";

				echo json_encode($status);

				exit();

			}else{

				$status['status'] = "0";

				$status['msg'] = "เกิดข้อผิดพลาด ไม่สามารถรีเช็ทการตั้งค่าได้";

				echo json_encode($status);

				exit();				

			}



	}else{

			$status['status'] = "0";

			$status['msg'] = "เกิดข้อผิดพลาด ไม่สามารถตั้งค่าได้";

			echo json_encode($status);

			exit();

	}

}



if(isset($_POST['addsharework'])){

	$gamesid = trim($_POST['gamesid']);


	if(empty($gamesid)){

		$status['status'] = "0";

		$status['msg'] = "เกิดข้อผิดพลาด";

		echo json_encode($status);

		exit();

	}
		
		$sql = "select * from sharework where gamesid = '".$gamesid."' and date = '".$timework."' and status = 'y' ";
		$result = $conn->query($sql);
		
		if ($result->num_rows == 0) {
		
		$sql8 = "select gamesidname from gamesid where id = '".$gamesid."'";
		$result8 = $conn->query($sql8);
		$row8 = $result8->fetch_assoc();
			
			
		$conn->query("UPDATE sharework SET status='n' WHERE gamesid = '".$gamesid."' ");
		$rowid = $conn->query("INSERT INTO sharework (gamesid, persoid , gamesidname,added ,date,status) VALUES ('".$gamesid."', '".$_COOKIE['PID']."', '".$row8['gamesidname']."','".$added."','".$timework."','y')");
		$insertid = $conn->insert_id;
		
		
		}else{
		$rowid='';	
		}

		if($rowid){

			$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'แบ่งงาน', 'ID : $insertid | เลือกงาน  ".$row8['gamesidname']."')");
		##insert Log##
		
		
			$status['msg'] = "เลือกเรียบร้อย";

			echo json_encode($status);

			exit();

		}else{

			$status['status'] = "0";

			$status['msg'] = "มีผู้เลือกแล้วบันทึกข้อมูลไม่ได้";

			echo json_encode($status);

			exit();

		}
}


if(isset($_POST['endsharework'])){

	$gamesid = trim($_POST['gamesid']);


	if(empty($gamesid)){

		$status['status'] = "0";

		$status['msg'] = "เกิดข้อผิดพลาด";

		echo json_encode($status);

		exit();

	}
			
			
		$sql8 = "select id,gamesidname from sharework where gamesid='".$gamesid."' and persoid='".$_COOKIE['PID']."' and date='".$timework."'";
		$result8 = $conn->query($sql8);
		$row8 = $result8->fetch_assoc();
		
		
		$rowid = $conn->query("UPDATE sharework SET status='n' where gamesid='".$gamesid."' and persoid='".$_COOKIE['PID']."' and date='".$timework."' ");
		

		if($rowid){

			$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'แบ่งงาน', 'ID : ".$row8['id']." | ยกเลิกงาน  ".$row8['gamesidname']."')");
		##insert Log##
		
		
			$status['msg'] = "ยกเลิกเรียบร้อย";

			echo json_encode($status);

			exit();

		}else{

			$status['status'] = "0";

			$status['msg'] = "ไม่สามารถยกเลิกได้";

			echo json_encode($status);

			exit();

		}

}

if(isset($_POST['openaccount'])){

	$name = $_POST['name'];

	$phone = $_POST['phone'];
	
	$lineid = $_POST['lineid'];

	$username = $_POST['username'];

	$password = $_POST['password'];

	$bankname = $_POST['bankname'];

	$banknumber = $_POST['banknumber'];
	
	$recom = $_POST['recom'];

	$added = time();

	

	

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

	
	$sql3 = "select * from member where phone = '$phone'";
	$result3 = $conn->query($sql3);
	$ck3 = $result3->fetch_assoc();

	if($ck3){

		$status['status'] = "0";

		$status['msg'] = "เบอร์โทรนี้ มีในระบบแล้ว ";

		echo json_encode($status);

		exit();

	}
	
	$sql1 = "select * from member where username = '$username'";
	$result1 = $conn->query($sql1);
	$ck1 = $result1->fetch_assoc();

	if($ck1){

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
	
	
	if(empty($password)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุ รหัสผ่าน";

		echo json_encode($status);

		exit();		

	}

	

	if(empty($bankname)){

		$status['status'] = "0";

		$status['msg'] = "โปรดเลือกธนาคารของลูกค้า ";

		echo json_encode($status);

		exit();		

	}

	$sql3 = "select gamesidname from gamesid";
	$result3 = $conn->query($sql3);
	while($ck = $result3->fetch_assoc()){
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
	
	
	$sql2 = "select * from member where banknumber = '$banknumber'";
	$result2 = $conn->query($sql2);
	$ck2 = $result2->fetch_assoc();

	if($ck2){

		$status['status'] = "0";

		$status['msg'] = "เลขบัญชีธนาคารนี้ มีในระบบแล้ว ";

		echo json_encode($status);

		exit();

	}
	
	



	

	
		
		
		$rowid = $conn->query("INSERT INTO member (name,username,password,phone,lineid,bankname,banknumber,added,recom) VALUES ('$name','$username','".MD5($password)."', '$phone','$lineid', '$bankname', '$banknumber','$added','$recom')");
		
	

	if($rowid){
		$lastid = $conn->insert_id;
		$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID : $lastid | เพิ่มลูกค้าใหม่  ชื่อ:".$name." เบอร์:".$phone." username:".$username." บัญชีธนาคาร:".$bankname." เลขที่บัญชี:".$banknumber." Line:$lineid  ผู้แนะนำ:$recom')");
		##insert Log##
		
		
		$status['msg'] = "เพิ่มบัญชีลูกค้าใหม่เรียบร้อย";

		echo json_encode($status);

		exit();

	}	

}

if(isset($_POST['loginuser'])){
	$usr = trim($_POST['usr']);
	$pwd = trim($_POST['pwd']);
		$_SESSION["id"] = $usr;
		$_SESSION["password"] = $pwd;
		$status['status'] = "1";
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'เข้าสู่ระบบของลูกค้า ID:$usr ')");
		##insert Log##
		echo json_encode($status);
		exit();
}

if(isset($_POST['addcoupon'])){

	$type = $_POST['type'];
	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$couponcode = $_POST['couponcode'];
	$datetran = $_POST['datetran'];
	$q = $_POST['q'];

	if(empty($type)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้เลือกชนิดคูปอง";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($amount)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุมูลค่า";
		echo json_encode($status);	
	exit();	
	}
	
	
	if(empty($couponcode)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุรหัสคูปอง";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($datetran) and $type=='percent'){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุวันที่หมดอายุ";
		echo json_encode($status);	
	exit();	
	}
	

	/*if(empty($q)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุหมายเหตุ";
		echo json_encode($status);	
	exit();	
	}*/
		
	 	

	if($type=='percent'){
	$mbtimes = str_replace('/','-',$datetran);
	$timestampp = strtotime(''.$mbtimes.' 23:59:00');
	}

$sql3 = "INSERT INTO coupon (couponcode, amount, type,exp,q,personnel,added) VALUES ('".$couponcode."','".$amount."','".$type."','".$timestampp."','".$q."','".$_SESSION['ps']['name']."','".$added."')";

$conn->query($sql3);
$insertid = $conn->insert_id;


		

		$status['status'] = "1";

		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'คูปอง', 'ID : $insertid | เพิ่มคูปอง Code:$couponcode  จำนวน:".$amount."".$type." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	

}

		
		
if(isset($_POST['sendsecu'])){

	$id = trim($_POST['id']);

	$passkey = trim($_POST['passkey']);

	if(empty($passkey)){

		$status['status'] = "0";

		$status['msg'] = "โปรดระบุข้อมูลให้ครบถ้วน";

		echo json_encode($status);

		exit();

	}

		$rowid = $conn->query("UPDATE security SET passkey='".$passkey."' where id=".$id." ");
		
		if($rowid){

			$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'ระบบความปลอดภัย', 'ID : $id | แก้ไขรหัสความปลอดภัย')");
		##insert Log##
		
		
		
			$status['msg'] = "แก้ไขรหัสความปลอดภัยเรียบร้อย";

			echo json_encode($status);

			exit();

		}else{

			$status['status'] = "0";

			$status['msg'] = "ไม่สามารถบันทึกข้อมูลได้ ";

			echo json_encode($status);

			exit();

		}

}


if(isset($_POST['getbank'])){

$usern = $_POST['usern'];

if(!empty($usern)){
$sql2 = "select * from gameusers where gameuser = '$usern'";
$result2 = $conn->query($sql2);
$member = $result2->fetch_assoc();

$sql3 = "select * from member where id = '".$member['owner']."'";
$result3 = $conn->query($sql3);
$member3 = $result3->fetch_assoc();
}

if($member3){		
$status['status'] = "1";

		//$status['status'] = $sql3;
		$status['msg'] = "".$member3['bankname'].":".$member3['banknumber']."";
		$status['msg'] .= "<input name='name' id='bank' type='hidden' value='".$member3['bankname'].":".$member3['banknumber']."' />";
		$status['msg'] .= "<input name='owner' id='owner' type='hidden' value='".$member3['id']."' />";
		
		echo json_encode($status);	
		exit();
}else{
$status['status'] = "0";
$status['msg'] = "ไม่มี";
echo json_encode($status);	
exit();
}
}

if(isset($_POST['addwd'])){

	$owner = $_POST['owner'];
	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$bank = $_POST['bank'];
	$usern = $_POST['usern'];
	$q = $_POST['q'];
	

	if(empty($owner)){
		$status['status'] = "0";
		$status['msg'] = "id game ไม่ถูกต้อง";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($amount)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุยอดเงิน";
		echo json_encode($status);	
	exit();	
	}
	
	
	if(empty($bank)){
		$status['status'] = "0";
		$status['msg'] = "id game ไม่ถูกต้อง";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($usern)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุ ID Game";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($q)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุหมายเหต";
		echo json_encode($status);	
	exit();	
	}
	
$sql4 = "select * from member where id = '".$owner."'";
$result4 = $conn->query($sql4);
$member4 = $result4->fetch_assoc();


			$sql3 = "INSERT INTO paylogs (owner, name, username, phone, types, froms, tos, amount, q, personnel, added) VALUES ('".$owner."','".$member4['name']."','".$member4['username']."','".$member4['phone']."','withdrawal','$usern', '".$bank."','".$amount."', '".$q."', '".$_SESSION['ps']['name']."','".$added."')";

$conn->query($sql3);
$insertid = $conn->insert_id;


		

		$status['status'] = "1";
	//$status['msg'] = "ไม่ได้ระบุหมายเหต";

		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'โอนเงิน', 'ID : $insertid | ลอยลอด $usern(".$name.") ไป $bank จำนวน $amount บาท หมายเหตุ $q')");
		##insert Log##
		
		
		//$status['msg'] = "insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เครดิต', 'ID : $insertid | ขอเบิกเครดิต $usern(".$name.") จำนวน $amount บาท หมายเหตุ $q')";

		echo json_encode($status);	

}

if(isset($_POST['getw88'])){

$usern = $_POST['usern'];

if(!empty($usern)){
$sql2 = "select * from gameusers where provider='W88' AND gameuser = '$usern'";
$result2 = $conn->query($sql2);
$member = $result2->fetch_assoc();

$sql3 = "select * from member where id = '".$member['owner']."'";
$result3 = $conn->query($sql3);
$member3 = $result3->fetch_assoc();
}

if($member3){		
$status['status'] = "1";

		//$status['status'] = $sql3;
		$status['msg'] = "ชื่อ ".$member3['name'].": ".$member3['username'].": โทร ".$member3['phone']." : ถุงเงิน ".$member3['moneybag']."";
		//$status['msg'] .= "<input name='name' id='bank' type='hidden' value='".$member3['bankname'].":".$member3['banknumber']."' />";
		$status['msg'] .= "<input name='owner88' id='owner88' type='hidden' value='".$member3['id']."' />";
		
		echo json_encode($status);	
		exit();
}else{
$status['status'] = "0";
$status['msg'] = "ไม่มี";
echo json_encode($status);	
exit();
}
}

if(isset($_POST['addw88'])){

	$owner = $_POST['owner88'];
	$amount = 0 + str_replace(",","",trim($_POST['amount88']));
	$usern = $_POST['userne'];
	$q = $_POST['q88'];
	

	if(empty($owner)){
		$status['status'] = "0";
		$status['msg'] = "id game ไม่ถูกต้อง";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($amount)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุยอดบัตร";
		echo json_encode($status);	
	exit();	
	}
	
	
	if(empty($usern)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุ ID Game";
		echo json_encode($status);	
	exit();	
	}
	
	/*if(empty($q)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุหมายเหต";
		echo json_encode($status);	
	exit();	
	}*/
	
$sql4 = "select * from member where id = '".$owner."'";
$result4 = $conn->query($sql4);
$member4 = $result4->fetch_assoc();

$moneybag = ($amount-(($amount*10)/100));
$moneybag2 = floor(($member4['moneybag']-$moneybag));

$amountw88 = floor(($amount-(($amount*15)/100)));

//$status['msg'] = $moneybag .">".$member4['moneybag'];

if($moneybag>$member4['moneybag']){
		$status['status'] = "0";
		$status['msg'] = "ยอดเงินในถุงเงิน ไม่พอสำหรับย้ายเข้าบัญชี W88";
		echo json_encode($status);	
	exit();	
	}
	
	$conn->query("UPDATE member SET moneybag='".$moneybag2."' where id=".$owner." ");

			$sql3 = "INSERT INTO paylogs (owner, name, username, phone, types, transfrom, froms, tos, amount, q, personnel, added) VALUES ('".$owner."','".$member4['name']."','".$member4['username']."','".$member4['phone']."','transfer', 'confirmed', 'moneybag".$owner."', 'W88:".$usern."','".$amountw88."', '".$q."', '".$_SESSION['ps']['name']."','".$added."')";

$conn->query($sql3);
$insertid = $conn->insert_id;


		

		$status['status'] = "1";
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'โอนเงิน', 'ID : $insertid | โยกจาก moneybag".$owner." เข้า  W88:$usern(".$name.") จำนวน $amountw88 บาท หมายเหตุ $q')");
		##insert Log##
		
		
		//$status['msg'] = "insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เครดิต', 'ID : $insertid | ขอเบิกเครดิต $usern(".$name.") จำนวน $amount บาท หมายเหตุ $q')";

		echo json_encode($status);	

}



if(isset($_POST['detailphone'])){

$id = $_POST['id'];

if(!empty($id)){
$sql3 = "select * from member where id = '".$id."'";
$result3 = $conn->query($sql3);
$member3 = $result3->fetch_assoc();
}

if($member3){		
$status['status'] = "1";

		
		$status['msg'] = $member3['phone'];
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'Owner ID : $id | กด Show หมายเลขโทรศัพท์ลูกค้า  ".$member3['name']." User:".$member3['username']."')");
		##insert Log##
		
		
		echo json_encode($status);
		exit();
}
}




if(isset($_POST['addaff'])){
	$id = $_POST['id'];
	$owner = $_POST['owner'];
	$gameid = $_POST['gameid'];
	$gameusers = $_POST['gameusers'];
	$m = $_POST['m'];
	$y = $_POST['y'];
	$affid = $_POST['affid'];
	$winloss = str_replace(",","",trim($_POST['winloss']));
	$com = $_POST['com'];

	if(empty($winloss)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุ Win/Loss".$winloss;
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($com)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุ % คอมมิชชั่น";
		echo json_encode($status);	
	exit();	
	}
		
	 $ttwinloss = $winloss;

	if(strstr($ttwinloss,'-')){
		
		$wl = str_replace("-","",trim($ttwinloss));
		$comm = (($wl*$com)/100);
		
	}else{
	
		$comm = (($ttwinloss*$com)/100);
		$comm = "-".$comm;
		//$comm = 
	
	}

			$sql2 = "select * from afflogs where owner = ".$owner." AND m=".$m." AND y=".$y." AND gameid=".$gameid." order by added ";
	
			$result2 = $conn->query($sql2);

			
			if ($result2->num_rows == 0) {
			$sql3 = "INSERT INTO afflogs (perid, owner, gameid, gameusers,winloss,com,comsum,m,y,added,personnel,type) VALUES ('".$id."','".$owner."','".$gameid."','".$gameusers."','".$winloss."','".$com."','".$comm."','".$m."','".$y."','".$added."','".$_SESSION['ps']['name']."','L')";

$conn->query($sql3);
}else{
			$sql3 = "UPDATE afflogs SET winloss='".$winloss."', com='".$com."' ,comsum='".$comm."' ,personnel='".$_SESSION['ps']['name']."' where gameid='".$gameid."' AND m='".$m."' AND y='".$y."' ";

$conn->query($sql3);
}


		

		$status['status'] = "1";
		$status['comm'] = $comm;
		##insert Log##
		//$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'คูปอง', 'เพิ่มคูปอง')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	

}

if(isset($_POST['sumaff'])){
	$id = $_POST['id'];
	$m = $_POST['m'];
	$y = $_POST['y'];

if($m=='01'){ $om = '12'; $oy=($y-1); }else{ $om=($m-1); $oy=$y; }

$sql4 = "select * from afflogs where perid = '".$id."' AND m='".$m."' AND y='".$y."' AND type='L'";
	$result4 = $conn->query($sql4);
	if ($result2->num_rows == 0) {
		while($member4 = $result4->fetch_assoc()){
			$comnow = $comnow+$member4['comsum'];
		}
		
		$sql5 = "select * from afflogs where perid = '".$id."' AND m=".$om." AND y=".$oy." AND type='M'";
		$result5 = $conn->query($sql5);
		$member5 = $result5->fetch_assoc();
		
		$comold = $member5['comsum'];
			if(strstr($comold,'-')){ $comold = $member5['comsum']; }else{ $comold=0; }
			
		$comsumnow = ($comold+$comnow);
	}else{
	
		$status['status'] = "0";
		$status['msg'] = "ไม่มีข้อมูลสำหรับคำนวณ";
		echo json_encode($status);	
		exit();	
	}
	
	
	

			$sql2 = "select * from afflogs where perid = ".$id." AND m=".$m." AND y=".$y." AND type='M' order by added ";
	
			$result2 = $conn->query($sql2);

			
			if ($result2->num_rows == 0) {
			$sql3 = "INSERT INTO afflogs (perid, winloss,comsum,oldwinloss,m,y,type,added,personnel) VALUES ('".$id."','".$comsumnow."','".$comnow."','".$comold."','".$m."','".$y."','M','".$added."','".$_SESSION['ps']['name']."')";

$conn->query($sql3);
}else{
			$sql3 = "UPDATE afflogs SET winloss='".$comsumnow."', comsum='".$comnow."', oldwinloss='".$comold."' ,personnel='".$_SESSION['ps']['name']."' where perid='".$id."' AND m='".$m."' AND y='".$y."' AND type='M'";

$conn->query($sql3);
}


		

		$status['status'] = "1";
		$status['comold'] = $comold;
		$status['comnow'] = $comnow;
		$status['comsumnow'] = $comsumnow;
		##insert Log##
		//$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'คูปอง', 'เพิ่มคูปอง')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	

}



if(isset($_POST['addrepass'])){
$usernrepass = $_POST['usernrepass'];
$owner = $_POST['owner'];
$qre = $_POST['qre'];


if(empty($usernrepass)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุ บัญชีเกมส์";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($owner)){
		$status['status'] = "0";
		$status['msg'] = "บัญชีเกมส์ ไม่ถูกต้อง";
		echo json_encode($status);	
	exit();	
	}
	
		$sql5 = "select * from member where id = '".$owner."'";
		$result5 = $conn->query($sql5);
		$member5 = $result5->fetch_assoc();
		
		$sql6 = "select provider from gameusers where gameuser = '".$usernrepass."'";
		$result6 = $conn->query($sql6);
		$member6 = $result6->fetch_assoc();
		
		if($member6['provider']=='W88'){ $usernrepass="W88:".$usernrepass; }
		
		$sql3 = "INSERT INTO paylogs (owner, name, username,phone,types,froms,tos,amount,status,added,added2,sure,q,personnel) VALUES ('".$member5['id']."','".$member5['name']."','".$member5['username']."','".$member5['phone']."','repass','".$usernrepass."','SMS:".$member5['id']."','0','pending','".$added."','".$added."','1','".$qre."','".$_SESSION['ps']['name']."')";
		
		$conn->query($sql3);


		$status['status'] = "1";
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ขอรีเซ็ตรหัสผ่าน บัญชีเกมส์ ".$usernrepass." ของ ".$member5['name']." หมายเหตุ ".$qre." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
			
}


if(isset($_POST['confrepassname'])){

$pid = $_POST['pid'];
$guser = $_POST['guser'];
$fromt = $_POST['fromt'];

		if($fromt==''){
			$status['status'] = "0";
			$status['msg'] = "กรุณาระบุรหัสผ่านใหม่ ";
			echo json_encode($status);	
			exit();
			
		}
		
$upd =  $conn->query("update paylogs set transfrom='confirmed', gamepass='".$fromt."', added3='".$added."', personnel='".$_SESSION['ps']['name']."' where id = $pid ");

if($upd){		
$status['status'] = "1";
		
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID $pid | ยืนยันการรีเซ็ตรหัสผ่าน บัญชีเกมส์ ".$guser." รหัสผ่านใหม่ ".$fromt." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}else{
$status['status'] = "0";
$status['msg'] = "ผิดพลาด  ";
echo json_encode($status);	
exit();
}
}


if(isset($_POST['confrepasssms'])){

$pid = $_POST['pid'];
$guser = $_POST['guser'];
$fromtp = $_POST['fromtp'];

		$sql5 = "select transfrom,phone,personnel from paylogs where id = '".$pid."'";
		$result5 = $conn->query($sql5);
		$paylogs5 = $result5->fetch_assoc();
		
		if($paylogs5['transfrom']=='pending'){
			$status['status'] = "0";
			$status['msg'] = "ยืนยันการรีเซ็ตรหัสผ่านก่อน ";
			echo json_encode($status);	
			exit();

		}
		
		/*if($paylogs5['phone']!='$fromtp'){
			$status['status'] = "0";
			$status['msg'] = "เบอร์โทรไม่ถูกต้อง ";
			echo json_encode($status);	
			exit();
			
		}*/

		$upd =  $conn->query("update paylogs set transto='confirmed' , status='confirmed' , added4='".$added."', personnel='".$paylogs5['personnel'].",".$_SESSION['ps']['name']."' where id = $pid ");
		
if($upd){		
$status['status'] = "1";
		
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID $pid | ยืนยันการส่ง SMS รีเซ็ตรหัสผ่าน บัญชีเกมส์ ".$guser." เรียบร้อย')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}else{
$status['status'] = "0";
$status['msg'] = "ผิดพลาด ";
echo json_encode($status);	
exit();
}
}

if(isset($_POST['repasscancel'])){

$pid = $_POST['pid'];
$guser = $_POST['guser'];
		

	$upd =  $conn->query("update paylogs set status='cancle', added4='".$added."' where id = $pid ");

if($upd){		
$status['status'] = "1";
		
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รอทำรายการ', 'ID $pid | ยกเลิก รีเซ็ตรหัสผ่าน บัญชีเกมส์ ".$guser."')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}
}

if(isset($_POST['memberlock'])){

$pid = $_POST['pid'];
		

	$upd =  $conn->query("update member set locked='lock' where id = $pid ");

if($upd){		
$status['status'] = "1";
		
		$sql5 = "select username,name from member where id = '".$pid."'";
		$result5 = $conn->query($sql5);
		$member = $result5->fetch_assoc();
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID $pid | ยืนยันการ Lock Member ".$member['username']." / ".$member['name']." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}
}

if(isset($_POST['memberunlock'])){

$pid = $_POST['pid'];
		

	$upd =  $conn->query("update member set locked='' where id = $pid ");

if($upd){		
$status['status'] = "1";
		
		$sql5 = "select username,name from member where id = '".$pid."'";
		$result5 = $conn->query($sql5);
		$member = $result5->fetch_assoc();
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID $pid | ยืนยันการ UnLock Member ".$member['username']." / ".$member['name']." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}
}

if(isset($_POST['membersup'])){

$pid = $_POST['pid'];
		

	$upd =  $conn->query("update member set suped='sup' where id = $pid ");

if($upd){		
$status['status'] = "1";
		
		$sql5 = "select username,name from member where id = '".$pid."'";
		$result5 = $conn->query($sql5);
		$member = $result5->fetch_assoc();
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID $pid | ยืนยันการ Sup Member ".$member['username']." / ".$member['name']." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}
}

if(isset($_POST['memberunsup'])){

$pid = $_POST['pid'];
		

	$upd =  $conn->query("update member set suped='' where id = $pid ");

if($upd){		
$status['status'] = "1";
		
		$sql5 = "select username,name from member where id = '".$pid."'";
		$result5 = $conn->query($sql5);
		$member = $result5->fetch_assoc();
		
		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID $pid | ยืนยันการ Un Sup Member ".$member['username']." / ".$member['name']." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}
}


if(isset($_POST['membershowq'])){

$pid = $_POST['pid'];
$showq = $_POST['showq'];

if($showq==''){ $showq=0; }
		

	$upd =  $conn->query("update q set status='".$showq."' where id = $pid ");

if($upd){		
$status['status'] = "1";
		
		//$sql5 = "select username,name from member where id = '".$pid."'";
		//$result5 = $conn->query($sql5);
		//$member = $result5->fetch_assoc();
		
		##insert Log##
		//$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'รายชื่อสมาชิก', 'ID $pid | ยืนยันการ Un Sup Member ".$member['username']." / ".$member['name']." ')");
		##insert Log##
		
		
		//$status['status'] = $sql3;

		echo json_encode($status);	
		exit();
}
}



if(isset($_POST['addtmto'])){

	$cardid = $_POST['cardid'];
	$amount = 0 + str_replace(",","",trim($_POST['amount']));
	$ref1 = 0 + str_replace(",","",trim($_POST['ref1']));
	$ref2 = $_POST['ref2'];
	$ref3 = $_POST['ref3'];
	$q = $_POST['q'];
	

	if(empty($cardid)){
		$status['status'] = "0";
		$status['msg'] = "ระบุรหัสบัตร TM ด้วยครับ";
		echo json_encode($status);	
	exit();	
	}
	
	if(strlen($cardid)!='14'){
		$status['status'] = "0";
		$status['msg'] = "รหัสบัตร TM ไม่เท่ากับ 14 ตัว";
		echo json_encode($status);	
	exit();	
	}
	
	$sql7 = "select id from paylogs where froms = 'T:".$cardid."' ";
$result7 = $conn->query($sql7);
if ($result7->num_rows > 0) {
		$status['status'] = "0";
		$status['msg'] = "รหัสบัตรนี้มีในระบบแล้ว";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($amount)){
		$status['status'] = "0";
		$status['msg'] = "เลือกมูลค่าบัตร TM ด้วยครับ";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($ref1)){
		$status['status'] = "0";
		$status['msg'] = "ระบุ Ref1 ด้วยครับ";
		echo json_encode($status);	
	exit();	
	}
	
	
	if(empty($ref2)){
		$status['status'] = "0";
		$status['msg'] = "ระบุ Ref2 ด้วยครับ";
		echo json_encode($status);	
	exit();	
	}
	
	if(empty($ref3)){
		$status['status'] = "0";
		$status['msg'] = "ระบุ Ref3 ด้วยครับ";
		echo json_encode($status);	
	exit();	
	}
	
	/*if(empty($q)){
		$status['status'] = "0";
		$status['msg'] = "ไม่ได้ระบุหมายเหต";
		echo json_encode($status);	
	exit();	
	}*/
	
	



$sql4 = "select * from member where id = '".$ref1."'";
$result4 = $conn->query($sql4);
$member = $result4->fetch_assoc();
if ($result4->num_rows == 0) {
		$status['status'] = "0";
		$status['msg'] = "ไม่มี ID ลูกค้านี้";
		echo json_encode($status);	
	exit();	
}

	
if($ref3=='OT'){

			if($amount=='50'){ $tamount = '45'; }
			if($amount=='90'){ $tamount = '81'; }
			if($amount=='150'){ $tamount = '135'; }
			if($amount=='300'){ $tamount = '270'; }
			if($amount=='500'){ $tamount = '450'; }
			if($amount=='1000'){ $tamount = '900'; }
			
			
			$sql3 = "INSERT INTO paylogs (
			owner,name,username,phone,types,froms,tos,amount,added,added4,dep_bef,dep_aft,status,q,personnel
			) VALUES (
			".$member['id'].",'".$member['name']."','".$member['username']."','".$member['phone']."','deposit','T:".$cardid."','moneybag".$member['id']."','".$tamount."',$added,$added,'".$member['moneybag']."',".($tamount+$member['moneybag']).",'confirmed','ลอย TM Timeout. ".$q."', '".$_SESSION['ps']['name']."'
			)";

$conn->query($sql3);
$insertid = $conn->insert_id;

$conn->query("UPDATE member SET moneybag = '".($tamount+$member['moneybag'])."',mactive = 'Y' where id= ".$member['id']." ");

}else{
			if($amount=='50'){ $tamount = '43'; }
			if($amount=='90'){ $tamount = '77'; }
			if($amount=='150'){ $tamount = '128'; }
			if($amount=='300'){ $tamount = '255'; }
			if($amount=='500'){ $tamount = '425'; }
			if($amount=='1000'){ $tamount = '850'; }
			
			$sql4 = "select id from gameusers where provider = 'W88' AND gameuser='".$ref2."' AND owner='".$member['id']."'";
			$result4 = $conn->query($sql4);
			if ($result4->num_rows == 0) {
					$status['status'] = "0";
					$status['msg'] = "ไม่มี ID Game (Ref2) นี้";
					echo json_encode($status);	
				exit();	
			}


			$sql3 = "INSERT INTO paylogs (
			owner,name,username,phone,types,froms,tos,amount,added,status,q,personnel
			) VALUES (
			".$member['id'].",'".$member['name']."','".$member['username']."','".$member['phone']."','deposit','T:".$cardid."','W88:".$ref2."','".$tamount."',$added,'pending','ลอย TM Timeout. ".$q."', '".$_SESSION['ps']['name']."'
			)";

$conn->query($sql3);
$insertid = $conn->insert_id;

}

		

		$status['status'] = "1";
	//$status['msg'] = $sql3;

		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'TMTIMEOUT', 'ID : $insertid | ลอย TM $usern(".$name.") ไป $bank จำนวน $amount บาท หมายเหตุ $q')");
		##insert Log##
		
		
		//$status['msg'] = "insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'เครดิต', 'ID : $insertid | ขอเบิกเครดิต $usern(".$name.") จำนวน $amount บาท หมายเหตุ $q')";

		echo json_encode($status);	

}


if($_GET['fileuploadget']=='yul'){
if($_FILES['file']['name']!=''){


if ( 0 < $_FILES['file']['error'] ) {
        echo 'no';
    } else {
       	$filetype=$_FILES["file"]["type"];
		if(($filetype!="image/jpg") and ($filetype!="image/jpeg") and ($filetype!="image/pjpeg") and  ($filetype!="image/png") and  ($filetype!="image/gif"))
		{
		echo 'filenosub';
		}
		else
		{
		
		$sur = strrchr($_FILES['file']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
		$newfilename = $_GET['memid']."-".date('d-m-Y')."-".time().$sur; //ผมตั้งเป็น วันที่_เวลา.นามสกุล
		
	    move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/'.$newfilename);
		$upd =  $conn->query("insert into fileslip (owner, filename, added, personnel)values('".$_GET['memid']."', '".$newfilename."', '".$added."', '".$_SESSION['ps']['name']."') ");
		echo 'yes';
		}	
    }
	
	
}else{ echo 'no'; }
}


if(isset($_POST['sendmarquee'])){

	$bgcolor = trim($_POST['bgcolor']);

	$marquee = trim($_POST['marquee']);


		$rowid = $conn->query("UPDATE marquee SET marquee='".$marquee."', bgcolor='".$bgcolor."' ");
		
		if($rowid){

			$status['status'] = "1";


		##insert Log##
		$conn->query("insert into logs (added, personnel, route, q) VALUES ('".$added."', '".$_SESSION['ps']['name']."', 'ระบบอักษรวิ่ง', 'ID : $id | แก้ไขข้อความ ".$marquee." ')");
		##insert Log##
		
		
		
			$status['msg'] = "แก้ไขข้อความวิ่งเรียบร้อย";

			echo json_encode($status);

			exit();

		}else{

			$status['status'] = "0";

			$status['msg'] = "ไม่สามารถบันทึกข้อมูลได้ ";

			echo json_encode($status);

			exit();

		}

}

?>
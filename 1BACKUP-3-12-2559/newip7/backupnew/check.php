<?php if(empty($_COOKIE['PID'])){ echo '<script>window.location.href = "login.php";</script>'; } ?>

<!-- addgameuser -->

<div class="modal fade" id="openaskbox" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h4 class="modal-title">ลอยยอดโอน</h4>

      </div>

      <div class="modal-body">

		<div id="askcredit_msg"></div>

			<form class="form-horizontal">					  

                      		

                      <div class="form-group" style="margin-top:10px;">

                        <label for="ordergameuser" class="col-xs-3 col-md-3 control-label">บัญชีเกมส์ :</label>

                        <div class="col-xs-7 col-md-7">
				
						<input type="text" id="usern" name="usern" value="" class="form-control input-small" placeholder="โปรดระบุ" onkeyup="getbank();">
             
</div>
                      </div>   
					  
					   <div class="form-group" style="margin-top:10px;">

                        <label for="ordergameuser" class="col-xs-3 col-md-3 control-label">โอนเข้าธนาคาร :</label>

                        <div class="col-xs-7 col-md-7">
						
<div id="gbank"></div>

</div>
                      </div>  
                      <div class="form-group" style="margin-top:10px;">

                        <label for="ordergameuser" class="col-xs-3 col-md-3 control-label">จำนวนเงิน :</label>

                        <div class="col-xs-7 col-md-7">

                            <input type="text" id="amount" name="amount" value="" class="form-control input-small" placeholder="โปรดระบุ">

                        </div>

                      </div>   
					  
					    
					  

                      <div class="form-group" style="margin-top:10px;">

                        <label for="q" class="col-xs-3 col-md-3 control-label">หมายเหตุ :</label>

                        <div class="col-xs-7 col-md-7"><input type="text" id="q" name="q" value="" class="form-control input-small" placeholder="โปรดระบุ">

                        </div>

                      </div>                            

      </form>

    </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

        <button type="button" class="btn btn-primary" id="saveorder" onClick="addwd()"><span class="glyphicon glyphicon-floppy-saved"></span> บันทึก</button>

      </div>

    </div>

  </div>

</div>

<!-- addgameuser -->


<!-- addgameuser -->

<div class="modal fade" id="openbagtw88box" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h4 class="modal-title">ถุงเงินเข้า w88</h4>

      </div>

      <div class="modal-body">

		<div id="askcredit_msg"></div>

			<form class="form-horizontal">					  

                      		

                      <div class="form-group" style="margin-top:10px;">

                        <label for="ordergameuser" class="col-xs-3 col-md-3 control-label">บัญชีเกมส์ W88 :</label>

                        <div class="col-xs-7 col-md-7">
				
						<input type="text" id="userne" name="userne" value="" class="form-control input-small" placeholder="โปรดระบุ" onkeyup="getw88();">
             
</div>
                      </div>   
					  
					   <div class="form-group" style="margin-top:10px;">

                        <label for="ordergameuser" class="col-xs-3 col-md-3 control-label">ผู้ใช้ :</label>

                        <div class="col-xs-7 col-md-7">
						
<div id="gw88"></div>

</div>
                      </div>  
                      <div class="form-group" style="margin-top:10px;">

                        <label for="ordergameuser" class="col-xs-3 col-md-3 control-label">ราคาบัตร :</label>

                        <div class="col-xs-7 col-md-7">

                            <select class="form-control input-small" id="amount88" name="amount88">
							<option value="">---กรุณาเลือก---</option>
                              <option value="50">50 บาท ได้ 42</option>
                              <option value="90">90 บาท ได้ 76</option>
                              <option value="150">150 บาท ได้ 127</option>
                              <option value="300">300 บาท ได้ 255</option>
                              <option value="500">500 บาท ได้ 425</option>
                              <option value="1000">1,000 บาท ได้ 850</option>
							
							</select>

                        </div>

                      </div>   
					  
					    
					  

                      <div class="form-group" style="margin-top:10px;">

                        <label for="q" class="col-xs-3 col-md-3 control-label">หมายเหตุ :</label>

                        <div class="col-xs-7 col-md-7"><input type="text" id="q88" name="q88" value="" class="form-control input-small" placeholder="โปรดระบุ">

                        </div>

                      </div>                            

      </form>

    </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

        <button type="button" class="btn btn-primary" id="saveorder" onClick="addw88()"><span class="glyphicon glyphicon-floppy-saved"></span> บันทึก</button>

      </div>

    </div>

  </div>

</div>

<!-- addgameuser -->


<!-- addgameuser -->

<div class="modal fade" id="openrepassbox" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h4 class="modal-title">รีพาส (Reset Password)</h4>

      </div>

      <div class="modal-body">

		<div id="askcredit_msg"></div>

			<form class="form-horizontal">					  

                      		

                      <div class="form-group" style="margin-top:10px;">

                        <label for="ordergameuser" class="col-xs-4 col-md-4 control-label">บัญชีเกมส์ :</label>

                        <div class="col-xs-7 col-md-7">
				
						<input type="text" id="usernrepass" name="usernrepass" value="" class="form-control input-small" placeholder="โปรดระบุ" onkeyup="getusername3();">
             
</div>
                      </div>   
					  
					   <div class="form-group" style="margin-top:10px;">

                        <label for="ordergameuser" class="col-xs-4 col-md-4 control-label">ผู้ใช้ :</label>

                        <div class="col-xs-7 col-md-7">
						
<div id="guserrp"></div>

</div>
                      </div>  
                     
				
					    
					  

                      <div class="form-group" style="margin-top:10px;">

                        <label for="q" class="col-xs-4 col-md-4 control-label">หมายเหตุ :</label>

                        <div class="col-xs-7 col-md-7"><input type="text" id="qre" name="qre" value="" class="form-control input-small" placeholder="โปรดระบุ">

                        </div>

                      </div>                            

      </form>

    </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

        <button type="button" class="btn btn-primary" id="saveorder" onClick="addrepass()"><span class="glyphicon glyphicon-floppy-saved"></span> บันทึก</button>

      </div>

    </div>

  </div>

</div>

<!-- addgameuser -->


<div class="container-fluid">

  <h1>รอทำรายการ</h1>
  <!-- aoldid : <span id="aoldid"></span> | apid : <span id="apid"></span> | ps : <span id="pss"></span> -->
  <hr>

  
<?php //if(($_COOKIE['PCLASS']=='Account')or($_COOKIE['PCLASS']=='Admin')){ ?>
                <!-- /.row -->
				<div class="row">
				<div class="col-xs-12" style="margin-bottom:20px;">
				<a href="javascript:;" data-toggle="modal" data-target="#openaskbox" class="btn btn-info pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-upload"></span> <span class="modal-title">ลอยยอดโอน</span></a>
				
				<a href="javascript:;" data-toggle="modal" data-target="#openbagtw88box" class="btn btn-info pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-upload"></span> <span class="modal-title">ถุงเงิน > W88</span></a> 
                
                <a href="javascript:;" data-toggle="modal" data-target="#openrepassbox" class="btn btn-info pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-upload"></span> <span class="modal-title">รีพาส (Reset Password)</span></a> 
				
				</div>
				<div class="col-xs-12"></div>
				</div>
                <div class="row">

					<div class="col-xs-12">

						<table class="table table-bordered" id="monitorstable">

									<tbody>

									  <tr>

										<td class="active">บัญชีใช้งาน</td>

										<td class="active">เมื่อ</td>

										<td class="active">รายการ</td>
                                        
                                        <td class="active">จาก</td>

										<td class="active">จำนวน</td>

										<td class="active">เข้า</td>
                                        
                                        <td class="active">ต้นทาง</td>

										<td class="active">สถานะ</td>

									  </tr>

									</tbody>

									<tbody id="phtml">

<?php 

	$statusmun = 0;

	
if(($_COOKIE['PCLASS']=='Account')or($_COOKIE['PCLASS']=='Admin')){
	$sql1 = "select * from paylogs where status='pending' AND withdrawal='pending' order by added desc limit 50";
}else{
	$sql1 = "select * from paylogs where status='pending' AND withdrawal='pending'  AND ($sqlre or $sqlree) $spaesql order by added desc limit 50";
}


	$result1 = $conn->query($sql1);

	$statusmun = $result1->num_rows;

	/*if($statusmun==''){
		
		echo '<center><h2>ยังไม่ได้แบ่งงาน</h2></center>';
		exit();
	}*/

	while($row1 = $result1->fetch_assoc()){
if($row1['webroot']=='bafobet'){
		$trbg = '#4da9ff';
		}else{
		$trbg = '#FFFFFF';
		}

	$usernameshow = $row1['username'];
	
	$id = $row1['id'];			



$gamecredit = 0;

	$formto = '';

	$formf = '';

	$formwd = '';

	$tft_check = '';

	$tff_check = '';

	$wd_check = '';

	$timedep = '';

	$newusrbutton = '';
	

	$sql2 = "select * from member where id = '".$row1['owner']."'";

	$result2 = $conn->query($sql2);

	

	$getmember = $result2->fetch_assoc();
	

	$popdetail = ": ".$getmember['name']." : ".$getmember['banknumber']." : ".$getmember['bankname']." <div id='phone_".$getmember['id']."'>0XXXXX".substr($getmember['phone'], 6, 4)."</div> <button type='button' class='btn btn-info btn-xs' onClick='detailphone(".$getmember['id'].")'>Show</button>";

	
	$sql7 = "select * from q where owner = '".$row1['owner']."' AND status='1'";
	$result7 = $conn->query($sql7);
	$qdetail = '';
	if ($result7->num_rows > 0) {
	while($getq = $result7->fetch_assoc()){
	$i++;
	
	$qdetail .= '
	<tr bgcolor="#FFFF99" id="monitors_'.$row1['id'].'">

					<td  colspan="7">หมายเหตุ Username : <a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom"  data-html="true" class="btn btn-success btn-xs" data-content="'.$popdetail.'" data-original-title="รายละเอียดบัญชี">'.$usernameshow.'</a> : '.$getq['q'].'</td>

				  </tr>
	';
	
	}
	}
	

	if($row1['types'] == 'deposit'){

		$type = 'ฝาก';

		$color = '468847';

		

		

		$sql3 = "select * from deposit where id = '".$row1['toporder']."'";

	$result3 = $conn->query($sql3);

	

	$order = $result3->fetch_assoc();

	

	
		if(empty($order['times'])){ $times=''; }else{ if(@ereg("^[0-9]+$",$order['times'] )){ $times = @date("d-m-Y H:i",$order['times']);  }else{ $times=$order['times'];  } }
			if($order['q2']){ $q2 = $order['q2']; }
		$timedep = '<span class="label label-success">'.$times.'</span>';

		

		if(preg_match("#NEWUSER#", $row1['tos'])){

			$addnewgameusr = "

				<div class='col-xs-12'>

				<div class='row'>

					<div class='col-xs-12'><input type='text' id='dep_newusr_ch_".$row1['id']."' value='' class='form-control input-small' placeholder='ระบุบัญชีเกมส์ใหม่'></div>

					<div class='clearfix'> </div>

					<div class='col-xs-12' style='margin-top:10px;margin-bottom:10px;'><button class='btn btn-success' onClick='savenewgameusr(".$row1['id'].")' type='button'><span class='glyphicon glyphicon-check'></span> บันทึก</button></div>

				</div>

				</div>

			";

			$newusrbutton = '

				<a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom" data-html="true" class="btn btn-success btn-xs" data-content="'.$addnewgameusr.'" data-original-title="เปิดบัญชีใหม่"><span class="glyphicon glyphicon-check"></span> เปิดบัญชีใหม่</a>

			';

		}

		#$trclr = ' class="success"';

		

			$sql4 = "select * from gameusers where gameuser = '".str_replace("W88:","",$row1['tos'])."'";

	$result4 = $conn->query($sql4);

	

	$resy = $result4->fetch_assoc();

	

	

				if($resy['provider'] == 'GCLUB' or $resy['provider'] == 'TBSBET' or $resy['provider'] == 'ASIA855' or $resy['provider'] == 'ROYAL1688' or $resy['provider'] == 'W88'){

					$sql4 = "select * from agent where provider in ('GCLUB','TBSBET','ASIA855','ROYAL1688','W88')";

	$result4 = $conn->query($sql4);

	

	while( $rowgz = $result4->fetch_assoc()){
$wdto = "";
	

					

						//print_r($resy); 

						//echo "<br>#".strtolower($rowgz['name'])."#,".strtolower($row1['tos'])."<br><br>";

						if(preg_match("#".strtolower($rowgz['name'])."#",strtolower($row1['tos']))){

							$gamecredit = $rowgz['credit'];

						}

					

	}

				}else{

					$gamecredit = $resy['credit'];

				}			

			$formto = "

				<div class='col-xs-12'>

				<div class='row'>

					<div class='col-xs-6'><input type='text' id='dep_bef_am_".$row1['id']."' value='".$gamecredit."' class='form-control input-small' placeholder='ยอดก่อนเติม' maxlength='10' disabled></div>

					<div class='col-xs-6'><input type='text' id='dep_aft_am_".$row1['id']."' class='form-control input-small' placeholder='ยอดหลังเติม' maxlength='10'></div>

					<div class='clearfix'> </div>

					<div class='col-xs-12' style='margin-top:10px;margin-bottom:10px;'><button class='btn btn-success' onClick='depok(".$row1['id'].")' type='button'><span class='glyphicon glyphicon-check'></span> ยืนยัน</button></div>

				</div>

				</div>

			";		

		$stat = '

			<a tabindex="0" href="javascript:;" data-toggle="popover" data-html="true" data-placement="bottom"  class="btn btn-success btn-xs"  data-content="'.$formto.'" data-original-title="ยินยันการทำรายการ"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a>

			<a href="javascript:;" onClick="Depcancel(\''.$row1['id'].'\')" class="btn btn-danger btn-xs" title="ยกเลิกการทำรายการนี้"><span class="glyphicon glyphicon-trash"></span> ยกเลิก</a>

		';

	}elseif(($row1['types'] == 'withdrawal')){

		$type = 'ถอน';

		$color = 'ff0000';

		if($row1['withdrawal'] == 'pending'){

			$wdto = "<a  href='javascript:;' onClick='updatebackwd(".$row1['id'].",".$row1['owner'].")' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-repeat'></span> </a>";

			$sql5 = "select * from gameusers where gameuser = '".str_replace("W88:","",$row1['froms'])."'";

	$result5 = $conn->query($sql5);

	

	$resx = $result5->fetch_assoc();

				if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

					

					$sql4 = "select * from agent where provider in ('GCLUB','TBSBET','ASIA855','ROYAL1688','W88')";

	$result4 = $conn->query($sql4);

	

	while( $rowgz = $result4->fetch_assoc()){

						if(preg_match("#".strtolower($rowgz['name'])."#",strtolower($row1['froms']))){

							$gamecredit = $rowgz['credit'];

						}

					}

				}else{

					$gamecredit = $resx['credit'];

				}

			$formf = "

				<div class='col-xs-12'>

				<div class='row'>

					<div class='col-xs-6'><input type='text' id='wd_bef_am_".$row1['id']."' value='".$gamecredit."' class='form-control input-small' placeholder='ยอดก่อนถอน' maxlength='10' disabled></div>

					<div class='col-xs-6'><input type='text' id='wd_aft_am_".$row1['id']."' class='form-control input-small' placeholder='ยอดหลังถอน' maxlength='10'></div>

					<div class='clearfix'> </div>

					<div class='col-xs-6' style='margin-top:10px;margin-bottom:10px;'><input type='text' id='wd_tran_am_".$row1['id']."' class='form-control input-small' placeholder='ยอดทรานเฟอ' maxlength='10'></div>

					<div class='col-xs-6' style='margin-top:10px;margin-bottom:10px;'><a href='javascript:;' onClick='WDcheck(".$row1['id'].")' class='btn btn-success' title='ยืนยันทำรายการเรียบร้อย'><span class='glyphicon glyphicon-check'></span> ยืนยัน</a></div>

				</div>

				</div>

			";

				

			$wd_check = '<a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom"  data-html="true" class="btn btn-success btn-xs" data-content="'.$formf.'" data-original-title="ยินยันการทำรายการ"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a>';

		}else{

			$wd_check = '<span class="glyphicon glyphicon-check text-success"></span>';
			$wd_true = 'Y';

		}

			$formwd = "

				<div class='col-xs-12'>

				<div class='row'>

					<div class='col-xs-12'>

						<select class='form-control input-small' id='wdfrombank_".$row1['id']."'>

							<option value='กสิกรไทย'>กสิกรไทย</option>

							<option value='กรุงเทพ'>กรุงเทพ</option>

							<option value='กรุงไทย'>กรุงไทย</option>

							<option value='ไทยพาณิชย์'>ไทยพาณิชย์</option>

							<option value='ทหารไทย'>ทหารไทย</option>

						</select>

					</div>

					<div class='clearfix'> </div>

					<div class='col-xs-6' style='margin-top:10px;margin-bottom:10px;'><a href='javascript:;' onClick='WDok(".$row1['id'].")' class='btn btn-success' title='ยืนยันทำรายการเรียบร้อย'><span class='glyphicon glyphicon-check'></span> ยืนยัน</a></div>

				</div>

				</div>

			";

		if($row1['withdrawal'] == 'pending'){	

			$stat = '

				<a href="javascript:;" onClick="WDcancel(\''.$row1['id'].'\')" class="btn btn-danger btn-xs" title="ยกเลิกการทำรายการนี้"><span class="glyphicon glyphicon-trash"></span> ยกเลิก</a>

			';

		}else{

			$stat = '

				<a  href="javascript:;" data-toggle="popover" data-html="true" data-placement="bottom"  class="btn btn-success btn-xs" data-content="'.$formwd.'"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a>

			';
			
			

		}

		#$trclr = ' class="danger"';

	}elseif($row1['types'] == 'transfer'){

		$type = 'โยก';

		$color = '000044';

		if($row1['transfrom'] == 'pending'){

			

	if($row1['froms']=='moneybag'.$row1['owner'].''){
	$sql5 = "select * from member where id = '".$row1['owner']."'";
	}else{
	$sql5 = "select * from gameusers where gameuser = '".str_replace("W88:","",$row1['froms'])."'";
	}
	//echo $sql5;

	$result5 = $conn->query($sql5);

	

	$resx = $result5->fetch_assoc();

	

				if($resx['provider'] == 'GCLUB' or $resx['provider'] == 'TBSBET' or $resx['provider'] == 'ASIA855' or $resx['provider'] == 'ROYAL1688' or $resx['provider'] == 'W88'){

					

					$sql4 = "select * from agent where provider in ('GCLUB','TBSBET','ASIA855','ROYAL1688','W88')";

	$result4 = $conn->query($sql4);

	

	while( $rowgz = $result4->fetch_assoc()){

						if(preg_match("#".strtolower($rowgz['name'])."#",strtolower($row1['froms']))){

							$gamecredit = $rowgz['credit'];

						}

					}

				}else{
					
					if($row1['froms']=='moneybag'.$row1['owner'].''){ $gamecredit = $resx['moneybag']; }else{ $gamecredit = $resx['credit']; }
				}

			$formf = "

				<div class='col-xs-12'>

				<div class='row'>

					<div class='col-xs-6'><input type='text' id='tff_bef_am_".$row1['id']."' value='".$gamecredit."' class='form-control input-small' placeholder='ยอดก่อนถอน' maxlength='10' disabled></div>

					<div class='col-xs-6'><input type='text' id='tff_aft_am_".$row1['id']."' class='form-control input-small' placeholder='ยอดหลังถอน' maxlength='10'></div>

					<div class='clearfix'> </div>

					<div class='col-xs-6' style='margin-top:10px;margin-bottom:10px;'><input type='text' id='tff_tran_am_".$row1['id']."' class='form-control input-small' placeholder='ยอดทรานเฟอ' maxlength='10'></div>

					<div class='col-xs-6' style='margin-top:10px;margin-bottom:10px;'><a href='javascript:;' onClick='TFFcheck(".$row1['id'].")' class='btn btn-success' title='ยืนยันทำรายการเรียบร้อย'><span class='glyphicon glyphicon-check'></span> ยืนยัน</a></div>

				</div>

				</div>

			";			

			$tff_check = '<a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom"  data-html="true" class="btn btn-success btn-xs" data-content="'.$formf.'" data-original-title="ยินยันการทำรายการ"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a>';

		}else{

			$tff_check = '<span class="glyphicon glyphicon-check text-success"></span>';

		}

			$gamecredit = 0;

		if($row1['transto'] == 'pending' and $row1['transfrom'] != 'pending'){

			

			

					$sql4 = "select * from gameusers where gameuser = '".str_replace("W88:","",$row1['tos'])."'";

	$result4 = $conn->query($sql4);

	

	$resy = $result4->fetch_assoc();

				if($resy['provider'] == 'GCLUB' or $resy['provider'] == 'TBSBET' or $resy['provider'] == 'ASIA855' or $resy['provider'] == 'ROYAL1688' or $resy['provider'] == 'W88'){

					

					$sql4 = "select * from agent where provider in ('GCLUB','TBSBET','ASIA855','ROYAL1688','W88')";

	$result4 = $conn->query($sql4);

	

	while( $rowgz = $result4->fetch_assoc()){

						if(preg_match("#".strtolower($rowgz['name'])."#",strtolower($row1['tos']))){

							$gamecredit = $rowgz['credit'];

						}

					}

				}else{

					$gamecredit = $resy['credit'];

				}			

			$formto = "

				<div class='col-xs-12'>

				<div class='row'>

					<div class='col-xs-6'><input type='text' id='tft_bef_am_".$row1['id']."' value='".$gamecredit."' class='form-control input-small' placeholder='ยอดก่อนเติม' maxlength='10' disabled></div>

					<div class='col-xs-6'><input type='text' id='tft_aft_am_".$row1['id']."' class='form-control input-small' placeholder='ยอดหลังเติม' maxlength='10'></div>

					<div class='clearfix'> </div>

					<div class='col-xs-12' style='margin-top:10px;margin-bottom:10px;'><a href='javascript:;' onClick='TFTcheck(".$row1['id'].")' class='btn btn-success' title='ยืนยันทำรายการเรียบร้อย'><span class='glyphicon glyphicon-check'></span> ยืนยัน</a></div>

				</div>

				</div>

			";

			$tft_check = '<a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom"  data-html="true" class="btn btn-success btn-xs" data-content="'.$formto.'" data-original-title="ยินยันการทำรายการ"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a>';

		}elseif($row1['transto'] != 'pending'){

			$tft_check = '<span class="glyphicon glyphicon-check text-success"></span>';

		}

		

		if($row1['transfrom'] == 'pending'){

		$stat = '

			<a href="javascript:;" onClick="TFok(\''.$row1['id'].'\')" class="btn btn-success btn-xs" title="ยืนยันทำรายการเรียบร้อย"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a>

			<a href="javascript:;" onClick="TFcancel(\''.$row1['id'].'\')" class="btn btn-danger btn-xs" title="ยกเลิกการทำรายการนี้"><span class="glyphicon glyphicon-trash"></span> ยกเลิก</a>

		';

		}else{

		$stat = '

			<a href="javascript:;" onClick="TFok(\''.$row1['id'].'\')" class="btn btn-success btn-xs" title="ยืนยันทำรายการเรียบร้อย"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a>

		';
		if(strstr($row1['froms'],'moneybag')){
			$stat .= '

				<a href="javascript:;" onClick="TFcancel(\''.$row1['id'].'\')" class="btn btn-danger btn-xs" title="ยกเลิกการทำรายการนี้"><span class="glyphicon glyphicon-trash"></span> ยกเลิก</a>


			';
			}

		}



		if(preg_match("#NEWUSER#", $row1['tos'])){

			$addnewgameusr = "

				<div class='col-xs-12'>

				<div class='row'>

					<div class='col-xs-12'><input type='text' id='dep_newusr_ch_".$row1['id']."' value='' class='form-control input-small' placeholder='ระบุบัญชีเกมส์ใหม่'></div>

					<div class='clearfix'> </div>

					<div class='col-xs-12' style='margin-top:10px;margin-bottom:10px;'><button class='btn btn-success' onClick='savenewgameusr(".$row1['id'].")' type='button'><span class='glyphicon glyphicon-check'></span> บันทึก</button></div>

				</div>

				</div>

			";

			$newusrbutton = '

				<a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom"  data-html="true" class="btn btn-success btn-xs" data-content="'.$addnewgameusr.'" data-original-title="เปิดบัญชีใหม่"><span class="glyphicon glyphicon-check"></span> เปิดบัญชีใหม่</a>

			';

		}		

		#$trclr = ' class="danger"';

	}else if($row1['types'] == 'repass'){

		$type = 'รีเซ็ตรหัสผ่าน';

		$color = 'FF3333';
		
		if($row1['transfrom']=='pending'){
			
			
		$formtore = "

				<div class='col-xs-12'>

				<div class='row'>

					<div class='col-xs-12'><input type='text' id='fromt_".$row1['id']."' value='' class='form-control input-small' placeholder='รหัสผ่านใหม่'  >
					<input type='hidden' id='gameuser_".$row1['id']."' value='".$row1['froms']."' >
					</div>

					<div class='clearfix'> </div>

					<div class='col-xs-12' style='margin-top:10px;margin-bottom:10px;'><a href='javascript:;' onClick='confrepassname(".$row1['id'].")' class='btn btn-success' title='ยืนยันทำรายการเรียบร้อย'><span class='glyphicon glyphicon-check'></span> ยืนยัน</a></div>

				</div>

				</div>

			";

			$fromre = '<span id="fromre_'.$row1['id'].'"><a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom"  data-html="true" class="btn btn-success btn-xs" data-content="'.$formtore.'" data-original-title="ยินยันการทำรายการ"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a></span>';

		
		$stat = ' <a href="javascript:;" onClick="repasscancel(\''.$row1['id'].'\',\''.$row1['froms'].'\')" class="btn btn-danger btn-xs" title="ยกเลิกการทำรายการนี้"><span class="glyphicon glyphicon-trash"></span> ยกเลิก</a>';
		
		
		}else{
		
		$fromre = '<span class="glyphicon glyphicon-check text-success"></span>';
		
		$newpassw = "<span class=\"label label-default\">NEWPASS: ".$row1['gamepass']."</span>";
		
		$stat = '';
		
		}
		
		if($row1['transto']=='pending'){
			
			$tor = "

				<div class='col-xs-12'>

				<div class='row'>
					
					<div class='col-xs-12'><span id='phone_".$getmember['id']."'>0XXXXX".substr($getmember['phone'], 6, 4)."</span> <button type='button' class='btn btn-info btn-xs' onClick='detailphone(".$getmember['id'].")'>Show</button>
					<input type='hidden' id='gameuser_".$row1['id']."' value='".$row1['froms']."' >
					</div>

					<div class='clearfix'> </div>

					<div class='col-xs-12' style='margin-top:10px;margin-bottom:10px;'><a href='javascript:;' onClick='confrepasssms(".$row1['id'].")' class='btn btn-success' title='ยืนยันทำรายการเรียบร้อย'><span class='glyphicon glyphicon-check'></span> ยืนยัน</a></div>

				</div>

				</div>

			";

			$tore = '<span id="tore_'.$row1['id'].'"><a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom"  data-html="true" class="btn btn-success btn-xs" data-content="'.$tor.'" data-original-title="ยินยันการทำรายการ"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a></span>';

		
		
		//$tore = '<span id="tore"><a tabindex="0" href="javascript:;" class="btn btn-success btn-xs" onclick="confrepasssms(\''.$row1['id'].'\',\''.$row1['froms'].'\')"><span class="glyphicon glyphicon-check"></span> ยืนยัน</a></span>';
		
		
		}else{
		
		$tore = '<span class="glyphicon glyphicon-check text-success"></span>';
		
		}
		
		
		

	}

if($row1['types']=='withdrawal'){ $wdto = $wdto;  }else{ $wdto = '';  }
if($row1['types']=='repass'){ $newpassw = $newpassw; $fromre=$fromre; $tore=$tore; }else{ $newpassw = ''; $fromre=''; $tore=''; }

		$from = "<span class=\"label label-default\">".strtoupper($row1['froms'])."</span> ".$wd_check.$tff_check.$timedep.$fromre.$newpassw;

		$to = "<span class=\"label label-default\">".strtoupper($row1['tos'])."</span> ".$tft_check.$newusrbutton.$wdto.$tore;
;

		$bmp = ($row1['before_mount_p'] == '-9.99')? '-' : $row1['before_mount_p'];

		$amp = ($row1['after_mount_p'] == '-9.99')? '-' : $row1['after_mount_p'];

		$warning = ($row1['sure'] == 0)? ' class="warning"' : '';

		


if($qdetail!=''){ $trcolor = 'bgcolor="#FFFF99"'; }else{ $trcolor = ''; }
		//if((($row1['types'] == 'withdrawal')and($row1['withdrawal'] == 'pending'))or(  )){
		if($wd_true!='Y'){
		$table .= '
					'.$qdetail.'
				  <tr'.$trclr.' '.$trcolor.' id="monitor_'.$row1['id'].'">

					<td bgcolor="'.$trbg.'"><a tabindex="0" href="javascript:;" data-toggle="popover" data-placement="bottom"  data-html="true" class="btn btn-success btn-xs" data-content="'.$popdetail.'" data-original-title="รายละเอียดบัญชี">'.$usernameshow.'</a></td>

					<td>'.date("d-m-Y H:i",$row1['added']).'</td>

					<td><span style="color:#'.$color.';">'.$type.'</span></td>					

					<td>'.$from.'</td>
					
					<td><span style="color:#'.$color.';font-weight: bold;">'.number_format($row1['amount']).'</span></td>
					
					<td>'.$to.'</td>
					
					<td bgcolor="'.$trbg.'">'.$row1['webroot'].'</td>

					<td>'.$stat.'</td>

				  </tr>

		';
		}
	
	
	

	
	//print_r($_COOKIE);
	
	if($_COOKIE['PCLASS']=='Personnel'){	
	
	if($row1['types']=='transfer'){
	
	if(strstr(strtoupper($row1['tos']),strtoupper('NEWUSER:'))){
		$tablep = $table;
	}else{
		for($x = 0; $x < count($usesel); $x++) {

    if(strstr(strtoupper($row1['froms']),strtoupper($usesel[$x]))and($row1['transfrom']=='pending')){
	$tablep = $table;
   }
   
   
   
   if(strstr(strtoupper($row1['tos']),strtoupper($usesel[$x]))and($row1['transfrom']=='confirmed')){
	$tablep = $table;
   }
}
}
}else{

	$tablep = $table;
}

	}else{
	
	$tablep = $table;
	}
	
	
	}

    
print($tablep);

	
	

    ?>

    

									<tbody>

						</table>			

					</div>

				</div>

            </div>

            <?php 
			//echo "<br>-------โปรแกรมเมอร์--------<br>";
			//echo $sql1;
			//echo "<br>-------โปรแกรมเมอร์--------";
			//}else{ echo "แบ่งงานก่อน"; } 
			
			//echo $sql1;
			?>
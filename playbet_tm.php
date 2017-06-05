						
<?
@session_start();
if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
 echo '<script> window.location="index.php"; </script>';
  exit;
}

//require_once "service/service.php";
//require_once "creation/creation.init.php";



include("core/core.php");
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


$row = $db->GetRow("SELECT sum(amount) AS Total FROM paylogs where owner='".$member['id']."' AND froms like 'T:%' AND tos NOT LIKE 'W88:%' AND added > '".strtotime(date('Y-m-d 00:00:00'))."'");

$row88 = $db->GetRow("SELECT sum(amount) AS Total FROM paylogs where owner='".$member['id']."' AND froms like 'T:%' AND tos like 'W88:%' AND added > '".strtotime(date('Y-m-d 00:00:00'))."'");

$tmsum = $row['Total'];
$tmsumw88 = $row88['Total'];

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
			$(".btn-primary").text("กรุณารอซักครู่.....");
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
			$(".btn-primary").text("กรุณารอซักครู่.....");
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
			$(".btn-primary").text("กรุณารอซักครู่.....");
			setTimeout( "submit_tmnc()", 4000);
			
			return false
			
			 }else{  alert('กรุณาระบุทรูมันนี่ให้ครบ 14 หลัก'); return false }
		}
		
		
	});
	}
	
	
	
	

</script>
<link href="css/bootstrap.css" rel="stylesheet">
 <style type="text/css">
<!--
html { color:#FFFFFF; }
body { color:#FFFFFF; background-color:#222222; width:650px; }
 </style>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<?php

						
							
								
									$html = '<h3 style="margin-top:15px;">เติมเงินผ่าน บัตร <strong>เงินสด</strong></h3>
									<hr>
									<div margin-top:-20px;>
									<form class="form-horizontal form-Right" action="" method="POST" >
                                        
                                        
                                        <!-- TMTOPUP -->
                                        <!--<input name="tmn_password" type="hidden" id="tmn_password" maxlength="14" />-->
                                        <input name="ref1" type="hidden" id="ref1" value="'.$member['id'].'" />
                                        <input name="ref2" type="hidden" id="ref2" value="moneybag" />
                                        <input name="ref3" type="hidden" id="ref3" value="OTB" />
                                        
                                        <!-- TMTOPUP -->
                                        
                                        
											 <div class="form-group" style="margin-top:25px;">
													<label for="true_gameuser" class="col-xs-6 col-md-6 control-label" ></label>
													<div class="col-xs-6 col-md-6">
														
													</div>
													
											 </div>
											 <div class="clearfix"></div>


											 											 
											 <div class="form-group" style="margin-top:-10px;">
													<label for="truepin" class="col-xs-4 col-md-4 control-label" >รหัสบัตรเงินสด:</label>
													<div class="col-xs-7 col-md-7">
														 <input type="text" name="tmn_true" id="tmn_password" value="" class="form-control w_form2 input-small" style="color:#000;" data-toggle="tooltip"'; 
														 if($member['suped']=='sup' or $member['locked']=='lock'){ $html .= 'disabled placeholder="ถูกระงับ กรุณาติดต่อแชท"'; }else{ 
														 $html .= 'placeholder="โปรดระบุ"'; } $html .= ' maxlength="14"> <span style="color:#FF0000;">*ฝากต่อวันไม่เกิน '.$member['tmlimit'].' บาท</span>
													</div>
											 </div>
											 <div class="clearfix"></div>
											 <div class="form-group" style="margin-top:-15px;">
													<div class="col-xs-offset-4 col-md-offset-4 col-xs-4 col-md-4">
													';
                                                     if($member['suped']!='sup'){
															if($webclose=='Y'){ 
																$html .=$webclose_text;
															}else{
														 if($tmsum >= $member['tmlimit']){ $html .= '<div style="color:red;">ยอด TM รวมวันนี้ เกิน '.$member['tmlimit'].' บาทแล้ว ไม่สามารถทำรายการฝากเพิ่มได้</div>';  }else{ $html .= '<button onClick="onsubm();" type="button" value="ส่งข้อมูล" class="btn btn-primary"><Strong>ส่งข้อมูล</strong></button>'; } 
															}
														}else{ $html = 'ขณะนี้ท่านถูกระงับการทำรายการ กรุณาติดต่อแชท'; } 
                                                  $html .= '  </div>
											 </div>
										</form>
										</div>
									<hr>	
										
                                    <div style="float:left; width:250px;">

 <table border="1" cellpadding="0" cellspacing="6" width="220" style="margin:10px;">
   <thead>
   <tr>
        <th height="40" colspan="2"  align="center"><div align="center"><strong>บัตรเงินสด</strong></div></th>
      </tr>
      <tr>
        <th><div align="center">มูลค่าบัตร</div></th>
        <th><div align="center">ที่ได้รับ</div></th>
      </tr>
    </thead>
												<tbody >
		

												<tr>
															<td width="50%" >
															<div align="center">50 บาท</div>
												  </td>
															<td width="50%">
															<div align="center">42 บาท</div>
												 </td>
														</tr>
														<tr>
															<td width="50%" >
															<div align="center">90 บาท</div>
														  </td>
															<td width="50%">
															<div align="center">76 บาท</div>
														  </td>
														</tr>
														<tr>
															<td width="50%" >
															<div align="center">150 บาท</div>
														  </td>
															<td width="50%">
															<div align="center">127 บาท</div>
														  </td>
														</tr>
														<tr>
															<td width="50%" >
															<div align="center">300 บาท</div>
														 </td>
															<td width="50%">
															<div align="center">255 บาท</div>
														  </td>
														</tr>
														<tr>
															<td width="50%" >
															<div align="center">500 บาท</div>
														  </td>
															<td width="50%">
															<div align="center">425 บาท</div>
														  </td>
														</tr>
														<tr>
															<td width="50%" >
															<div align="center">1,000 บาท</div>
														 </td>
															<td width="50%">
															<div align="center">850 บาท</div>
														  </td>
														</tr>
												</tbody>
											</table>
                                
                                    </div>
                                    
                                    <div style="float:right; width:400px;">
									<p>
									<div style="color:red;">*ค่าธรรมเนียม 15%
									<br>*ต้องมียอดเล่น 1 เท่า จึงจะถอนเงินได้*</div>
<div style="color:yellow;">ไม่รับออนไลน์ / ไม่รับเติมเงินโทรศัพท์</div>
								</p>
									
									<p>
										<small>* สำหรับสมาชิกใหม่ จะได้รับ id , pass โดยจะส่งไปให้ทาง SMS ตามหมายเลขที่กรอกในช่อง Username
										<br>* หลังจากเติมเงินไม่เกิน 10 นาที ยอดเงินจะเข้าระบบ
										<br>* ถ้าเกิน 10 นาที ยังไม่ได้รับความคืบหน้าใดๆ รบกวน ติดต่อ Livechat
										<br>* ถอนเงินขั้นต่ำ 500 บาท โดยโอนเข้าบัญชีธนาคาร ไม่หักค่าธรรมเนียม หรือ ค่าบริการใดๆ ได้ยอดเงินเต็ม 100%</small>
									</p>
								
							
						</div></div>';
						
						$status['status'] = "1";
		$status['html'] = $html;
		//echo json_encode($status);
		//exit();
		
		echo $html;
		?>
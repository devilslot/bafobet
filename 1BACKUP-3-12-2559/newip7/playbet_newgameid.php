<?
session_start();

/*if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
 echo '<script> window.location="index.php"; </script>';
  exit;
}*/
include("core/core.php");
$db=Live::core("db");
$member=Live::member();
$resx = $db->GetRow("select * from tmtopup where used = '1'");

if($member['locked'] == 'lock'){
	$status['status'] = "0";
		header ('Location: index.php');
		exit();
}


$ck1 = $db->GetAll("select member.id,member.mactive,gameusers.* from member left join gameusers on gameusers.owner=member.id where member.id = '".$member['id']."'  and member.webroot='bafobet' AND member.mactive='N' ");
		 
		 if($ck1[0]['gameuser']!='' and $ck1[0]['mactive']=='N'){
		 $dcb = 'disabled="disabled"';
		 
		 }
		 
if(isset($_POST['act'])){


$row = $db->GetRow("SELECT sum(amount) AS Total FROM paylogs where owner='".$member['id']."' AND froms like 'T:%' AND tos NOT LIKE 'W88:%' AND added > '".strtotime(date('Y-m-d 00:00:00'))."'");

$row88 = $db->GetRow("SELECT sum(amount) AS Total FROM paylogs where owner='".$member['id']."' AND froms like 'T:%' AND tos like 'W88:%' AND added > '".strtotime(date('Y-m-d 00:00:00'))."'");

$tmsum = $row['Total'];
$tmsumw88 = $row88['Total'];



							
									$html = '<h3>ทำรายการเปิดไอดีค่ายใหม่</h3>
                                    <hr />
										<form class="form-horizontal form-Right" action="" method="POST" onSubmit="opennewusergame(); return false;">
											 

											<div class="form-group" id="newgamelist">
													<label for="dep_gameuser" class="col-xs-4 col-md-4 control-label" style="text-align:right;" >ยอดถุงเงินทั้งหมด :</label>
													<div class="col-xs-7 col-md-7">
                                                   <div class="input-group"  >
                                                    
									                    '.$member['moneybag'].'
                                                         บาท
														</div>										
													</div>
											 </div>	
                                             
                                             <div class="form-group">
													<label for="dep_gameuser" class="col-xs-4 col-md-4 control-label"  style="text-align:right;">เลือกค่ายเกมส์ใหม่ :</label>
													<div class="col-xs-7 col-md-7">'.$_POST['prov'].'
									                   
													<input type="hidden" name="pv_gameuser" id="pv_gameuser" value="'.$_POST['prov'].'">												
													</div>
											 </div>									

											 <div class="clearfix"></div>
                                             
                                             <div class="form-group" style="margin-top:-5px;">
													<label for="dep_amount" class="col-xs-4 col-md-4 control-label" style="text-align:right;" >จำนวนเงินเปิดไอดีเกมส์ :</label>
													<div class="col-xs-7 col-md-7" style="margin-left:5px;">
														<div class="input-group"  >
															<span class="input-group-addon form-control3 input-small" >฿</span>
															<input type="text" class="input-group-addon form-control3 input-small" name="wd_amount" id="wd_amount" style="width:100%; height:30px; text-align:left;">
															<span class="input-group-addon form-control3 input-small">.00</span>
														</div>
													</div>
											 </div>
											 <div class="clearfix"></div>	
                                             
											 
											 
											<!-- <div class="form-group" style="margin-top:-5px;">
													<label for="dep_q" class="col-xs-3 col-md-3 control-label" >รหัสคูปอง :</label>
													<div class="col-xs-7 col-md-7 " >
														<input type="text" class=" form-control input-small" name="dep_coupon" id="dep_coupon" style="width:100%; height:30px; text-align:left;">
													</div>
													
											 </div>
											 <div class="clearfix"></div>-->

											
											 
											 <div class="form-group" style="margin-top:-5px;">
													<div class="col-xs-offset-5 col-md-offset-5 col-xs-3 col-md-3">';
                                                    if($member['suped']!='sup'){
                                                    $html .= '<button id="dep_button_s" type="submit" value="ส่งข้อมูล" '.$dcb.' class="btn btn-primary"><Strong>ส่งข้อมูล</strong></button>';
                                                    }else{ $html .= 'ขณะนี้ท่านถูกระงับการทำรายการ กรุณาติดต่อแชท'; } 
													
													$html .= '</div>
											 </div>
										</form>
								</div>
								<div class="col-xs-12 col-sm-12 pm0 bg-table-bottom"></div>
							</div>
						</div>
						
						
						
<div class="clearfix"></div>';
  
  $status['status'] = "1";
		$status['html'] = $html;
		echo json_encode($status);
		exit();
		} 
		?>
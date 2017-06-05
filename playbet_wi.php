<?
session_start();

/*if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
 echo '<script> window.location="index.php"; </script>';
  exit;
}*/
include("core/core.php");
$db=Live::core("db");
$member=Live::member();

if($member['locked'] == 'lock'){
	$status['status'] = "0";
		header ('Location: index.php');
		exit();
}

if(isset($_POST['act'])){		
						
							
									$html = '<h3><span class="glyphicon glyphicon-download" aria-hidden="true" style="font-size:15px;"></span>&nbsp;ถอนเงิน</h3>
                                    <hr />
										<form class="form-horizontal form-Right" action="" method="POST" onSubmit="sendWD(); return false;">
											 <div class="form-group" style="margin-top:25px;">
													<label for="wd_gameuser" class="col-xs-3 col-md-3 control-label" >บัญชีเกมส์ :</label>
													<div class="col-xs-5 col-md-5">
														<select id="wd_gameuser" name="wd_gameuser" onChange="" class="form-control w_form2 input-small" style="width:100%; height:30px;">
															<option value="">เลือกบัญชีเกมส์ที่ต้องการ</option>
															';
															
																$true_res = $db->GetAll("select * from gameusers where owner = '".$member['id']."' and provider != 'W88' and provider='".$_POST['prov']."' ");
																foreach($true_res as $x){
																	$html .= '<option value="'.$x['gameuser'].'">'.strtoupper($x['gameuser']).'</option>';
																}
															
														$html .= '</select>															
													</div>
											 </div>
											 <div class="clearfix"></div>
											 <div class="form-group" style="margin-top:-5px;">
													<label for="wd_amount" class="col-xs-3 col-md-3 control-label" >จำนวนเงิน :</label>
													<div class="col-xs-5 col-md-5" style="margin-left:5px;">
														<div class="input-group"  style="padding-bottom:10px;">
															<span class="input-group-addon form-control3 input-small" >฿</span>
															<input type="text" class="input-group-addon form-control3 input-small" name="wd_amount" id="wd_amount" style="width:100%; height:30px; text-align:left;">
															<span class="input-group-addon form-control3 input-small">.00</span>
														</div>
													
													</div>
											 </div>
											 
											 <div class="form-group" style="margin-top:-5px;">
													<label for="wd_gameuser" class="col-xs-3 col-md-3 control-label" >โอนเข้า :</label>
													<div class="col-xs-8 col-md-8"><strong>ธนาคาร</strong> '.$member['bankname'].'<strong> เลขที่บัญชี </strong>'.$member['banknumber'].'
													
														<select id="tf_gameuser" name="tf_gameuser" style="display:none;" class="form-control w_form2 input-small" style="width:100%; height:30px;">
															<option value="" id="tobank">บัญชีธนาคาร</option>
														</select>															
													</div>
											 </div>
											 
											 <div class="form-group" id="trannewgamelist" style="display:none;">
													<label for="dep_gameuser" class="col-xs-3 col-md-3 control-label" >เลือกค่ายเกมส์ใหม่ :</label>
													<div class="col-xs-5 col-md-5">
									                     <select id="tf_gameprovider" name="tf_gameprovider" class="form-control w_form2 input-small">
				                                            <option value="" selected>โปรดเลือก ค่ายเกมส์</option>
															<option value="Vegus168">Vegus168</option>
															<option value="GCLUB">GCLUB</option>
															<option value="SBOBET">SBOBET</option>
				                                        </select>
														</select>														
													</div>
											 </div>												 
											 
											 <div class="clearfix"></div>
											 
											 <div class="form-group" style="margin-top:-5px;">
													<div class="col-xs-offset-3 col-md-offset-3 col-xs-5 col-md-5">';
                                                     if($member['suped']!='sup'){
														 if($webclosewi=='Y'){ 
															$html .=$webclosewi_text;
														}else{
                                                   			$html .= '<button type="submit" class="btn btn-primary"><Strong>ส่งข้อมูล</strong></button>'; 
														}
													}else{ 
														$html .= 'ขณะนี้ท่านถูกระงับการทำรายการ กรุณาติดต่อแชท'; 
													} 
                                                    $html .= '</div>
											 </div>
										</form>';
								
		$status['status'] = "1";
		$status['html'] = $html;
		echo json_encode($status);
		exit();
		} 
		?>	
						
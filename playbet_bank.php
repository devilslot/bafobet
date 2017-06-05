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

if(isset($_POST['act'])){
									$html = '<h3><span class="glyphicon glyphicon-download" aria-hidden="true" style="font-size:15px;"></span>&nbsp;ทำรายการแจ้งฝากเงิน</h3>
                                    <hr />
										<form class="form-horizontal form-Right" action="" method="POST" onSubmit="sendDep(); return false;">
											 
											 
											 <div class="form-group" style="margin-top:25px;">
													<label for="dep_bank" class="col-xs-4 col-md-4 control-label" >โอนเข้าธนาคาร :</label>
													<div class="col-xs-5 col-md-5">
														<select class="form-control w_form2 input-small" name="bank" id="bank" onChange="selecbacc();" style="width:100%; height:30px;">
															<option value="" selected="selected">โปรดเลือก</option>';
															
								
								 
																$true_res = $db->GetAll("SELECT DISTINCT bank from bank where onsite='1' AND webroot='bafobet'  ");
																if($true_res){
																	foreach($true_res as $x){
																		 $html .= '<option value="'.$x['bank'].'">ธนาคาร'.$x['bank'].'</option>';
																	}
																}
																											
														$html .= '</select>	
													</div>
											 </div>
											 <div class="clearfix"></div>
											 <div class="form-group" style="margin-top:-5px;">
													<label for="dep_bank" class="col-xs-4 col-md-4 control-label" >โอนเข้าบัญชี :</label>
													<div class="col-xs-5 col-md-5">
														<select class="form-control w_form2 input-small" name="dep_bank" id="dep_bank" style="width:100%; height:30px;">
															<option value="">โปรดเลือก</option>														
														</select>	
													</div>
											 </div>
											 <div class="clearfix"></div>
                                             
                                             <div class="form-group" style="margin-top:-5px;">
													<label for="dep_amount" class="col-xs-4 col-md-4 control-label" >จำนวนเงิน :</label>
													<div class="col-xs-5 col-md-5" style="margin-left:5px;">
														<div class="input-group"  >
															<span class="input-group-addon form-control3 input-small" >฿</span>
															<input type="text" class="input-group-addon form-control3 input-small" name="dep_amount" id="dep_amount" style="width:100%; height:30px; text-align:left;">
															<span class="input-group-addon form-control3 input-small">.00</span>
														</div>
													</div>
											 </div>
											 <div class="clearfix"></div>
											 
                                             <div class="form-group" style="margin-top:-5px;">
													<label for="dep_q" class="col-xs-4 col-md-4 control-label" >รหัสคูปอง :</label>
													<div class="col-xs-5 col-md-5 " >
														<input type="text" class=" form-control input-small" name="dep_coupon" id="dep_coupon">
													</div>
													<label class="col-xs-3 col-md-3" >
																				</label>
											 </div>
											 <div class="form-group mbclass" style="margin-top:-10px;">
													<label for="dep_time" class="col-xs-4 col-md-4 control-label" >วันที่โอน :</label>
													<div class="col-xs-5 col-md-5 pm0">
														<div style="float:left; margin-right:5px;">
															<select id="dep_time" class="form-control input-small" style="height:30px; width:50px; padding:0px;">
																
<option value="">วัน</option>
<option'; if(date('d')=='1'){ $html.=' selected="selected" '; } $html.=' value="01">01</option>
<option'; if(date('d')=='2'){ $html.=' selected="selected" '; } $html.=' value="02">02</option>
<option'; if(date('d')=='3'){ $html.=' selected="selected" '; } $html.=' value="03">03</option>
<option'; if(date('d')=='4'){ $html.=' selected="selected" '; } $html.=' value="04">04</option>
<option'; if(date('d')=='5'){ $html.=' selected="selected" '; } $html.=' value="05">05</option>
<option'; if(date('d')=='6'){ $html.=' selected="selected" '; } $html.=' value="06">06</option>
<option'; if(date('d')=='7'){ $html.=' selected="selected" '; } $html.=' value="07">07</option>
<option'; if(date('d')=='8'){ $html.=' selected="selected" '; } $html.=' value="08">08</option>
<option'; if(date('d')=='9'){ $html.=' selected="selected" '; } $html.=' value="09">09</option>
<option'; if(date('d')=='10'){ $html.=' selected="selected" '; } $html.=' value="10">10</option>
															 	
<option'; if(date('d')=='11'){ $html.=' selected="selected" '; } $html.=' value="11">11</option>
<option'; if(date('d')=='12'){ $html.=' selected="selected" '; } $html.=' value="12">12</option>
<option'; if(date('d')=='13'){ $html.=' selected="selected" '; } $html.=' value="13">13</option>
<option'; if(date('d')=='14'){ $html.=' selected="selected" '; } $html.=' value="14">14</option>
<option'; if(date('d')=='15'){ $html.=' selected="selected" '; } $html.=' value="15">15</option>
<option'; if(date('d')=='16'){ $html.=' selected="selected" '; } $html.=' value="16">16</option>
<option'; if(date('d')=='17'){ $html.=' selected="selected" '; } $html.=' value="17">17</option>
<option'; if(date('d')=='18'){ $html.=' selected="selected" '; } $html.=' value="18">18</option>
<option'; if(date('d')=='19'){ $html.=' selected="selected" '; } $html.=' value="19">19</option>
<option'; if(date('d')=='20'){ $html.=' selected="selected" '; } $html.=' value="20">20</option>
															 	
<option'; if(date('d')=='21'){ $html.=' selected="selected" '; } $html.=' value="21">21</option>
<option'; if(date('d')=='22'){ $html.=' selected="selected" '; } $html.=' value="22">22</option>
<option'; if(date('d')=='23'){ $html.=' selected="selected" '; } $html.=' value="23">23</option>
<option'; if(date('d')=='24'){ $html.=' selected="selected" '; } $html.=' value="24">24</option>
<option'; if(date('d')=='25'){ $html.=' selected="selected" '; } $html.=' value="25">25</option>
<option'; if(date('d')=='26'){ $html.=' selected="selected" '; } $html.=' value="26">26</option>
<option'; if(date('d')=='27'){ $html.=' selected="selected" '; } $html.=' value="27">27</option>
<option'; if(date('d')=='28'){ $html.=' selected="selected" '; } $html.=' value="28">28</option>
<option'; if(date('d')=='29'){ $html.=' selected="selected" '; } $html.=' value="29">29</option>
<option'; if(date('d')=='30'){ $html.=' selected="selected" '; } $html.=' value="30">30</option>
<option'; if(date('d')=='31'){ $html.=' selected="selected" '; } $html.=' value="31">31</option>
															</select>
														</div>
														<div style="float:left; margin-right:5px;">
															<select id="dep_time1" class="form-control input-small" style="height:30px; padding:0px;">
																
<option value="">เดือน</option>
<option'; if(date('m')=='01'){ $html.=' selected="selected" '; } $html.=' value="01">มกราคม</option>
<option'; if(date('m')=='02'){ $html.=' selected="selected" '; } $html.=' value="02">กุมภาพันธ์</option>
<option'; if(date('m')=='03'){ $html.=' selected="selected" '; } $html.=' value="03">มีนาคม</option>
<option'; if(date('m')=='04'){ $html.=' selected="selected" '; } $html.=' value="04">เมษายน</option>
<option'; if(date('m')=='05'){ $html.=' selected="selected" '; } $html.=' value="05">พฤษภาคม</option>
<option'; if(date('m')=='06'){ $html.=' selected="selected" '; } $html.=' value="06">มิถุนายน</option>
<option'; if(date('m')=='07'){ $html.=' selected="selected" '; } $html.=' value="07">กรกฎาคม </option>
<option'; if(date('m')=='08'){ $html.=' selected="selected" '; } $html.=' value="08">สิงหาคม</option>
<option'; if(date('m')=='09'){ $html.=' selected="selected" '; } $html.=' value="09">กันยายน</option>
<option'; if(date('m')=='10'){ $html.=' selected="selected" '; } $html.=' value="10">ตุลาคม</option>
																
<option'; if(date('m')=='11'){ $html.=' selected="selected" '; } $html.=' value="11">พฤศจิกายน</option>
<option'; if(date('m')=='12'){ $html.=' selected="selected" '; } $html.=' value="12">ธันวาคม</option>
															</select>
														</div>
														<div style="float:left; margin-right:5px;">
															<select id="dep_time2" class="form-control input-small" style="height:30px; padding:0px;">
																
<option value="">ปี</option>
<option'; if(date('Y')=='2015'){ $html.=' selected="selected" '; } $html.=' value="2558">2558</option>
<option'; if(date('Y')=='2016'){ $html.=' selected="selected" '; } $html.=' value="2559">2559</option>
<option'; if(date('Y')=='2017'){ $html.=' selected="selected" '; } $html.=' value="2560">2560</option>
<option'; if(date('Y')=='2018'){ $html.=' selected="selected" '; } $html.=' value="2561">2561</option>
<option'; if(date('Y')=='2019'){ $html.=' selected="selected" '; } $html.=' value="2562">2562</option>
<option'; if(date('Y')=='2020'){ $html.=' selected="selected" '; } $html.=' value="2563">2563</option>
<option'; if(date('Y')=='2021'){ $html.=' selected="selected" '; } $html.=' value="2564">2564</option>
<option'; if(date('Y')=='2022'){ $html.=' selected="selected" '; } $html.=' value="2565">2565</option>
															</select>
														</div>
										
													</div>
											 </div>
											 <div class="clearfix"></div>
											 <div class="form-group mbclass" style="margin-top:-10px;">
													<label for="fullname" class="col-xs-4 col-md-4 control-label" >เวลาที่โอน :</label>
													<div class="col-xs-5 col-md-5 pm0">
														<div style="float:left; width:20%;">
															<select id="dep_time3" class="form-control input-small" style="height:30px;  padding:0px;">
																<option value="" selected>..</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option>
																<option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option>
																<option value="21">21</option><option value="22">22</option><option value="23">23</option>
															</select>
														</div>
														<div style="float:left; width:4%;"><p align="center" style="padding-top:10px; ">:</p></div>
														<div style="float:left; width:20%;">
															<select id="dep_time4" class="form-control  input-small" style="height:30px; padding:0px;">
																<option value="" selected>..</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option>
																<option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option>
																<option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option>
																<option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
																<option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option>
																<option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option>
																<option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option>
															</select>
														</div>
														

													</div>
											 </div>
											<div class="clearfix"></div>

											 <div class="form-group" style="margin-top:-5px;">
													<label for="dep_q" class="col-xs-4 col-md-4 control-label" >หมายเหตุ :</label>
													<div class="col-xs-5 col-md-5" >
														<textarea type="text" name="dep_q" id="dep_q" value="" class="form-control w_form2 input-small" data-toggle="tooltip" title="" placeholder="" rows="3" style="height:auto;"></textarea>
													</div>
											 </div>
											 <div class="clearfix"></div>
											 <div class="form-group" style="margin-top:-5px;">
													<div class="col-xs-offset-4 col-md-offset-4 col-xs-5 col-md-5">';
                                                   
												    if($member['suped']!='sup'){ 
													
														if($webclose=='Y'){ 
															$html .=$webclose_text;
														}else{
															$html .= ' <button id="dep_button_s" type="submit" value="ส่งข้อมูล" class="btn btn-primary"><Strong>ส่งข้อมูล</strong></button>';
														}
													}else{ 
														$html .= 'ขณะนี้ท่านถูกระงับการทำรายการ กรุณาติดต่อแชท'; 
													} 
													
													$html .= '</div>
											 </div>
										</form>
										<hr>
										<center style="color:#FFFF00;">**ท่านลูกค้าสามารถติดต่อสอบถาม "เลขบัญชี" ได้จาก chat ขวามือล่างค่ะ</div>
								</div>
								
							</div>
						';
						
						
		$status['status'] = "1";
		$status['html'] = $html;
		echo json_encode($status);
		exit();
		} 
		?>
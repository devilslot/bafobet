
	function newmember(){
		if($("#dep_gameuser option:selected").val() == 'NEWUSER'){
			$("#newgamelist").slideDown(500);
		}
	}

	function truenewmember(){
		if($("#true_gameuser option:selected").val() == 'NEWUSER'){
			$("#truenewgamelist").slideDown(500);
		}
	}

	function trannewmember(){
		if($("#tf_gameuser option:selected").val() == 'NEWUSER'){
			$("#trannewgamelist").slideDown(500);
		}
	}	
	
	function sendTopupW88(){
		//$("#f_loading_new").modal('show');
		//$("#loading_msg_new").html("<div class='text-center'>กำลังตรวจสอบข้อมูล........................</div>");
		var url="truetopup.php";
		var dataSet={ sendTopup: true,
			gameuser: $("#w88true_gameuser option:selected").val(),
			card: $("input#w88truepin").val(),
			type: 'W88'};
		$.post(url,dataSet,function(data){
			if(data.status == '0'){
				//$("#loading_msg_new").html("<div class='alert alert-success text-center'>"+data.msg+"</div>");
				alert(data.msg);
			}else if(data.status == '1'){	
				//$("#loading_msg_new").html("<div class='alert alert-success text-center'>"+data.msg+"</div>");	
				alert(data.msg);
			}
 		 }, "json");
	}

	function sendTopup(x){
		var newgameuser = '';
		$("#dep_button_s").hide(0);
		//$("#f_loading_new").modal('show');
		//$("#loading_msg_new").html("<div class='text-center'>กำลังตรวจสอบข้อมูล........................</div>");
		if($("#true_gameuser option:selected").val() == 'NEWUSER'){
			if($("#true_gameuser option:selected").val() == ''){
				$("#loading_msg_new").html("<div class='text-center'>เลือกค่ายที่ต้องการจะเปิดใหม้ก่อนค่ะ</div>");
				return false;
			}
			var newgameuser = ':'+$("#true_gameprovider option:selected").val();
		}
		var url="truetopup.php";
		var dataSet={ sendTopup: true,
			gameuser: $("#true_gameuser option:selected").val()+newgameuser,
			card: $("input#truepin").val(),
			type: x};
		$.post(url,dataSet,function(data){
			if(data.status == '0'){
				
				//$("#loading_msg_new").html("<div class='alert alert-success text-center'>"+data.msg+"</div>");
				alert(data.msg);
			}else if(data.status == '1'){
				
				//$("#loading_msg_new").html("<div class='alert alert-success text-center'>"+data.msg+"</div>");	
				alert(data.msg);
			}
 		 }, "json");
	}

	function sendDep(){
		$("#dep_button_s").hide(0);
		$("#f_loading_new").modal('show');
		$("#loading_msg_new").html("<div class='text-center'>กำลังตรวจสอบข้อมูล........................อาจใช้เวลา 1 - 5 นาที ในการตรวจสอบ</div>");
		var time = $("#dep_time1 option:selected").val()+'/'+$("#dep_time option:selected").val()+'/'+$("#dep_time2 option:selected").val()+' '+$("#dep_time3 option:selected").val()+':'+$("#dep_time4 option:selected").val();
		var min = 0 + $("#dep_time3 option:selected").val();
		var sec = 0 + $("#dep_time4 option:selected").val();
		var bankm = $("#dep_bank option:selected").val();
		var newgameuser = '';
		
		
			if(min == '0' || sec == '0'){
				$("#dep_button_s").show(0);
				//$("#loading_msg_new").html("<div class='text-center'>โปรดระบุเวลาที่โอนเข้ามา</div>");
				$("#f_loading_new").modal('hide');
				alert('โปรดระบุเวลาที่โอนเข้ามา');
				return false;
			}
		
		if($("#dep_gameuser option:selected").val() == 'NEWUSER'){
			if($("#dep_gameprovider option:selected").val() == ''){
				$("#dep_button_s").show(0);
				//$("#loading_msg_new").html("<div class='text-center'>เลือกค่ายที่ต้องการจะเปิดใหม้ก่อนค่ะ</div>");
				$("#f_loading_new").modal('hide');
				alert('เลือกค่ายที่ต้องการจะเปิดใหม้ก่อนค่ะ');
				return false;
			}
			var newgameuser = ':'+$("#dep_gameprovider option:selected").val();
		}
		var url="action.php";
		var dataSet={ sendDep: true,
			gameuser: 'moneybag',
			amount: $("#dep_amount").val(),
			coupon: $("#dep_coupon").val(),
			bankname: $("#dep_bank option:selected").val(),
			time: time,
			q: $("#dep_q").val()};
		$.post(url,dataSet,function(data){
			if(data.status == '0'){
				$("#dep_button_s").show(0);
				$("#loading_msg_new").html("<div class='alert alert-danger'>"+data.msg+"</div>");
				//alert(data.msg);
			}else if(data.status == '1'){
				$("#loading_msg_new").html("<div class='alert alert-success'>"+data.msg+"</div>");
				//alert(data.msg);
				var ck = setInterval(function(){
					var url="action.php";
					var dataSet={ cheackdeposit: true,
						rowid: data.rid};
					$.post(url,dataSet,function(data){
						if(data.status == '0'){

						}else if(data.status == '1'){
							alert("รายการฝากเงินของคุณ ได้รับการยืนยันเรียบร้อย ใช้เวลาในการเติมเข้าถุงเงิน 1 - 10 นาที");
							$("#loading_msg_new").html("<div class='alert alert-success'>รายการฝากเงินของคุณ ได้รับการยืนยันเรียบร้อย ใช้เวลาในการเติมเข้าถุงเงิน 1 - 10 นาที</div>");
							clearInterval(ck);
							window.location = 'playbet.php';
						}else if(data.status == '2'){
							alert("รายการฝากเงินของคุณ ได้ถูกปฏิเสธ หากคุณมั่นใจว่าทำรายการถูกต้อง โปรดติดต่อสอบถามผ่านช่องทางติดต่อที่สะดวกได้ทันที");
							$("#loading_msg_new").html("<div class='alert alert-danger'>รายการฝากเงินของคุณ ได้ถูกปฏิเสธ หากคุณมั่นใจว่าทำรายการถูกต้อง โปรดติดต่อสอบถามผ่านช่องทางติดต่อที่สะดวกได้ทันที</div>");
							clearInterval(ck);
							window.location = 'playbet.php';
						}
					}, "json");
				},5000);
			}
 		 }, "json");
	}
	
	function sendWD(){
		var newgameuser = '';
		$("#f_loading_new").modal('show');
		$("#loading_msg_new").html("<div class='text-center'>กำลังตรวจสอบข้อมูล........................อาจใช้เวลา 1 - 5 นาที ในการตรวจสอบ</div>");
		if($("#tf_gameuser option:selected").val() == 'NEWUSER'){
			if($("#tf_gameprovider option:selected").val() == ''){
				//$("#loading_msg_new").html("<div class='text-center'>เลือกค่ายที่ต้องการจะเปิดใหม้ก่อนค่ะ</div>");
				$("#f_loading_new").modal('hide');
				alert('เลือกค่ายที่ต้องการจะเปิดใหม้ก่อนค่ะ');
				return false;
			}
			var newgameuser = ':'+$("#tf_gameprovider option:selected").val();
		}		
		var url="action.php";
		var dataSet={ sendWD: true,
			gameuser: $("#wd_gameuser option:selected").val(),
			amount: $("#wd_amount").val(),
			phone: $("#wd_phone").val(),
			tranfers: $("#tf_gameuser option:selected").val()+newgameuser};
		$.post(url,dataSet,function(data){
			if(data.status == '0'){
				$("#loading_msg_new").html("<div class='alert alert-danger'>"+data.msg+"</div>");
				//alert(data.msg);
			}else if(data.status == '1'){
				$("#loading_msg_new").html("<div class='alert alert-success'>"+data.msg+"</div>");
				//alert(data.msg);
				var ck = setInterval(function(){
					var url="action.php";
					var dataSet={ cheackWd: true,
						rowid: data.rid};
					$.post(url,dataSet,function(data){
						if(data.status == '0'){

						}else if(data.status == '1'){
							alert("ยินดีด้วย การถอนเงินของท่านสำเร็จแล้ว! ใช้เวลาในการถอนเข้าเงินเข้าปลายทาง 1 - 10 นาที");
							$("#loading_msg_new").html("<div class='alert alert-success'>รายการถอนเงินของคุณ ได้รับการยืนยันเรียบร้อย ใช้เวลาในการถอนเงินเข้าปลายทาง 1 - 10 นาที</div>");
							clearInterval(ck);
							window.location = 'playbet.php';
						}else if(data.status == '2'){
							alert("รายการถูกยกเลิก ติดต่อแชท");
							$("#loading_msg_new").html("<div class='alert alert-danger'>รายการถอนเงินของคุณ ได้ถูกปฏิเสธ หากคุณมั่นใจว่าทำรายการถูกต้อง โปรดติดต่อสอบถามผ่านช่องทางติดต่อที่สะดวกได้ทันที</div>");
							clearInterval(ck);
							window.location = 'playbet.php';
						}
					}, "json");
				},5000);
			}
 		 }, "json");
	}	
	
	function sendBO(){
		
		var url="action.php";
		var dataSet={ sendBO: true, 
				couponcode: $("#couponcode").val()
				};
				
				//alert('open'+bank);
		$.post(url,dataSet,function(data){
									
			//alert('data'+data.status+''+data.msg);
									
			if(data.status == '0'){
				alert(data.msg);
				//$('#dep_bank').html(data.msg);
			}else if(data.status == '1'){
				alert(data.msg);
				window.location = 'playbet.php';
				//$('#dep_bank').html(data.msg);
			}
 		 }, "json");	
	}
	
	function sendeuro(){
		
		var url="action.php";
		var dataSet={ sendeuro: true, 
				seleuros: $("#euro option:selected").val()
				};
				
				//alert('open');
		$.post(url,dataSet,function(data){
									
			//alert('data'+data.status+''+data.msg);
									
			if(data.status == '0'){
				alert(data.msg);
				
			}else if(data.status == '1'){
				alert(data.msg);
				window.location = 'playbet.php';
				
			}
 		 }, "json");	
	}
	
		function selecbacc(){
		
		var url="action.php";
		var dataSet={ selecbacc: true, 
				bank: $("#bank option:selected").val()
				};
				
				//alert('open'+bank);
		$.post(url,dataSet,function(data){
									
			//alert('data'+data.status+''+data.msg);
									
			if(data.status == '0'){
				//alert(data.msg);
				//$('#dep_bank').html(data.msg);
			}else if(data.status == '1'){
				//alert(data.msg);
				$('#dep_bank').html(data.msg);
			}
 		 }, "json");	
	}
	
	
	function sele_tf_game(memberid){
		var url="action.php";
		var dataSet={ sele_tf_game: true,
			gameuser: $("#wd_gameuser option:selected").val(),
			memberid: memberid
			};
		$.post(url,dataSet,function(data){
			if(data.status == '0'){
				
			}else if(data.status == '1'){	
				$("#tf_gameuser").html(data.html);			
			}
 		 }, "json");
	}
	
	
	function getgift(id){
		//$("#f_loading_new").modal('show');
		$("#gift_"+id+"").html('<img src="images/gift_check.gif" width="100">');
		$("#gift_bonus_"+id+"").html('กำลังจับรางวัล.......');
		//alert('1');
		var url="action.php";
		var dataSet={ gift: true };
		setTimeout(function(){
							// alert('2');
		$.post(url,dataSet,function(data){
									//alert('3');
			if(data.status == '0'){
				$("#gift_"+id+"").html('<img src="images/gift.png" width="100">');
				$("#gift_bonus_"+id+"").html('<strong>'+data.msg+'</strong>');
				
			}else if(data.status == '1'){
				$("#gift_"+id+"").html('<img src="images/gift.png" width="100">');
				$("#gift_bonus_"+id+"").html('รางวัลของคุณคือ <strong>'+data.msg+'</strong>');
				$("#sit").html(data.sit);
				$("#sitt").html(data.sit);
			}
 		 }, "json");
		},3000);
	}
	
	
	function opennewusergame(){
		var newgameuser = '';
		$("#myModalBet").modal('show');
		var url="action.php";
		var dataSet={ opennewgames: true,
			amount: $("#wd_amount").val(),
			
			tranfers: 'NEWUSER:'+$("#pv_gameuser").val()};
		$.post(url,dataSet,function(data){
									//alert(data.status);
			if(data.status == '0'){
				//$("#loading_msg_new").html("<div class='alert alert-danger'>"+data.msg+"</div>");
				alert(data.msg);
			}else if(data.status == '1'){
				$("#myModalBetContent").html("<div class='alert alert-success'>"+data.msg+"</div>");
				//alert(data.msg);
				var ck = setInterval(function(){
					var url="action.php";
					var dataSet={ cheackWd: true,
						rowid: data.rid};
					$.post(url,dataSet,function(data){
						//alert(data.status);
						if(data.status == '0'){
						
						}else if(data.status == '1'){
							alert("ยินดีด้วย การเปิดไอดีใหม่ของท่านสำเร็จแล้ว! ใช้เวลาในการส่ง ID/Password ทาง SMS ประมาณ 1 - 10 นาที");
							//$("#loading_msg_new").html("<div class='alert alert-success'>รายการถอนเงินของคุณ ได้รับการยืนยันเรียบร้อย ใช้เวลาในการถอนเงินเข้าปลายทาง 1 - 10 นาที</div>");
							clearInterval(ck);
							window.location = 'playbet.php';
						}else if(data.status == '2'){
							alert("รายการ ไอดีใหม่ถูกยกเลิก");
							//$("#loading_msg_new").html("<div class='alert alert-danger'>รายการถอนเงินของคุณ ได้ถูกปฏิเสธ หากคุณมั่นใจว่าทำรายการถูกต้อง โปรดติดต่อสอบถามผ่านช่องทางติดต่อที่สะดวกได้ทันที</div>");
							clearInterval(ck);
							window.location = 'playbet.php';
						}
					}, "json");
				},5000);
			}
 		 }, "json");
	}	
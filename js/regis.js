
	
function sendregister(){
	
	if($("#password").val() != $("#conpassword").val()){
		alert("รหัสผ่านไม่ตรงกัน");
		document.frmRegister.cpassword.focus();
		return false;
	}	
	
		$("#loading_msg").html("<div class='alert alert-info'><img src='images/loader.gif' alt='Loading'> กำลังตรวจสอบข้อมูล........................</div>");
		$("#f_loading").show(0);
		$("#loading_msg").html("<div class='text-center'>กำลังตรวจสอบข้อมูล........................</div>");
		var url="admin/common/function.php";
		var dataSet={ openaccount: true,
			name: $("#name").val(),
			phone: $("#phone").val(),
			lineid: $("#lineid").val(),
			username: $("#username").val(),
			password: $("#password").val(),
			recom: $("#recom").val(),
			bankname: $("#bankname option:selected").val(),
			banknumber: $("#banknumber").val()};
		$.post(url,dataSet,function(data){
			if(data.status == '0'){
				$("#loading_msg").html("<div class='alert alert-danger'>"+data.msg+"</div>");
				//$("#f_loading").hide(0);
			}else if(data.status == '1'){
				$("#loading_msg").html("<div class='alert alert-success'>"+data.msg+"</div>");
				//$("#f_loading").hide(0);
				var countone=2;
				$one = setInterval(function(){countone--;if(countone == 0){window.location='index.php';}},1000);
			}
 		 }, "json");
	}
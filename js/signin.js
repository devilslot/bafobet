	function loginmember(){
		//$("#f_loading").show(0);
		//$("#loading_msg").html("<div class='text-center'>กำลังตรวจสอบข้อมูล........................</div>");
		var url="action.php";
		var dataSet={ loginmember: true,
			usr: $("#username").val(),
			pwd: $("#password").val()};
		$.post(url,dataSet,function(data){
			if(data.status == '0'){
				//$("#loading_msg").html("<div class='alert alert-danger'>"+data.msg+"</div>");
				alert(data.msg);
			}else if(data.status == '1'){
				//$("#loading_msg").html("<div class='alert alert-success'>"+data.msg+"</div>");
				//var countone=0;
				window.location='member.php';
			}
 		 }, "json");
	}
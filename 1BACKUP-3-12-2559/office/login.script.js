/*==================================================
*  Author : Attaphon Wongbuatong
*  Created Date : 14/6/2554 1:29
*  Module : Compile
*  Description : _FUNCTION_
*  Involve People : -
*  Last Updated : 14/6/2554 1:29
==================================================*/

/*==================================================
  :: METHOD ::
==================================================*/
var me={
  url:'login.inc.php'
};

me.Login=function(){
	$('#frmLogin').submit(function(){
		$('#err_insertuser').slideUp();
		$('#err_insertpass').slideUp();
		$('#err_login').slideUp();
		
		if($('#usernames').val()==''){
			$('#err_insertuser').slideDown();
			setTimeout(function(){
				$('#err_insertuser').slideUp();
			}, 3000);
			return;
		}
		if($('#passwords').val()==''){
			$('#err_insertpass').slideDown();
			setTimeout(function(){
				$('#err_insertpass').slideUp();
			}, 3000);
			return;
		}
		var myData = {
			user : $('#usernames').val(),
			pass : $('#passwords').val()
		};
		$.ajax({
			url:me.url+'?'+new Date().getTime(),
			type:'POST',
			dataType:'json',
			data:myData,
			success:function(data){
				switch(data.success){
					case 'COMPLETE' :
						window.location.href = data.url;
					break;
					default :
						$('#err_login').slideDown();
						setTimeout(function(){
							$('#err_login').slideUp();
						}, 3000);
					break;
				}
			}
		});
	});
};

$(document).ready(function(){	
	me.Login();
	$('#usernames').focus();
});









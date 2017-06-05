/*==================================================
*  Author : Tirapant Tongpann
*  Created Date : 14/6/2554 1:29
*  Module : Compile
*  Description : _FUNCTION_
*  Involve People : -
*  Last Updated : 14/6/2554 1:29
==================================================*/

/*==================================================
  :: VARIABLE ::
  ==================================================*/
  var me={
  	url:'creation/creation.inc.php',
  	get:ft.GetParam(),
  	lang:'th',
  	code:'',
  	alert_th:{
  		calladd : 'คุณต้องการเพิ่มข้อมูลใช่หรือไม่ ?',
  		calledit : 'คุณต้องการแก้ไขข้อมูลใช่หรือไม่ ?',
  		calldel : 'คุณต้องการลบข้อมูลใช่หรือไม่ ?',
  		savecomplete : 'บันทึกข้อมูลเรียบร้อย',
  		delcomplete : 'ลบข้อมูลเรียบร้อย',
  		saveerror : 'บันทึกข้อมูลผิดพลาด',
  		loadcomplete : 'โหลดข้อมูลเรียบร้อยแล้ว'
  	},
  	alert_en:{
  		calladd : 'Do yow want to add data?',
  		calledit : 'Do yow want to edit data?',
  		calldel : 'Do yow want to delete data?',
  		savecomplete : 'Save data complete',
  		delcomplete : 'Delete data complete',
  		saveerror : 'Save data error',
  		loadcomplete : 'Load complete'
  	}
  };

/*================================================*\
  :: METHOD ::
  \*================================================*/



  me.PutStar=function(){
  	var self;
  	var id = '';
  	var text = '';
  	$('.empty').each(function(){
  		self = $(this);
  		if((self.is('input:text')) || (self.is('input:file')) || (self.is('input:password')) || (self.is('textarea')) || (self.is('select'))){
  			id = $(this).attr('id');
  			text = $('#lbl'+id).html()+'';
  			text = text.split(' :').join('');
  			$('#lbl'+id).html(text+' <b><font color="red">*</font></b> :');
  		}
  	});
  };

  me.ClearData=function(){
  	$('#lyAddEdit input').val('');
  	$('#lyAddEdit select').val('');
  	$('#lyAddEdit textarea').val('');
  };

  me.ClearError=function(){
  	$('.err').css('display', 'none');
  	$('.form-group').removeClass('has-error');
  };

  me.CheckForm=function(){

  	me.ClearError();
  	if(ft.CheckEmpty('empty') == false)return false;
  	if(ft.CheckEmail('email') == false)return false;
  	// if(ft.CheckUserName('username') == false)return false;
  	// if(ft.CheckPassword('password') == false)return false;
  	// if(ft.Character('cha') == false)return false;
  	// if(ft.CheckTel('tel') == false)return false;
  	// if(ft.CheckZipCode('zip') == false)return false;
  	// if(ft.CheckDigit('digit') == false)return false;

  	return true;
  };

  me.AddError=function(id){
  	$('#dv'+id).addClass('has-error');
  	$('#e'+id).css('display', 'block');
  };

  me.SetDate=function(){
  	var lang = 'uk';
  	if(me.lang == 'TH'){
  		lang = 'th';
  	}
  	$('.dpk').datetimepicker({
  		language: lang,
  		format: 'yyyy-mm-dd',
  		pickerPosition: 'bottom-right',
  		weekStart: 1,
  		todayBtn:  1,
  		autoclose: 1,
  		todayHighlight: 1,
  		startView: 2,
  		minView: 2,
  		forceParse: 0
  	});
  };

  me.RefreshCaptcha=function(){
  	$.ajax({
  		url:me.url+'?mode=RefreshCaptcha&'+new Date().getTime(),
  		type:'POST',
  		dataType:'json',
  		cache: false,
  		data:{},
  		success:function(data){			
  			$('.captcha').css('background-position', data.position);
  		}
  	});
  };

  me.ForgetPass=function(){
  	var myData = {
  		data : ft.LoadForm('mydata')
  	}
  	$.ajax({
  		url:me.url+'?mode=ForgetPass&'+new Date().getTime(),
  		type:'POST',
  		dataType:'json',
  		data:myData,
  		success:function(data){
  			switch(data.success){
  				case 'COMPLETE' :
  				alert('Password is '+data.password);

  				break;
  				default:
  				alert('Not Found');

  			}
  		}
  	});
  };


  me.Login=function(){


    if($('#user').val() == ""){
      alert('กรุณาใส่ USERNAME');
      $('#user').focus()
      return false;
    }
    if($('#pass').val() == ""){
      alert('กรุณาใส่ PASSWORD');
      $('#pass').focus()
      return false;
    }



    var myData = {
      data : ft.LoadForm('mydata')
    }
    $.ajax({
      url:me.url+'?mode=Login&'+new Date().getTime(),
      type:'POST',
      dataType:'json',
      data:myData,
      success:function(data){
       switch(data.success){
        case 'COMPLETE' :
        window.location.reload();
        break;
        default:
        alert('เกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูล!');
        //window.location.reload();
      }
    }
  });
  };

  me.LoginHeader=function(){
  	var myData = {
  		data : {
  			username : $('#username_h').val(),
  			password : $('#password_h').val(),
  			captcha : $('#captcha_h').val()
  		}
  	}
  	$.ajax({
  		url:me.url+'?mode=Login&'+new Date().getTime(),
  		type:'POST',
  		dataType:'json',
  		data:myData,
  		success:function(data){
  			switch(data.success){
  				case 'COMPLETE' :
  				window.location.href = 'bankaccount';

  				break;

  				case 'CAPCHA' :
  				alert('CAPCHA is wrong');
  				window.location.href = 'login';
  				break;
  				default:
  				window.location.href = 'login';

  			}
  		}
  	});
  };

  me.LoadProfile=function(){

  	$.ajax({
  		url:me.url+'?mode=LoadProfile&'+new Date().getTime(),
  		type:'POST',
  		dataType:'json',
  		success:function(data){
  			var temp1 = data.profile.bank;
  			var temp2 = data.profile.account_name;
  			var temp3 = data.profile.account_no;

  			if(temp1 == '' || temp2 == '' || temp3 ==''){
  				$('#bank').val(data.profile.bank);
  				$('#account_name').val(data.profile.account_name);
  				$('#account_no').val(data.profile.account_no);
  			}else{
  				$('#bank').val(data.profile.bank);
  				$('#account_name').val(data.profile.account_name);
  				$('#account_no').val(data.profile.account_no);		
  				$('#bank').attr('disabled', true); 
  				$('#account_name').attr('disabled', true); 
  				$('#account_no').attr('disabled', true); 
  				$('.btn-login').hide(); 
  			}
  			$('#gender').val(data.profile.gender);
  			$('#mobile').val(data.profile.mobile);
  			$('#mobile1').val(data.profile.mobile1);
  		}
  	});
  };



//function Register() {
	me.Register=function(){

  if(!me.CheckForm()){
    $('#lyAddEdit input').first().focus();
    setTimeout('me.ClearError();', 5000);
    return;
  }

  var myData = {
    data : ft.LoadForm('mydata2')
  };
  
  $.ajax({
    url:me.url+'?mode=Register&'+new Date().getTime(),
    type:'POST',
    dataType:'json',
    data:myData,
    success:function(data){
	//alert(data.success);
      switch(data.success){
        case 'COMPLETE' :
        alert('ลงทะเบียนสำเร็จ')
		window.location.reload();
        break;
        case 'EMAIL' :
        alert('อีเมลล์นี้มีอยู่ในระบบแล้ว')
        break;
        case 'USERNAME' :
        alert('Username นี้มีอยู่ในระบบแล้ว')
        break;
      }
    }
  });
};




  me.SaveProfile=function(){

  	if(!me.CheckForm()){
  		$('#lyAddEdit input').first().focus();
  		setTimeout('me.ClearError();', 5000);
  		return;
  	}



  	var myData = {
  		data : ft.LoadForm('mydata')
  	}


  	$.ajax({
  		url:me.url+'?mode=SaveProfile&'+new Date().getTime(),
  		type:'POST',
  		dataType:'json',
  		data:myData,
  		success:function(data){
  			switch(data.success){
  				case 'COMPLETE' :
  				alert('Save Complete');
  				window.location.reload();
  				break;
  				case 'PASS' :
  				alert('Current Password is wrong');
  				break;
  				case 'PASSMATCH' :
  				alert('New Password is not match');
  				break;
  				default:
  				alert('Save Error');

  			}
  		}
  	});
  };

  me.SaveDeposit=function(){

  	if(!me.CheckForm()){
  		$('#lyAddEdit input').first().focus();
  		setTimeout('me.ClearError();', 5000);
  		return;
  	}

  	var myData = {
  		data : ft.LoadForm('mydata')
  	}
  	$.ajax({
  		url:me.url+'?mode=SaveDeposit&'+new Date().getTime(),
  		type:'POST',
  		dataType:'json',
  		data:myData,
  		success:function(data){
  			switch(data.success){
  				case 'COMPLETE' :
  				alert('Save Complete');
  				window.location.href = 'deposit';
  				break;
  				default:
  				alert('Save Error');

  			}
  		}
  	});
  };

  me.SaveWithdraw=function(){

  	if(!me.CheckForm()){
  		$('#lyAddEdit input').first().focus();
  		setTimeout('me.ClearError();', 5000);
  		return;
  	}

  	var myData = {
  		data : ft.LoadForm('mydata')
  	}
  	$.ajax({
  		url:me.url+'?mode=SaveWithdraw&'+new Date().getTime(),
  		type:'POST',
  		dataType:'json',
  		data:myData,
  		success:function(data){
  			switch(data.success){
  				case 'COMPLETE' :
  				alert('Save Complete');
  				window.location.href = 'withdrawal';
  				break;
  				default:
  				alert('Save Error');

  			}
  		}
  	});
  };

  me.SaveTransfer=function(){

  	if(!me.CheckForm()){
  		$('#lyAddEdit input').first().focus();
  		setTimeout('me.ClearError();', 5000);
  		return;
  	}

  	var myData = {
  		data : ft.LoadForm('mydata')
  	}
  	$.ajax({
  		url:me.url+'?mode=SaveTransfer&'+new Date().getTime(),
  		type:'POST',
  		dataType:'json',
  		data:myData,
  		success:function(data){
  			switch(data.success){
  				case 'COMPLETE' :
  				alert('Save Complete');
  				window.location.href = 'transfer';
  				break;
  				default:
  				alert('Save Error');

  			}
  		}
  	});
  };

  me.Open=function(){
  	alert('test');
  };

  me.SubmitUpload=function(){

  	if(!me.CheckForm()){
  		$('form#formpayment :input').each(function(){
  			if (this.value === '' ) {
  				this.focus();
  				return false;
  			}
  		});
  		setTimeout('me.ClearError();', 5000);
  		return false;
  	}




  	$('#btnSubmit').css('display', 'none');
  	$('#btnLoading').css('display', '');
  	$('form#formpayment').submit();


  };

  me.UploadComplete=function(){
  	alert('Save Complete');
  	window.location.reload();

  };

  me.UploadUnComplete=function(){
  	alert('Save Error');
  };

/*================================================*\
  :: DEFAULT ::
  \*================================================*/

  $(document).ready(function(){
//	me.SearchProduct();
});

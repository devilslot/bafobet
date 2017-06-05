/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 05/12/2013 09:09
*  Module : Script
*  Description : Backoffice javascript
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

/*================================================*\
  :: FUNCTION ::
\*================================================*/

me.Import=function(){
	if(!me.CheckForm()){
		$('#lyAddEdit input').first().focus();
		setTimeout('me.ClearError();', 5000);
		return;
	}
	if(!confirm('คุณต้องการ Import ข้อมูลใช่หรือไม่ ?'))return;
		
	$.ajax({
		url:'module/import/import.import.php?mode=Import&'+new Date().getTime(),
		type:'POST',
		dataType:'json',
		data:{
			tablename : $('#tablename').val(),
			excel : $('#excel_file').text()
		},
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					me.MsgSuccess(data.msg);
					me.Clear();
					me.Upload.Clear();
					$('#lyUpload').css('display', 'none');
				break;
				default :
					alert(data.msg);
				break;
			}
		}
	});
};

me.CreateTable=function(){
	if(!me.CheckForm()){
		$('#lyAddEdit input').first().focus();
		setTimeout('me.ClearError();', 5000);
		return;
	}
	if(!confirm('คุณต้องการสร้างฐานข้อมูลใหม่ใช่หรือไม่ ?'))return;

	var myData = {
		tablename : $('#tablename').val(),
		excel : $('#excel_file').text()
	};
	
	$.ajax({
		url:'module/import/import.import.php?mode=CreateTable&'+new Date().getTime(),
		type:'POST',
		dataType:'json',
		data:myData,
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					me.MsgSuccess(data.msg);
				break;
				default :
					alert(data.msg);
				break;
			}
		}
	});
};

me.Upload={
	Submit:function(){
		if($('#fileupload').val()=='')return false;

		$('#btnUpload').css('display', 'none');
		$('#btnLoading').css('display', '');

		return true;
	},
	Complete:function(file){
		$('#excel_file').text(file);
		$('#lyUpload').css('display', '');
		me.Upload.Clear();

		return true;
		
	},
	Error:function(msg){
		alert(msg);
		
		me.Upload.Clear();
	},
	Clear:function(){
		$('#fileupload').val('');
		$('#btnUpload').css('display', '');
		$('#btnLoading').css('display', 'none');
	}
};


/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ClearButton(["addedit_back", "tooladd"]);
	me.New();
});
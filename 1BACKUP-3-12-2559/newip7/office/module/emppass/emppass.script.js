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

me.Edit=function(){
	$('.modal').modal('hide');
	
	var myData = {
		code : me.code,
		data : ft.LoadForm('mydata')
	};

	$.ajax({
		url:me.url+'?mode=Edit&mod='+me.mod+'&'+new Date().getTime(),
		type:'POST',
		dataType:'json',
		data:myData,
		success:function(data){
			if(data.success=='COMPLETE'){
				me.ClearData();
				me.MsgSuccess(data.msg);
			}else{
				me.MsgError(data.msg);
			}
		}
	});
};

me.SetButton=function(){
	$('#content-viewlist').remove();
	$('#content-addedit').fadeIn('slow');
	$('#content-status').remove();
	
	$('#add_title').css('display', 'none');
	$('#edit_title').css('display', '');

	$('#tooladd').remove();
	$('#tooledit').css('display', '');
	$('#addedit_pointer').remove();
	$('#addedit_del').remove();
	$('#addedit_back').remove();

	$('#btnEditClear').remove();
	$('#btnEditCopy').remove();
	$('#btnEditDel').remove();
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.SetButton();
});
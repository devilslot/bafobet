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

me.LoadEdit=function(){
	var myData = {};

	me.ClearData();
	$.ajax({
		url:me.url+'?mode=LoadEdit&mod='+me.mod+'&'+new Date().getTime(),
		type:'GET',
		dataType:'json',
		data:myData,
		success:function(data){
			ft.PutForm(data.row);
			
			if(data.field.filepic != ''){
				me.UploadPic.Apply(data.field.filepic);
			}	
			
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};

me.LoadCbo=function(){
  $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.province, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#province_code');
    });
    $.each(data.prefix, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#prefix_code');
    });
		$.each(data.departments, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#department_code');
    });
		$.each(data.position, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#position_code');
    });
		me.LoadEdit();
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

me.ChangeTab=function(){
	if(me.get.param.tab=='picture'){
		$('#picture_tab').click();
	}
};

me.UploadPic={
	Submit:function(){
		if($('#fileupload').val()=='')return false;

		$('#btnUpload').css('display', 'none');
		$('#btnLoading').css('display', '');
		$('#btnfiledel').css('display', 'none');

		return true;
		
	},
	Complete:function(pic){
		$('#filepic').val(pic);

		me.UploadPic.Apply(pic);
		me.MsgSuccess('Upload complete!!');

		return true;
		
	},
	Clear:function(){
		$('#fileupload').val('');
		$('#filepic').val('');
		$('#lnkUpload').attr('href', me.site+'/img/nopic.jpg');
		$('#lnkUpload img').attr('src', me.site+'/img/nopic.jpg');
		$('#btnfiledel').css('display', 'none');
	},
	Apply:function(pic){
		$('#lnkUpload').attr('href', me.site+'/img/'+pic);
		$('#lnkUpload img').attr('src', me.site+'/img/'+pic);
		$('#lnkUpload').attr('title', pic);
		$('#btnUpload').css('display', '');
		$('#btnLoading').css('display', 'none');
		$('#btnfiledel').css('display', '');		
	}
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.SetButton();
	me.ChangeTab();
	me.LoadCbo();
});
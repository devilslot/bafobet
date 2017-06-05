/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 05/12/2013 09:09
*  Module : Script
*  Description : Backoffice javascript
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/
var cbo_sub = [];
/*================================================*\
  :: FUNCTION ::
\*================================================*/
me.ViewHeader=function(){
	me.ViewSetHeader([
		{name:'filepic', display:'รูป', width:50, align:'center',search:false, sort:false},
		{name:'id', display:'รหัสสินค้า', align:'center'},
		{name:'cat_code', display:'หมวดหมู่', align:'center',search:false, sort:false},
		{name:'subcat_code', display:'หมวดหมู่ย่อย', align:'center',search:false, sort:false},
		{name:'name_th', display:'ชื่อ (TH)', align:'center'},
		{name:'price', display:'ราคา', align:'right'},
		{name:'quantity', display:'จำนวน', align:'right'}
	]);
};

me.ClearData=function(){
	$('#lyAddEdit input').val('');
	$('#lyAddEdit select').val('');
	$('#lyAddEdit textarea').val('');
	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);
	
	$('#enable').prop('checked', true);
//	$('#department_code').val('1477');
	
	me.UploadPic.Clear();
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

me.LoadCbo=function(){
  $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.cat, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#cat_code');
    });
		
		cbo_sub = data.subcat;
   
	});
};

me.LoadCboCat=function(){
	$('#cat_code').change(function(){
		$('#subcat_code').val('');
		$('#subcat_code option').remove();
		var id = $('#cat_code').val();
    $.each(cbo_sub, function(i, result) {
			if(result.cat_code == id){
				$('<option>')
					.attr('value', result.code)
					.text(result.name)
					.appendTo('#subcat_code');
			}
    });
		
	});
};

me.LoadEdit=function(code){
	var myData = {
		code : code
	};

	me.ClearData();
	$.ajax({
		url:me.url+'?mode=LoadEdit&mod='+me.mod,
		type:'GET',
		dataType:'json',
		cache:false,
		data:myData,
		success:function(data){
			me.code = code;
			ft.PutForm(data.row);
			
			
			me.UploadPic.Apply(data.field.filepic);
			$.each(cbo_sub, function(i, result) {
				if(result.cat_code == data.field.cat_code){
					$('<option>')
					.attr('value', result.code)
					.text(result.name)
					.appendTo('#subcat_code')
					.addClass('optsub')
					.addClass('optsub-'+result.cat_code);
				}
			});
			$('#subcat_code').val(data.field.subcat_code);
					
			$('.optsub').css('display', 'none');
			$('.optsub-'+data.field.cat_code).css('display', '');
			
			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};





/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.View();
	me.TextEditor();
	me.LoadCbo();
	me.LoadCboCat();

});



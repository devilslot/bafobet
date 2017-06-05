/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 24/01/2015 09:09
*  Module : Script
*  Description : Backoffice javascript
*  Involve People : MangEak
*  Last Updated : 24/01/2015 09:09
\*================================================*/

/*================================================*\
  :: FUNCTION ::
\*================================================*/
me.ViewHeader=function(){
	me.ViewSetHeader([
		{display:'สิทธิ์การใช้', name:'name_th'}
	]);
};

me.Add=function(){
	$('.modal').modal('hide');
	
	var myData = {
		data : ft.LoadForm('mydata'),
		per : []
	};

	myData.data['per_code'] = me.parent;

	var n=0;
	$('.permdata').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.per[n] = $(this).attr('rel');
			n++;
		}
	});	

	$.ajax({
		url:me.url+'?mode=Add&mod='+me.mod,
		type:'POST',
		dataType:'json',
		cache: false,
		data:myData,
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					me.MsgSuccess(data.msg, 1.5);
					me.Clear();
				break;
				default :
					me.MsgDanger(data.msg, 3);
				break;
			}
		}
	});
};

me.Edit=function(){
	$('.modal').modal('hide');
	
	var myData = {
		code : me.code,
		data : ft.LoadForm('mydata'),
		per : []
	};

	var n=0;
	$('.permdata').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.per[n] = $(this).attr('rel');
			n++;
		}
	});	

	$.ajax({
		url:me.url+'?mode=Edit&mod='+me.mod,
		type:'POST',
		dataType:'json',
		cache:false,
		data:myData,
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					me.LoadEdit(me.code);
					me.MsgSuccess(data.msg, 1.5);
				break;
				default :
					me.MsgDanger(data.msg, 3);
				break;
			}
		}
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
			$('#lnktab_image').css('display', '');
			me.code = code;
			ft.PutForm(data.row);
			
			$(data.level_open).each(function(i, item){
				$('.permdata[rel="'+item+'"]').prop('checked', true);
			});
			
			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};

me.CheckPermAll=function(){
	$('#ChkAll').click(function(){
		if($(this).is(':checked')){
			$('.permdata').prop('checked', true);
		}else{
			$('.permdata').prop('checked', false);
		}
	});
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.SetSort('name_th', 'asc');
	me.CheckPermAll();
	me.View();
});
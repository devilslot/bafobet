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
me.ViewHeader=function(){
	me.ViewSetHeader([
		{display:'รูป', name:'filepic', width:'40', align:'center', search:false, sort:false},
		{display:'ชื่อ', name:'name', width:'150', view:true},
		{display:'นามสกุล', name:'surname', width:'150', view:true},
		{display:'สิทธิ์การใช้', name:'task_code', type:'cbo', option:false}
	]);
};

me.ViewOpenHeader=function(){
	me.ViewOpenSetHeader([
		{display:'รหัส', name:'id'},
		{display:'ชื่อ', name:'name'},
		{display:'นามสกุล', name:'surname'},
		{display:'เบอร์มือถือ', name:'mobile'},
		{display:'อีเมล์', name:'email'},
		{display:'ชื่อผู้ใช้', name:'user_name'}
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

me.CheckForm=function(){
	me.ClearError();
  return ft.CheckEmpty('empty');
};

me.CheckPermAll=function(){
	$('#ChkAll-VIEW').click(function(){
		if($(this).is(':checked')){
			$('.perview').prop('checked', true);
		}else{
			$('.perview').prop('checked', false);
		}
		
		$('.menubody').each(function(){
			var id = $(this).attr('id');
			var mode = 'view';
			var c = 0;
			id = id.split('menubody_').join('');
			$('#menubody_'+id+' .per'+mode).each(function(){
				if($(this).is(':checked')){
					c++;
				}
			});

			if(c > 0){
				$('#cnt'+mode+'_'+id).css('display', '');
				$('#cnt'+mode+'_'+id).text(c);
			}else{
				$('#cnt'+mode+'_'+id).css('display', 'none');
			}
		});
	});
	$('#ChkAll-ADD').click(function(){
		if($(this).is(':checked')){
			$('.peradd').prop('checked', true);
		}else{
			$('.peradd').prop('checked', false);
		}
		
		$('.menubody').each(function(){
			var id = $(this).attr('id');
			var mode = 'add';
			var c = 0;
			id = id.split('menubody_').join('');
			$('#menubody_'+id+' .per'+mode).each(function(){
				if($(this).is(':checked')){
					c++;
				}
			});

			if(c > 0){
				$('#cnt'+mode+'_'+id).css('display', '');
				$('#cnt'+mode+'_'+id).text(c);
			}else{
				$('#cnt'+mode+'_'+id).css('display', 'none');
			}
		});
	});
	$('#ChkAll-EDIT').click(function(){
		if($(this).is(':checked')){
			$('.peredit').prop('checked', true);
		}else{
			$('.peredit').prop('checked', false);
		}
		
		$('.menubody').each(function(){
			var id = $(this).attr('id');
			var mode = 'edit';
			var c = 0;
			id = id.split('menubody_').join('');
			$('#menubody_'+id+' .per'+mode).each(function(){
				if($(this).is(':checked')){
					c++;
				}
			});

			if(c > 0){
				$('#cnt'+mode+'_'+id).css('display', '');
				$('#cnt'+mode+'_'+id).text(c);
			}else{
				$('#cnt'+mode+'_'+id).css('display', 'none');
			}
		});
	});
	$('#ChkAll-DEL').click(function(){
		if($(this).is(':checked')){
			$('.perdel').prop('checked', true);
		}else{
			$('.perdel').prop('checked', false);
		}
		
		$('.menubody').each(function(){
			var id = $(this).attr('id');
			var mode = 'del';
			var c = 0;
			id = id.split('menubody_').join('');
			$('#menubody_'+id+' .per'+mode).each(function(){
				if($(this).is(':checked')){
					c++;
				}
			});

			if(c > 0){
				$('#cnt'+mode+'_'+id).css('display', '');
				$('#cnt'+mode+'_'+id).text(c);
			}else{
				$('#cnt'+mode+'_'+id).css('display', 'none');
			}
		});
	});
	$('#ChkAll-OK').click(function(){
		if($(this).is(':checked')){
			$('.perok').prop('checked', true);
		}else{
			$('.perok').prop('checked', false);
		}
	});
};

me.Add=function(){
	$('.modal').modal('hide');
	
	var myData = {
		data : ft.LoadForm('mydata'),
		permission : []
	};
	
	var n=0;
	$('.permdata').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.permission[n] = $(this).attr('rel');
			n++;
		}
	});
	
	myData.data['enable'] = ($('#enable').is(':checked'))?'Y':'N';

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
		permission : []
	};	
	
	var n=0;
	$('.permdata').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.permission[n] = $(this).attr('rel');
			n++;
		}
	});
	myData.data['enable'] = ($('#enable').is(':checked'))?'Y':'N';

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
		url:me.url+'?mode=LoadEdit&mod='+me.mod+'&'+new Date().getTime(),
		type:'GET',
		dataType:'json',
		data:myData,
		success:function(data){
			me.code = code;
			ft.PutForm(data.row);
			
			$(data.permission).each(function(i, item){
				var obj = $('input[rel="'+item+'"]');
				obj.prop('checked', true);
				var parent = obj.attr('parent');
				
				if(item.indexOf("VIEW")>-1){
					me.Permission(parent, 'view');
				}else if(item.indexOf("ADD")>-1){
					me.Permission(parent, 'add');
				}else if(item.indexOf("EDIT")>-1){
					me.Permission(parent, 'edit');
				}else if(item.indexOf("DEL")>-1){
					me.Permission(parent, 'del');
				}
			});
			
			if(data.field.filepic != ''){
				me.UploadPic.Apply(data.field.filepic);
			}	
			
			me.SetPointer(data.pointer);
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
//		$.each(data.position, function(i, result) {
//      $('<option>').attr('value', result.code).text(result.name).appendTo('#position_code');
//    });
		$.each(data.task, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#task_code');
      $('<option>').attr('value', result.code).text(result.name).appendTo('#search_task_code');
    });
	});
};

me.ChangeTask=function(){
	$('#task_code').change(function(){
		$('.permdata').prop('checked', false);
		
		var level = $(this).val();
		$('.level-'+level).prop('checked', true);
	});
};

me.Accr=function(obj){
	var id = $(obj).attr('rel');
//	ft.Debug(id);
	if($(obj).find('i').hasClass('fa-plus-circle')){
		$(obj).find('i').removeClass('fa-plus-circle').addClass('fa-minus-circle');
		$('.blockpermiss_'+id).fadeIn('fast');
	}else{
		$(obj).find('i').removeClass('fa-minus-circle').addClass('fa-plus-circle');
		$('.blockpermiss_'+id).fadeOut('fast');
	}
};

me.ClickPermission=function(){
	$('.perview').click(function(){
		var parent = $(this).attr('parent');
		if(!$(this).is(':checked')){
			var rel = $(this).attr('rel');
			rel = rel.split('-VIEW').join('');
			$('#trper_'+rel+' .peradd').prop('checked', false);
			$('#trper_'+rel+' .peredit').prop('checked', false);
			$('#trper_'+rel+' .perdel').prop('checked', false);
		}
		me.Permission(parent, 'view');
		me.Permission(parent, 'add');
		me.Permission(parent, 'edit');
		me.Permission(parent, 'del');
	});
	$('.peradd').click(function(){
		var parent = $(this).attr('parent');
		if($(this).is(':checked')){
			var rel = $(this).attr('rel');
			rel = rel.split('-ADD').join('');
			$('#trper_'+rel+' .perview').prop('checked', true);
		}
		me.Permission(parent, 'view');
		me.Permission(parent, 'add');
	});
	$('.peredit').click(function(){
		var parent = $(this).attr('parent');
		if($(this).is(':checked')){
			var rel = $(this).attr('rel');
			rel = rel.split('-EDIT').join('');
			$('#trper_'+rel+' .perview').prop('checked', true);
		}
		me.Permission(parent, 'view');
		me.Permission(parent, 'edit');
	});
	$('.perdel').click(function(){
		var parent = $(this).attr('parent');
		if($(this).is(':checked')){
			var rel = $(this).attr('rel');
			rel = rel.split('-DEL').join('');
			$('#trper_'+rel+' .perview').prop('checked', true);
		}
		me.Permission(parent, 'view');
		me.Permission(parent, 'del');
	});
};

me.Permission=function(id, mode){
	var c = 0;
	$('#menubody_'+id+' .per'+mode).each(function(){
		if($(this).is(':checked')){
			c++;
		}
	});
	
	if(c > 0){
		$('#cnt'+mode+'_'+id).css('display', '');
		$('#cnt'+mode+'_'+id).text(c);
	}else{
		$('#cnt'+mode+'_'+id).css('display', 'none');
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
	me.ViewHeader();
	me.ViewOpenHeader();
	me.View();
	me.CheckPermAll();
	me.LoadCbo();
	me.ChangeTask();
	me.ClickPermission();
});
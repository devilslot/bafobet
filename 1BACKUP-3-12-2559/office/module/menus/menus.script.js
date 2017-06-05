/*================================================*\
*  Author : Attaphon Wongbuatong
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
		{display:'เมนู', name:'shortname_th', sort:false},
		{display:'Module', name:'id', sort:false},
//		{display:'Token', name:'encode', sort:false},
		{display:'สิทธ์แสดง', name:'level_view', align:'center', sort:false, search:false},
		{display:'สิทธ์เพิ่ม', name:'level_add', align:'center', sort:false, search:false},
		{display:'สิทธ์แก้ไข', name:'level_edit', align:'center', sort:false, search:false},
		{display:'สิทธ์ลบ', name:'level_del', align:'center', sort:false, search:false},
//		{display:'Sort', name:'sort', align:'center', sort:false, search:false},
		{display:'ขึ้น', name:'opt_up', align:'center', width:40, sort:false, search:false},
		{display:'ลง', name:'opt_down', align:'center', width:40, sort:false, search:false}
	]);
};

me.Add=function(){
	$('.modal').modal('hide');
	
	var myData = {
		data : ft.LoadForm('mydata'),
		perview : [],
		peradd : [],
		peredit : [],
		perdel : []
	};

	var n=0;
	$('.perview').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.perview[n] = $(this).attr('rel');
			n++;
		}
	});	
	n=0;
	$('.peradd').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.peradd[n] = $(this).attr('rel');
			n++;
		}
	});	
	n=0;
	$('.peredit').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.peredit[n] = $(this).attr('rel');
			n++;
		}
	});	
	n=0;
	$('.perdel').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.perdel[n] = $(this).attr('rel');
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
					me.ClearCbo('after_code');
					me.LoadCbo();
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
		perview : [],
		peradd : [],
		peredit : [],
		perdel : []
	};

	var n=0;
	$('.perview').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.perview[n] = $(this).attr('rel');
			n++;
		}
	});	
	n=0;
	$('.peradd').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.peradd[n] = $(this).attr('rel');
			n++;
		}
	});	
	n=0;
	$('.peredit').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.peredit[n] = $(this).attr('rel');
			n++;
		}
	});	
	n=0;
	$('.perdel').each(function(i, obj){
		if($(obj).is(':checked')){
			myData.perdel[n] = $(this).attr('rel');
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
					me.ClearCbo('after_code');
					me.LoadCbo();
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
			
			$(data.level_view).each(function(i, item){
				$('.perview[rel="'+item+'"]').prop('checked', true);
			});
			$(data.level_add).each(function(i, item){
				$('.peradd[rel="'+item+'"]').prop('checked', true);
			});
			$(data.level_edit).each(function(i, item){
				$('.peredit[rel="'+item+'"]').prop('checked', true);
			});
			$(data.level_del).each(function(i, item){
				$('.perdel[rel="'+item+'"]').prop('checked', true);
			});
				
			if(data.field.icon != ''){
				$('#btnicon i').attr('class', '').addClass('fa').addClass(data.field.icon);
			}

			if(data.field.main_menu=='Y'){
				$('#dvicon').css('display', '');
			}else{
				$('#dvicon').css('display', 'none');
			}

			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};

me.CheckPermAll=function(){
	$('#ChkAll-VIEW').click(function(){
		if($(this).is(':checked')){
			$('.perview').prop('checked', true);
		}else{
			$('.perview').prop('checked', false);
		}
	});
	$('#ChkAll-ADD').click(function(){
		if($(this).is(':checked')){
			$('.peradd').prop('checked', true);
		}else{
			$('.peradd').prop('checked', false);
		}
	});
	$('#ChkAll-EDIT').click(function(){
		if($(this).is(':checked')){
			$('.peredit').prop('checked', true);
		}else{
			$('.peredit').prop('checked', false);
		}
	});
	$('#ChkAll-DEL').click(function(){
		if($(this).is(':checked')){
			$('.perdel').prop('checked', true);
		}else{
			$('.perdel').prop('checked', false);
		}
	});
};

me.HideOption=function(){
	$('#row_limit').css('display', 'none');
	$('#PageTop').css('display', 'none');
	$('#PageBottom').css('display', 'none');
//	$('#row_search').css('display', 'none');
};

me.LoadCbo=function(){
  $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.menu, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#after_code');
    });
	});
};

me.MoveUp=function(code){
	$.ajax({
		url:me.url+'?mode=MoveUp&mod='+me.mod,
		type:'GET',
		dataType:'json',
		cache:false,
		data:{
			code:code
		},
		success:function(data){
			if(data.success=='COMPLETE'){
				me.View();
			}
		}
	});
};

me.MoveDown=function(code){
	$.ajax({
		url:me.url+'?mode=MoveDown&mod='+me.mod,
		type:'GET',
		dataType:'json',
		cache:false,
		data:{
			code:code
		},
		success:function(data){
			if(data.success=='COMPLETE'){
				me.View();
			}
		}
	});
};

me.NewInsert=function(code){
	me.New();
	$('#after_code').val(code);
};

me.ShowIcon=function(){
	$('#btnicon').click(function(){
		$('#font-search').val('');
		$('#menuIcon .fa').parent().css('display', '');
		$('#ModalIcon').modal('show');
	});
};

me.SelectIcon=function(){
	$('#menuIcon .fa-hover').click(function(){
		var icon = $(this).find('i').attr('class');
		icon = icon.split('fa ').join('');
		icon = icon.split(' col-md-3 col-sm-4').join('');
		$('#icon').val(icon);
		$('#btnicon i').attr('class', '').addClass('fa').addClass(icon);
		
		$('#ModalIcon').modal('hide');
	});
};

me.SearchFont=function(){
	$('#font-search').keyup(function(){
		var id=$(this).val();
		if(id==''){
			$('#menuIcon .fa').parent().css('display', '');
		}else{
			$('#menuIcon .fa').parent().css('display', 'none');
			$("#menuIcon .fa[class*='"+id+"']").parent().css('display', '');
		}
	});
};

me.ClearData=function(){
	$('#lyAddEdit input').val('');
	$('#lyAddEdit select').val('');
	$('#lyAddEdit textarea').val('');
	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);
	
	$('#enable').prop('checked', true);

	$('#btnicon').html('<i class="fa fa-search"></i>');
	$('#dvicon').css('display', 'none');
};

me.MainMenuClick=function(){
	$('#main_menu').click(function(){
		if($(this).is(':checked')){
			$('#dvicon').css('display', '');
		}else{
			$('#dvicon').css('display', 'none');
		}
	});
};

me.BlurName=function(){
	$('#name_en').blur(function(){
		if($('#shortname_en').val()==''){
			$('#shortname_en').val($('#name_en').val());
		}
		if($('#name_th').val()==''){
			$('#name_th').val($('#name_en').val());
		}
	});
	$('#name_th').blur(function(){
		if($('#shortname_th').val()==''){
			$('#shortname_th').val($('#name_th').val());
		}
	});
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.BlurName();
	me.HideOption();
	me.ShowIcon();
	me.SelectIcon();
	me.SearchFont();
	me.MainMenuClick();
	me.LoadCbo();
	me.View();
	me.CheckPermAll();
});
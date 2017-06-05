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
		{display:'Group', name:'groups', width:'100', align:'center', type:'cbo'},
		{display:'ID', name:'id', width:'150'},
		{display:'Text (TH)', name:'name_th'},
		{display:'Text (EN)', name:'name_en'}
	]);
};

me.Add=function(){
	$('.modal').modal('hide');
	
	var myData = {
		data : ft.LoadForm('mydata')
	};

	if($('#enable').Exist()){
		myData.data['enable'] = ($('#enable').is(':checked'))?'Y':'N';
	}
	
	myData.data['id'] = myData.data['id'].split(' ').join('_');

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
		data : ft.LoadForm('mydata')
	};

	if($('#enable').Exist()){
		myData.data['enable'] = ($('#enable').is(':checked'))?'Y':'N';
	}
	
	myData.data['id'] = myData.data['id'].split(' ').join('_');

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

me.LoadCbo=function(){
	$('<option>').attr('value', 'CONTENT').text('CONTENT').appendTo('#search_groups');
	$('<option>').attr('value', 'DEFINE').text('DEFINE').appendTo('#search_groups');
	$('<option>').attr('value', 'ALERT').text('ALERT').appendTo('#search_groups');
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.View();
	me.LoadCbo();
});
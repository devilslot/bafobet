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
		{name:'id', display:'Table', width:'200'},
		{name:'name', display:'Title'}
	]);
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
			
			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
			
			var html = me.Table('field', data.datafield);
			$('#zone_field').html(html);
		}
	});
};

me.Add=function(){
	if(!me.CheckForm()){
		$('#lyAddEdit input').first().focus();
		setTimeout('me.ClearError();', 5000);
		return;
	}
	
	bootbox.confirm(me.alert.CALLADD, function(result){
		if(!result)return;

		var myData = {
			data : ft.LoadForm('mydata')
		};

		$.ajax({
			url:me.url+'?mode=Add&mod='+me.mod,
			type:'POST',
			dataType:'json',
			cache: false,
			data:myData,
			success:function(data){
				switch(data.success){
					case 'COMPLETE' :
						me.MsgSuccess(me.alert.SAVECOMPLETE);
						$('#lnk_child').css('display', '');
						me.LoadEdit(data.code);
					break;
					default :
						alert(me.alert.SAVEERROR);
					break;
				}
			}
		});
	});
};

me.ViewSub=function(code){
	window.frames.ifmchild.me.parent = code;
	window.frames.ifmchild.me.LoadCbo();
	window.frames.ifmchild.me.ViewList();
	me.OpenSub();
};

me.ClearData=function(){
	$('#lyAddEdit input').val('');
	$('#lyAddEdit select').val('');
	$('#lyAddEdit textarea').val('');
	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);
	
	$('#lnk_child').css('display', 'none');
	$('#titletab_info').click();
};

me.AppendField=function(){
	var html = me.Table('field', {
		header : [
			{name:'no', display:'No.', align:'center', width:30},
			{name:'id', display:'ID', align:'center'},
			{name:'name', display:'Name'},
			{name:'type', display:'Type', align:'center'},
			{name:'remark', display:'Type', align:'center'}
		],
		data : [
			{code:'1', no:'1', id:'111', name:'abc', type:'x', remark:'12345'},
			{code:'2', no:'2', id:'112', name:'abc', type:'x', remark:'12345'},
			{code:'3', no:'3', id:'113', name:'abc', type:'x', remark:'12345'},
			{code:'4', no:'4', id:'114', name:'abc', type:'x', remark:'12345'}
		]
	});
	$('#zone_field').html(html);
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.SetLimit(500);
	me.SetSort('id', 'asc');
	me.View();
	me.AppendField();
});
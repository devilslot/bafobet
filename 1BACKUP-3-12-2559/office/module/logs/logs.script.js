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
		{name:'mode', display:'Mode', align:'center', view:true},
		{name:'menu', display:'Menu'},
		{name:'record', display:'Record', align:'center'},
		{name:'ip', display:'IP', align:'center'},
		{name:'user_create', display:'Create by', align:'center'},
		{name:'date_create', display:'Date', align:'center', cls:'dpk'}
	]);
};

me.ViewOpenHeader=function(){
	me.ViewOpenSetHeader([
		{name:'mode', display:'Mode'},
		{name:'menu', display:'Menu'},
		{name:'record', display:'Record'},
		{name:'ip', display:'IP'},
		{name:'user_create', display:'Create by'},
		{name:'date_create', display:'Date', type:'datetime'}
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
			me.code = code;
			ft.PutForm(data.row);
			me.AppendItem(data.item);
			
			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};

me.AppendItem=function(data){
	var html = '';
	html += '<tr class="rowdata" id="row{code}">';
	html += '  <td>{name}</td>';
	html += '  <td>{value}</td>';
	html += '</tr>';
	html += '';

	var temp = '';
	$('#tb_item').text('');
	$.each(data, function(i, attr){
		temp = html;
		temp = temp.split('{code}').join(i);
		temp = temp.split('{name}').join(attr.name);
		temp = temp.split('{value}').join(attr.value);
		$('#tb_item').append(temp);
	});	
};

me.RollBack=function(){
	if(!confirm('Do you want rollback data?'))return;
	
	var myData = {
		code : me.code
	};

	$.ajax({
		url:me.url+'?mode=RollBack&mod='+me.mod,
		type:'GET',
		dataType:'json',
		cache:false,
		data:myData,
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					me.MsgSuccess(me.alert.SAVECOMPLETE);
				break;
				default :
					me.MsgError(me.alert.SAVEERROR);
				break;
			}
		}
	});
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.ViewOpenHeader();
	me.View();
	me.ClearButton(['ZoneViewNew', 'addedit_del', 'tooledit', 'btnViewOpenDel']);
	me.SetDate();
});
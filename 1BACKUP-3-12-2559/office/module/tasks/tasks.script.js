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
		{display:'หน้าที่', name:'name_th', view:true},
		{display:'User create', name:'user_create'},
		{display:'code', name:'code', datatype:'number', format:2, align:'right', style:'success'},
		{display:'Date create', name:'date_create', cls:'dpk', datatype:'datetime', align:'center'}
	], {
		style : 2,
		sort_by : 'name_th',
		sort_order : 'asc',
		limit : 50,
		show_button : false,
		show_no : false,
		show_enable : false,
		show_page : false,
		show_limit : false,
		show_record : false,
		show_search : false
	});
};

me.ViewOpenHeader=function(){
	me.ViewOpenSetHeader([
		{display:'หน้าที่ (TH)', name:'name_th'},
		{display:'หน้าที่ (EN)', name:'name_en'},
		{display:'รหัส', name:'code', type:'number', format:2},
		{display:'วันที่สร้าง', name:'date_create', type:'date'},
		{display:'วันที่แก้ไข', name:'date_update', type:'datetime'}
	]);
};

me.chk=function(callback1, callback2) {
	$('body').on('click', function(){
		callback1('111');
	});
	$('body').on('dblclick', function(){
		callback2('222');
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
	me.SetDate();
	me.TableCheckAll();
	me.chk(function(data) {
		console.log(data);
	}, function(data){
		console.log(data);
	});
});
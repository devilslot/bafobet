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
		{name:'cat_code', display:'หมวดหมู่หลัก'},
		{name:'name_th', display:'หมวดหมู่ย่อย'},
		{name:'enable', display:'Display', width:'70', align:'center', type:'cbo'}
	]);
};

me.LoadCbo=function(){
	$('<option>').attr('value', 'Y').text('Open').appendTo('#search_enable');
	$('<option>').attr('value', 'N').text('Close').appendTo('#search_enable');
	
	$.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.cat, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#cat_code');
    });
	});
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
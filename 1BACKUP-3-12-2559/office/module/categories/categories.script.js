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
		{name:'name_th', display:'หมวดหมู่'},
		{name:'enable', display:'Display', width:'70', align:'center', type:'cbo'}
	]);
};

me.LoadCbo=function(){
	$('<option>').attr('value', 'Y').text('Open').appendTo('#search_enable');
	$('<option>').attr('value', 'N').text('Close').appendTo('#search_enable');
};

me.ClearData=function(){
	$('#lyAddEdit input').val('');
	$('#lyAddEdit select').val('');
	$('#lyAddEdit textarea').val('');
	$('#filepic').val('');
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
/*================================================*\
*  Author : Attaphon Wongbuatong
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
		{name:'name_th', display:'จังหวัด'},
		{name:'geo_code', display:'ภาค', type:'cbo', option:false}
	], {
		sort_by : 'name_th',
		sort_order : 'asc'
	});
};

me.LoadCbo=function(){
  $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.geo, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#geo_code');
      $('<option>').attr('value', result.code).text(result.name).appendTo('#search_geo_code');
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
/*================================================*\
*  Author : Online creation soft
*  Created Date : 28/11/2014 10:51
*  Module : script
*  Description : javascript
*  Involve People : Tirapant Tongpann
*  Last Updated : 28/11/2014 10:51
\*================================================*/

/*================================================*\
  :: FUNCTION ::
\*================================================*/
me.ViewHeader=function(){
	me.ViewSetHeader([
		{display:'อำเภอ', name:'name_th'},
		{display:'จังหวัด', name:'province_code', type:'cbo', option:false},
		{display:'ภาค', name:'geo_code', type:'cbo', option:false}
	], {sort_by:'code', sort_order:'asc'});
};

me.LoadCbo=function(){
  $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.province, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#province_code');
      $('<option>').attr('value', result.code).text(result.name).appendTo('#search_province_code');
    });
    $.each(data.geography, function(i, result) {
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
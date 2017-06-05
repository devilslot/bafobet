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
		{display:'ตำแหน่ง', name:'name_th'},
		{display:'แผนก', name:'depart_code', type:'cbo', option:false}
	]);
};

me.LoadCbo=function(){
  $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.department, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#depart_code');
      $('<option>').attr('value', result.code).text(result.name).appendTo('#search_depart_code');
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
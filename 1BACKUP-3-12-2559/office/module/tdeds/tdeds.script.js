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
      {display:'วันที่', name:'date_match',cls:'dpk', align:"center"},
      {display:'เซียนต่อ', name:'zean1', align:"center"},
      {display:'เซียนรอง', name:'zean2', align:"center"},
      {display:'เซียนหมู', name:'zean3', align:"center"},
      {display:'ผลเซียนต่อ', name:'result_zean1', align:"center",type:'cbo'},
      {display:'ผลเซียนรอง', name:'result_zean2', align:"center",type:'cbo'},
      {display:'ผลเซียนหมู', name:'result_zean3', align:"center",type:'cbo'},
      ]);
  };

  me.ViewOpenHeader=function(){
  	me.ViewOpenSetHeader([
      {display:'วันที่', name:'date_match'},
      {display:'เซียนต่อ', name:'zean1'},
      {display:'เซียนรอง', name:'zean2'},
      {display:'เซียนหมู', name:'zean3'},
      {display:'ผลเซียนต่อ', name:'result_zean1'},
      {display:'ผลเซียนรอง', name:'result_zean2'},
      {display:'ผลเซียนหมู', name:'result_zean3'},
      {display:'รหัส', name:'code'},
      {display:'วันที่สร้าง', name:'date_create', type:'date'},
      {display:'วันที่แก้ไข', name:'date_update', type:'datetime'}
      ]);
  };


  me.ClearData=function(){
  	$('#lyAddEdit input').val('');
  	$('#lyAddEdit select').val('');
  	$('#lyAddEdit textarea').val('');
  	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);

  	$('#enable').prop('checked', true);
  };


  me.LoadCbo=function(){
    $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
      $.each(data.football, function(i, result) {
        $('<option>').attr('value', result.code).text(result.name).appendTo('#result_zean1');
        $('<option>').attr('value', result.code).text(result.name).appendTo('#result_zean2');
        $('<option>').attr('value', result.code).text(result.name).appendTo('#result_zean3');
        $('<option>').attr('value', result.code).text(result.name).appendTo('#search_result_zean1');
        $('<option>').attr('value', result.code).text(result.name).appendTo('#search_result_zean2');
        $('<option>').attr('value', result.code).text(result.name).appendTo('#search_result_zean3');

      });
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
   me.LoadCbo();
 });
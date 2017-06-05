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
  		{display:'ตำแหน่ง', name:'name_th', view:true}
  		]);
  };

  me.ViewOpenHeader=function(){
  	me.ViewOpenSetHeader([
  		{display:'ตำแหน่ง', name:'name_th'},
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




/*================================================*\
  :: DEFAULT ::
  \*================================================*/
  $(document).ready(function(){
  	me.SetUrl();
  	me.ViewHeader();
  	me.ViewOpenHeader();
  	me.View();
  	me.TextEditor();
  });
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
      {display:'ชื่อ TH', name:'name_th'},
      {display:'ชื่อ EN', name:'name_en'}
      ]);
  };



  me.ClearData=function(){
    $('#lyAddEdit input').val('');
    $('#lyAddEdit select').val('');
    $('#lyAddEdit textarea').val('');
    $('#lyAddEdit input[type="checkbox"]').prop('checked', false);

    $('#enable').prop('checked', true);
    //me.UploadPic.Clear();
  };






/*================================================*\
  :: DEFAULT ::
  \*================================================*/
  $(document).ready(function(){
  	me.SetUrl();
  	me.ViewHeader();
    me.SetSort('name_en', 'asc');
    me.View();
  	//me.TextEditor();
  });
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
      {display:'งวดประจำวันที่', name:'lotto_date', cls:'dpk',view:true,align:'center'},
      {display:'รางวัลที่ 1', name:'sixdigit',align:'center'},
      {display:'เลขหน้า 3 ตัว [1]', name:'threedigitf1',align:'center'},
      {display:'เลขหน้า 3 ตัว [2]', name:'threedigitf2',align:'center'},
      {display:'เลขท้าย 3 ตัว [1]', name:'threedigitl1',align:'center'},
      {display:'เลขท้าย 3 ตัว [2]', name:'threedigitl2',align:'center'},
      {display:'เลขท้าย 2 ตัว', name:'twodigit',align:'center'}
      ]);
  };

  me.ViewOpenHeader=function(){
  	me.ViewOpenSetHeader([
      {display:'งวดประจำวันที่', name:'lotto_date'},
      {display:'รางวัลที่ 1', name:'sixdigit'},
      {display:'เลขหน้า 3 ตัว [1]', name:'threedigitf1'},
      {display:'เลขหน้า 3 ตัว [2]', name:'threedigitf2'},
      {display:'เลขท้าย 3 ตัว [1]', name:'threedigitl1'},
      {display:'เลขท้าย 3 ตัว [2]', name:'threedigitl2'},
      {display:'เลขท้าย 2 ตัว', name:'twodigit'},
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
  	me.SetDate();

  });
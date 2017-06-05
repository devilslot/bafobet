/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 08/02/2016 01:14
*  Module : Class
*  Description : Backoffice Javascript
*  Involve People : MangEak
*  Last Updated : 08/02/2016 01:14
\*================================================*/

/*================================================*\
  :: FUNCTION ::
  \*================================================*/
  me.ViewHeader=function(){
  	me.ViewSetHeader([
  		{display:'Match ID',align:'center', name:'matchID',style:"danger"},
  		{display:'ข้อความ', name:'msg'},
      {display:'IP', name:'ip',align:'center',style:"success"},
      {display:'สมาชิก', name:'user_create',style:"info",align:'center'},
  		{display:'วันที่', name:'date_create'}
  		]);
  };

me.ViewOpenHeader=function(){
  me.ViewOpenSetHeader([
    {display:'ชื่อบริษัท (TH)', name:'name_th'},
    {display:'ชื่อบริษัท (EN)', name:'name_en'},
    {display:'รหัส', name:'code', type:'number', format:2},
    {display:'วันที่สร้าง', name:'date_create', type:'date'},
    {display:'วันที่แก้ไข', name:'date_update', type:'datetime'}
  ]);
};






/*================================================*\
  :: DEFAULT ::
  \*================================================*/
  $(document).ready(function(){
  	me.SetUrl();
  	me.ViewHeader();
  	me.SetSort('code', 'asc');
  	me.View();
    $('#btnViewNew').hide();
  });
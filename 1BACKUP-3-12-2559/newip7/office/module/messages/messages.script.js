/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 24/01/2015 09:09
*  Module : Script
*  Description : Backoffice javascript
*  Involve People : MangEak
*  Last Updated : 24/01/2015 09:09
\*================================================*/

/*================================================*\
  :: FUNCTION ::
\*================================================*/
me.ViewHeader=function(){
	me.ViewSetHeader([
		{display:'ข้อความ', name:'msg'},
		{display:'พนักงาน', name:'emp_code'},
		{display:'Module', name:'module'},
		{display:'code', name:'ref_code'},
		{display:'สถานะ', name:'status', align:'center', type:'cbo', option:false}
	]);
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.View();
	me.SetDate();
});
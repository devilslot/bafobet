/*================================================*\
*  Author : Attaphon Wongbuatong
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
		{display:'คำนำหน้า', name:'name_th'}
	], {
		sort_by : 'name_th',
		sort_order : 'asc'
	});
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.View();
});
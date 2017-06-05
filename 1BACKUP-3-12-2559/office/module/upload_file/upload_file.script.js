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
		{display:'No.', name:'no', width:'50', align:'center', search:false},
		{display:'Name', name:'name'},
		{display:'Description', name:'description'}
	]);
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.View();
});
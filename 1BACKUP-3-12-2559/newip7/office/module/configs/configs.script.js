/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 05/12/2013 09:09
*  Module : Script
*  Description : Backoffice javascript
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

/*================================================*\
  :: FUNCTION ::
\*================================================*/

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.LoadEdit(1);
	me.ClearButton(["btnEditClear", "btnEditCopy", "btnEditDel", "addedit_back", "addedit_pointer", "addedit_del"])
});
/*==================================================
*  Author : Attaphon Wongbuatong
*  Created Date : 14/6/2554 1:29
*  Module : Compile
*  Description : _FUNCTION_
*  Involve People : -
*  Last Updated : 14/6/2554 1:29
==================================================*/

/*==================================================
  :: METHOD ::
==================================================*/
var me={
  url:'../main/module.inc.php',
	get:ft.GetParam(),
	lang:{
		calladd:'คุณต้องการเพิ่มข้อมูลใช่หรือไม่ ?',
		calledit:'คุณต้องการแก้ไขข้อมูลใช่หรือไม่ ?',
		calldel:'คุณต้องการลบข้อมูลใช่หรือไม่ ?'
	}
};

me.Add=function(){
	$('#Add').click(function(){
		if(!confirm(me.lang.calladd))return;
		
		var myData = ft.LoadForm('mydata');

		$.ajax({
			url:me.url+'?mode=Add&mod='+me.get.param.mod+'&'+new Date().getTime(),
			type:'POST',
			dataType:'json',
			data:myData,
			success:function(data){
				switch(data.success){
					case 'COMPLETE' :
						alert('complete');
//						window.location.reload();
					break;
					default :
						alert('add error');
					break;
				}
			}
		});
	});
};

me.SetUrl=function(){
	me.url = '../module/'+me.get.param.mod+'.inc.php'
};

/*==================================================
  :: DEFAULT ::
==================================================*/
(function() {
	me.SetUrl();
//	ft.Debug(me.url);
}).call(this);









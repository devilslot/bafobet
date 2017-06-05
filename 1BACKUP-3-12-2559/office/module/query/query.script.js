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
		{display:'Query', name:'name'}
	], {style:2});
};

me.LoadEdit=function(code){
	var myData = {
		code : code
	};

	me.ClearData();
	$.ajax({
		url:me.url+'?mode=LoadEdit&mod='+me.mod,
		type:'GET',
		dataType:'json',
		cache:false,
		data:myData,
		success:function(data){
			$('#lnktab_image').css('display', '');
			me.code = code;
			ft.PutForm(data.row);
			
			$('.query_code').val(me.code);
			
			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};

me.New=function(){
	var myData = {
		data : {
			query1 : '',
			query2 : '',
			query3 : '',
			query4 : '',
			query5 : ''
		}
	};

	if($('#enable').Exist()){
		myData.data['enable'] = ($('#enable').is(':checked'))?'Y':'N';
	}

	$.ajax({
		url:me.url+'?mode=Add&mod='+me.mod,
		type:'POST',
		dataType:'json',
		cache: false,
		data:myData,
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					me.LoadEdit(data.code);
				break;
				default :
					alert(me.alert.SAVEERROR);
				break;
			}
		}
	});
};

me.AddTable=function(){
	$('.btn_table').click(function(){
		var text = $(this).text();
		var href = $('.tabbable').find('li.active').find('a').attr('href');
		switch(href){
			case '#tab_query1' : $('#query1').val($('#query1').val()+text); break;
			case '#tab_query2' : $('#query2').val($('#query2').val()+text); break;
			case '#tab_query3' : $('#query3').val($('#query3').val()+text); break;
			case '#tab_query4' : $('#query4').val($('#query4').val()+text); break;
			case '#tab_query5' : $('#query5').val($('#query5').val()+text); break;
		}
	});
};

me.UseTab=function(){
	$(document).delegate('textarea', 'keydown', function(e) {
		var keyCode = e.keyCode || e.which;

		if (keyCode == 9) {
			e.preventDefault();
			var start = $(this).get(0).selectionStart;
			var end = $(this).get(0).selectionEnd;

			// set textarea value to: text before caret + tab + text after caret
			$(this).val($(this).val().substring(0, start)
									+ "\t"
									+ $(this).val().substring(end));

			// put caret at right position again
			$(this).get(0).selectionStart =
			$(this).get(0).selectionEnd = start + 1;
		}
	});	
};

me.RemoveTool=function(){
	$('#tooladd').remove();
	$('#tooledit').remove();
};

me.Submit=function(){
	$('#btnRun1').click(function(){
		var rdorun = ft.GetRadio('rdorun');
		if(rdorun=='1'){
			$("#frm1").attr('target', 'ifm');
			$('#frm1').attr('action', 'module/query/query.output.php?mod=query&type=1');
		}else{
			$("#frm1").attr('target', '_blank');
			$('#frm1').attr('action', 'module/query/query.result.php?mod=query&type=1');
		}
		$('#frm1').submit();
	});
	$('#btnRun2').click(function(){
		var rdorun = ft.GetRadio('rdorun');
		if(rdorun=='1'){
			$("#frm2").attr('target', 'ifm');
			$('#frm2').attr('action', 'module/query/query.output.php?mod=query&type=2');
		}else{
			$("#frm2").attr('target', '_blank');
			$('#frm2').attr('action', 'module/query/query.result.php?mod=query&type=2');
		}
		$('#frm2').submit();
	});
	$('#btnRun3').click(function(){
		var rdorun = ft.GetRadio('rdorun');
		if(rdorun=='1'){
			$("#frm3").attr('target', 'ifm');
			$('#frm3').attr('action', 'module/query/query.output.php?mod=query&type=3');
		}else{
			$("#frm3").attr('target', '_blank');
			$('#frm3').attr('action', 'module/query/query.result.php?mod=query&type=3');
		}
		$('#frm3').submit();
	});
	$('#btnRun4').click(function(){
		var rdorun = ft.GetRadio('rdorun');
		if(rdorun=='1'){
			$("#frm4").attr('target', 'ifm');
			$('#frm4').attr('action', 'module/query/query.output.php?mod=query&type=4');
		}else{
			$("#frm4").attr('target', '_blank');
			$('#frm4').attr('action', 'module/query/query.result.php?mod=query&type=4');
		}
		$('#frm4').submit();
	});
	$('#btnRun5').click(function(){
		var rdorun = ft.GetRadio('rdorun');
		if(rdorun=='1'){
			$("#frm5").attr('target', 'ifm');
			$('#frm5').attr('action', 'module/query/query.output.php?mod=query&type=5');
		}else{
			$("#frm5").attr('target', '_blank');
			$('#frm5').attr('action', 'module/query/query.result.php?mod=query&type=5');
		}
		$('#frm5').submit();
	});
};

me.EditName=function(){
	$('#name').blur(function(){
		var myData = {
			code : me.code,
			data : {name : $('#name').val()}
		};

		$.ajax({
			url:me.url+'?mode=Edit&mod='+me.mod,
			type:'POST',
			dataType:'json',
			cache:false,
			data:myData,
			success:function(data){

			}
		});
	});
};
/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.ViewHeader();
	me.View();
	me.HideMenu();
	me.UseTab();
	me.RemoveTool();
	me.Submit();
	me.AddTable();
	me.EditName();
});
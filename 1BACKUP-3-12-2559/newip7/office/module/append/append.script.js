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

me.FindItem = function(str, n, result){
	if(result==null){
		result = [];
	}
	if(n==null){
		n = 0;
	}
	var start_pos = str.indexOf('{') + 1;
	var end_pos = str.indexOf('}', start_pos);
	result[n] = str.substring(start_pos, end_pos); 
	str = str.split('{'+result[n]+'}').join('');
	if(str.indexOf('{') > 0){
		return me.FindItem(str, n+1, result);
	}else{
		return result;
	}
};

me.SplitFunction=function(source){
	source = source.split("'").join("\\'");
	source = source.split("\n").join("';\nhtml += '");
	source = "var html = '';\nhtml += '" + source + "';";

	return source;
};

me.CreateFunction=function(){
	var source = $('#Source').val();
	var item = me.FindItem(source);

	source = me.SplitFunction(source);

	if(item.length > 0){
		source += "\n$('#').text('');";
		source += "\n$.each(data, function(i, attr){";
		$.each(item, function(i, attr){
			source += "\ntemp = html;";
			source += "\ntemp = temp.split('{"+attr+"}').join(attr."+attr+");";
		});
		source += "\n$('#').append(temp);";
		source += "\n});";
	}
//      
//      if(item.length > 0){
//        $.each(item, function(i, attr){
//          source += "\nhtml = html.split('{"+attr+"}').join(data."+attr+");";
//        });
//      }

	$('#Result').val(source);

};

me.CreateSingle=function(){
	var source = $('#Source').val();
	var item = me.FindItem(source);

	source = me.SplitFunction(source);

	if(item.length > 0){
		source += "\n\n$('#').remove();";
		$.each(item, function(i, attr){
			source += "\nhtml = html.split('{"+attr+"}').join(data."+attr+");";
		});
		source += "\n$('#').append(html);";
	}

	$('#Result').val(source);
};

me.CreateLoop=function(){
	var source = $('#Source').val();
	var item = me.FindItem(source);

	source = me.SplitFunction(source);

	if(item.length > 0){
		source += "\n\nvar temp = '';\n$('#').text('');";
		source += "\n$.each(data, function(i, attr){";
		source += "\ntemp = html;";
		$.each(item, function(i, attr){
			source += "\ntemp = temp.split('{"+attr+"}').join(attr."+attr+");";
		});
		source += "\n$('#').append(temp);";
		source += "\n});";
	}

	$('#Result').val(source);
};

me.ClearData=function(){

};

me.Run=function(){
	$('#Change').click(function(){
		if($('#loopN').is(':checked')){
			me.CreateSingle();
		}else{
			me.CreateLoop();
		}
	});
	$('#Source').focus();
};

/*================================================*\
  :: DEFAULT ::
\*================================================*/
$(document).ready(function(){
	me.SetUrl();
	me.New();
	me.Run();
	me.ClearButton(["addedit_back", "tooladd"]);
});
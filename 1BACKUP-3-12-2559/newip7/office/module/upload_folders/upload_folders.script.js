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
		{display:'No.', name:'no', width:'50', align:'center', search:false},
		{display:'Folder', name:'name'}
	]);
};

me.ClearData=function(){
	$('#lyAddEdit input').val('');
	$('#lyAddEdit select').val('');
	$('#lyAddEdit textarea').val('');
	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);
	
	$('#enable').prop('checked', true);
	$('#tbUpload').text('');	
	
	$('#lnk_child').css('display', 'none');
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
			me.code = code;
			ft.PutForm(data.row);
			
			$(data.photo).each(function(i, attr){
				me.AppendUpload(attr);
			});
			
			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};

me.SetUpload=function(){
	$("#uploader").pluploadQueue({
    runtimes : 'gears,html5,flash,silverlight,browserplus',
		url : 'app.upload.php?mod='+me.mod,
		max_file_size : '5mb',
		chunk_size : '1mb',
		unique_names : true,
		multi_selection: false,
		multiple_queues : true,
		filters : [
			{title : "Image files", extensions : "jpg,png,gif"}
		],

		init : {
			FilesAdded: function(up, files) {
				up.start();
			},

			FileUploaded: function(up, files, res){
//				ft.Debug(res.response);
				var obj = JSON.parse(res.response);
				if(obj.error != null){
					var err = obj.error;
					alert(err.message);
				}else{
					var rs = obj.result;
					$('#lyImage').text('');
					me.AppendImage(rs);
					$('#filepic').val(rs.id);
					$('#lyImageAdd').css('display', 'none');
					$('#lyImage').css('display', 'block');
					$('#boxUpload').modal('hide');
				}
			},

			UploadComplete: function(up, files) {
				up.splice();
			}
		}
	});	
};

me.SetUploadMulti=function(){
	$("#uploader").pluploadQueue({
    runtimes : 'gears,html5,flash,silverlight,browserplus',
		url : 'module/'+me.mod+'/'+me.mod+'.upload.php',
		max_file_size : '300mb',
		chunk_size : '100mb',
		unique_names : true,
		multiple_queues : true,
		filters : [
			{title : "Upload file", extensions : "jpg,png,gif,pdf,doc,docx,xls,xlsx,zip,rar,mp4,mp3,flv"}
		],

		init : {
			BeforeUpload : function(up, file) {
				up.settings.multipart_params = {
					code : me.code
				};
			},
						
			FilesAdded: function(up, files) {
				up.start();
			},

			FileUploaded: function(up, files, res){
				var obj = JSON.parse(res.response);
//				console.log(obj);
				if(obj.success == 'COMPLETE'){
//					me.MsgSuccess('Upload complete!!');
					me.AppendUpload(obj);
				}else{
					me.MsgError(obj.msg);
				}
			},

			UploadComplete: function(up, files) {
				up.splice();
			}
		}
	});	
};

me.AppendUpload=function(data){
	var html = '';
	html += '<tr id="filedata_{code}" class="file-block">';
	html += '  <td class="text-center">{no}</td>';
	html += '  <td>{name}</td>';
	html += '  <td class="text-center">{filetype}</td>';
	html += '  <td>{url}</td>';
	html += '  <td class="text-center">';
	html += '		<button class="btn btn-danger btn-xs" onclick="me.DelUpload({code});">';
	html += '			<i class="fa fa-trash-o"></i> Del';
	html += '		</button>';
	html += '  </td>';
	html += '</tr>';

	html = html.split('{no}').join($('.file-block').length+1);
	html = html.split('{code}').join(data.code);
	html = html.split('{name}').join(data.name);
	html = html.split('{filetype}').join(data.filetype);
	html = html.split('{url}').join(data.url);
	html = html.split('{del}').join(data.del);
	$('#tbUpload').append(html);	
};

me.DelUpload=function(code){
	bootbox.confirm(me.alert.CALLDEL, function(result){
		if(!result)return;
		
		var myData = {
			code : code
		};	

		$.ajax({
			url:me.url+'?mode=DelUpload&mod='+me.mod,
			type:'POST',
			dataType:'json',
			cache:false,
			data:myData,
			success:function(data){
				switch(data.success){
					case 'COMPLETE' :
						me.MsgSuccess(me.alert.DELCOMPLETE);
						
						$('#filedata_'+code).fadeOut('slow');
						$('#filedata_'+code).remove();
					break;
					default :
						alert(me.alert.SAVEERROR);
					break;
				}
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
	me.SetUploadMulti();
});
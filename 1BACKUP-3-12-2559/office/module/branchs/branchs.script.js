/*================================================*\
*  Author : Online creation soft
*  Created Date : 28/11/2014 10:51
*  Module : script
*  Description : javascript
*  Involve People : Tirapant Tongpann
*  Last Updated : 28/11/2014 10:51
\*================================================*/
var cbo_sub = [];
/*================================================*\
  :: FUNCTION ::
\*================================================*/
me.ViewHeader=function(){
	me.ViewSetHeader([
		{display:'No.', name:'no', width:'50', align:'center', search:false, sort:false},
		{display:'รูป', name:'filepic', search:false, sort:false, align:'center', width:50},
		{display:'ประเภท', name:'branch_type', align:'center', type:'cbo'},
		{display:'ชื่อ', name:'name_th'},
		{display:'ภาค', name:'geo_code', type:'cbo', option:false},
		{display:'จังหวัด', name:'province_code', type:'cbo', option:false},
		{display:'สบอ.', name:'paro_code', type:'cbo', option:false},
		{display:'แสดงผล', name:'enable', align:'center', width:90, search:false}
	]);
};

me.Add=function(){
	if(!me.CheckForm()){
		$('#lyAddEdit input').first().focus();
		setTimeout('me.ClearError();', 5000);
		return;
	}
	
	bootbox.confirm(me.alert.CALLADD, function(result){
		if(!result)return;

		var myData = {
			data : ft.LoadForm('mydata')
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
						me.MsgSuccess(me.alert.SAVECOMPLETE);
						me.LoadEdit(data.code);
					break;
					default :
						alert(me.alert.SAVEERROR);
					break;
				}
			}
		});
	});
};

me.LoadCbo=function(){
  $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.province, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#province_code');
      $('<option>').attr('value', result.code).text(result.name).appendTo('#search_province_code');
    });
    $.each(data.paro, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#paro_code');
      $('<option>').attr('value', result.code).text(result.name).appendTo('#search_paro_code');
    });
    $.each(data.geo, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#search_geo_code');
    });
		$.each(data.paro_sub, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name_th).appendTo('#paro_sub_code');
    });
		cbo_sub = data.paro_sub;
	});
	
	$('<option>').attr('value', 'A').text('อุทยาน').appendTo('#search_branch_type');
	$('<option>').attr('value', 'B').text('วนอุทยาน').appendTo('#search_branch_type');
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
			$('#lnktab_vdo').css('display', '');
			me.code = code;
			ft.PutForm(data.row);
			
			$(data.photo).each(function(i, attr){
				me.Upload.Append(attr);
			});
			
			$(data.vdo).each(function(i, attr){
				me.UploadVdo.Append(attr);
			});
			
//			me.AppendReview(data.review);
			
			$('#pinFilepic').attr('src', data.field.thumb);
			$('#filepic').val(data.field.filepic);
			
			$('#pinFilemap').attr('src', data.field.thumbmap);
			$('#filemap').val(data.field.filemap);
			
			$.each(cbo_sub, function(i, result) {
				if(result.paros_code == data.field.paro_code){
					$('<option>')
					.attr('value', result.code)
					.text(result.name_th)
					.appendTo('#paro_sub_code')
					.addClass('optsub')
					.addClass('optsub-'+result.paros_code);
				}
			});
			$('#paro_sub_code').val(data.field.paro_sub_code);
			$('.optsub').css('display', 'none');
			$('.optsub-'+data.field.paro_code).css('display', '');
			
			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};

me.AppendReview=function(data){
	var html = '';
	html += '<div class="comment reviewdata" id="review_{code}">';
	html += '  <img src="{pic}" alt="" class="comment-avatar">';
	html += '  <div class="comment-body">';
	html += '    <div class="comment-text">';
	html += '      <div class="comment-header">';
	html += '        <a href="#" title="">{username}</a><span>{date_create}</span>';
	html += '      </div>';
	html += '      {comment}';
	html += '<div>{btn}</div>';
	html += '    </div>';
	
	html += '  </div>';
	html += '</div>';
	html += '';

	var temp = '';
	$('#zone_review').text('');
	$.each(data, function(i, attr){
		var status = (attr.enable == 'N' ? '<button class="btn btn-success btn-xs icon-only" onclick="me.CommentAdd('+attr.code+')"><i class="fa fa-check"></i></button>' : '<button class="btn btn-danger btn-xs icon-only" onclick="me.CommentDel('+attr.code+')"><i class="fa fa-times"></i></button>');
		temp = html;
		temp = temp.split('{code}').join(attr.code);
		temp = temp.split('{pic}').join(attr.pic);
		temp = temp.split('{username}').join(attr.username);
		temp = temp.split('{date_create}').join(attr.date_create);
		temp = temp.split('{comment}').join(attr.comment);
		temp = temp.split('{btn}').join(status);
		$('#zone_review').append(temp);
	});	
};

me.Upload={
	Init : function(type){
		if(type == 'multi'){
			me.Upload.Multi();
		}else{
			me.Upload.One();
		}
	},
	One : function(){
		
	},
	Multi : function(){
		$("#uploader").pluploadQueue({
			runtimes : 'gears,html5,flash,silverlight,browserplus',
			url : 'app.upload.php?mod='+me.mod,
			max_file_size : '300mb',
			chunk_size : '100mb',
			unique_names : true,
			multiple_queues : true,
			filters : [
				{title : "Image files", extensions : "jpg,png,gif"}
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
						me.Upload.Append(obj);
					}else{
						me.MsgError(obj.msg);
					}
				},

				UploadComplete: function(up, files) {
					up.splice();
				}
			}
		});	
	},
	Append : function(data){
		var html = '';
		html += '<div id="imgdata_{code}" rel="{filepic}" class="col-lg-3 col-sm-3 col-md-3 col-xs-6 img-block">';
		html += '  <div class="widget">';
		html += '    <div class="widget-header bordered-left bordered-blueberry">';
		html += '      <span class="widget-caption" title="{name}">';
		html += '				 <i class="fa fa-picture-o sky"></i> <a href="{pic}" target="_blank">{shortname}</a>';
		html += '      </span>';
		html += '      <div class="widget-buttons">';
		html += '        <a href="javascript:;" onclick="me.Upload.Map({code});" class="pinimg">';
		html += '					 <i class="fa fa-map-marker"></i>';
		html += '        </a>';
		html += '        <a href="javascript:;" onclick="me.Upload.Pin({code});" class="pinimg">';
		html += '					 <i class="fa fa-thumb-tack"></i>';
		html += '        </a>';
		html += '        <a href="javascript:me.Upload.Del({code});">';
		html += '          <i class="fa fa-trash-o red"></i>';
		html += '        </a>';
		html += '      </div>';
		html += '    </div>';
		html += '    <div class="widget-body bordered-left bordered-blue imgbody">';
		html += '      <a href="javascript:me.Upload.Show(\'{name}\', \'{pic}\');">';
		html += '        <img id="thumbPic_{code}" src="{thumb}" class="img-responsive" /></a>';
		html += '      </a>';
		html += '    </div>';
		html += '  </div>';
		html += '</div>';

		html = html.split('{code}').join(data.code);
		html = html.split('{name}').join(data.name);
		html = html.split('{shortname}').join(data.shortname);
		html = html.split('{pic}').join(data.pic);
		html = html.split('{thumb}').join(data.thumb);
		html = html.split('{filepic}').join(data.filepic);
		$('#tbUpload').append(html);	

		var n = $('.img-block').length;
		if(n%4==0){
			$('#tbUpload').append('<div class="clear"></div>');	
		}
		
	},
	Pin : function(code){
		bootbox.confirm(me.alert.CALLEDIT, function(result){
			if(!result)return;

			var img = $('#thumbPic_'+code).attr('src');
			var filepic = $('#imgdata_'+code).attr('rel');
			
			var myData = {
				code : me.code,
				filepic : filepic
			};	

			$.ajax({
				url:'app.ajax.php?mode=Pin&mod='+me.mod,
				type:'POST',
				dataType:'json',
				cache:false,
				data:myData,
				success:function(data){
					switch(data.success){
						case 'COMPLETE' :
							$('#pinFilepic').attr('src', img);
							$('#filepic').val(filepic);
						break;
						default :
							alert(me.alert.SAVEERROR);
						break;
					}
				}
			});
		});		
	},
	Map : function(code){
		bootbox.confirm(me.alert.CALLEDIT, function(result){
			if(!result)return;

			var img = $('#thumbPic_'+code).attr('src');
			var filemap = $('#imgdata_'+code).attr('rel');
			
			var myData = {
				code : me.code,
				filemap : filemap
			};	

			$.ajax({
				url:'app.ajax.php?mode=PinMap&mod='+me.mod,
				type:'POST',
				dataType:'json',
				cache:false,
				data:myData,
				success:function(data){
					switch(data.success){
						case 'COMPLETE' :
							$('#pinFilemap').attr('src', img);
							$('#filemap').val(filemap);
						break;
						default :
							alert(me.alert.SAVEERROR);
						break;
					}
				}
			});
		});		
	},
	Del : function(code){
		bootbox.confirm(me.alert.CALLDEL, function(result){
			if(!result)return;

			var myData = {
				code : code
			};	

			$.ajax({
				url:'app.ajax.php?mode=DelUpload&mod='+me.mod,
				type:'POST',
				dataType:'json',
				cache:false,
				data:myData,
				success:function(data){
					switch(data.success){
						case 'COMPLETE' :
							me.MsgSuccess(me.alert.DELCOMPLETE);

							$('#imgdata_'+code).fadeOut('slow');
							$('#imgdata_'+code).remove();
						break;
						default :
							alert(me.alert.SAVEERROR);
						break;
					}
				}
			});
		});		
	},
	DelPin : function(){
		bootbox.confirm(me.alert.CALLDEL, function(result){
			if(!result)return;

			var myData = {
				code : me.code
			};	

			$.ajax({
				url:'app.ajax.php?mode=DelPin&mod='+me.mod,
				type:'POST',
				dataType:'json',
				cache:false,
				data:myData,
				success:function(data){
					switch(data.success){
						case 'COMPLETE' :
							me.MsgSuccess(me.alert.DELCOMPLETE);

							$('#filepic').val('');
							$('#pinFilepic').attr('src', '../img/nopic.jpg');
						break;
						default :
							alert(me.alert.SAVEERROR);
						break;
					}
				}
			});
		});	
	},
	DelPinMap : function(){
		bootbox.confirm(me.alert.CALLDEL, function(result){
			if(!result)return;

			var myData = {
				code : me.code
			};	

			$.ajax({
				url:'app.ajax.php?mode=DelPinMap&mod='+me.mod,
				type:'POST',
				dataType:'json',
				cache:false,
				data:myData,
				success:function(data){
					switch(data.success){
						case 'COMPLETE' :
							me.MsgSuccess(me.alert.DELCOMPLETE);

							$('#filemap').val('');
							$('#pinFilemap').attr('src', '../img/nopic.jpg');
						break;
						default :
							alert(me.alert.SAVEERROR);
						break;
					}
				}
			});
		});	
	},
	Show : function(name, pic){
		$('#modelpic_title').text(name);	
		$('#modelpic_img').html('<img src="'+pic+'" class="img-responsive" />');	
		
		$('#modelpic').modal('show');
	}
};

me.UploadVdo={
	Submit : function(){
		$('#btnvdo_submit').css('display', 'none');
		$('#btnvdo_loading').css('display', '');
		
		$('#upload_code').val(me.code);
		return true;
	},
	Complete : function(data){
		me.UploadVdo.Append(data);
		me.UploadVdo.Clear();
		
		$('#btnvdo_submit').css('display', '');
		$('#btnvdo_loading').css('display', 'none');
	},
	Error : function(msg){
		me.MsgError(msg, 3);
		me.UploadVdo.Clear();
		
		$('#btnvdo_submit').css('display', '');
		$('#btnvdo_loading').css('display', 'none');
	},
	Clear : function(){
		$('#file_name').val('');
		$('#file_pic').val('');
		$('#file_vdo').val('');
	},
	Append : function(data){
		var html = '';
		html += '<div id="vdodata_{code}" rel="{filevdo}" class="col-lg-3 col-sm-3 col-md-3 col-xs-6 vdo-block">';
		html += '  <div class="widget">';
		html += '    <div class="widget-header bordered-left bordered-blueberry">';
		html += '      <span class="widget-caption" title="{name}">';
		html += '				 <i class="fa fa-picture-o sky"></i> <a href="{vdo}" target="_blank">{shortname}</a>';
		html += '      </span>';
		html += '      <div class="widget-buttons">';
		html += '        <a href="javascript:me.UploadVdo.Del({code});">';
		html += '          <i class="fa fa-trash-o red"></i>';
		html += '        </a>';
		html += '      </div>';
		html += '    </div>';
		html += '    <div class="widget-body bordered-left bordered-blue imgbody">';
		html += '      <a href="javascript:me.UploadVdo.Show(\'{name}\', \'{vdo}\', \'{pic}\');">';
		html += '        <img id="thumbPic_{code}" src="{pic}" class="img-responsive" /></a>';
		html += '      </a>';
		html += '    </div>';
		html += '  </div>';
		html += '</div>';

		html = html.split('{code}').join(data.code);
		html = html.split('{name}').join(data.name);
		html = html.split('{filevdo}').join(data.filevdo);
		html = html.split('{filepic}').join(data.filepic);
		html = html.split('{vdo}').join(data.vdo);
		html = html.split('{pic}').join(data.pic);
		html = html.split('{shortname}').join(data.shortname);
		$('#tbUpload_vdo').append(html);	

		var n = $('.vdo-block').length;
		if(n%4==0){
			$('#tbUpload_vdo').append('<div class="clear"></div>');	
		}
		
	},
	Del : function(code){
		bootbox.confirm(me.alert.CALLDEL, function(result){
			if(!result)return;

			var myData = {
				code : code
			};	

			$.ajax({
				url:'app.ajax.php?mode=DelUploadVdo&mod='+me.mod,
				type:'POST',
				dataType:'json',
				cache:false,
				data:myData,
				success:function(data){
					switch(data.success){
						case 'COMPLETE' :
							me.MsgSuccess(me.alert.DELCOMPLETE);

							$('#vdodata_'+code).fadeOut('slow');
							$('#vdodata_'+code).remove();
						break;
						default :
							alert(me.alert.SAVEERROR);
						break;
					}
				}
			});
		});		
	},
	Show : function(name, vdo, pic){
		$('#modelvdo_title').text(name);	
    jwplayer('modelvdo_file').setup({
        file: vdo,
        image: pic,
        title: name,
        width: '100%',
        aspectratio: '16:9'
    });
		
		$('#modelvdo').modal('show');
	},
	Close : function(){
		$('#modelvdo_title').text('');	
		$('#modelvdo_file').text('');	
		
		$('#modelvdo').modal('hide');
	}
};

me.CommentAdd=function(code){
	var myData = {
		code : code
	};
	
	$.ajax({
			url:me.url+'?mode=EditComment&mod='+me.mod,
			type:'POST',
			dataType:'json',
			cache: false,
			data:myData,
			success:function(data){
				switch(data.success){
					case 'COMPLETE' :
						me.MsgSuccess(me.alert.SAVECOMPLETE);
						me.LoadEdit(me.code);
					break;
					default :
						alert(me.alert.SAVEERROR);
					break;
				}
			}
		});
};

me.CommentDel=function(code){
	var myData = {
		code : code
	};
	
	$.ajax({
			url:me.url+'?mode=DelComment&mod='+me.mod,
			type:'POST',
			dataType:'json',
			cache: false,
			data:myData,
			success:function(data){
				switch(data.success){
					case 'COMPLETE' :
						me.MsgSuccess(me.alert.SAVECOMPLETE);
						me.LoadEdit(me.code);
					break;
					default :
						alert(me.alert.SAVEERROR);
					break;
				}
			}
		});
};

me.ClearData=function(){
	$('#lyAddEdit input').val('');
	$('#lyAddEdit select').val('');
	$('#lyAddEdit textarea').val('');
	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);
	$('.tabbable').find('a').first().click();
	
	$('#enable').prop('checked', true);
	$('#pinFilepic').attr('src', '../img/nopic.jpg');
	
	$('#lnk_child').css('display', 'none');
	$('#lnktab_image').css('display', 'none');
	$('#tbUpload').text('');
	
	$('#lnktab_vdo').css('display', 'none');
	$('#tbUpload_vdo').text('');
	$('#paro_sub_code option').remove();
};

me.LoadCboCat=function(){
	$('#paro_code').change(function(){
		$('#paro_sub_code').val('');
		$('#paro_sub_code option').remove();
		var id = $('#paro_code').val();
    $.each(cbo_sub, function(i, result) {
			if(result.paros_code == id){
				$('<option>')
					.attr('value', result.code)
					.text(result.name_th)
					.appendTo('#paro_sub_code');
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
	me.TextEditor();
	me.LoadCbo();
	me.LoadCboCat();
	me.SetDate();
	me.Upload.Init('multi');
	$('#close_start').attr('readonly', false);
	$('#close_stop').attr('readonly', false);
});
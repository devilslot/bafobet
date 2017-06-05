/*==================================================
*  Author : Attaphon Wongbuatong
*  Created Date : 14/6/2554 1:29
*  Module : Compile
*  Description : _FUNCTION_
*  Involve People : -
*  Last Updated : 14/6/2554 1:29
==================================================*/

/*==================================================
  :: VARIABLE ::
==================================================*/
var me={
	debug:[],
	site:'',
  url:'',
	mod:'',
	lang:'th',
	menu:'',
	submenu:'',
	task:'',
	parent:'',
	code:'',
	sub:0,
	loading:true,
	viewstyle:1,
	get:ft.GetParam(),
	viewcolumn:[],
	opencolumn:[],
	permission:{
		add:'',
		edit:'',
		del:''
	},
	define:{},
	alert:{}
};


/*==================================================
  :: METHOD ::
==================================================*/
me.Init=function(){
	me.Search();
	me.SetLoading();
	me.PutStar();
	me.SearchMenu();
//	me.LabelLanguage();
	me.Alert.Load();
//	me.Inbox.Load();
//	me.Tasks.Load();
	
	$('.readonly').attr('readonly', true);
	$('#menu-'+me.menu).addClass('active');
	if(me.submenu != ''){
		$('#menu-'+me.menu).addClass('open');
		$('#submenu-'+me.menu+'-'+me.submenu).addClass('active');
	}
	me.SetFocus();
};

me.SetFocus=function(){
	if($('#lyAddEdit input').first().hasClass('dpk')){
		
	}else if($('#lyAddEdit input').first().hasClass('dtpk')){
		
	}else if($('#lyAddEdit input').first().hasClass('tpk')){
		
	}else{
		$('#lyAddEdit input').first().focus();	
	}
};

me.ChangeLanguage=function(x){
	var myData={
		lang : x
	};
	
	$.ajax({
		url:'app.ajax.php?mode=ChangeLang',
		type:'GET',
		dataType:'json',
		cache:false,
		data:myData,
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					window.location.reload();
				break;
				default :
					alert('Change language error!!');
				break;
			}
		}
	});
};

me.SetUrl=function(){
	me.url = 'module/'+me.mod+'/'+me.mod+'.inc.php';
	
	$('.readonly').attr('readonly', true);
};

me.MsgWarning=function(msg, limit){
	limit = (limit === undefined)?1000:limit*1000;
	
	$('#popup-warning').modal('show');
	$('#popup-warning .modal-body').html(msg);

	setTimeout(function(){
		$('#popup-warning .modal-body').html('');
		$('#popup-warning').modal('hide');
	}, limit);	
};

me.MsgInfo=function(msg, limit){
	limit = (limit === undefined)?1000:limit*1000;
	
	$('#popup-info').modal('show');
	$('#popup-info .modal-body').html(msg);

	setTimeout(function(){
		$('#popup-info .modal-body').html('');
		$('#popup-info').modal('hide');
	}, limit);	
};

me.MsgSuccess=function(msg, limit){
	limit = (limit === undefined)?1000:limit*1000;
	
	$('#popup-success').modal('show');
	$('#popup-success .modal-body').html(msg);

	setTimeout(function(){
		$('#popup-success .modal-body').html('');
		$('#popup-success').modal('hide');
	}, limit);	
};

me.MsgDanger=function(msg, limit){
	limit = (limit === undefined)?1000:limit*1000;
	$('#popup-danger').modal('show');
	$('#popup-danger .modal-body').html(msg);

	setTimeout(function(){
		$('#popup-danger .modal-body').html('');
		$('#popup-danger').modal('hide');
	}, limit);	
};

me.TextEditor=function(id){
	var lang = '';
	if(me.lang == 'en'){
		lang = 'en';
	}else{
		lang = 'th';
	}

	$('.editor').summernote({height: 300});
};

me.TextEditorMin=function(id){
	CKEDITOR.replace(id, {
		language: 'th',
		skin : 'moonocolor',
		toolbar: [
			{name: 'tools', items: [ 'Maximize' ]},
			{name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ]},
//			{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
			{name: 'others', items: [ '-' ]},
			{name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ]},
			{name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ]}
		]
	});
};

me.SetLoading=function(){
	$(document).ajaxStart(function(){
		if(me.loading){
			$('.loading-container').removeClass('loading-inactive');
		}
	});
	$(document).ajaxStop(function(){
		$('.loading-container').addClass('loading-inactive');
	});
};

me.SubTable=function(){
	$('#zone_header').remove();
	$('#lyMenu').remove();
	var title = $('#ModTitle').text();
	title += ' #'+me.get.param.parent_code;
	$('#ModTitle').text(title);
	$('.mymenu').css('top', '5px');
	$('.wrapper').css('padding-top', '0');
	$('.content').css('margin-left', '0');
};

me.LabelLanguage=function(){
	var text = '';
	$('.control-label').each(function(){
		text = $(this).html();
		text = text.split('(TH)').join('<sup><i class="flag flag-th"></i></sup>');
		text = text.split('(EN)').join('<sup><i class="flag flag-en"></i><sup>');
		
		$(this).html(text);
	});
};

me.Table=function(id, obj){
	var html = '';
	var header = '';
	var content = '';
	html += '<table id="tb_'+id+'" class="table table-bordered table-striped table-scrollable table-hover">';
	html += '  <thead class="bordered-blue">';
	html += '    <tr>{header}</tr>';
	html += '  </thead>';
	html += '  <tbody id="td_'+id+'">';
	html += '			{content}';
	html += '  </tbody>';
	html += '</table>';

	$('#tb_'+id).remove();
	
	$(obj.header).each(function(i, item){
		header += '<th class="text-align-center">'+item.display+'</th>';
	});
	
	$(obj.data).each(function(i, field){
		content += '<tr id="tr'+field.code+'">';
		$(obj.header).each(function(j, attr){
			content += '<td style="text-align:'+attr.align+'">'+field[attr.name]+'</td>';
		});
		content += '</tr>';
	});
	
	html = html.split('{header}').join(header);
	html = html.split('{content}').join(content);
	
	return html;
};

/*==================================================
  :: VIEW ::
==================================================*/
me.ViewSetHeader=function(obj, style){
	var html = '';
	var showsearch = true;
	var showsort = true;
	var show = true;
	var display = '';
	var width = '';
	var txtsort = '';
	var setsearch = [];
	var ix = 0;
	var type = '';
	var cls = '';
	var guide = '';
	var option = true;
	var item = {
		name : 'code',
		align : 'center'
	};
	
	style = (style===undefined)?{}:style;
	me.viewstyle = {
		style : (style.style===undefined)?1:style.style,
		
		sort_by : (style.sort_by===undefined)?'code':style.sort_by,
		sort_order : (style.sort_order===undefined)?'desc':style.sort_order,
		limit : (style.limit===undefined)?10:style.limit,
		
		show_button : (style.show_button===undefined)?true:style.show_button,
		show_no : (style.show_no===undefined)?true:style.show_no,
		show_enable : (style.show_enable===undefined)?true:style.show_enable,
		show_page : (style.show_page===undefined)?true:style.show_page,
		show_limit : (style.show_limit===undefined)?true:style.show_limit,
		show_record : (style.show_record===undefined)?true:style.show_record,
		show_search : (style.show_search===undefined)?true:style.show_search
	};

	$('#thView').text('');
	html = '<tr>';
	switch(me.viewstyle.style){
		case 2 : 
			html += '<th class="text-align-center" width="40">';
			html += '	<button ';
			html += '		type="button"';
			html += '		id="btncallap_plus_all" ';
			html += '		onclick="me.CollapseTable(\'plus\', \'all\');" ';
			html += '		class="btn btn-xs shiny success icon-only">';
			html += '		<i class="fa fa-plus-square"></i></button>';
			html += '';
			html += '	<button ';
			html += '		type="button"';
			html += '		id="btncallap_minus_all" ';
			html += '		class="btn btn-xs shiny warning icon-only" ';
			html += '		onclick="me.CollapseTable(\'minus\', \'all\');"';
			html += '		style="display:none">';
			html += '		<i class="fa fa-minus-square"></i></button>';
			html += '</th>';	
			break;
		case 3 : 
			html += '<th class="text-align-center" width="40">';	
			html += '	<label><input id="trchk_all" type="checkbox" class="colored-success" /><span class="text"></span></label>';	
			html += '</th>';	
			break;
	}
	if(me.viewstyle.show_enable){
		html += '<th class="text-center" width="30"><i id="sort_enable" onclick="me.ViewSort(this);" rel="enable" style="text-decoration:none;" class="sortdata fa fa-unsorted btn-link"></i></th>';
	}
	if(me.viewstyle.show_no){
		html += '<th class="text-center" width="30">No.</th>';
	}
	
	$.each(obj, function(i, attr){
		item = {
			name : '',
			align : '',
			view : false
		};
		type=(attr.type===undefined)?'':attr.type;
		guide=(attr.guide===undefined)?'':attr.guide;
		option=(attr.option===undefined)?true:attr.option;
		cls=(attr.cls===undefined)?'':attr.cls;
		display=(attr.display===undefined)?'':attr.display;
		width=(attr.width===undefined)?'':'width="'+attr.width+'"';
		showsort=(attr.sort===undefined)?true:attr.sort;
		showsearch=(attr.search===undefined)?true:attr.search;
		show=(attr.show===undefined)?true:attr.show;
		item.name=(attr.name===undefined)?'':attr.name;
		item.align=(attr.align===undefined)?'left':attr.align;
		item.view=(attr.view===undefined)?false:attr.view;
		item.datatype=(attr.datatype===undefined)?'text':attr.datatype;
		item.style=(attr.style===undefined)?'':attr.style;
		item.format=(attr.format===undefined)?'2':attr.format;
		
		if(showsort){
			txtsort = '<i id="sort_'+attr.name+'" onclick="me.ViewSort(this);" rel="'+attr.name+'" style="float:right; text-decoration:none;" class="sortdata fa fa-unsorted btn-link"></i>';
		}else{
			txtsort = '';
		}
		if(showsearch){
			setsearch[ix] = {
				name : attr.display,
				id : attr.name,
				type : type,
				cls : cls,
				option : option,
				guide : guide,
				datatype : item.datatype,
				format : item.format,
				style : item.style
			};
			ix++;
		}
		if(show){
			me.viewcolumn[i] = item;
			html += '<th class="text-center" '+width+'>'+display+txtsort+'</th>';
		}
	});
	if(me.viewstyle.show_button){
		html += '<th class="text-center" width="50">&nbsp;</th>';
	}
	html += '</tr>';
	$('#thView').append(html);
	
	me.ViewSetSearch(setsearch);
	
//	console.log(me.viewstyle);
	me.SetSort(me.viewstyle.sort_by, me.viewstyle.sort_order);
	me.SetLimit(me.viewstyle.limit);
	if(!me.viewstyle.show_page){$('#PageTop').remove(); $('#PageBottom').remove();}
	if(!me.viewstyle.show_limit){$('#block_limit').remove();}
	if(!me.viewstyle.show_record){$('#block_record').remove();}
	if(!me.viewstyle.show_search){$('#row_search').remove();}
		
	$('.sortdata').first().addClass('fa-sort-asc').removeClass('fa-unsorted');
};

me.ViewSetSearch=function(data){
	var html = '';
	html += '<div id="lysearch_{id}" class="col-sm-4">';
	html += '  <div class="form-group">';
	html += '    <label for="" class="col-sm-4 control-label no-padding-right">{name} :</label>';
	html += '    <div class="col-sm-8">';
	html += '      <div class="input-group">';
	html += '        <div class="input-group-btn">';
	html += '          {btnlimit}';
	html += '        </div>';
	html += '        {input}';
	html += '      </div>               ';
	html += '    </div>';
	html += '  </div>';
	html += '</div>';
	
	var text = '<input id="search_{id}" name="{id}" type="text" class="form-control searchdata {cls}" tabindex="{tabindex}" placeholder="{guide}" rel="" />';
	var cbo = '<select id="search_{id}" name="{id}" class="form-control searchdata {cls}" tabindex="{tabindex}" rel=""><option value="">{guide}</option></select>';
	
	var textlimit = '<button id="option_{id}" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="border-right:0;" rel="LIKE">&TildeTilde;</button>';
	textlimit += '<ul class="dropdown-menu">';
	textlimit += '  <li><a href="javascript:;" onclick="me.SetOption(\'{id}\', \'=\');">= เท่ากับ </a></li>';
	textlimit += '  <li><a href="javascript:;" onclick="me.SetOption(\'{id}\', \'>\');">&gt; มากกว่า</a></li>';
	textlimit += '  <li><a href="javascript:;" onclick="me.SetOption(\'{id}\', \'<\');">&lt; น้อยกว่า</a></li>';
	textlimit += '  <li><a href="javascript:;" onclick="me.SetOption(\'{id}\', \'<>\');">&NotEqual; ไม่เท่ากับ</a></li>';
	textlimit += '  <li><a href="javascript:;" onclick="me.SetOption(\'{id}\', \'LIKE\');">&TildeTilde; ใกล้เคียง</a></li>';
	textlimit += '</ul>';
	
	var textcbo = '<button id="option_{id}" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="border-right:0;" rel="=">=</button>';
//console.log(data);
	var temp = '';
	var tabindex = 500;
	$('#ViewSetSearch').text('');
	$.each(data, function(i, attr){
		tabindex++;
		
		temp = html;
		if(attr.option){
			temp = temp.split('{btnlimit}').join(textlimit);
		}else{
			temp = temp.split('{btnlimit}').join(textcbo);
		}
		if(attr.type=='cbo'){
			temp = temp.split('{input}').join(cbo);
		}else{
			temp = temp.split('{input}').join(text);
		}
		
		temp = temp.split('{id}').join(attr.id);
		temp = temp.split('{guide}').join(attr.guide);
		temp = temp.split('{name}').join(attr.name);
		temp = temp.split('{cls}').join(attr.cls);
		temp = temp.split('{tabindex}').join(tabindex);
		$('#ViewSetSearch').append(temp);
	});	
};

me.SetOption=function(id, option){
	switch(option){
		case '=' :$('#option_'+id).html('=');break;
		case '>' :$('#option_'+id).html('&gt;');break;
		case '<' :$('#option_'+id).html('&lt;');break;
		case '<>' :$('#option_'+id).html('&NotEqual;');break;
		case 'LIKE' :$('#option_'+id).html('&TildeTilde;');break;
	}
	$('#option_'+id).attr('rel', option);
	$('#search_'+id).focus();
};

me.ViewSearch=function(){
	if($('#ViewSearchCaret').hasClass('fa-caret-right')){
		$('#ViewSearchCaret').removeClass('fa-caret-right').addClass('fa-caret-down');
		$('#ViewSearch').slideDown('fast');
	}else{
		$('#ViewSearchCaret').removeClass('fa-caret-down').addClass('fa-caret-right');
		$('#ViewSearch').slideUp('fast');
	}
};

me.View=function(page){
	if(page===undefined)page=1;
	var myData = {
		sortby : $('#sortby').val(),
		sortorder : $('#sortorder').val(),
		limit : $('#cboLimit').val(),
		page : page,
		parent : me.parent,
		column : [],
		search : []
	};
	
	var v = '';
	var id = '';
	$('.searchdata').each(function(i){
		id = $(this).attr('name');
		if($(this).hasClass('dpk')){
			if($(this).val()!=''){
				v = ft.DateFormat($(this).val());
			}else{
				v = '';
			}
		}else if($(this).hasClass('dtpk')){
			if($(this).val()!=''){
				v = ft.DateTimeFormat($(this).val());
			}else{
				v = '';
			}
		}else if($(this).hasClass('tpk')){
			if($(this).val()!=''){
				v = ft.TimeFormat($(this).val());
			}else{
				v = '';
			}
		}else if($(this).hasClass('getrel')){ 
			if($(this).val()!=''){
				if($(this).attr('rel')!=''){
					v = $(this).attr('rel');
				}else{
					v = '';
				}
			}else{
				v = '';
			}
		}else{
			v = $(this).val();
		}
		myData.search[i] = {
			searchby : id,
			searchoption : $('#option_'+id).attr('rel'),
			searchkey : v
		};
	});
	$(me.viewcolumn).each(function(i, attr){
		myData.column[i] = attr.name;
	});
	
	$('#tbView').text('');
	$('#tbView').css('display', 'none');
	$.ajax({
		url:me.url+'?mode=View&mod='+me.mod,
		type:'POST',
		dataType:'json',
		cache: false,
		data:myData,
		success:function(data){
			$('#ViewRecord').text(data.record);
			me.AppendView(data.row);
			me.AppendPage(data.page);
			$('#tbView').css('display', '');
			
			$('#content-addedit').css('display', 'none');
			$('#content-viewlist').fadeIn('slow');
			$('#content-status').css('display', 'none');
		}
	});
};

me.AppendView=function(data){
	var html;
	var colspan = me.viewcolumn.length+3;
	var value = '';
	if(me.viewstyle.style==2 || me.viewstyle.style==3)colspan++;
	$(data).each(function(i, field){
		html = '<tr id="tr'+field.code+'">';
		switch(me.viewstyle.style){
			case 2 : 
				html += '<td class="text-align-center" width="40">';
				html += '	<button ';
				html += '		type="button"';
				html += '		id="btncallap_plus_'+field.code+'" ';
				html += '		onclick="me.CollapseTable(\'plus\', \''+field.code+'\');" ';
				html += '		class="btn btn-xs shiny success icon-only btncallap_plus">';
				html += '		<i class="fa fa-plus-square"></i></button>';
				html += '';
				html += '	<button ';
				html += '		type="button"';
				html += '		id="btncallap_minus_'+field.code+'" ';
				html += '		class="btn btn-xs shiny warning icon-only btncallap_minus" ';
				html += '		onclick="me.CollapseTable(\'minus\', \''+field.code+'\');"';
				html += '		style="display:none">';
				html += '		<i class="fa fa-minus-square"></i></button>';
				html += '</td>';	
				break;
			case 3 : 
				html += '<th class="text-align-center" width="40">';	
				html += '	<label><input id="trchk_'+field.code+'" type="checkbox" class="colored-success trchk" /><span class="text"></span></label>';	
				html += '</th>';	
				break;
		}
		if(me.viewstyle.show_enable){
			html += '<td class="text-center">'+field.enable+'</td>';
		}
		if(me.viewstyle.show_no){
			html += '<td class="text-center">'+field.no+'</td>';
		}
		$(me.viewcolumn).each(function(j, attr){
			switch(attr.datatype){
				case 'date' : value = ft.DateDisplay(field.item[j]); break;
				case 'datetime' : value = ft.DateTimeDisplay(field.item[j]); break;
				case 'number' : value = ft.NumberDisplay(field.item[j], attr.format); break;
				default : value = field.item[j];
			}
			if(attr.view){
				html += '<td style="text-align:'+attr.align+'" class="'+attr.style+'"><a href="javascript:me.OpenView('+field.code+');">'+value+'</a></td>';
			}else{
				html += '<td style="text-align:'+attr.align+'" class="'+attr.style+'">'+value+'</td>';
			}
		});
		if(me.viewstyle.show_button){
			html += '<td class="text-center">'+field.btn+'</td>';
		}
		html += '</tr>';
		if(me.viewstyle.style==2){
			field.collap = (field.collap===undefined)?'&nbsp;':field.collap;
			html += '<tr id="trcollap_'+field.code+'" class="trcollap" style="display:none;">';
			html += '	<td colspan="'+colspan+'">'+field.collap+'</td>';
			html += '</tr>';
		}
		$('#tbView').append(html);
	});
};

me.OpenView=function(code){
	$('#tb-view').text('');
	
	$.ajax({
		url:me.url+'?mode=OpenView&mod='+me.mod,
		type:'GET',
		dataType:'json',
		cache: false,
		data:{code:code},
		success:function(data){
			var html = '';
			var temp = '';
			html += '<tr>';
			html += '	<td width="35%"><b>{title}</b></td>';
			html += '	<td width="65%">{value}</td>';
			html += '</tr>';
			
			$(me.opencolumn).each(function(i, item){
				$(data.row).each(function(j, attr){
					if(item.name == attr.name){
						switch(item.type){
							case 'date' : attr.value = ft.DateDisplay(attr.value); break;
							case 'datetime' : attr.value = ft.DateTimeDisplay(attr.value); break;
							case 'number' : attr.value = ft.NumberDisplay(attr.value, attr.format); break;
						}
						temp = html;
						temp = temp.split('{title}').join(item.display);
						temp = temp.split('{value}').join(attr.value);

						$('#tb-view').append(temp);
					}
				});
			});
			
			$('#popup-view').modal('show');
			$('#view_code').text(code);
			$('#code').val(code);
			me.code = code;
		}
	});
};

me.ViewOpenSetHeader=function(obj){
	$.each(obj, function(i, attr){
		attr.display=(attr.display===undefined)?'':attr.display;
		attr.name=(attr.name===undefined)?'':attr.name;
		attr.type=(attr.type===undefined)?'text':attr.type;
		attr.format=(attr.format===undefined)?2:attr.format;
		
		me.opencolumn.push(attr);
	});
};

me.AppendPage=function(data){
	var disable_fp = '';
	if(data.page == data.fp){
		disable_fp = 'disabled="disabled"';
	}
	var disable_pp = '';
	if(data.page == data.pp){
		disable_pp = 'disabled="disabled"';
	}
	var disable_np = '';
	if(data.page == data.np){
		disable_np = 'disabled="disabled"';
	}
	var disable_ep = '';
	if(data.page == data.ep){
		disable_ep = 'disabled="disabled"';
	}
	
	var html = '';
	html += '<li><a href="javascript:me.View('+data.fp+');" '+disable_fp+'><i class="fa fa-step-backward"></i></a></li>';
	html += '<li><a href="javascript:me.View('+data.pp+');" '+disable_pp+'><i class="fa fa-backward"></i></a></li>';
	
	$(data.runpage).each(function(i, page){
		if(data.page == page){
			html += '<li class="active"><a href="javascript:me.View('+page+');">'+page+'</a></li>';
		}else{
			html += '<li><a href="javascript:me.View('+page+');">'+page+'</a></li>';
		}
	});
	html += '<li><a href="javascript:me.View('+data.np+');" '+disable_np+'><i class="fa fa-forward"></i></a></li>';
	html += '<li><a href="javascript:me.View('+data.ep+');" '+disable_ep+'><i class="fa fa-step-forward"></i></a></li>';
	
	$('#lyPage').text('');
	$('#lyPage').html(html);
	
	if($('#cboLimit').val()>10){
		$('#PageBottom').css('display', 'block');
		$('#lyPageBtm').text('');
		$('#lyPageBtm').html(html);
	}else{
		$('#PageBottom').css('display', 'none');
	}
};

me.Search=function(){
	$('#frmSearch').submit(function(){
		me.View();
		return false;
	});
};

me.Limit=function(limit){
	$('#cboLimit').val(limit);
	var text = $('#limit_'+limit).html();
	$('#btnGroupLimit').html(text+' <i class="fa fa-angle-down"></i>');
	me.View();
};

me.SetLimit=function(limit){
	$('#cboLimit').val(limit);
	var text = $('#limit_'+limit).html();
	$('#btnGroupLimit').html(text+' <i class="fa fa-angle-down"></i>');
};

me.ViewSort=function(obj){
	var sortby = $(obj).attr('rel');
	var sortorder = '';
	if($(obj).hasClass('fa-unsorted')){
		sortorder = 'asc';
		$('.sortdata').removeClass('fa-sort-asc').removeClass('fa-sort-desc').addClass('fa-unsorted');
		$(obj).addClass('fa-sort-asc').removeClass('fa-unsorted');
	}else if($(obj).hasClass('fa-sort-asc')){
		sortorder = 'desc';
		$('.sortdata').removeClass('fa-sort-asc').removeClass('fa-sort-desc').addClass('fa-unsorted');
		$(obj).addClass('fa-sort-desc').removeClass('fa-unsorted');
	}else if($(obj).hasClass('fa-sort-desc')){
		sortorder = 'asc';
		$('.sortdata').removeClass('fa-sort-asc').removeClass('fa-sort-desc').addClass('fa-unsorted');
		$(obj).addClass('fa-sort-asc').removeClass('fa-unsorted');
	}else{
		sortorder = 'asc';
		$('.sortdata').removeClass('fa-sort-asc').removeClass('fa-sort-desc').addClass('fa-unsorted');
		$(obj).addClass('fa-sort-asc').removeClass('fa-unsorted');
	}
	$('#sortby').val(sortby);
	$('#sortorder').val(sortorder);
	
	me.View();
};

me.SetSort=function(sortby, sortorder){
	var obj = $('#sort_'+sortby);
	if(sortorder=='desc'){
		$('.sortdata').removeClass('fa-sort-asc').removeClass('fa-sort-desc').addClass('fa-unsorted');
		$(obj).addClass('fa-sort-desc').removeClass('fa-unsorted');
	}else{
		sortorder = 'asc';
		$('.sortdata').removeClass('fa-sort-asc').removeClass('fa-sort-desc').addClass('fa-unsorted');
		$(obj).addClass('fa-sort-asc').removeClass('fa-unsorted');
	}
	
	$('#sortby').val(sortby);
	$('#sortorder').val(sortorder);
};

me.ViewPageNumber=function(e, obj){
	e.which = e.which || e.keyCode;
	if(e.which == 13) {
		var num = ft.NumberFormat($(obj).val());

		if(num==0)num=1;

		$(obj).val(num);

		me.View(num);
	}
};

me.ViewPageNumberBlur=function(obj){
	var num = ft.NumberFormat($(obj).val());
	
	if(num==0)num=1;
	
	$(obj).val(num);
	
	me.View(num);
};

me.ReView=function(){
	$('#sortby').val('code');
	$('#sortorder').val('asc');
	
	$('.sortdata').removeClass('btn-info').addClass('btn-link');
	$('.sortdata').first().addClass('btn-info').removeClass('btn-link');
	$('.searchdata').val('');
	
	me.View();
};

me.ExportExcel=function(){
	var p={
		limit:$('#cboLimit').val(),
		page:$('.pagenow').val()
	};
	
	var v = '';
	var id = '';
	$('.searchdata').each(function(i){
		id = $(this).attr('name');
		if($(this).hasClass('dpk')){
			if($(this).val()!=''){
				v = ft.DateFormat($(this).val());
			}else{
				v = '';
			}
		}else if($(this).hasClass('dtpk')){
			if($(this).val()!=''){
				v = ft.DateTimeFormat($(this).val());
			}else{
				v = '';
			}
		}else if($(this).hasClass('tpk')){
			if($(this).val()!=''){
				v = ft.TimeFormat($(this).val());
			}else{
				v = '';
			}
		}else if($(this).hasClass('getrel')){ 
			if($(this).val()!=''){
				if($(this).attr('rel')!=''){
					v = $(this).attr('rel');
				}else{
					v = '';
				}
			}else{
				v = '';
			}
		}else{
			v = $(this).val();
		}
		if(v!=''){
			p[id]=v;
		}
	});
	var para = $.param(p);
//	window.open('app.excel.php?file=print&mod='+me.mod+'&'+para, '_blank');
	window.location.href = 'app.excel.php?file=excel&mod='+me.mod+'&'+para;
//	window.location.href = 'app.excel2.php?mod='+me.mod;
};

me.CollapseTable=function(option, id){
	// ft.Debug(id);
	if(option=='plus'){
		if(id=='all'){
			$('.trcollap').css('display', '');
			$('#btncallap_plus_all').css('display', 'none');
			$('#btncallap_minus_all').css('display', '');
			$('.btncallap_plus').css('display', 'none');
			$('.btncallap_minus').css('display', '');
		}else{
			$('#trcollap'+'_'+id).css('display', '');
			$('#btncallap_plus_'+id).css('display', 'none');
			$('#btncallap_minus_'+id).css('display', '');
		}
	}else if(option=='minus'){
		if(id=='all'){
			$('.trcollap').css('display', 'none');
			$('#btncallap_plus_all').css('display', '');
			$('#btncallap_minus_all').css('display', 'none');
			$('.btncallap_plus').css('display', '');
			$('.btncallap_minus').css('display', 'none');
		}else{
			$('#trcollap_'+id).css('display', 'none');
			$('#btncallap_plus_'+id).css('display', '');
			$('#btncallap_minus_'+id).css('display', 'none');
		}
	}
};

me.TableCheckAll=function(){
	$('#trchk_all').on('click', function(){
		if($(this).is(':checked')){
			$('.trchk').prop('checked', true);
		}else{
			$('.trchk').prop('checked', false);
		}
	});
};

/*==================================================
  :: ADDEDIT ::
==================================================*/

me.New=function(){
	$('#content-viewlist').css('display', 'none');
	$('#content-addedit').fadeIn('slow');
	$('#content-status').css('display', 'none');

	$('#tooladd').css('display', '');
	$('#tooledit').css('display', 'none');
	$('#addedit_pointer').css('display', 'none');
	$('#addedit_del').css('display', 'none');

	$('#add_title').css('display', '');
	$('#edit_title').css('display', 'none');

	me.ClearData();
	$('#lyAddEdit input').first().focus();
};

me.Copy=function(){
	$('#tooladd').css('display', '');
	$('#tooledit').css('display', 'none');
	$('#addedit_pointer').css('display', 'none');
	$('#addedit_del').css('display', 'none');
	
	$('#content-status').css('display', 'none');
	
	$('#add_title').css('display', '');
	$('#edit_title').css('display', 'none');
	
	me.SetFocus();
};

me.AddCheck=function(){
	if(!me.CheckForm()){
		$('#lyAddEdit input').first().focus();
		setTimeout('me.ClearError();', 5000);
		return;
	}

	$('#popup-add').modal('show');
};

me.EditCheck=function(){
	if(!me.CheckForm()){
		$('#lyAddEdit input').first().focus();
		setTimeout('me.ClearError();', 5000);
		return;
	}

	$('#popup-edit').modal('show');
};

me.Add=function(){
	$('.modal').modal('hide');
	
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
					me.MsgSuccess(data.msg, 1.5);
					me.Clear();
				break;
				default :
					me.MsgDanger(data.msg, 3);
				break;
			}
		}
	});
};

me.Edit=function(){
	$('.modal').modal('hide');
	
	var myData = {
		code : me.code,
		data : ft.LoadForm('mydata')
	};

	if($('#enable').Exist()){
		myData.data['enable'] = ($('#enable').is(':checked'))?'Y':'N';
	}

	$.ajax({
		url:me.url+'?mode=Edit&mod='+me.mod,
		type:'POST',
		dataType:'json',
		cache:false,
		data:myData,
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					me.LoadEdit(me.code);
					me.MsgSuccess(data.msg, 1.5);
				break;
				default :
					me.MsgDanger(data.msg, 3);
				break;
			}
		}
	});
};

me.LoadEditView=function(){
	$('.modal').modal('hide');
	var code = $('#code').val();
	me.LoadEdit(code);
}

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
			
			me.SetPointer(data.pointer);
			me.SetLoadEdit(data.field);
			me.SetFocus();
		}
	});
};

me.HideMenu=function(){
	$('#sidebar-collapse').click();
	$('#sidebar-collapse').removeClass('active');	
};

me.SetLoadEdit=function(data){
	$('#content-viewlist').css('display', 'none');
	$('#content-addedit').fadeIn('slow');
	$('#content-status').fadeIn('slow');
	
	$('#add_title').css('display', 'none');
	$('#edit_title').css('display', '');

	$('#tooladd').css('display', 'none');
	$('#tooledit').css('display', '');
	$('#addedit_pointer').css('display', '');
	$('#addedit_del').css('display', '');

	$('#status_code').text(data.code);
	$('#status_user_create').text(data.user_create);
	$('#status_user_update').text(data.user_update);
	$('#status_date_create').text(data.date_create);
	$('#status_date_update').text(data.date_update);
	if(data.enable == 'N'){
		$('#status_enable').html('<i class="fa fa-eye-slash" title="Disable"></i> close');
	}else{
		$('#status_enable').html('<i class="fa fa-eye" style="color:green;" title="Enable"></i> open');
	}	
};

me.SetPointer=function(data){
	if(me.code == data.firstcode){
		$('#btnEditFirst').attr('disabled', true);
	}else{
		$('#btnEditFirst').attr('disabled', false);
	}
	if(me.code == data.prevcode){
		$('#btnEditPrev').attr('disabled', true);
	}else{
		$('#btnEditPrev').attr('disabled', false);
	}
	if(me.code == data.nextcode){
		$('#btnEditNext').attr('disabled', true);
	}else{
		$('#btnEditNext').attr('disabled', false);
	}
	if(me.code == data.lastcode){
		$('#btnEditLast').attr('disabled', true);
	}else{
		$('#btnEditLast').attr('disabled', false);
	}
	
	$('#firstcode').val(data.firstcode);
	$('#prevcode').val(data.prevcode);
	$('#nextcode').val(data.nextcode);
	$('#lastcode').val(data.lastcode);
};

me.Clear=function(){
	me.ClearData();
	$('#lyAddEdit input').first().focus();
};

me.Del=function(code, modedel){
	var myData = {
		code : code
	};	

	$.ajax({
		url:me.url+'?mode=Del&mod='+me.mod,
		type:'POST',
		dataType:'json',
		cache:false,
		data:myData,
		success:function(data){
			switch(data.success){
				case 'COMPLETE' :
					if(modedel=='VIEW'){
						$('#tr'+code).remove();
					}else{
						me.View();
					}
					me.MsgSuccess(me.alert.DELCOMPLETE);
				break;
				default :
					alert(me.alert.SAVEERROR);
				break;
			}
		}
	});
};

me.DelView=function(code){
	me.DelViewPopup();
	$('#code').val(code);
	me.code = code;
};

me.DelViewPopup=function(){
	$('.modal').modal('hide');
	$('#popup-delview').modal('show');
};

me.DelViewOpen=function(){
	$('.modal').modal('hide');
	var code = $('#code').val();

	me.Del(code, 'VIEW');
};

me.DelPopup=function(){
	$('.modal').modal('hide');
	$('#popup-del').modal('show');
};

me.DelEdit=function(){
	$('.modal').modal('hide');
	var code = $('#code').val();
	me.Del(code, 'EDIT');
};

me.ClearCbo=function(id){
	$('#'+id+' option').remove();
	$('<option>').attr('value', '').text('').appendTo('#'+id);
};

me.SetDateTime=function(){
	var lang = 'uk';
	if(me.lang == 'th'){
		lang = 'th';
	}
	$('.dtpk').datetimepicker({
		language: lang,
		format: 'dd/mm/yyyy hh:ii',
		pickerPosition: 'bottom-right',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
		showMeridian: 1
	});
};

me.SetDate=function(){
	var lang = 'uk';
	if(me.lang == 'TH'){
		lang = 'th';
	}
	$('.dpk').datetimepicker({
		language: lang,
		format: 'dd/mm/yyyy',
		pickerPosition: 'bottom-right',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
	});
};

me.SetTime=function(){
	var lang = 'uk';
	if(me.lang == 'TH'){
		lang = 'th';
	}
	$('.tpk').datetimepicker({
		language: lang,
		format: 'hh:ii',
		pickerPosition: 'bottom-right',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
	});
};

me.First=function(){
	var code = $('#firstcode').val();
	me.LoadEdit(code);
};

me.Prev=function(){
	var code = $('#prevcode').val();
	me.LoadEdit(code);
};

me.Next=function(){
	var code = $('#nextcode').val();
	me.LoadEdit(code);
};

me.Last=function(){
	var code = $('#lastcode').val();
	me.LoadEdit(code);
};

me.PutStar=function(){
	var self;
	var id = '';
	var text = '';
	$('.empty').each(function(){
		self = $(this);
		if((self.is('input:text')) || (self.is('input:password')) || (self.is('textarea')) || (self.is('select'))){
			id = $(this).attr('id');
			text = $('#lbl'+id).html()+'';
			text = text.split(' :').join('');
			$('#lbl'+id).html(text+' <b><font color="red">*</font></b> :');
		}
	});
};

me.ClearData=function(){
	$('#lyAddEdit input').val('');
	$('#lyAddEdit select').val('');
	$('#lyAddEdit textarea').val('');
	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);
	
	$('#enable').prop('checked', true);
	$('#pinFilepic').attr('src', '../img/nopic.jpg');
	
	$('#lnk_child').css('display', 'none');
	$('#lnktab_image').css('display', 'none');
	$('#tbUpload').text('');
	
	$('#lnktab_vdo').css('display', 'none');
	$('#tbUpload_vdo').text('');
	$('.editor').code('');
};

me.ClearButton=function(btn){
	$.each(btn, function(i, attr){
		$('#'+attr).remove();
	});
};

me.ClearError=function(){
  $('#lyAddEdit .err').css('display', 'none');
	$('.form-group').removeClass('has-error');
};

me.CheckForm=function(){
	me.ClearError();
  var chk =  ft.CheckEmpty('empty');
	if(chk){
		return true;
	}else{
		me.MsgDanger(me.alert.PLEASEINSERT);
		return false;
	}
};

me.ModalUpload=function(){
	$('#ModalUpload').modal('show');
};

me.SearchMenu=function(){
	$('#SearchMenu').keyup(function(){
		var text=$(this).val();
		var value='';
		if(text==''){
			$('.menuitem').css('display', '');
			$('.menusubitem').css('display', '');
			$('.menusearch').css('display', 'none');
		}else{
			$('.menuitem').css('display', 'none');
			$('.menusubitem').css('display', 'none');
			$('.menusearch').css('display', 'none');
			$(".menusearch[rel*='"+text+"']").css('display', '');
			$(".menusearch[rel*='"+text+"']").each(function(){
				value = $(this).attr('rel');
				value = value.split(text).join('<b class="info">'+text+'</b>');
				$(this).find('.menu-text').html(value);
			});
		}
	});	
};

/*================================================*\
  :: UPLOAD ::
\*================================================*/

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
						me.MsgDanger(obj.msg);
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
	Show : function(name, pic){
		$('#modelpic_title').text(name);	
		$('#modelpic_img').html('<img src="'+pic+'" class="img-responsive" />');	
		
		$('#modelpic').modal('show');
	}
};

/*================================================*\
  :: ALERT ::
\*================================================*/
me.Alert={
	Load:function(){
		me.loading = false;
		$.ajax({
			url:'app.ajax.php?mode=LoadAlert',
			type:'POST',
			dataType:'json',
			cache:false,
			data:{},
			success:function(data){
				me.loading = true;
				if(data.success=='LOGOUT'){
					window.location.href = data.url;
				}else{
					me.Alert.Append(data);
					setTimeout('me.Alert.Load()', 60000);
				}
			}
		});
	},
	Append:function(data){
		var html = '';
		html += '<li>';
		html += '    <a href="{lnk}">';
		html += '        <div class="clearfix">';
		html += '            <div class="notification-icon">';
		html += '                <i class="fa {icon} bg-themeprimary white"></i>';
		html += '            </div>';
		html += '            <div class="notification-body">';
		html += '                <span class="title">{msg}</span>';
		html += '                <span class="description">{date_create}</span>';
		html += '            </div>';
		html += '            <div class="notification-extra">';
		html += '                <i class="fa fa-bitcoin themeprimary"></i>';
		html += '                <span class="description">{total}</span>';
		html += '            </div>';
		html += '        </div>';
		html += '    </a>';
		html += '</li>';

		var temp = '';
		$('#zone_alert').text('');
		$.each(data.row, function(i, attr){
			temp = html;
			temp = temp.split('{icon}').join('fa-file-text-o');
			temp = temp.split('{code}').join(attr.code);
			temp = temp.split('{msg}').join(attr.msg);
			temp = temp.split('{branch_name}').join(attr.branch_name);
			temp = temp.split('{date_create}').join(attr.date_create);
			temp = temp.split('{total}').join(attr.total);
			$('#zone_alert').append(temp);
		});		
		
		html  = '<li class="dropdown-footer" style="cursor:pointer;" onclick="window.location=\'FEAE57551F7DA68DC340D755B98A0B4D.html?call='+data.cnt+'\';">';
		html += '    <span>';
		html += '        Alert';
		html += '    </span>';
		html += '    <span class="pull-right">';
		html += '        Show all';
		html += '        <i class="fa fa-search"></i>';
		html += '    </span>';
		html += '</li>';		
		
		$('#zone_alert').append(html);
		
		$('#alert_no').text(data.cnt);
	}
};

me.Inbox={
	Load:function(){
		me.loading = false;
		$.ajax({
			url:'app.ajax.php?mode=LoadInbox',
			type:'POST',
			dataType:'json',
			cache:false,
			data:{},
			success:function(data){
				me.loading = true;
				me.Inbox.Append(data);
//				setTimeout('me.Inbox.Load()', 30000);
			}
		});
	},
	Append:function(data){
		var html = '';
		html += '<li>';
		html += '    <a href="#">';
		html += '        <img src="../img/?pic={filepic}&w=50" class="message-avatar" alt="{name}">';
		html += '        <div class="message">';
		html += '            <span class="message-sender">';
		html += '                {name}';
		html += '            </span>';
		html += '            <span class="message-time">';
		html += '                {date_create}';
		html += '            </span>';
		html += '            <span class="message-subject">';
		html += '                {title}';
		html += '            </span>';
		html += '            <span class="message-body">';
		html += '                {detail}';
		html += '            </span>';
		html += '        </div>';
		html += '    </a>';
		html += '</li>';

		var temp = '';
		$('#zone_inbox').text('');
		$.each(data.row, function(i, attr){
			temp = html;
			temp = temp.split('{filepic}').join(attr.filepic);
			temp = temp.split('{name}').join(attr.name);
			temp = temp.split('{date_create}').join(ft.DateTimeDisplay(attr.date_create));
			temp = temp.split('{title}').join(attr.surname);
			temp = temp.split('{detail}').join(attr.email);
			$('#zone_inbox').append(temp);
		});	
		
		$('#inbox_no').text(data.cnt);
	}
};

me.Tasks={
	Load:function(){
		me.loading = false;
		$.ajax({
			url:'app.ajax.php?mode=LoadTasks',
			type:'POST',
			dataType:'json',
			cache:false,
			data:{},
			success:function(data){
				me.loading = true;
				me.Tasks.Append(data);
//				setTimeout('me.Tasks.Load()', 30000);
			}
		});
	},
	Append:function(data){
		var html = '';
		html += '<li>';
		html += '  <a href="#">';
		html += '    <div class="clearfix">';
		html += '      <span class="pull-left">{name}</span>';
		html += '      <span class="pull-right">{pertask}%</span>';
		html += '    </div>';
		html += '';
		html += '    <div class="progress progress-xs">';
		html += '      <div style="width:{pertask}%" class="progress-bar"></div>';
		html += '    </div>';
		html += '  </a>';
		html += '</li>';

		var temp = '';
		$('#zone_tasks').text('');
		$.each(data.row, function(i, attr){
			temp = html;
			temp = temp.split('{name}').join(attr.name);
			temp = temp.split('{pertask}').join(attr.pertask);
			$('#zone_tasks').append(temp);
		});	
		
		$('#tasks_no').text(data.cnt);
		$('#tasks_no2').text(data.cnt);
	}
};



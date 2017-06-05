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
  		{name:'filepic', display:'รูป', width:'100', align:'center',search:false, sort:false},
  		{display:'หัวข้อ', name:'topic', view:true}
  		]);
  };

  me.ViewOpenHeader=function(){
  	me.ViewOpenSetHeader([
  		{display:'หัวข้อ', name:'topic'},
  		{display:'รหัส', name:'code'},
  		{display:'วันที่สร้าง', name:'date_create', type:'date'},
  		{display:'วันที่แก้ไข', name:'date_update', type:'datetime'}
  		]);
  };


  me.ClearData=function(){
  	$('#lyAddEdit input').val('');
  	$('#lyAddEdit select').val('');
  	$('#lyAddEdit textarea').val('');
  	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);

  	$('#enable').prop('checked', true);
  	me.UploadPic.Clear();
  };


  me.UploadPic={
  	Submit:function(){
  		if($('#fileupload').val()=='')return false;

  		$('#btnUpload').css('display', 'none');
  		$('#btnLoading').css('display', '');
  		$('#btnfiledel').css('display', 'none');

  		return true;

  	},
  	Complete:function(pic){
  		$('#filepic').val(pic);

  		me.UploadPic.Apply(pic);
  		me.MsgSuccess('Upload complete!!');

  		return true;

  	},
  	Clear:function(){
  		$('#fileupload').val('');
  		$('#filepic').val('');
  		$('#lnkUpload').attr('href', me.site+'/img/nopic.jpg');
  		$('#lnkUpload img').attr('src', me.site+'/img/nopic.jpg');
  		$('#btnfiledel').css('display', 'none');
  	},
  	Apply:function(pic){
  		$('#lnkUpload').attr('href', me.site+'/img/'+pic);
  		$('#lnkUpload img').attr('src', me.site+'/img/'+pic);
  		$('#lnkUpload').attr('title', pic);
  		$('#btnUpload').css('display', '');
  		$('#btnLoading').css('display', 'none');
  		$('#btnfiledel').css('display', '');    
  	}
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


  			me.UploadPic.Apply(data.field.filepic);
  			me.SetPointer(data.pointer);
  			me.SetLoadEdit(data.field);
  			me.SetFocus();
  		}
  	});
  };


/*================================================*\
  :: DEFAULT ::
  \*================================================*/
  $(document).ready(function(){
  	me.SetUrl();
  	me.ViewHeader();
  	me.ViewOpenHeader();
  	me.View();
  	me.TextEditor();
  });
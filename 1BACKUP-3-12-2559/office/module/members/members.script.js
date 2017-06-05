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
      {display:'ชื่อ', name:'firstname'},
      {display:'นามสกุล', name:'lastname'},
      {display:'อีเมลล์', name:'email'},
      {display:'เบอร์โทร', name:'tel'},
      {display:'Username', name:'username',style:"success",align:'center'},
      {display:'Last IP', name:'lastIP',style:"info", align:'center'},
      {display:'Last Login', name:'lastLogin',style:"danger", align:'center'}
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

  me.LoadCbo=function(){
    $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
      $.each(data.zone, function(i, result) {
        $('<option>').attr('value', result.code).text(result.name).appendTo('#zone_code');
      });
    });
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
  	me.View();
  	me.TextEditor();
  });
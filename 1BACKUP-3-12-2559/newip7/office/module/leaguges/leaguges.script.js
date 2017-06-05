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
      {display:'ชื่อ [TH]', name:'name_th', view:true},
      {display:'ชื่อ [EN]', name:'name_en'},
      {display:'ลำดับ', name:'sort',align:'center'}
      ]);
  };

  me.ViewOpenHeader=function(){
    me.ViewOpenSetHeader([
      {display:'ชื่อ [TH]', name:'name_th'},
      {display:'ชื่อ [EN]', name:'name_en'},
      {display:'ลำดับ', name:'sort'},
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
  };




  me.Add=function(){
    if(!me.CheckForm()){
      $('#lyAddEdit input').first().focus();
      setTimeout('me.ClearError();', 5000);
      return;
    }

    var myData = {
      data : ft.LoadForm('mydata'),
      detail : []
    };


    $('.detaildata').each(function(i){
      myData.detail[i] = {
        teamname_th : $(this).find('.teamname_thdata').find('.teamname_th').val(),
        teamname_en : $(this).find('.teamname_endata').find('.teamname_en').val()
      };
    });

$.ajax({
  url:me.url+'?mode=Add&mod='+me.mod,
  type:'POST',
  dataType:'json',
  cache: false,
  data:myData,
  success:function(data){
    switch(data.success){
      case 'COMPLETE' :
      $('#popup-add').modal('hide');
      me.MsgSuccess(me.alert.SAVECOMPLETE);
      me.Clear();
      break;
      default :
      alert(me.alert.SAVEERROR);
      break;
    }
  }
});

};

me.Edit=function(){

  if(!me.CheckForm()){
    $('#lyAddEdit input').first().focus();
    setTimeout('me.ClearError();', 5000);
    return;
  }

  var myData = {
    code : me.code,
    data : ft.LoadForm('mydata'),
    detail : []
  };

  $('.detaildata').each(function(i){
    myData.detail[i] = {
      teamname_th : $(this).find('.teamname_thdata').find('.teamname_th').val(),
      teamname_en : $(this).find('.teamname_endata').find('.teamname_en').val()
    };
  });

// ft.Debug(myData);
// return;


$.ajax({
  url:me.url+'?mode=Edit&mod='+me.mod,
  type:'POST',
  dataType:'json',
  cache:false,
  data:myData,
  success:function(data){
    switch(data.success){
      case 'COMPLETE' :
      $('#popup-edit').modal('hide');
      me.LoadEdit(me.code);
      me.MsgSuccess(me.alert.SAVECOMPLETE);
      break;
      default :
      me.MsgError(me.alert.SAVEERROR);
      break;
    }
  }
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
      
      $('#lyDetail').text('');
      $(data.product).each(function(i, attr){
        me.LoadAppendProduct(attr);
      });
      

me.SetPointer(data.pointer);
me.SetLoadEdit(data.field);
me.SetFocus();
}
});
};



me.AddProduct=function(){
  me.AppendProduct({
    time : new Date().getTime(),
    teamname_th : '',
    teamname_en :''
  });
};

me.AppendProduct=function(data){
  var html = '';
  html += '<tr id="detail_{time}" class="detaildata" rel="{code}">';
  html += '  <td class="text-center" class="descno">{no}</td>';
  html += '  <td class="teamname_thdata text-center"><input type="text" class="form-control input-sm teamname_th" placeholder="ชื่อทีม TH" value="{teamname_th}"></td>';
  html += '  <td class="teamname_endata text-center"><input type="text" class="form-control input-sm teamname_en" placeholder="ชื่อทีม EN" value="{teamname_en}"></td>';
  html += '  <td class="text-center">';
  html += '   <button onclick="me.DelProduct({time})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Del</button>';
  html += '  </td>';
  html += '</tr>';
  
  var time = new Date().getTime();

  html = html.split('{code}').join(data.code);
  html = html.split('{time}').join(time);
  html = html.split('{no}').join($('.detaildata').length+1);
  html = html.split('{teamname_th}').join(data.teamname_th);
  html = html.split('{teamname_en}').join(data.teamname_en);
  $('#lyDetail').append(html);
};

me.LoadAppendProduct=function(data){
  var html = '';
  html += '<tr id="detail_{time}" class="detaildata" rel="{code}">';
  html += '  <td class="text-center" class="descno">{no}</td>';
  html += '  <td class="teamname_thdata text-center"><input type="text" class="form-control input-sm teamname_th" placeholder="ชื่อทีม TH" value="{teamname_th}"></td>';
  html += '  <td class="teamname_endata text-center"><input type="text" class="form-control input-sm teamname_en" placeholder="ชื่อทีม EN" value="{teamname_en}"></td>';
  html += '  <td class="text-center">';
  html += '   <button onclick="me.DelProduct({code})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Del</button>';
  html += '  </td>';
  html += '</tr>';
  
  var time = new Date().getTime();

  html = html.split('{code}').join(data.code);
  html = html.split('{time}').join(time);
  html = html.split('{no}').join($('.detaildata').length+1);
  html = html.split('{teamname_th}').join(data.teamname_th);
  html = html.split('{teamname_en}').join(data.teamname_en);
  $('#lyDetail').append(html);
};

me.DelProduct=function(code){
  $('#detail_'+code).remove();
};


/*================================================*\
  :: DEFAULT ::
  \*================================================*/
  $(document).ready(function(){
  	me.SetUrl();
  	me.ViewHeader();
  	me.ViewOpenHeader();
    me.SetSort('sort', 'asc');
    me.View();

  });
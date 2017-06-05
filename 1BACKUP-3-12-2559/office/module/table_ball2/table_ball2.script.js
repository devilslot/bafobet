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
      {display:'วันที่', name:'dates',width:'100',cls:'dpk', align:"center"},
      {display:'ลีก', name:'ref', align:"center",width:'180',search:false},
      {display:'ทีมเจ้าบ้าน', name:'team1', align:"center",width:'120'},
      {display:'ทีมเยือน', name:'team2', align:"center",width:'120'},
      {display:'ทีมต่อ', name:'ratio', align:"center",width:'120',search:false},
      {display:'ราคา', name:'hdc', align:"center",search:false},
      {display:'ทรรศนะ', name:'tded', align:"center",search:false},
      {display:'ช่องถ่ายทอด', name:'channel', align:"center",search:false},
      {display:'Hot', name:'hot', align:"center",width:'80',search:false}
      ]);
  };



  me.ClearData=function(){
  	$('#lyAddEdit input').val('');
  	$('#lyAddEdit select').val('');
  	$('#lyAddEdit textarea').val('');
  	$('#lyAddEdit input[type="checkbox"]').prop('checked', false);

  	$('#enable').prop('checked', true);
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
        html += ' <button ';
        html += '   type="button"';
        html += '   id="btncallap_plus_'+field.code+'" ';
        html += '   onclick="me.CollapseTable(\'plus\', \''+field.code+'\');" ';
        html += '   class="btn btn-xs shiny success icon-only btncallap_plus">';
        html += '   <i class="fa fa-plus-square"></i></button>';
        html += '';
        html += ' <button ';
        html += '   type="button"';
        html += '   id="btncallap_minus_'+field.code+'" ';
        html += '   class="btn btn-xs shiny warning icon-only btncallap_minus" ';
        html += '   onclick="me.CollapseTable(\'minus\', \''+field.code+'\');"';
        html += '   style="display:none">';
        html += '   <i class="fa fa-minus-square"></i></button>';
        html += '</td>';  
        break;
      case 3 : 
        html += '<th class="text-align-center" width="40">';  
        html += ' <label><input id="trchk_'+field.code+'" type="checkbox" class="colored-success trchk" /><span class="text"></span></label>';  
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
      html += '<td class="text-center"><a href="javascript:;" onclick="me.SaveHdc('+field.code+')" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</a></td>';
    }
    html += '</tr>';
    if(me.viewstyle.style==2){
      field.collap = (field.collap===undefined)?'&nbsp;':field.collap;
      html += '<tr id="trcollap_'+field.code+'" class="trcollap" style="display:none;">';
      html += ' <td colspan="'+colspan+'">'+field.collap+'</td>';
      html += '</tr>';
    }
    $('#tbView').append(html);
  });
};


me.SaveHdc=function(code){
  

  var myData = {
    code : code,
    hdc : $('#hdc'+code).val(), 
    tded : $('#tded'+code).val(),
    channel : $('#channel'+code).val(),
    ratio :  $('#ratio'+code).val(),
    hot :  $('#hot'+code).val()
  };

  $.ajax({
    url:me.url+'?mode=SaveHdc&mod='+me.mod,
    type:'POST',
    dataType:'json',
    cache:false,
    data:myData,
    success:function(data){
      switch(data.success){
        case 'COMPLETE' :
          me.MsgSuccess(data.msg, 1.5);
          me.View();
        break;
        default :
          me.MsgDanger(data.msg, 3);
        break;
      }
    }
  });

};

  me.LoadCbo=function(){
  $.getJSON(me.url+'?mode=LoadCbo&mod='+me.mod+'&'+new Date().getTime(), {}, function(data){
    $.each(data.leaguge, function(i, result) {
      $('<option>').attr('value', result.code).text(result.name).appendTo('#search_ref');
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
  	me.SetDate();
//me.LoadCbo();
  });
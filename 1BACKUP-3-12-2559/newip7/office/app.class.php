<?php
/*=========================================
*  Author : Attaphon Wongbuatong
*  Created Date : 08/08/2011 14:42
*  Module : Class
*  Description : -
*  Involve People : -
*  Last Updated : 08/08/2011 14:42
=========================================*/
function EnableDisplay($input){
  if($input=='Y'){
    $result = '<i class="fa fa-eye" style="color:green;" title="Enable"></i>';
  }else{
    $result = '<i class="fa fa-eye-slash" style="color:#999999;" title="Disable"></i>';
  }
  
  return $result;
}

class AppClass extends SuperClass{
  public $lang = 'th';
  public $permission = array();
  public $alert = array();
  public $define = array();
  public $content = array();

  public function __construct($table=''){
    $this->table = $table;
  } 

  public function View(){
    $table = $this->table;
    $column = $this->attr['column'];
    $page = $this->attr['page'];
    $limit = $this->attr['limit'];
    $start = (($page - 1) * $limit);
    $search = (array)$this->attr['search'];
    $searchkey = $this->attr['searchkey'];
    $sortby = $this->attr['sortby'];
    $sortorder = $this->attr['sortorder'];

    foreach($search as $i => $value){
      $searchby = $value['searchby'];
      $searchkey = $value['searchkey'];
      if(!empty($searchby) && ($searchkey!='')){
        switch($value['searchoption']){
          case 'LIKE' : $where .= "tb.$searchby LIKE '%$searchkey%' AND "; break;
          case '=' : $where .= "tb.$searchby = '$searchkey' AND "; break;
          case '>' : $where .= "tb.$searchby > '$searchkey' AND "; break;
          case '<' : $where .= "tb.$searchby < '$searchkey' AND "; break;
          case '<>' : $where .= "tb.$searchby <> '$searchkey' AND "; break;
        }
      }
    }

    $sql="SELECT COUNT(*) AS cnt FROM $table tb WHERE $where tb.code <> 0";
    $query = mysql_query($sql);
    $count = 0;
    if($row=mysql_fetch_object($query)){
      $count = $row->cnt;
    }    
    $allpage = ceil($count / $limit);

    $pp = $page - 1;
    if($pp < 1){
      $pp = 1;
    }
    $np = $page + 1;
    if($np > $allpage){
      $np = $allpage;
    }

    if($page==$allpage){
      $beginpage=$allpage-4;
      $endpage = $allpage;
      if($beginpage < 1){
        $beginpage = 1;
      }
    }elseif($page==$allpage-1){
      $beginpage=$allpage-4;
      $endpage = $allpage;
      if($beginpage < 1){
        $beginpage = 1;
      }
    }else{
      $beginpage = $page - 2;
      if($beginpage < 1){
        $beginpage = 1;
      }
      $endpage = $beginpage + 4;
      if($endpage > $allpage){
        $endpage = $allpage;
      }
    }

    $runpage = array();
    for($i=$beginpage; $i<=$endpage; $i++){
      $runpage[] = $i;
    }
    
    $sql="
      SELECT 
        tb.* 
      FROM 
        $table tb
      WHERE 
        $where 
        tb.code <> 0
      ORDER BY 
        tb.$sortby $sortorder
      LIMIT 
        $start, $limit
    ;";
//    PrintR($sql);
    
    $query = mysql_query($sql);
    $tmp=array();
    while($row=mysql_fetch_assoc($query)){
      $tmp[] = $row;
    }   

    $result = array(
      'record' => NumberDisplay($count, 0),
      'row' => array(),
      'page' => array(
        'page' => $page,
        'fp' => 1,
        'pp' => $pp,
        'np' => $np,
        'ep' => $allpage,
        'runpage' => $runpage
      )
    );  
    
    $btn = $this->ViewButton($this->table, $this->permission, array(
      'EDIT' => $this->define['OPEN'],
      'DEL' => $this->define['DEL']
     ));
    
    foreach((array)$tmp as $i => $value){   
//      $result['row'][$i]['_id']=sprintf("%05d", $value['code']);
//      $result['row'][$i]['item'][]=$value[''];
      
      $result['row'][$i]['code']=$value['code'];
      $result['row'][$i]['no'] = ++$start;
      $result['row'][$i]['enable'] = EnableDisplay($value['enable']);
      $result['row'][$i]['btn'] = str_replace("{code}", $value['code'], $btn);
      
      foreach((array)$column as $j => $item){
        $result['row'][$i]['item'][]=$value[$item];
      }  
      
    }  

    return $result;
  }

  public function ViewSub(){
    $table = $this->table;
    $column = $this->attr['column'];
    $sortby = $this->attr['sortby'];
    $sortorder = $this->attr['sortorder'];
    $parent_field = $this->attr['parent_field'];
    $parent = $this->attr['parent'];
    
    $where = "$parent_field = '$parent' AND ";
    
    $sql="
      SELECT 
        tb.* 
      FROM 
        $table tb
      WHERE 
        $where 
        tb.code <> 0
      ORDER BY 
        tb.$sortby $sortorder
    ;";
//    PrintR($sql);
    
    $query = mysql_query($sql);
    $tmp=array();
    while($row=mysql_fetch_assoc($query)){
      $tmp[] = $row;
    }   

    $result = array(
      'row' => array()
    );  
    
    $btn = $this->ViewButtonSub($this->table, $this->permission, array(
      'EDIT' => $this->define['OPEN'],
      'DEL' => $this->define['DEL']
     ));
    
    foreach((array)$tmp as $i => $value){   
//      $result['row'][$i]['_id']=sprintf("%05d", $value['code']);
//      $result['row'][$i]['item'][]=$value[''];
      
      $result['row'][$i]['code']=$value['code'];
      $result['row'][$i]['no'] = ++$start;
      $result['row'][$i]['btn'] = str_replace("{code}", $value['code'], $btn);
      
      foreach((array)$column as $j => $item){
        $result['row'][$i]['item'][]=$value[$item];
      }  
      
    }  

    return $result;
  }

  public function ViewButton($mod, $permission, $input){
    $btn = array();

    if(array_key_exists("EDIT", $input) && $permission['EDIT'][$mod]){
      $btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.LoadEdit({code});'><i class='fa fa-edit success'></i> ".$input['EDIT']."</a></li>";
    }
    if(array_key_exists("DEL", $input) && $permission['DEL'][$mod]){
      $btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.DelView({code});'><i class='fa fa-trash-o danger'></i> ".$input['DEL']."</a></li>";
    }
    if(array_key_exists("PRINT", $input) && $permission['PRINT'][$mod]){
      $btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.Print({code});'><i class='fa fa-print info'></i> ".$input['PRINT']."</a></li>";
    }

    if(empty($btn)){
      $result = "";
    }else{
      $result  = "<div class='btn-group btn-group-xs'>";
      $result .= "    <button class='btn shiny dropdown-toggle' type='button' data-toggle='dropdown'><span class='fa fa-cog success'></span>&nbsp;<span class='fa fa-caret-down'></span></button>";
      $result .= "    <ul class='dropdown-menu dropdown-menu-right'>";
      $result .= implode(" ", $btn);
      $result .= "    </ul>";
      $result .= "</div>";
    }

    return $result;
  }

  public function ViewButtonSub($mod, $permission, $input){
    $btn = array();
    if(array_key_exists("EDIT", $input) && $permission['EDIT'][$mod]){
      $btn[] = "<button type='button' rel='{code}' class='btn btn-xs shiny success icon-only btn-viewopen' title='".$input['EDIT']."'><i class='fa fa-edit'></i></button>";
    }
    if(array_key_exists("DEL", $input) && $permission['DEL'][$mod]){
      $btn[] = "<button type='button' rel='{code}' class='btn btn-xs shiny danger icon-only btn-viewdel' title='".$input['DEL']."'><i class='fa fa-trash-o'></i></button>";
    }
    if(array_key_exists("PRINT", $input) && $permission['PRINT'][$mod]){
      $btn[] = "<button type='button' rel='{code}' class='btn btn-xs shiny info icon-only btn-viewprint' title='".$input['PRINT']."'><i class='fa fa-print'></i></button>";
    }

    if(empty($btn)){
      $result = "";
    }else{
      $result = implode(" ", $btn);
    }

    return $result;
  }

  public function LoadEdit(){
    $sql="
      SELECT
        *
      FROM
        ".$this->table."
      WHERE
        code = '".$this->attr["code"]."'
    ";
//    echo $sql;
    $result['row'] = array();
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_object($query)){
      $data=$row;
    }
    mysql_free_result($query);

    foreach ((object)$data as $key => $value) {
      $result['row'][]=array(
        'name' => $key,
        'value' => $value
      );
    }
    
    $result['field'] = (array)$data;
    
    $result['pointer']['firstcode'] = $this->LoadFirstCode();
    $result['pointer']['lastcode'] = $this->LoadLastCode();
    $result['pointer']['prevcode'] = $this->LoadPrevCode();
    $result['pointer']['nextcode'] = $this->LoadNextCode();
    
    return $result;
  }

  public function OpenView(){
    $sql="
      SELECT
        *
      FROM
        ".$this->table."
      WHERE
        code = '".$this->attr["code"]."'
    ";
//    echo $sql;
    $result['row'] = array();
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_object($query)){
      $data=$row;
    }
    mysql_free_result($query);

    foreach ((object)$data as $key => $value) {
      $result['row'][]=array(
        'name' => $key,
        'value' => $value
      );
    }
    
    $result['field'] = (array)$data;
    
    return $result;
  }
  
  public function LoadLanguageDefine(){
    $lang = $this->lang;
    
    $sql="
      SELECT
        id, name_$lang AS name
      FROM
        languages
      WHERE
        groups = 'DEFINE' AND
        code <> 0
      ORDER BY
        id
    ";
//    echo $sql;
    $result = array();
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_assoc($query)){
      $this->define[$row['id']]=$row['name'];
    }
    mysql_free_result($query);
  }
  
  public function LoadLanguageAlert(){
    $lang = $this->lang;
    
    $sql="
      SELECT
        id, name_$lang AS name
      FROM
        languages
      WHERE
        groups = 'ALERT' AND
        code <> 0
      ORDER BY
        id
    ";
//    echo $sql;
    $result = array();
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_assoc($query)){
      $this->alert[$row['id']]=$row['name'];
    }
    mysql_free_result($query);
  }
  
  public function LoadLanguageContent(){
    $lang = $this->lang;
    
    $sql="
      SELECT
        id, name_$lang AS name
      FROM
        languages
      WHERE
        groups = 'CONTENT' AND
        code <> 0
      ORDER BY
        id
    ";
//    echo $sql;
    $result = array();
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_assoc($query)){
      $this->content[$row['id']]=$row['name'];
    }
    mysql_free_result($query);
  }
  
  public function LoadLanguage($lang){
    $sql="
      SELECT
        id, groups, name_$lang AS name
      FROM
        languages
      WHERE
        code <> 0
      ORDER BY
        groups, id
    ";
//    echo $sql;
    $result = array();
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_assoc($query)){
      $result[$row['groups']][$row['id']]=$row['name'];
    }
    mysql_free_result($query);
    
    return $result;
  }

  public function ExportExcel(){
    $table = $this->table;
    $page=1;
    $limit=10;
    foreach((array)$this->attr as $i => $item){
      switch($i){
        case 'file' : break;
        case 'mod' : $table = $item; break;
        case 'limit' : $limit = $item; break;
        case 'page' : $page = $item; break;
        default : $where .= "tb.$i LIKE '%$item%' AND "; break;
      }
    }
    $page = (empty($page))?1:$page;
    $start = (($page - 1) * $limit);
    
    $sql="
      SELECT 
        tb.* 
      FROM 
        $table tb
      WHERE 
        $where 
        tb.code <> 0
      ORDER BY 
        tb.code ASC
      #LIMIT $start, $limit
    ;";
//    PrintR($sql);
    
    $query = mysql_query($sql);
    $result=array();
    while($row=mysql_fetch_assoc($query)){
      $result[] = $row;
    }   

    return $result;
  }

  public function LoadField($table){
    $sql="
      SELECT 
        df.* 
      FROM 
        datadics dd, datafields df
      WHERE  
        dd.code = df.dic_code AND
        dd.id = '$table'
    ;";
//    PrintR($sql);
    
    $query = mysql_query($sql);
    $tmp=array();
    while($row=mysql_fetch_assoc($query)){
      if($row['enable'] == 'Y'){
        if(empty($row['name'])){
          $name = $row['id'];
        }else{
          $name = $row['name'];
        }
        $result[$row['id']] = $name;
      }
    }   

    return $result;
  }

  public function LoadConfig(){
    $sql="
      SELECT 
        *
      FROM 
        configs
      WHERE
        code = 1
    ;";
//    PrintR($sql);
    
    $query = mysql_query($sql);
    $result=array();
    if($row=mysql_fetch_assoc($query)){
      $result = $row;
    }   

    return $result;
  }

  public function LoadMyMenu($encode){
    $sql="
      SELECT
        *, shortname_{$this->lang} AS name
      FROM
        menus
      WHERE
        encode = '$encode'
    ";
//    echo PrintR($sql);
    $result = array();
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_assoc($query)){
      $result=$row;
    }
    mysql_free_result($query);
    
    return $result;
  }

  public function LoadMySubMenu($encode){
    $sql="
      SELECT
        *, shortname_{$this->lang} AS name
      FROM
        menus_sub
      WHERE
        encode = '$encode'
    ";
//    echo $sql;
    $result = array();
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_assoc($query)){
      $result=$row;
    }
    mysql_free_result($query);
    
    return $result;
  }

  public function LoadMyParentMenu($code){
    $sql="
      SELECT
        *
      FROM
        menus
      WHERE
        sort < (SELECT sort FROM menus WHERE code = '$code') AND
        main_menu = 'Y' AND
        enable = 'Y' AND
        code <> 0
      ORDER BY
        sort DESC
      LIMIT 
        0, 1
    ";
//    echo $sql;
    $result = array();
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_assoc($query)){
      $result=$row;
    }
    mysql_free_result($query);
    
    return $result;
  }
  
  public function LoadFirstCode(){
    $sql="
      SELECT
        code
      FROM
        ".$this->table."
      WHERE
        code <> 0
      ORDER BY
        code
      LIMIT
        0, 1
    ";
//    echo $sql;
    $result = 0;
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_object($query)){
      $result = $row->code;
    }
    mysql_free_result($query);
    return $result;    
  }
  
  public function LoadLastCode(){
    $sql="
      SELECT
        code
      FROM
        ".$this->table."
      ORDER BY
        code DESC
      LIMIT
        0, 1
    ";
//    echo $sql;
    $result = 0;
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_object($query)){
      $result = $row->code;
    }
    mysql_free_result($query);
    return $result;    
  }
  
  public function LoadPrevCode(){
    $sql="
      SELECT
        code
      FROM
        ".$this->table."
      WHERE
        code < '".$this->attr["code"]."' and
        code <> 0
      ORDER BY
        code DESC
      LIMIT
        0, 1
    ";
//    echo $sql;
    $result = $this->attr["code"];
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_object($query)){
      $result = $row->code;
    }
    mysql_free_result($query);
    return $result;    
  }
  
  public function LoadNextCode(){
    $sql="
      SELECT
        code
      FROM
        ".$this->table."
      WHERE
        code > '".$this->attr["code"]."'
      ORDER BY
        code
      LIMIT
        0, 1
    ";
//    echo $sql;
    $result = $this->attr["code"];
    $query=mysql_query($sql) or die(mysql_error());
    if($row=mysql_fetch_object($query)){
      $result = $row->code;
    }
    mysql_free_result($query);
    return $result;    
  }
  
  public function CheckTable(){
    $sql="
      check table {$this->table}
    ;";
//    echo $sql;
    $result = false;
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_object($query)){
      if($row->Msg_text == 'OK'){
        $result = true;
      }
    }
    mysql_free_result($query);
    return $result; 
  }
  
  public function CreateTable($table='', $data=array()){
    if(!empty($data)){
      $attribute_arr = array();
      
      unset($data['code']);
      unset($data['user_create']);
      unset($data['user_update']);
      unset($data['date_create']);
      unset($data['date_update']);
      
      foreach($data as $fields => $value){
        $value = mysql_real_escape_string($value);
        $attribute_arr[] = "`$fields` varchar(100) NOT NULL DEFAULT '',";
      }
      $attribute = implode("\n", $attribute_arr);
      
      $sql="
        CREATE TABLE `$table` (
          `code` int(11) NOT NULL AUTO_INCREMENT,
          $attribute
          `user_create` varchar(100) NOT NULL,
          `user_update` varchar(100) NOT NULL,
          `date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `date_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`code`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8
      ;";
//      echo $this->sql = $sql;

      $query=mysql_query($sql) or die(mysql_error());
      if($query){
        $result['success'] = 'COMPLETE';
      }else{
        $result['success'] = 'FAIL';
        $this->error[] = 'QUERY ERROR';
      }
    }else{
      $result['success'] = 'FAIL';
      $this->error[] = 'NOT FOUND DATA';
    }
    
    return $result;
  }  
  
  public function PushFile($text, $id, $class='', $guide=''){
    echo '
      <div id="dv'.$id.'" class="form-group">
        <label id="lbl'.$id.'" for="'.$id.'" class="control-label no-padding-right col-md-6 col-sm-12">'.$text.' :</label>
        <div class="col-md-6 col-sm-12">
          <input class="form-control '.$class.'" id="'.$id.'" name="'.$id.'" type="file" placeholder="" />
          <span id="e'.$id.'" class="help-block err" style="display:none;">Please insert '.$id.'</span>
        </div>
      </div>  
    ';
  }

  public function PushText($text, $id, $class, $maxlength=100, $guide='', $mask=''){
    if(!empty($mask)){
      $datamask = "data-mask='$mask'";
    }
    if(Find('dpk', $class)){
      $input = "
        <div class='input-group'>
          <input class='form-control $class' id='$id' name='$id' type='text' placeholder='$guide' readonly='readonly' $datamask />
          <span class='input-group-btn'> 
            <button id='d$id' class='btn btn-default' type='button' style='padding:5px;'><i class='fa fa-calendar'></i></button> 
          </span>
          <span id='e$id' class='help-block err' style='display:none;'>Please select $text</span>
        </div>
      ";
    }elseif(Find('dtpk', $class)){
      $input = "
        <div class='input-group'>
          <input class='form-control $class' id='$id' name='$id' type='text' placeholder='$guide' readonly='readonly' $datamask />
          <span class='input-group-btn'> 
            <button id='d$id' class='btn btn-default' type='button' style='padding:5px;'><i class='fa fa-calendar-o'></i></button> 
          </span>
          <span id='e$id' class='help-block err' style='display:none;'>Please select $text</span>
        </div>
      ";
    }elseif(Find('tpk', $class)){
      $input = "
        <div class='input-group'>
          <input class='form-control $class' id='$id' name='$id' type='text' placeholder='$guide' readonly='readonly' $datamask />
          <span class='input-group-btn'> 
            <button id='d$id' class='btn btn-default' type='button' style='padding:5px;'><i class='fa fa-clock-o'></i></button> 
          </span>
          <span id='e$id' class='help-block err' style='display:none;'>Please select $text</span>
        </div>
      ";
    }else{
      $input = "
        <input class='form-control input-sm $class' id='$id' name='$id' type='text' placeholder='$guide' maxlength='$maxlength' $datamask />
          <span id='e$id' class='help-block err' style='display:none;'>Please insert $text</span>
      ";
    }

    echo " 
      <div id='dv$id' class='form-group'>
        <label id='lbl$id' for='$id' class='col-sm-4 control-label no-padding-right' style='white-space:nowrap'>$text :</label>
        <div class='col-sm-8'>
          $input
        </div>
      </div>  
    ";
  }

  public function PushTextSelect($text, $id, $class, $maxlength=100, $icon='fa-search', $select='Select', $guide=''){
    echo " 
      <div id='dv$id' class='form-group'>
        <label id='lbl$id' for='$id' class='col-sm-4 control-label' style='white-space:nowrap'>$text :</label>
        <div class='col-sm-8'>
          <div class='input-group'>
            <input class='form-control $class' id='$id' name='$id' type='text' placeholder='$guide' maxlength='$maxlength' />
            <span class='input-group-btn'> 
              <button id='btn$id' class='btn btn-info' type='button' style='padding:5px;'><i class='fa $icon'></i> $select</button> 
            </span>
          </div>
          <span id='e$id' class='help-block err' style='display:none;'>Please select $text</span>
        </div>
      </div>  
    ";
  }

  public function PushSelect($text, $id, $class, $value=array(), $guide='', $style=1){
    foreach((array)$value as $key => $txt){
      $option.="<option value='$key'>$txt</option>";
    }

    if($style==2){
      echo "
        <div id='dv$id' class='form-group'>
          <label id='lbl$id' for='$id' class='col-sm-12 control-label no-padding-right' style='white-space:nowrap'>$text :</label>
          <div class='col-sm-12'>
            <select id='$id' name='$id' class='form-control input-sm $class'>
              <option value=''>$guide</option>
              $option
            </select>
            <span id='e$id' class='help-block err' style='display:none;'>Please select $text</span>
          </div>
        </div>
      ";
    }else{
      echo "
        <div id='dv$id' class='form-group'>
          <label id='lbl$id' for='$id' class='col-sm-4 control-label no-padding-right' style='white-space:nowrap'>$text :</label>
          <div class='col-sm-8'>
            <select id='$id' name='$id' class='form-control input-sm $class'>
              <option value=''>$guide</option>
              $option
            </select>
            <span id='e$id' class='help-block err' style='display:none;'>Please select $text</span>
          </div>
        </div>
      ";
    }
  }

  public function PushHidden($id, $class, $value=''){
    echo "<input type='hidden' id='$id' name='$id' class='$class' value='$value' />";
  }

  public function PushCheckbox($text, $id, $class){
    echo " 
      <div id='dv$id' class='form-group'>
        <label id='lbl$id' for='$id' class='col-sm-4 control-label no-padding-right'></label>
        <div class='col-sm-8'>
          <label>
            <input type='checkbox' id='$id' name='$id' class='colored-blue $class'>
            <span class='text'>$text</span>
          </label>
        </div>
      </div> 
    ";  
  }

  public function PushCheckboxList($text, $id, $class, $item=array()){
    foreach((array)$item as $ids => $val){
      $checkbox.="
        <label class='checkbox-inline'><input type='checkbox' class='uniform $class' name='$id$ids' id='$id$ids' /> $val</label> 
      ";
    }
    echo " 
      <div id='dv$id' class='form-group'>
        <label id='lbl$id' class='col-sm-4 control-label'>$text :</label>
        <div class='col-sm-8'>
          $checkbox
        </div>
      </div>  
    ";  
  }

  public function PushRadio($text, $name, $class, $value=array()){
    $checked = "checked='checked'";
    foreach((array)$value as $id => $val){
      $radio.="
        <div class='radiobox'>
          <label>
            <input type='radio' name='$name' id='$name$id' class='$class colored-blueberry' rel='$id' $checked /> 
            <span class='text'> $val</span>
          </label>
        </div> 
      ";
      $checked='';
      $class='';
    }

    echo " 
      <div id='dv$name' class='form-group'>
        <label class='col-sm-4 control-label no-padding-right'>$text : </label>
        <div class='col-sm-8'>
          $radio
        </div>
      </div>  
    ";   
  }

  public function PushTextArea($text, $id, $class, $rows=3, $style=1){
    if($style==2){
      echo "
        <div id='dv$id' class='form-group'>
          <label id='lbl$id' for='$id' class='col-sm-12'>$text :</label>
          <div class='col-sm-12'>
            <textarea class='form-control $class' rows='$rows' id='$id' name='$id'></textarea>
            <span id='e$id' class='help-block err' style='display:none;'>Please insert $text</span>
          </div>
        </div>  
      ";  
    }else{
      echo "
        <div id='dv$id' class='form-group'>
          <label id='lbl$id' for='$id' class='col-sm-4 control-label' style='white-space:nowrap'>$text :</label>
          <div class='col-sm-8'>
            <textarea class='form-control $class' rows='$rows' id='$id' name='$id'></textarea>
            <span id='e$id' class='help-block err' style='display:none;'>Please insert $text</span>
          </div>
        </div>  
      ";  
    }
  }

  public function PushTextEditor($text, $id, $class){
    echo "
      <div id='dv$id' class='form-group'>
        <label id='lbl$id' for='$id' class='col-sm-12'>$text :</label>
        <div class='col-sm-12'>
          <textarea class='$class' id='$id' name='$id'></textarea>
        </div>
      </div>  
    ";  
  }

  public function PushPassword($text, $id, $class, $maxlength, $guide=''){
  echo " 
    <div id='dv$id' class='form-group'>
      <label id='lbl$id' for='$id' class='col-sm-4 control-label'>$text :</label>
      <div class='col-sm-8'>
        <input class='form-control $class' id='$id' name='$id' type='password' placeholder='$guide' maxlength='$maxlength' />
        <span id='e$id' class='help-block err' style='display:none;'>Please insert $text</span>
      </div>
    </div>  
  ";  
}

  public function PushButton($text, $id, $class, $icon){
    foreach((array)$value as $key => $txt){
      $option.="<option value='$key'>$txt</option>";
    }

    echo "
      <div id='dv$id' class='form-group'>
        <label id='lbl$id' for='$id' class='col-sm-4 control-label'>&nbsp;</label>
        <div class='col-sm-8'>
          <button id='btn$id' class='btn $class'><i class='fa $icon'></i>$text</button>
        </div>
      </div>
    ";
  }
  
  public function PushApprove($text, $id, $class){
    echo " 
      <div id='dv$id' class='form-group'>
        <label id='lbl$id' class='col-sm-4 control-label no-padding-right'>
          <a href='#' target='_blank' id='applink_$id'>
          <i class='fa fa-external-link'></i> 
          $text</a> :</label>
        <div class='col-sm-8'>
          <button type='button' id='appbtn_$id' class='btn btn-default info btn-xs $class' rel='$id'><i class='fa fa-check'></i> อนุมัติ</button>
          <button type='button' id='rejbtn_$id' class='btn btn-default danger btn-xs $class' rel='$id'><i class='fa fa-times'></i> ไม่อนุมัติ</button>
          &nbsp; &nbsp; &nbsp; &nbsp; 
          <span id='appcheck_$id'></span> &nbsp; &nbsp; 
          <span id='appuser_$id'></span> &nbsp; &nbsp; 
          <span id='apptime_$id'></span> &nbsp; &nbsp; 
        </div>
      </div> 
    ";  
  }
  
  public function LoadAlert(){
    $sql="
      SELECT
        *
      FROM
        messages
      WHERE
        status = 1 AND
        code <> 0
      ORDER BY
        code DESC
      LIMIT
        0, 5
    ;";
//    echo "<pre>$sql</pre>";
    $query=mysql_query($sql);
    $result = array();
    while($row=mysql_fetch_assoc($query)){
      $row['member_name'] = Cut($row['member_name'], 20);
      $row['total'] = NumberDisplay($row['total']);
      $row['date_create'] = DateTimeDisplay($row['date_create'], 1);
      $result[] = $row;
    }
    mysql_free_result($query);
 
    return $result;
  }  
  
  public function LoadInbox(){
    $sql="
      SELECT
        *
      FROM
        employees
      WHERE
        code <> 0
      ORDER BY
        code DESC
      LIMIT
        0, 5
    ;";
//    echo "<pre>$sql</pre>";
    $query=mysql_query($sql);
    $result = array();
    while($row=mysql_fetch_assoc($query)){
      $result[] = $row;
    }
    mysql_free_result($query);
 
    return $result;
  }  
  
  public function LoadInboxCount(){
    $sql="
      SELECT
        COUNT(*) AS cnt
      FROM
        employees
      WHERE
        code <> 0
    ;";
//    echo "<pre>$sql</pre>";
    $query=mysql_query($sql);
    $result = 0;
    if($row=mysql_fetch_assoc($query)){
      $result = $row['cnt'];
    }
    mysql_free_result($query);
 
    return $result;
  }  
  
  public function LoadAlertCount(){
    $sql="
      SELECT
        COUNT(*) AS cnt
      FROM
        messages
      WHERE
        status = 1 AND
        code <> 0
    ;";
//    echo "<pre>$sql</pre>";
    $query=mysql_query($sql);
    $result = 0;
    if($row=mysql_fetch_assoc($query)){
      $result = $row['cnt'];
    }
    mysql_free_result($query);
 
    return $result;
  }  

  public function LoadCbo($table, $code, $name){
    $sql="
      SELECT
        $code AS code, 
        $name AS name
      FROM
        $table
      WHERE
        enable = 'Y' AND
        code <> 0
      ORDER BY
        $name
    ";
//    echo $sql;
    $result=array();
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_object($query)){
      $result[]=array(
        'code' => $row->code,
        'name' => $row->name
      );
    }
    mysql_free_result($query);

    return $result;
  }
  
  public function LoadCboSub($table, $code, $name, $sub){
    $sql="
      SELECT
        $code AS code, 
        $name AS name,
        $sub AS $sub
      FROM
        $table
      WHERE
        enable = 'Y' AND
        code <> 0
      ORDER BY
        $name
    ";
//    echo $sql;
    $result=array();
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_object($query)){
      $result[]=array(
        'code' => $row->code,
        'name' => $row->name,
        $sub => $row->$sub
      );
    }
    mysql_free_result($query);

    return $result;
  }
  
  public function LoadMatch($table,$order='code'){
    $sql="
      SELECT
        *
      FROM
        $table
      WHERE
        code <> 0
      ORDER BY
        $order
    ";
//    echo $sql;
    $result=array();
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_object($query)){
      $result[$row->code]=$row;
    }
    mysql_free_result($query);

    return $result;
  }
  
  public function LoadMainMenu(){
    $sql="
      SELECT
        *
      FROM
        menus
      WHERE
        main_menu = 'Y' AND
        enable = 'Y' AND
        code <> 0
      ORDER BY
        sort
    ";
//    echo $sql;
    $result=array();
    $query=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_assoc($query)){
      $result[]=$row;
    }
    mysql_free_result($query);

    return $result;
  }
  
  public function LoadSubMenu(){
    $sql="
      SELECT
        *
      FROM
        menus
      WHERE
        enable = 'Y' AND
        code <> 0
      ORDER BY
        sort
    ";
//    echo $sql;
    $result=array();
    $query=mysql_query($sql) or die(mysql_error());
    $main_menu = "-";
    while($row=mysql_fetch_assoc($query)){
      if($row['main_menu']=='Y'){
        $main_menu = $row['code'];
      }else{
        $result[$main_menu][]=$row;
      }
    }
    mysql_free_result($query);

    return $result;
  }
  
  public function AddMsg($msg, $emp, $mod, $code){
    $sql="
      INSERT INTO messages 
        (msg, emp_code, module, ref_code, status, user_create, user_update, date_create, date_update)
      VALUES (
        '$msg', 
        '$emp', 
        '$mod', 
        '$code', 
        '1', 
        'SYSTEM', 
        'SYSTEM', 
        NOW(), 
        NOW()
      )
    ";
//    echo $sql;
    $query=mysql_query($sql) or die(mysql_error().$sql);
  }
  
  public function Login($user_name){
  $sql="
    SELECT
      code, id, prefix_code, name, surname, nickname, 
      user_name, user_pass, filepic, superadmin, 
      CONCAT(name, ' ', surname) AS user,
      NOW() AS datenow
    FROM
      employees
    WHERE
      user_name = '$user_name' AND
      enable = 'Y'
  ";
//    echo $sql;

  $query = mysql_query($sql) or die(mysql_error());
  $result=array();
  if($row=mysql_fetch_assoc($query)){
    $result=$row;
  }

  mysql_free_result($query);
  return $result;
}

  public function LoadEmpPermission($code){
  $sql="
    SELECT
      *
    FROM
      emp_permission
    WHERE
      emp_code = '$code'
  ";
//    echo $sql;
  $result = array();
  $query=mysql_query($sql) or die(mysql_error());
  while($row=mysql_fetch_object($query)){
    $result[$row->task][$row->id]=true;
  }
  mysql_free_result($query);

  return $result;
}

  public function LoadEmpPermissionAdmin(){
  $result = array();

  $sql="
    SELECT
      *
    FROM
      menus
    WHERE
      code <> 0
    ORDER BY
      sort
  ";
//    echo $sql;
  $query=mysql_query($sql) or die(mysql_error());
  while($row=mysql_fetch_object($query)){
    $result['VIEW'][$row->id]=true;
    $result['ADD'][$row->id]=true;
    $result['EDIT'][$row->id]=true;
    $result['DEL'][$row->id]=true;
    $result['PRINT'][$row->id]=true;
  }
  mysql_free_result($query);

  $sql="
    SELECT
      id
    FROM
      permissions
    WHERE
      code <> 0
    ORDER BY
      id
  ";
//    echo $sql;
  $query=mysql_query($sql) or die(mysql_error());
  while($row=mysql_fetch_object($query)){
    $result['OPEN'][$row->id]=true;
  }
  mysql_free_result($query);

  return $result;
}

  public function Logs($mode, $menu, $record, $user, $item=array()){
  if(empty($item)){
    $log = array();
  }
  $log = serialize($item);
  $log = mysql_real_escape_string($log);
  $ip = get_client_ip();
//    echo $log;
//    print_r($item);

  $sql="
    INSERT INTO logs (mode, menu, record, item, ip, user_create, date_create)
    VALUES(
      '$mode', '$menu', '$record', '$log', '$ip', '$user', NOW()
    )
  ";
//    echo $sql;
  $query=mysql_query($sql) or die(mysql_error());
} 
}
?>
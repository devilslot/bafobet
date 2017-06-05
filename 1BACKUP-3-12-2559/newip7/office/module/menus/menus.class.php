<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 24/01/2015 09:09
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 24/01/2015 09:09
\*================================================*/
function MenuDisplay($type, $name, $icon){
  if($type=='Y'){
    $result = "<i class='fa $icon'></i> $name";
  }else{
    $result = " &nbsp; - $name";
  }
  
  return $result;
}

function LevelDisplay($level, $task){
  $arr = explode(",", $level);
  foreach((array)$arr as $i => $item){
    $result[] = $task[$item];
  }
  
  return implode(", ", (array)$result);
}

class SubClass extends AppClass{

  public function __construct($table='', $lang='th'){
    $this->table = $table;
    $this->lang = $lang;
	}

  public function View(){
    $table = $this->table;
    $column = $this->attr['column'];
    $page = $this->attr['page'];
    $limit = 500;
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
        tb.sort
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
      'EDIT' => $this->define['EDIT'],
      'DEL' => $this->define['DEL'],
      'ADD' => $this->define['ADD']
     ));
    
    $first_row = true;
    $task = $this->LoadTask();
    foreach((array)$tmp as $i => $value){   
      $code = $value['code'];
      
      if($first_row){
        $value['opt_up'] = "&nbsp;";
        $first_row = false;
      }else{
        $value['opt_up'] = "<button class='btn shiny icon-only btn-xs' onclick='me.MoveUp($code);'><i class='fa fa-level-up warning'></i></button>";
      }
      if($i == $count-1){
        $value['opt_down'] = "&nbsp;";
      }else{
        $value['opt_down'] = "<button class='btn shiny icon-only btn-xs' onclick='me.MoveDown($code);'><i class='fa fa-level-down darkorange'></i></button>";
      }
      
      $value['level_view'] = LevelDisplay($value['level_view'], $task);
      $value['level_add'] = LevelDisplay($value['level_add'], $task);
      $value['level_edit'] = LevelDisplay($value['level_edit'], $task);
      $value['level_del'] = LevelDisplay($value['level_del'], $task);
      $value['shortname_th'] = MenuDisplay($value['main_menu'], $value['shortname_th'], $value['icon']);
      $result['row'][$i]['code']=$code;
      $result['row'][$i]['no'] = ++$start;
      $result['row'][$i]['enable'] = EnableDisplay($value['enable']);
      $result['row'][$i]['btn'] = str_replace("{code}", $value['code'], $btn);
      
      foreach((array)$column as $j => $item){
        $result['row'][$i]['item'][]=$value[$item];
      }  
      
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
      $result['level_view'] = explode(',', $row->level_view);
      $result['level_add'] = explode(',', $row->level_add);
      $result['level_edit'] = explode(',', $row->level_edit);
      $result['level_del'] = explode(',', $row->level_del);
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

  public function ViewButton($mod, $permission, $input){
    $btn = array();

    if(array_key_exists("EDIT", $input) && $permission['EDIT'][$mod]){
      $btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.LoadEdit({code});'><i class='fa fa-edit success'></i> ".$input['EDIT']."</a></li>";
    }
    if(array_key_exists("DEL", $input) && $permission['DEL'][$mod]){
      $btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.DelView({code});'><i class='fa fa-trash-o danger'></i> ".$input['DEL']."</a></li>";
    }
    if(array_key_exists("ADD", $input) && $permission['ADD'][$mod]){
      $btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.NewInsert({code});'><i class='fa fa-indent info'></i> แทรก</a></li>";
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

  public function LoadCboMenu(){
    $lang = $this->lang;
    
		$sql="
			SELECT
				code, 
        shortname_$lang AS name,
        icon, main_menu
			FROM
				menus
      WHERE
        code <> 0
      ORDER BY
        sort
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
      if($row->main_menu == 'Y'){
        $row->name = $row->name;
      }else{
        $row->name = " - ".$row->name;
      }
			$result[]=array(
        'code' => $row->code,
        'name' => $row->name
      );
		}
		mysql_free_result($query);

    return $result;
  }

	public function MoveUp(){
    $table = $this->table;
    $sort=0;
    
    $sql="SELECT sort FROM $table WHERE code = '".$this->attr['code']."';";
		$query=mysql_query($sql) or die(mysql_error().$sql);
		if($row=mysql_fetch_object($query)){
      $sort=$row->sort;
		}
    
    $sql="
      UPDATE $table SET 
        sort = sort + 1
      WHERE
        sort < $sort
      ORDER BY 
        sort DESC
      LIMIT 
        1      
		;";
		mysql_query($sql) or die(mysql_error().$sql);
    
    $sql="
      UPDATE $table SET 
        sort = sort - 1
      WHERE
        code = '".$this->attr['code']."'
		;";
		$query=mysql_query($sql) or die(mysql_error().$sql);
    
    if($query){
      $result['success'] = 'COMPLETE';
		}
    
		return $result;
	}

	public function MoveDown(){
    $table = $this->table;
    $sort=0;
    
    $sql="SELECT sort FROM $table WHERE code = '".$this->attr['code']."';";
		$query=mysql_query($sql) or die(mysql_error().$sql);
		if($row=mysql_fetch_object($query)){
      $sort=$row->sort;
		}
    
    $sql="
      UPDATE $table SET 
        sort = sort - 1
      WHERE
        sort > $sort
      ORDER BY 
        sort
      LIMIT 
        1      
		;";
//    echo $sql;
		mysql_query($sql) or die(mysql_error().$sql);
    
    $sql="
      UPDATE $table SET 
        sort = sort + 1
      WHERE
        code = '".$this->attr['code']."'
		;";
//    echo $sql;
		$query=mysql_query($sql) or die(mysql_error().$sql);
    
    if($query){
      $result['success'] = 'COMPLETE';
		}
    
		return $result;
	}

	public function MoveAfter($code){
    $table = $this->table;
    $sort=0;
    
    $sql="SELECT sort FROM $table WHERE code = '$code';";
		$query=mysql_query($sql) or die(mysql_error().$sql);
		if($row=mysql_fetch_object($query)){
      $sort=$row->sort;
		}
    
    $sql="
      UPDATE $table SET 
        sort = sort + 1
      WHERE
        sort > $sort
		;";
//    echo $sql;
		mysql_query($sql) or die(mysql_error().$sql);
	}

	public function MoveBefore($code){
    $table = $this->table;
    $sort=0;
    
    $sql="SELECT sort FROM $table WHERE code = '$code';";
		$query=mysql_query($sql) or die(mysql_error().$sql);
		if($row=mysql_fetch_object($query)){
      $sort=$row->sort;
		}
    
    $sql="
      UPDATE $table SET 
        sort = sort - 1
      WHERE
        sort > $sort
		;";
//    echo $sql;
		mysql_query($sql) or die(mysql_error().$sql);
	}

	public function MoveBetween($code, $after_code){
    $table = $this->table;
    $sort_code=0;
    $sort_after=0;
    
    $sql="SELECT sort FROM $table WHERE code = '$code';";
		$query=mysql_query($sql) or die(mysql_error().$sql);
		if($row=mysql_fetch_object($query)){
      $sort_code=$row->sort;
		}
    
    $sql="SELECT sort FROM $table WHERE code = '$after_code';";
		$query=mysql_query($sql) or die(mysql_error().$sql);
		if($row=mysql_fetch_object($query)){
      $sort_after=$row->sort;
		}
    
    if($sort_code > $soft_after){
      $sql="
        UPDATE $table SET 
          sort = sort + 1
        WHERE
          sort > $sort_after AND
          sort < $sort_code
      ;";
      mysql_query($sql) or die(mysql_error().$sql);     
      
      $sql="
        UPDATE $table SET 
          sort = $sort_after + 1
        WHERE
          code = $code
      ;";
      mysql_query($sql) or die(mysql_error().$sql);  
    }else{
      $sql="
        UPDATE $table SET 
          sort = sort - 1
        WHERE
          sort > $sort_code AND
          sort <= $sort_after
      ;";
      mysql_query($sql) or die(mysql_error().$sql); 
      
      $sql="
        UPDATE $table SET 
          sort = $sort_after
        WHERE
          code = $code
      ;";
      mysql_query($sql) or die(mysql_error().$sql); 
    }
    
	}

	public function SortAfter($code){
    $table = $this->table;
    $sort=0;
    
    $sql="SELECT sort + 1 AS sort FROM $table WHERE code = '$code';";
		$query=mysql_query($sql) or die(mysql_error().$sql);
		if($row=mysql_fetch_object($query)){
      $sort=$row->sort;
		}else{
      $sql="SELECT sort + 1 AS sort FROM $table WHERE code <> 0 ORDER BY sort DESC;";
      $query=mysql_query($sql) or die(mysql_error().$sql);
      if($row=mysql_fetch_object($query)){
        $sort=$row->sort;
      }
    }
    
    return $sort;
	}

	public function LoadTask(){
    $table = $this->table;
    
    $sql="SELECT code, shortname FROM tasks WHERE code <> 0 AND enable = 'Y';";
		$query=mysql_query($sql) or die(mysql_error().$sql);
    
    $result = array();
		while($row=mysql_fetch_assoc($query)){
      $result[$row['code']] = $row["shortname"];
		}
    
    return $result;
	}

	public function UpdateSort(){
    $table = $this->table;
    
    $sql="select code from $table where code <> 0 order by sort;";
		$query=mysql_query($sql) or die(mysql_error().$sql);
    
    $result = array();
    $i=0;
		while($row=mysql_fetch_object($query)){
      $i++;
      $this->Edit($table, array('sort'=>$i), array('code'=>$row->code));
//      echo $this->sql;
		}
	}

  
}
?>






























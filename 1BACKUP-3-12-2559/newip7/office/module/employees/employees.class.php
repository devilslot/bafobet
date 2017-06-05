<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 05/12/2013 09:09
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/
function LevelDisplay($input){
  switch($input){
    case '1' : $result = 'User'; break;
    case '9' : $result = 'Admin'; break;
  }
  
  return $result;
}

class SubClass extends AppClass{

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
        tb.*, tk.name_th AS task_code
      FROM 
        $table tb, tasks tk
      WHERE 
        $where 
        tk.code = tb.task_code AND
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
      'EDIT' => $this->define['EDIT'],
      'DEL' => $this->define['DEL']
     ));
    
    foreach((array)$tmp as $i => $value){   
      $value['filepic'] = '<img src="'.Thumbnail($value['filepic'], 30).'" class="img-thumbnail" />';
      
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

  public function View_(){
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
      if(!empty($searchby) && (!empty($searchkey))){
        $where .= "tb.$searchby LIKE '%$searchkey%' AND ";
      }
    }
    
    if($_SESSION[OFFICE]['DATA']['level'] != 9){
      $where .= "tb.level <> '9' AND ";
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

    $beginpage = $page - 2;
    if($beginpage < 1){
      $beginpage = 1;
    }
    $endpage = $beginpage + 4;
    if($endpage > $allpage){
      $endpage = $allpage;
    }

    $runpage = array();
    for($i=$beginpage; $i<=$endpage; $i++){
      $runpage[] = $i;
    }

    
		$sql="
      SELECT 
        tb.*, ps.name_th AS position_code
      FROM 
        $table tb, positions ps
      WHERE 
        $where 
        ps.code = tb.position_code AND
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
    foreach((array)$tmp as $i => $value){  
      $result['row'][$i]['code']=$value['code'];
      
      $result['row'][$i]['item'][]=++$start;
      $result['row'][$i]['item'][]='<img src="'.Thumbnail($value['filepic'], 30).'" class="img-thumbnail" />';
      $result['row'][$i]['item'][]=$value['id'];
      $result['row'][$i]['item'][]=$value['name'];
      $result['row'][$i]['item'][]=$value['surname'];
      $result['row'][$i]['item'][]=$value['position_code'];
      $result['row'][$i]['item'][]=$value['mobile'];
      $result['row'][$i]['item'][]=$value['email'];
      $result['row'][$i]['item'][]=$value['user_name'];
      $result['row'][$i]['item'][]=EnableDisplay($value['enable']);
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
//      $result['permission'] = json_decode(str_replace('\"', '"', $row->permission));
      $result['permission'] = $this->LoadEmpPermiss();
      unset($row->permission);
      $data=$row;
		}
		mysql_free_result($query);

    unset($data->user_pass);
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
  
  public function LoadEmpPermiss(){
    $sql="
      SELECT
        *
      FROM
        emp_permission
      WHERE
        emp_code = '".$this->attr["code"]."'
		";
//    echo $sql;
    $result = array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
      $result[] = $row->id.'-'.$row->task;
		}
		mysql_free_result($query);
    
		return $result;
  }

	public function LoadPerMenu(){
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
    $result = array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
      $result[]=$row;
		}
		mysql_free_result($query);
    
		return $result;
	}

	public function LoadPerMenuSub(){
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
    $result = array();
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

	public function LoadPermission(){
    $sql="
      SELECT
        *
      FROM
        permissions
      WHERE
        enable = 'Y' AND
        code <> 0
      ORDER BY
        sort
		";
//    echo $sql;
    $result = array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
      $result[]=$row;
		}
		mysql_free_result($query);
    
		return $result;
	}

	public function LoadSubPermission(){
    $sql="
      SELECT
        *
      FROM
        permissions
      WHERE
        per_code <> 0 AND
        code <> 0
      ORDER BY
        sort
		";
//    echo $sql;
    $result = array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
      $result[$row['per_code']][]=$row;
		}
		mysql_free_result($query);
    
		return $result;
	}

	public function DelEmpPermission($code){
    $sql="
      DELETE FROM
        emp_permissions
      WHERE
        emp_code = '$code'
		";
//    echo $sql;
    $query=mysql_query($sql) or die(mysql_error());
	}

	public function DelEmpPic($code){
    $sql="
      DELETE FROM
        emp_pics
      WHERE
        emp_code = '$code'
		";
//    echo $sql;
    $query=mysql_query($sql) or die(mysql_error());
	}

	public function LoadEmpPic(){
    $sql="
      SELECT
        *
      FROM
        emp_pics
      WHERE
        emp_code = '".$this->attr["code"]."'
      ORDER BY
        code
		";
//    echo $sql;
    $result = array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
      $result[]=$row['id'];
		}
		mysql_free_result($query);
    
		return $result;
	}

  public function LoadCboProvince(){
		$sql="
			SELECT
				code, 
        name_th AS name
			FROM
				provinces
      WHERE
        code <> 0
      ORDER BY
        name_th
		";
//		echo $sql;
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

  public function LoadCboPrefix(){
		$sql="
			SELECT
				code, 
        name_th AS name
			FROM
				prefixs
      WHERE
        code <> 0
      ORDER BY
        code
		";
//		echo $sql;
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

  public function LoadCboPosition(){
		$sql="
			SELECT
				pt.code, 
        CONCAT(dp.name_th, ' :: ', pt.name_th) AS name
			FROM
				positions pt, departments dp
      WHERE
        dp.code = pt.depart_code and
        pt.code <> 0
      ORDER BY
        dp.name_th, pt.name_th
		";
//		echo $sql;
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
  
  public function LoadCboDepartments(){
		$sql="
			SELECT
				code, 
        name_th AS name
			FROM
				departments
      WHERE
        name_th <> '-' AND
        code <> 0
      ORDER BY
        name_th
		";
//		echo $sql;
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
}
?>






























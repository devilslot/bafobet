<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 05/12/2013 09:09
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

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
      'PRINT' => $this->define['PRINT'],
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

  public function LoadTable($dbname){
		$sql="
      SHOW TABLES FROM $dbname
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row['Tables_in_'.$dbname];
		}
		mysql_free_result($query);

    return $result;
  }

  public function CheckDataDic($table){
		$sql="
      SELECT code FROM datadics WHERE id = '$table'
		";
//		echo $sql;
    $result=true;
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_assoc($query)){
			$result=false;
		}
		mysql_free_result($query);

    return $result;
  }
  
  public function CheckDataField($dic_code, $field){
		$sql="
      SELECT 
        code 
      FROM 
        datafields 
      WHERE 
        dic_code = '$dic_code' AND  
        id = '$field'
		";
//		echo $sql;
    $result=true;
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_assoc($query)){
			$result=false;
		}
		mysql_free_result($query);

    return $result;
  }

  public function LoadDataDic($code){
		$sql="
      SELECT
        *
      FROM
        datadics
      WHERE
        code = '$code'
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_assoc($query)){
			$result=$row;
		}
		mysql_free_result($query);

    return $result;
  }

  public function LoadDataDicField($code){
		$sql="
      SELECT DISTINCT
        dd.*
      FROM
        datadics dd, datafields df
      WHERE
        df.dic_code = dd.code AND
        df.code = '$code'
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_assoc($query)){
			$result=$row;
		}
		mysql_free_result($query);

    return $result;
  }

  public function LoadDataField($code){
		$sql="
      SELECT
        *
      FROM
        datafields
      WHERE
        code = '$code'
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_assoc($query)){
			$result=$row;
		}
		mysql_free_result($query);

    return $result;
  }

  public function RemoveField($table, $field){
		$sql="ALTER TABLE `$table` DROP COLUMN `$field`;";
//		echo $sql;
		$query=mysql_query($sql) or die(mysql_error());
  }

  public function LoadField($table){
		$sql="
      DESC $table
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row;
		}
		mysql_free_result($query);

    return $result;
  }

  public function LoadCboField($table){
		$sql="
			DESC $table
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result[]=array(
        'code' => $row->Field,
        'name' => $row->Field
      );
		}
		mysql_free_result($query);

    return $result;
  }

  public function AddField($table, $data){
    if($data['attr_type']=='enum'){
      $data['attr_type'] = "enum('Y','N')";
    }
		$sql="ALTER TABLE `$table` ADD COLUMN `{$data['id']}` {$data['attr_type']} NOT NULL  DEFAULT '{$data['default_field']}' AFTER `{$data['after_field']}`;";
//		echo $sql;
    $result=$sql;
		$query=mysql_query($sql) or die(mysql_error());

    return $result;
  }
}
?>






























<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 24/01/2015 09:09
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 24/01/2015 09:09
\*================================================*/

function ClearQuery($query){
  $query = str_replace("\\'", "'", $query);
  $query = str_replace("\\n", "\r\n", $query);
  
  return $query;
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
      $value['query1'] = ClearQuery($value['query1']);
      $value['query1'] = SqlFormatter::format($value['query1']);
      $value['query2'] = ClearQuery($value['query2']);
      $value['query2'] = SqlFormatter::format($value['query2']);
      $value['query3'] = ClearQuery($value['query3']);
      $value['query3'] = SqlFormatter::format($value['query3']);
      $value['query4'] = ClearQuery($value['query4']);
      $value['query4'] = SqlFormatter::format($value['query4']);
      $value['query5'] = ClearQuery($value['query5']);
      $value['query5'] = SqlFormatter::format($value['query5']);
      
      $result['row'][$i]['code']=$value['code'];
      $result['row'][$i]['no'] = ++$start;
      $result['row'][$i]['enable'] = EnableDisplay($value['enable']);
      $result['row'][$i]['btn'] = str_replace("{code}", $value['code'], $btn);
      
      $result['row'][$i]['collap'] = '
        <div class="row">
          <div class="col-lg-3 col-sm-6 col-xs-12"><div class="form-title">Query 1</div>'.$value['query1'].'</div>
          <div class="col-lg-3 col-sm-6 col-xs-12"><div class="form-title">Query 2</div>'.$value['query2'].'</div>
          <div class="col-lg-3 col-sm-6 col-xs-12"><div class="form-title">Query 3</div>'.$value['query3'].'</div>
          <div class="col-lg-3 col-sm-6 col-xs-12"><div class="form-title">Query 4</div>'.$value['query4'].'</div>
        </div>
      ';
      
      foreach((array)$column as $j => $item){
        $result['row'][$i]['item'][]=$value[$item];
      }  
      
    }  

    return $result;
  }
  
  public function LoadResult($sql){
//    echo $sql;
    $result = array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
      $result[]=$row;
		}
		mysql_free_result($query);
    
		return $result;
  }

  public function LoadTable($dbname){
		$sql="
      SHOW TABLES FROM $dbname
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error().$sql);
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row['Tables_in_'.$dbname];
		}
		mysql_free_result($query);

    return $result;
  }
  
	public function CreateTableQuery(){
    $sql="
      CREATE TABLE `query` (
        `code` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL DEFAULT '',
        `query1` text NOT NULL DEFAULT '',
        `query2` text NOT NULL DEFAULT '',
        `query3` text NOT NULL DEFAULT '',
        `query4` text NOT NULL DEFAULT '',
        `query5` text NOT NULL DEFAULT '',
        `user_create` varchar(100) NOT NULL,
        `user_update` varchar(100) NOT NULL,
        `date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `date_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`code`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ;";
//      echo $this->sql = $sql;

    $query=mysql_query($sql) or die(mysql_error());
    
    return $result;
	}  
}
?>






























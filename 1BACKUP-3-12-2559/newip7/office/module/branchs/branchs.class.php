<?php
/*================================================*\
*  Author : Online creation soft
*  Created Date : 28/11/2014 10:51
*  Module : Class
*  Description : Office Class
*  Involve People : Tirapant Tongpann
*  Last Updated : 28/11/2014 10:51
\*================================================*/

function TypeDisplay($input){
  if($input=='B'){
    $result = '<label class="label label-primary">วนอุทยาน</label>';
  }else{
    $result = '<label class="label label-info">อุทยาน</label>';
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
        tb.*, pv.name_th AS province_code, pr.name_th AS paro_code, ge.name_th as geo_code
      FROM 
        $table tb, provinces pv, paros pr, geographies ge
      WHERE 
        $where 
        tb.province_code = pv.code AND
        tb.paro_code = pr.code AND
        tb.geo_code = ge.code AND
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
      $value['enable'] = EnableDisplay($value['enable']);
      $value['close_start'] = DateDisplay($value['close_start']);
      $value['close_stop'] = DateDisplay($value['close_stop']);
      $value['branch_type'] = TypeDisplay($value['branch_type']);
      $value['filepic'] = '<img src="'.Thumbnail($value['filepic'], 30).'" class="img-thumbnail" />';
      
      $result['row'][$i]['code']=$value['code'];
      foreach((array)$column as $j => $item){
        if($item == 'no'){
          $result['row'][$i]['item'][]=++$start;
        }else{
          $result['row'][$i]['item'][]=$value[$item];
        }
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
      $row->content_th = ContentDisplay($row->content_th);
      $row->content_en = ContentDisplay($row->content_en);
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
  
  public function LoadPhoto($code){
		$sql="
			SELECT
        *
			FROM
        ".$this->table."_photos
			WHERE
        parent_code = '$code'
		;";
//		echo "<pre>$sql</pre>";
		$query=mysql_query($sql);
		$result = array();
		while($row=mysql_fetch_assoc($query)){
      $row['shortname'] = Cut($row['name'], 20);
      $row['thumb'] = Thumbnail($row['filepic'], 300);
      $row['thumbmap'] = Thumbnail($row['filemap'], 300);
//      $row['thumb'] = URL."/img/".$row['filepic'];
      $row['pic'] = URL."/img/".$row['filepic'];
      
			$result[] = $row;
		}
		mysql_free_result($query);
 
		return $result;
	}
  
  public function LoadVdo($code){
		$sql="
			SELECT
        *
			FROM
        ".$this->table."_vdos
			WHERE
        parent_code = '$code'
		;";
//		echo "<pre>$sql</pre>";
		$query=mysql_query($sql);
		$result = array();
		while($row=mysql_fetch_assoc($query)){
      $row['shortname'] = Cut($row['name'], 20);
      $row['vdo'] = URL.'/vdo/'.$row['filevdo'];
      $row['pic'] = URL.'/vdo/'.$row['filepic'];
      
			$result[] = $row;
		}
		mysql_free_result($query);
 
		return $result;
	}
  
  public function LoadReview($code){
		$sql="
			SELECT
        br.*, mb.file_filepic, mb.username
			FROM
        branchs_review br, members mb
			WHERE
        br.parent_code = '$code' and
        br.member_code = mb.code
		;";
//		echo "<pre>$sql</pre>";
		$query=mysql_query($sql);
		$result = array();
		while($row=mysql_fetch_assoc($query)){
      $row['date_create'] = DateTimeDisplay($row['date_create'], 9);
      $row['pic'] = Thumbnail($row['file_filepic'], 30);
      
			$result[] = $row;
		}
		mysql_free_result($query);
 
		return $result;
	}
}
?>






























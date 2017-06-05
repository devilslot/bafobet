<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 08/02/2016 01:14
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 08/02/2016 01:14
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
      'EDIT' => $this->define['EDIT'],
      'DEL' => $this->define['DEL']
     ));

    $pb = $this->LoadMatch('positionbanners');

    foreach((array)$tmp as $i => $value){   

      $value['filepic'] = "<img src='http://www.369zean.com/img/".$value['filepic']."' width='95%'/>";
      $value['position_code'] = $pb[$value['position_code']]->name_th;
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


  public function LoadCboPosition(){
    $sql="
      SELECT
        code, 
        name_th AS name
      FROM
        positionbanners
      WHERE
        enable = 'Y' AND
        code <> 0
      ORDER BY
        name_th
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


  public function OpenView(){
    $sql="
    SELECT
        bn.*, pb.name_th AS position_code
    FROM
        ".$this->table." bn, positionbanners pb
    WHERE
        bn.position_code = pb.code AND
        bn.code = '".$this->attr["code"]."'
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






}
?>






























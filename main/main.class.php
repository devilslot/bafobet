<?php
/*=========================================
*  Author : Attaphon Wongbuatong
*  Created Date : 27/6/2552 0:49
*  Module : Class Main
*  Description : -
*  Involve People : -
*  Last Updated : 27/6/2552 0:49
=========================================*/

class SuperClass{
  public $table = '';
  public $attr = array();
	public $error = array();
  public $sql = '';
  public $lang = 'th';
  
	public function Log($mode, $menu, $record, $user, $item=array()){
    if(empty($item)){
      $log = array();
    }
    $log = serialize($item);
    $log = mysql_real_escape_string($log);
//    echo $log;
//    print_r($item);
    
    $sql="
      INSERT INTO logs (mode, menu, record, item, ip, user_create, date_create)
      VALUES(
        '$mode', '$menu', '$record', '$log', '".IP()."', '$user', NOW()
      )
    ";
//    echo $sql;
    $query=mysql_query($sql) or die(mysql_error());
	}  
  
	public function Add($table='', $data=array()){
    if(!empty($data)){
      $attribute_arr = array();
      $values_arr = array();
      
      foreach($data as $fields => $val){
        $attribute_arr[] = $fields;
        $values_arr[] ="'".mysql_real_escape_string($val)."'";
      }
      $attribute = implode(',', $attribute_arr);
      $values = implode(',', $values_arr);
      $sql="
        INSERT INTO $table ($attribute)
        VALUES($values);
      ";
//      echo $sql;
      $this->sql = $sql;

      $query=mysql_query($sql) or die($sql);
//      $query=mysql_query($sql) or die(mysql_error());
      if($query){
        $result['success'] = 'COMPLETE';
        $result['code'] = mysql_insert_id();
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
  
	public function Edit($table='', $data=array(), $where=array()){
    if(!empty($data)){
      $attribute_arr = array();
      $where_arr = array();
      
      foreach($data as $fields => $value){
//        $value = mysql_real_escape_string($value);
        $attribute_arr[] = " $fields = '".mysql_real_escape_string($value)."' ";
      }
      foreach($where as $fields => $value){
//        $value = mysql_real_escape_string($value);
        $where_arr[] = " $fields = '".mysql_real_escape_string($value)."' ";
      }
      $attribute = implode(', ', $attribute_arr);
      $whereqry = implode(' AND ', $where_arr);
      
      $sql="SELECT * FROM $table WHERE $whereqry ";
      $query = mysql_query($sql);
      $log = array();
      while($row=mysql_fetch_assoc($query)){
        $log[] = $row;
      }
      
      $sql="
        UPDATE $table SET
          $attribute
        WHERE 
          $whereqry
      ";
      $this->sql = $sql;

      $query=mysql_query($sql) or die($sql);
//      $query=mysql_query($sql) or die(mysql_error());
      if($query){
        $result['success'] = 'COMPLETE';
        $result['log'] = $log;
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
  
	public function Del($table='', $where=array()){
    if(!empty($where)){
      $where_arr = array();
      
      foreach($where as $fields => $value){
        $value = mysql_real_escape_string($value);
        $where_arr[] = " $fields = '$value' ";
      }
      $whereqry = implode(' AND ', $where_arr);
      
      $sql="SELECT * FROM $table WHERE $whereqry ";
      $query = mysql_query($sql);
      $log = array();
      while($row=mysql_fetch_assoc($query)){
        $log[] = $row;
      }
      
      $sql="
        DELETE FROM
          $table
        WHERE
          $whereqry
      ";
      $this->sql = $sql;

      $query=mysql_query($sql) or die($sql);
//      $query=mysql_query($sql) or die(mysql_error());
      if($query){
        $result['success'] = 'COMPLETE';
        $result['log'] = $log;
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

	public function Load($table, $where=array(), $orderby='', $limit=''){
    if(!empty($where)){
      foreach((array)$where as $i => $item){
        $item = mysql_real_escape_string($item);
        $qrywhere .= "$i = '$item' AND ";
      }
    }
    if(!empty($orderby)){
      $orderby = "ORDER BY $orderby";
    }
    if(!empty($limit)){
      $limit = "LIMIT $limit";
    }
		$sql="
      SELECT * 
      FROM $table 
      WHERE
        $qrywhere
        1
      $orderby
      $limit
    ";
//    echo $sql;
    
    $this->sql = $sql;

    $query = mysql_query($sql) or die(mysql_query().$sql);
    $result = array();
    while($row=mysql_fetch_assoc($query)){
      $result[] = $row;
    }
		return $result;
	}

	public function LoadStep($table, $step, $where=array(), $orderby='', $limit=''){
    if(!empty($where)){
      foreach((array)$where as $i => $item){
        $item = mysql_real_escape_string($item);
        $qrywhere .= "$i = '$item' AND ";
      }
    }
    if(!empty($orderby)){
      $orderby = "ORDER BY $orderby";
    }
    if(!empty($limit)){
      $limit = "LIMIT $limit";
    }
		$sql="
      SELECT * 
      FROM $table 
      WHERE
        $qrywhere
        1
      $orderby
      $limit
    ";
    $this->sql = $sql;

    $query = mysql_query($sql);
    $result = array();
    while($row=mysql_fetch_assoc($query)){
      $result[$row[$step]][] = $row;
    }
		return $result;
	}

	public function LoadOne($table, $where=array(), $orderby=''){
    if(!empty($where)){
      foreach((array)$where as $i => $item){
        $item = mysql_real_escape_string($item);
        $qrywhere .= "$i = '$item' AND ";
      }
    }
    if(!empty($orderby)){
      $orderby = "ORDER BY $orderby";
    }
		$sql="
      SELECT 
        * 
      FROM 
        $table 
      WHERE
        $qrywhere
        1
      $orderby
      LIMIT 0, 1
    ";
    $this->sql = $sql;

    $query = mysql_query($sql);
    $result = array();
    if($row=mysql_fetch_assoc($query)){
      $result = $row;
    }
		return $result;
	}

	public function CreateCode($table){
		$sql="SELECT MAX(code) AS code FROM $table ORDER BY code DESC";

		$query=mysql_query($sql);
		if($row=mysql_fetch_object($query)){
			$num=intval($row->code);
			$Code=$num+1;
		}else{
			$Code=1;
		}

		mysql_free_result($query);
		return $Code;
	}
  
//   public function LoadCbo($table, $code, $name, $orderby){
// 		$sql="
// 			SELECT
// 				$code AS code, 
//         $name AS name
// 			FROM
// 				$table
//       WHERE
//         code <> 0
//       ORDER BY
//         $orderby
// 		";
// //		echo $sql;
//     $result=array();
// 		$query=mysql_query($sql) or die(mysql_error());
// 		while($row=mysql_fetch_object($query)){
// 			$result[]=array(
//         'code' => $row->code,
//         'name' => $row->name
//       );
// 		}
// 		mysql_free_result($query);

//     return $result;
//   }

  public function query($sql) {
      $sql =str_replace(";", "", $sql);
      $this->sql = $sql;
      return $this;
  }

  public function select($field='*') {
      $this->select = array();
      $this->from = array();
      $this->where = array();
      $this->groupby = array();
      $this->having = array();
      $this->orderby = array();
      $this->sql = "";

      $this->select[] = $field;
      return $this;
  }

  public function from($table, $shortname="") {
      if($shortname==''){
          $this->from[] = $table;    
      }else{
          $this->from[] = "$table $shortname";
      }

      return $this;
  }

  public function where($field, $arg1, $arg2='') {
      if($arg2==''){
          $this->where[] = "$field = '$arg1'";
      }else{
          $this->where[] = "$field $arg1 '$arg2'";
      }

      return $this;
  }

  public function groupby($field) {
      $this->groupby[] = $field;

      return $this;
  }

  public function having($field, $arg1, $arg2='') {
      if($arg2==''){
          $this->where[] = "$field = '$arg1'";
      }else{
          $this->where[] = "$field $arg1 '$arg2'";
      }

      return $this;
  }

  public function orderby($field, $order='ASC') {
      $this->orderby[] = "$field $order";

      return $this;
  }

  public function join($table1, $table2) {
      $this->where[] = "$table1 = $table2";

      return $this;
  }
  
  public function all(){
    $this->selectSql();

    $query = mysql_query($this->sql) or die("Error query : \n".$this->sql."\n => ".mysql_error());
    $this->result = array();
    while($row=mysql_fetch_assoc($query)){
        $this->result[] = $row;
    }
    mysql_free_result($query);

    return $this;
  }

  public function one(){
      $this->selectSql();

      $this->sql .= " LIMIT 0, 1 ";    

    $query = mysql_query($this->sql) or die("Error query : \n".$this->sql."\n => ".mysql_error());
      $this->result = array();
      if($row=mysql_fetch_assoc($query)){
          $this->result = $row;
      }
      mysql_free_result($query);

      return $this;
  }

  public function limit($start, $stop=''){
      $this->selectSql();

      if($stop==''){
          $this->sql .= "\nLIMIT\n\t0, $start";    
      }else{
          $this->sql .= "\nLIMIT\n\t$start, $stop ";
      }

      $query = mysql_query($this->sql) or die("Error query : \n".$this->sql."\n => ".mysql_error());
      $this->result = array();
      while($row=mysql_fetch_assoc($query)){
          $this->result[] = $row;
      }
      mysql_free_result($query);

      return $this;
  }

  public function page($page, $limit){
      $this->selectSql();
      $query = mysql_query($this->sql) or die("Error query : \n".$this->sql."\n => ".mysql_error());
      $count = mysql_num_rows($query);

      $page = (empty($page))?"1":$page;
      $start = (($page - 1) * $limit);

      $this->selectSql();

      $allpage = ceil($count / $limit);

      $pp = $page - 1;
      if($pp < 1){
        $pp = 1;
      }
      $np = $page + 1;
      if($np > $allpage){
        $np = $allpage;
      }

      $runpage = array();
      for($i=1; $i<=$allpage; $i++){
        $runpage[] = $i;
      }

      $this->page = array(
          'page' => $page,
          'first' => 1,
          'prev' => $pp,
          'next' => $np,
          'count' => $count,
          'all' => $allpage,
          'limit' => $limit,
          'number' => $runpage
      );

      $this->sql .= "\nLIMIT\n\t$start, $limit ";
      $query = mysql_query($this->sql) or die("Error query : \n".$this->sql."\n => ".mysql_error());
      $this->result = array();
      while($row=mysql_fetch_assoc($query)){
          $this->result[] = $row;
      }
      mysql_free_result($query);

      return $this;
  }

  private function selectSql(){
    if(empty($this->sql)){
      $select = implode(", ", (array)$this->select);
      $from = implode(", ", (array)$this->from);
      $where = implode(" AND \n\t", (array)$this->where);
      $groupby = implode(", ", (array)$this->groupby);
      $having = implode(" AND \n\t", (array)$this->having);
      $orderby = implode(", ", (array)$this->orderby);

      $groupby = (empty($groupby))?"":"\nGROUP BY\n\t$groupby";
      $having = (empty($having))?"":"\nHAVING\n\t$having";
      $orderby = (empty($orderby))?"":"\nORDER BY\n\t$orderby";

      $this->sql = "\nSELECT\n\t$select\nFROM\n\t$from\nWHERE\n\t$where$groupby$having$orderby";
    }
  }
}

?>
<?php
/*================================================*\
*  Author : BoyBangkhla
*  Created Date : 24/01/2015 09:09
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 24/01/2015 09:09
\*================================================*/

class SubClass extends AppClass{

  public function __construct($table='', $lang='th'){
    $this->table = $table;
    $this->lang = $lang;
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
      $result['level_open'] = explode(',', $row->level_open);
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
}
?>






























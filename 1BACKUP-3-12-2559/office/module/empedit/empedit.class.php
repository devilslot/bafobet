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






























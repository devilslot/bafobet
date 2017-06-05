<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 05/12/2013 09:09
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 05/12/2013 09:09
\*================================================*/

class SubClass extends SuperClass{

  public function __construct(){
	}

	public function Login(){
		$sql="
			SELECT
        code, id, prefix_code, name, surname, nickname, 
        user_name, user_pass, filepic, superadmin, 
        CONCAT(name, ' ', surname) AS user,
        NOW() AS datenow
			FROM
        employees
			WHERE
        user_name = '".$this->attr["user_name"]."' AND
				enable = 'Y'
		";
//		echo $sql;

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
}
?>






























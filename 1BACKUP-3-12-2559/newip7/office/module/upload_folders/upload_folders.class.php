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

  public function __construct($table=''){
    $this->table = $table;
	}
  
  public function LoadFile($code){
		$sql="
			SELECT
        *
			FROM
        upload_files
			WHERE
        folder_code = '$code'
		;";
//		echo "<pre>$sql</pre>";
		$query=mysql_query($sql);
		$result = array();
		while($row=mysql_fetch_assoc($query)){
      $url = URL."/doc/".$row['filename'];
      $row['name'] = $row['name'];
      $row['url'] = "<a href='".$url."' target='_blank'>".$url."</a>";
      
			$result[] = $row;
		}
		mysql_free_result($query);
 
		return $result;
	}
      
}
?>






























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

  public function LoadLog(){
		$sql="
			SELECT
				*
			FROM
				logs
      WHERE
        code <> 0
      ORDER BY
        code DESC
      LIMIT
        0, 10
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

  public function LoadSurveyApprove(){
		$sql="
			SELECT
				*
			FROM
				surveys
      WHERE
        approve = 'Y' AND
        code <> 0
      ORDER BY
        date_approve DESC, code DESC
      LIMIT
        0, 5
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

  public function CountSurveyAll(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				projects
      WHERE
        online = 'Y' AND
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountSurveyApprove(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				surveys
      WHERE
        approve = 'Y' AND
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountSurveyReject(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				surveys
      WHERE
        approve = 'N' AND
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountSurveyInProject(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				surveys
      WHERE
        project_code <= 7735 AND
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountSurveyOutProject(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				surveys
      WHERE
        project_code > 7735 AND
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountContact(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				contacts
      WHERE
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountContactMail(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				contacts
      WHERE
        sendmail > 0 AND
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountContactQuiz(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				contacts
      WHERE
        cnt_quiz > 0 AND
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountProject(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				projects
      WHERE
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }

  public function CountProjectOri(){
		$sql="
			SELECT
				COUNT(code) AS cnt
			FROM
				projects
      WHERE
        user_create = 'OCS' AND
        code <> 0
		";
//		echo $sql;
    $result=0;
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result=$row->cnt;
		}
		mysql_free_result($query);

    return $result;
  }
}
?>






























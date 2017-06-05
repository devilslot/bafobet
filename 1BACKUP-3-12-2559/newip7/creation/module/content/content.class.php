<?php
/*================================================*\
*  Author : Attaphon
*  Created Date : 29/07/14 13:27
*  Module : Creation
*  Description : Creation
*  Involve People : Boy
*  Last Updated : 29/07/14 13:27
\*================================================*/

class clsContent extends clsCreation{

	public function __construct($table=''){
		$this->table = $table;
	}

	public function LoadConfig(){
		$sql="
		SELECT
		*
		FROM
		configs
		WHERE
		code = 1
		";
//		echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_object($query)){
			$result=(array)$row;
		}
		mysql_free_result($query);

		return $result;
	}

	public function LoadBanner($position,$limit){
		$sql="
		SELECT
		*
		FROM
		banners
		WHERE
		position_code = '$position' AND
		CURRENT_DATE() <= expire_date
		ORDER BY
		code DESC
		LIMIT $limit
		";
	//echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row;
		}
		mysql_free_result($query);

		return $result;
	}

	public function LoadTdedNew($limit){
		$sql="
		SELECT
		*
		FROM
		tdeds
		WHERE
		date_match = '".date('Y-m-d')."'
		ORDER BY
		code DESC
		LIMIT $limit
		";
	//echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_assoc($query)){
			$result[]=$row;
		}
		mysql_free_result($query);

		return $result;
	}


	public function LoadTded($limit){
		$sql="
		SELECT
		*
		FROM
		tdeds
		WHERE
		date_match < '".date('Y-m-d')."'
		ORDER BY
		code DESC
		LIMIT $limit
		";
	//echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row;
		}
		mysql_free_result($query);

		return $result;
	}

	public function LoadHilight($limit){
		$sql="
		SELECT
		*
		FROM
		hilights
		ORDER BY
		code DESC
		LIMIT $limit
		";
	//echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row;
		}
		mysql_free_result($query);

		return $result;
	}

	public function LoadNewsPaper($limit){
		$sql="
		SELECT
		*
		FROM
		newspapers
		ORDER BY
		code DESC
		LIMIT $limit
		";
	//echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row;
		}
		mysql_free_result($query);

		return $result;
	}

	public function LoadLotto(){
		$sql="
		SELECT
		*
		FROM
		lottos
		ORDER BY
		code DESC
		LIMIT 1
		";
	//echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_assoc($query)){
			$result=$row;
		}
		mysql_free_result($query);

		return $result;
	}

	public function LoadLottoNews($limit){
		$sql="
		SELECT
		*
		FROM
		lottonews
		ORDER BY
		code DESC
		LIMIT $limit
		";
	//echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row;
		}
		mysql_free_result($query);

		return $result;
	}

	public function LoadPantip($limit){
		$sql="
		SELECT
		*
		FROM
		pantipnews
		ORDER BY
		code DESC
		LIMIT $limit
		";
	//echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_assoc($query)){
			$result[]=$row;
		}
		mysql_free_result($query);

		return $result;
	}
	
	public function LoadContent($table,$id){
		$sql="
		SELECT
        *
		FROM
		$table
		WHERE
		code = '$id'
		;";
//		echo "<pre>$sql</pre>";
		$query=mysql_query($sql);
		$result = array();
		if($row=mysql_fetch_assoc($query)){
			$result = $row;
		}
		mysql_free_result($query);

		mysql_query($sql);

		$sql = " UPDATE $table SET view = view+1 WHERE code = '".$id."' ";
		mysql_query($sql);



		return $result;
	} 

	public function LoadData($table,$id){
		$sql="
		SELECT
        *
		FROM
		$table
		WHERE
		code = '$id'
		;";
//		echo "<pre>$sql</pre>";
		$query=mysql_query($sql);
		$result = array();
		if($row=mysql_fetch_assoc($query)){
			$result = $row;
		}
		mysql_free_result($query);

		mysql_query($sql);



		return $result;
	} 

	public function LoadCount($table,$feild,$id){
		$sql="
		SELECT
		COUNT(code) AS cnt
		FROM
		$table
		WHERE
		$feild = '$id'
		;";
//		echo "<pre>$sql</pre>";
		$query=mysql_query($sql);
		$result = array();
		if($row=mysql_fetch_assoc($query)){
			$cnt = $row['cnt'];
		}
		mysql_free_result($query);

		mysql_query($sql);



		return $cnt;
	} 


	public function LoadMatch($id){
		$sql="
		SELECT
		*
		FROM
		matchHDC
		WHERE
		MatchID = '$id'
		";
//		echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_object($query)){
			$result=(array)$row;
		}
		mysql_free_result($query);

		return $result;
	}


	public function LoadView($table, $where=array(), $orderby='', $limit='',$pagenew=''){

		if(!empty($where)){
			foreach((array)$where as $i => $item){
				$item = mysql_real_escape_string($item);
				$qrywhere .= "$i = '".$item."' AND ";
			}
		}
		
		if(!empty($orderby)){
			$orderby = "ORDER BY $orderby";
		}
		if(empty($limit)){
			$limit = 1;
		}
		if(!empty($pagenew)){
			$page = $pagenew;
		}

		$sql="SELECT COUNT(*) AS cnt FROM $table tb WHERE $qrywhere tb.code <> 0";
		$query = mysql_query($sql);
		$count = 0;
		if($row=mysql_fetch_object($query)){
			$count = $row->cnt;
		}    
		$allpage = ceil($count / $limit);
		$start = (($page - 1) * $limit);
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
		$qrywhere 
		tb.code <> 0
		$orderby
		LIMIT 
		$start, $limit
		;";
//    PrintR($sql);
		
		$query = mysql_query($sql);
		$num_row = mysql_num_rows($query);
		
		
		while ($row = mysql_fetch_assoc($query)) {
			$result['row'][] = $row;
		}
		$result['start'] = $start;
		$result['limit'] = $limit;
		$result['count'] = $count;
		$result['num_row'] = $num_row;  
		$result['allpage'] = $allpage;
		$result['prev'] = $pp;
		$result['next'] = $np;

		return $result;
	}

	public function CountH($match){
		$sql="
		SELECT
		COUNT(code) AS cnt
		FROM
		playgame
		WHERE
		matchID = '$match' AND
		bet = 1
		";
//		echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_object($query)){
			$total=$row->cnt;
		}
		mysql_free_result($query);

		return $total;
	}

	public function CountA($match){
		$sql="
		SELECT
		COUNT(code) AS cnt
		FROM
		playgame
		WHERE
		matchID = '$match' AND
		bet = 2
		";
//		echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_object($query)){
			$total=$row->cnt;
		}
		mysql_free_result($query);

		return $total;
	}

	public function CountD($match){
		$sql="
		SELECT
		COUNT(code) AS cnt
		FROM
		playgame
		WHERE
		matchID = '$match' AND
		salway = shome
		";
//		echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_object($query)){
			$total=$row->cnt;
		}
		mysql_free_result($query);

		return $total;
	}

	public function CountC($match){
		$sql="
		SELECT
		COUNT(code) AS cnt
		FROM
		playgame
		WHERE
		matchID = '$match'
		";
//		echo $sql;
		$result=array();
		$query=mysql_query($sql) or die(mysql_error());
		if($row=mysql_fetch_object($query)){
			$total=$row->cnt;
		}
		mysql_free_result($query);

		return $total;
	}


}
?>
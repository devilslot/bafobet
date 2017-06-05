<?php
define('DB',true);
class db
{
	public static $count;
	function db($key="default")
	{
		$this->host='localhost';
		
		/*$this->host='localhost';
		$this->username='tonyscore_db';
		$this->password='ssK8d!p^gm[c';
		$this->database='tonyscore_try';
		*/
		
		$this->host='139.162.25.110';
		$this->username='tonyscor_usertry';
		$this->password='#@DyWFo~C)zX';
		$this->database='tonyscor_trys';
		
		/*
		$this->username='root';
		$this->password='root';
		$this->database='tryscore';
		*/
		$this->encode='utf8';
		$this->key=$key;
	}
	function Connect()
	{
		$time_start=array_sum(explode(' ',microtime()));
		if (!$this->Connected=@mysql_connect($this->host,$this->username,$this->password,true))
		{
			$this->dbError('Connect');
			return false;
		}
		if(!@mysql_select_db($this->database , $this->Connected))
		{
			$this->dbError('SelectDB');
			return false;
		}
		$this->connect_time+=(array_sum(explode(' ',microtime()))-$time_start);
		$this->Execute("SET NAMES ".$this->encode);
		return true;
	}
	function Execute($sql,$inputarr=false)
	{
		if(!$this->Connected&&!$this->Connect())return;
		if($inputarr&&is_array($inputarr))
		{
			$sqlarr=explode('?',$sql);
			$sql=$sqlarr[0];
			foreach($inputarr as $v)
			{
				$sql.=$sqlarr[$i];
				switch(gettype($v))
				{
					case 'string':$sql.=$this->qstr($v); break;
					case 'double':$sql.=str_replace(',', '.', $v);break;
					case 'boolean':$sql.=$v?1:0;break;
					default:$sql.=($v===null?'NULL':$v);
				}
				$i++;
			}
			$sql.=$sqlarr[$i];
			if($i+1!=sizeof($sqlarr))
			{
				$this->dbError("Value in Array for Query");
				return;
			}
		}
		$this->sql=$sql;
		$time_start=array_sum(explode(' ',microtime()));
		$this->query_count++;
		db::$count++;
		$resultId=@mysql_query($this->sql,$this->Connected);
		$this->query_time_total+=(array_sum(explode(' ',microtime()))-$time_start);
		//echo $this->sql.'<br>';
		if(!$resultId)
		{
			$this->lastsql=$this->sql;
			$this->dbError("query");
			return;
		}
		switch(substr(trim(strtolower($sql)),0,6))
		{
			case 'insert': return @mysql_insert_id($this->Connected);
			case 'update':
			case 'delete': return @mysql_affected_rows($this->Connected);
			default: return $resultId;
		}
	}
	function qstr($string)
	{
		return "'".mysql_escape_string($string)."'";
	}
	function Fetch()
	{
		if($row=@mysql_fetch_assoc($this->resultId))
		{
			while(list($key,$val)=each($row)) $row[$key]=stripslashes($val);
			$row['db']=$this->key;
			return $row;
		}
		return array();
	}
	function Insert_ID()
	{
		return @mysql_insert_id($this->Connected);
	}
	
	function CloseDB()
	{
		return @mysql_close();
	}
	
	
	function GetOne($sql,$inputarr=false)
	{
		if(strpos(strtolower($sql)," limit ")===false) $sql.=" limit 0,1";
		if($this->resultId=$this->Execute($sql,$inputarr))
		{
			$a=@array_values($this->Fetch());
			return $a[0];
		}
	}

	function GetRow($sql,$inputarr=false)
	{
		if(strpos(strtolower($sql)," limit ")===false) $sql.=" limit 0,1";
		if($this->resultId=$this->Execute($sql,$inputarr)) return $this->Fetch();
	}
	function GetAll($sql,$inputarr=false)
	{
		if($this->resultId=$this->Execute($sql,$inputarr))
		{
			while($a=$this->Fetch()) $b[]=$a;
			return $b;
		}
		return;
	}
	function Close()
	{
		@mysql_close($this->Connected);
		$this->Connected=false;
	}
	function dbError($e='')
	{
		$this->error=$e.' - '.$this->sql;
		echo "<div style='background:#ff0000;color:#ffffff'><b>DB Error!</b><br><b>Function</b>: ".$e."<br><b>Error Type</b>: ".@mysql_errno($this->Connected)." - ".@mysql_error($this->Connected)."<br><b>Sql</b>: ".$this->sql." <br><b>Last Sql</b>: ".$this->lastsql."<br><b>Server</b>: ".$this->host."(".$this->key.")</div>";
	}
	function Count($disconnect=false)
	{
		return number_format($this->query_count);
	}
	function Time($connect=false)
	{
		return number_format(($connect?$this->connect_time:$this->query_time_total),4);
	}
}
?>

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
				//$where .= "tb.date_match = '".date('Y-m-d')."' AND ";
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

		if($where == ''){
			$where = "tb.date_match = '".date('Y-m-d')."' AND ";
		}

		$sql="SELECT COUNT(*) AS cnt FROM $table tb WHERE $where tb.code <> 0";
		//echo $sql;
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
		tb.date_match,tb.time_match ASC
		LIMIT 
		$start, $limit
		;";
		//PrintR($sql);

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

		$fb = $this->LoadMatch('footballresult');

		foreach((array)$tmp as $i => $value){   
			$value['date_match'] = DateDisplay($value['date_match'],6);
			
			if($value['ratio'] == 1){
				$value['ratio'] = '<select  class="form-control" id="ratio'.$value['code'].'" name="ratio'.$value['code'].'" onchange="me.SaveRate('.$value['code'].')"><option value="1" selected>Home</option><option value="2">Alway</option></select>';
			}else  if($value['ratio'] == 2){
				$value['ratio'] = '<select  class="form-control" id="ratio'.$value['code'].'" name="ratio'.$value['code'].'" onchange="me.SaveRate('.$value['code'].')"><option value="1">Home</option><option value="2" selected>Alway</option></select>';
			}else{
				$value['ratio'] = '<select  class="form-control" id="ratio'.$value['code'].'" name="ratio'.$value['code'].'" onchange="me.SaveRate('.$value['code'].')"><option value="">++ เลือก ++</option><option value="1">Home</option><option value="2">Alway</option></select>';
			}

			$value['hdc'] = '<input type="text" onchange="me.SaveHdc('.$value['code'].')" class="form-control" id="hdc'.$value['code'].'" name="hdc'.$value['code'].'" placeholder="ราคา" value="'.$value['hdc'].'">';
			$value['tded'] = '<input type="text" onchange="me.SaveTded('.$value['code'].')" class="form-control" id="tded'.$value['code'].'" name="tded'.$value['code'].'" placeholder="ทรรศนะ" value="'.$value['tded'].'">';


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









}
?>






























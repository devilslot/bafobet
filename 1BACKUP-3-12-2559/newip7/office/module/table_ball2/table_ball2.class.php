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
			$where = "tb.dates = '".date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'))."' AND ";
		}

		$sql="SELECT COUNT(tb.code) AS cnt 
		FROM table_ball tb,Tem_league lg
		 WHERE 
		$where 
		lg.id IN (36,31,8,34,11,700,90,84,81,51,83,54,37,39,35,33,1413,9,693,40,12,203,78,29,150,59,16,17,70,23,157,108,5,138,22,123,1428,1048,67,103,113,109,650,648,652,651,653,88,304,1366) AND
		tb.code <> 0 AND
		tb.ref = lg.id AND
		tb.live = 'FT'

		 ";
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
		tb.* ,lg.name_th,lg.name_en,lg.id
		FROM 
		table_ball tb,Tem_league lg
		WHERE 
		$where 
		lg.id IN (36,31,8,34,11,700,90,84,81,51,83,54,37,39,35,33,1413,9,693,40,12,203,78,29,150,59,16,17,70,23,157,108,5,138,22,123,1428,1048,67,103,113,109,650,648,652,651,653,88,304,1366) AND
		tb.code <> 0 AND
		tb.ref = lg.id AND
		tb.live = 'FT'
		GROUP BY tb.team2
		ORDER BY 
		 lg.sort
		 ASC
		LIMIT 
		$start, $limit
		;";
		//echo $sql;
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

		//$fb = $this->LoadMatch('footballresult');
			$lg = $this->LoadMatch('Tem_league');
		foreach((array)$tmp as $i => $value){   
			$value['dates'] = DateDisplay($value['dates'],6);
			$value['ref'] = $lg[$value['ref']]->name_th;
			// $value['HomeTeam'] = TeamName($value['HomeTeam']);
			// $value['AwayTeam'] = TeamName($value['AwayTeam']);
			if($value['name_th'] ==""){
				$value['name_th'] = $value['name_en'];
			}
			if($value['ratio'] == 1){
				$value['ratio'] = '<select  class="form-control" id="ratio'.$value['code'].'" name="ratio'.$value['code'].'" onchange="me.SaveRate('.$value['code'].')"><option value="1" selected>Home</option><option value="2">Alway</option></select>';
			}else  if($value['ratio'] == 2){
				$value['ratio'] = '<select  class="form-control" id="ratio'.$value['code'].'" name="ratio'.$value['code'].'" onchange="me.SaveRate('.$value['code'].')"><option value="1">Home</option><option value="2" selected>Alway</option></select>';
			}else{
				$value['ratio'] = '<select  class="form-control" id="ratio'.$value['code'].'" name="ratio'.$value['code'].'" onchange="me.SaveRate('.$value['code'].')"><option value="">++ เลือก ++</option><option value="1">Home</option><option value="2">Alway</option></select>';
			}

			$value['hdc'] = '<input type="text" class="form-control" id="hdc'.$value['code'].'" name="hdc'.$value['code'].'" placeholder="ราคา" value="'.$value['hdc'].'" onblur="me.SaveHdc('.$value['code'].')">';
			$value['tded'] = '<input type="text" class="form-control" id="tded'.$value['code'].'" name="tded'.$value['code'].'" placeholder="ทรรศนะ" value="'.$value['tded'].'" onblur="me.SaveTded('.$value['code'].')">';
			// $value['channel'] = '<input type="text" class="form-control" id="channel'.$value['code'].'" name="channel'.$value['code'].'" placeholder="ช่องถ่ายทอด" value="'.$value['channel'].'">';
			if($value['channel'] == 0){
				$value['channel'] = '<select  class="form-control" id="channel'.$value['code'].'" name="channel'.$value['code'].'" onchange="me.SaveCha('.$value['code'].')"><option value="0" selected>ไม่แสดง</option><option value="1">แสดง</option></select>';
			}else  if($value['channel'] == 1){
				$value['channel'] = '<select  class="form-control" id="channel'.$value['code'].'" name="channel'.$value['code'].'" onchange="me.SaveCha('.$value['code'].')"><option value="0">ไม่แสดง</option><option value="1" selected>แสดง</option></select>';
			}else{
				$value['channel'] = '<select  class="form-control" id="channel'.$value['code'].'" name="channel'.$value['code'].'" onchange="me.SaveCha('.$value['code'].')"><option value="">++ เลือก ++</option><option value="0">ไม่แสดง</option><option value="1">แสดง</option></select>';
			}			

			if($value['hot'] == 0){
				$value['hot'] = '<select  class="form-control" id="hot'.$value['code'].'" name="hot'.$value['code'].'" onchange="me.SaveHot('.$value['code'].')"><option value="0" selected>ไม่แสดง</option><option value="1">แสดง</option></select>';
			}else  if($value['hot'] == 1){
				$value['hot'] = '<select  class="form-control" id="hot'.$value['code'].'" name="hot'.$value['code'].'" onchange="me.SaveHot('.$value['code'].')"><option value="0">ไม่แสดง</option><option value="1" selected>แสดง</option></select>';
			}else{
				$value['hot'] = '<select  class="form-control" id="hot'.$value['code'].'" name="hot'.$value['code'].'" onchange="me.SaveHot('.$value['code'].')"><option value="">++ เลือก ++</option><option value="0">ไม่แสดง</option><option value="1">แสดง</option></select>';
			}

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



  public function LoadCboLeaguge(){
    $sql="
    SELECT
    id as code,
    CONCAT(name_th, ' / ', name_en) as name
    FROM
    Tem_league
    GROUP BY
    name_en
    ORDER BY
    name_en ASC
    ";
//    echo $sql;
    $result=array();
    $query=mysql_query($sql) or die(mysql_error().$sql);
    while($row=mysql_fetch_assoc($query)){
      $result[]=$row;

    }
    mysql_free_result($query);

    return $result;
  }


  public function LoadMatch($table,$order='code'){
		$sql="
			SELECT
				*
			FROM
				$table
      WHERE
        code <> 0
      ORDER BY
        $order
		";
//		echo $sql;
    $result=array();
		$query=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_object($query)){
			$result[$row->id]=$row;
		}
		mysql_free_result($query);

    return $result;
  }


}
?>






























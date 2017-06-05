<?php
date_default_timezone_set("Asia/Bangkok");
include('config_cronjob.php');
$url = "http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/soccernew/home";

$xml = json_decode(json_encode(simplexml_load_file($url)), true);

//echo '<pre>';print_r(simplexml_load_file($url));echo '</pre>';
// Get League
foreach ($xml['category'] as $key => $value) {
	 //echo '<pre>';print_r($value);echo '</pre>';
	// echo $value['@attributes']['name'].'Date Match = '.$value['matches']['@attributes']['formatted_date'].'<br/>';

	// Get Match
	//foreach ($value['matches']['match'] as $key2 => $value2) {
	
	//echo '---------#################------------<pre>';print_r($value['matches']['match']);echo '</pre>';
	for($a=0;$a<count($value['matches']['match']);$a++){
	
	if($value['matches']['match']['@attributes']['status']!=''){
	$status = $value['matches']['match']['@attributes']['status'];  
	
	$formatted_date=$value['matches']['match']['@attributes']['formatted_date'];  
	
	$time=$value['matches']['match']['@attributes']['time']; 
	
	$static_id=$value['matches']['match']['@attributes']['static_id'];  
	
	$fix_id=$value['matches']['match']['@attributes']['fix_id']; 
	
	$id=$value['matches']['match']['@attributes']['id'];
	
	$localteamname=$value['matches']['match']['localteam']['@attributes']['name'];
	
	$localteamgoals=$value['matches']['match']['localteam']['@attributes']['goals'];
	
	$localteamid=$value['matches']['match']['localteam']['@attributes']['id'];
	
	$visitorteamname=$value['matches']['match']['visitorteam']['@attributes']['name'];
	
	$visitorteamgoals=$value['matches']['match']['visitorteam']['@attributes']['goals'];
	
	$visitorteamid=$value['matches']['match']['visitorteam']['@attributes']['id'];
	
	$htscore = $value['matches']['match']['ht']['@attributes']['score'];
	}else{
	
	$status = $value['matches']['match'][$a]['@attributes']['status'];  
	
	$formatted_date=$value['matches']['match'][$a]['@attributes']['formatted_date'];  
	
	$time=$value['matches']['match'][$a]['@attributes']['time']; 
	
	$static_id=$value['matches']['match'][$a]['@attributes']['static_id'];  
	
	$fix_id=$value['matches']['match'][$a]['@attributes']['fix_id']; 
	
	$id=$value['matches']['match'][$a]['@attributes']['id'];
	
	$localteamname=$value['matches']['match'][$a]['localteam']['@attributes']['name'];
	
	$localteamgoals=$value['matches']['match'][$a]['localteam']['@attributes']['goals'];
	
	$localteamid=$value['matches']['match'][$a]['localteam']['@attributes']['id'];
	
	$visitorteamname=$value['matches']['match'][$a]['visitorteam']['@attributes']['name'];
	
	$visitorteamgoals=$value['matches']['match'][$a]['visitorteam']['@attributes']['goals'];
	
	$visitorteamid=$value['matches']['match'][$a]['visitorteam']['@attributes']['id'];
	
	$htscore = $value['matches']['match'][$a]['ht']['@attributes']['score'];
	
	}
	//echo 'lllll'.$value2['visitorteam']['@attributes']['goals'];
	//echo '<pre>';print_r($value2);echo '</pre>';
		/* echo '########################################################<br/>';
		 //echo '<pre>';print_r($value2['@attributes']['name']);echo '</pre>';
		  echo 'Sattus = '.$status.'<br/>';
		 echo 'Date = '.$formatted_date.'<br/>';
		 
		 echo 'Time = '.$time.'<br/>';
		 
		 echo 'Static ID = '.$static_id.'<br/>';
		 echo 'Fix ID = '.$fix_id.'<br/>';
		 echo 'ID = '.$id.'<br/>##';
		echo 'Local Team Name = '.$localteamname.'<br/>';
		 echo 'Local Team Goal = '.$localteamgoals.'<br/>';
		 echo 'Local Team ID = '.$localteamid.'<br/>';
		 echo '$visitorteamname = '.$visitorteamname.'<br/>';
		 echo '$visitorteamgoals = '.$visitorteamgoals.'<br/>';
		 echo '$visitorteamid = '.$visitorteamid.'<br/>';
		// echo 'HT = '.$htscore.'<br/>';
		 echo '$htscore = '.$htscore.'<br/>';
		 echo '########################################################<br/>';*/

		$sqlck="SELECT id_match FROM soccer_match  WHERE id_match = '".$id."' ";
		$queryck = mysql_query($sqlck);
		$row=mysql_fetch_array($queryck);
		
		
		
$temp =explode('.', $formatted_date);
			$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
		if(empty($row['id_match']) and $status != "" and $date != "--"){
			
			$sql="
			INSERT  INTO soccer_match  SET
			League = '".mysql_real_escape_string($value['@attributes']['name'])."',
			status = '".mysql_real_escape_string($status)."',
			date_match = '".mysql_real_escape_string($date)."',
			time_match = '".mysql_real_escape_string(htmlspecialchars($time))."',
			static_id = '".mysql_real_escape_string($static_id)."',
			fix_id = '".mysql_real_escape_string($fix_id)."',
			id_match = '".mysql_real_escape_string($id)."',
			local_team_name = '".mysql_real_escape_string($localteamname)."',
			local_team_goal = '".mysql_real_escape_string($localteamgoals)."',
			local_team_id = '".mysql_real_escape_string($localteamid)."',
			visitor_team_name = '".mysql_real_escape_string($visitorteamname)."',
			visitor_team_goal = '".mysql_real_escape_string($visitorteamgoals)."',
			visitor_team_id = '".mysql_real_escape_string($visitorteamid)."',
			ht = '".$htscore."',
			date_update = NOW()
			";
			$query=mysql_query($sql) or die(mysql_error());

		}else if($date != "--"){
			$temp =explode('.', $formatted_date);
			$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
			$sql="
			UPDATE  soccer_match  SET
			status = '".mysql_real_escape_string($status)."',
			local_team_goal = '".mysql_real_escape_string($localteamgoals)."',
			visitor_team_goal = '".mysql_real_escape_string($visitorteamgoals)."',
			ht = '".$htscore."',
			date_update = NOW()
			WHERE id_match = '".$id."'
			";
			$query=mysql_query($sql) or die(mysql_error());
		}
//echo '<pre>'.$sql.'</pre>########################---------------------################';








	}

	
}
echo "ok";


?>

<?php

$Query = mysql_query("select * from soccer_match where unix_timestamp(date_match) >= '".strtotime("-1 day", strtotime(date('Y-m-d')))."' AND FT!='-1' and id_match!='' ");
//$Query = mysql_query("select * from soccer_match ");
$i=0;
while($Result = mysql_fetch_array($Query)){
$sqlckm="SELECT HomeName FROM matchHDC  WHERE MatchID = '".$Result['id_match']."' ";
							//echo $sqlck;
							$queryckm = mysql_query($sqlckm);
							$rowm=mysql_fetch_array($queryckm);
	//echo "CM".$sqlckm."<br>";
$i++;


		$datetime = strtotime ('+7hours',strtotime($Result['date_match']." ".$Result['time_match']));
		$datetimeout = strtotime ('+10hours',strtotime($Result['date_match']." ".$Result['time_match']));
//echo '<hr>'.$i.': '.$Result['id_match'].'';
		 
		 if($Result['status']!='' and strlen($Result['status'])=='5'){
		 $status = 0;
		 }else if($Result['status']!='' and $Result['status']>=1 and $Result['status']<=45){
		 $status = 1;
		 }else if($Result['status']!='' and $Result['status']=='HT'){
		 $status = 2;
		 	mysql_query("update matchHDC set ScoreHomeHalfTime='".$Result['local_team_goal']."' , ScoreAwayHalfTime='".$Result['visitor_team_goal']."' where MatchID='".$Result['id_match']."' ");
			
			
		}else if($Result['status']!='' and $Result['status']>=45 and $Result['status']<=90){
			$status = 3;
		}else if($Result['status']!='' and $Result['status']=='FT'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='ET'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='AET'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='P'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='Pen.'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='Postp.'){
			$status = '0';
		}else if($Result['status']!='' and $Result['status']=='Cancl.'){
			$status = '-14';
		}else if($Result['status']!='' and $Result['status']=='Aban.'){
			$status = '-13';
		}else if($Result['status']!='' and $Result['status']=='Break Time'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='Int.'){
			$status = '2';
		}
		//$t11 = $datetime;
		//$t22 = $datetimeout;
		//echo 't11'.$t11;
		//echo 't22'.$t22;
		$tout = ($datetimeout-time());
		//echo "WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW".$tout."|".date('Y-m-d H:i',$datetimeout)."|".date('Y-m-d H:i',time());
		if($tout<0 and $status!='-1'){
		$status = 'Und';
		//echo "DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD".$timeouts;
		}
		$leasho = str_replace("-", "", $Result['League']);
		$leasho = explode(" ", $leasho);
		$leasho1 = substr($leasho[0], 0, 3);
		$leasho2 = substr($leasho[1], 0, 2);
		$leasho3 = substr($leasho[2], 0, 1);
		$leasho4 = substr($leasho[3], 0, 1);
		$leasho5 = substr($leasho[4], 0, 1);
		$leasho6 = substr($leasho[5], 0, 1);
		$leasho7 = substr($leasho[6], 0, 1);
		
		$leashort = $leasho1.' '.$leasho2.''.$leasho3.''.$leasho4;
		
		if(empty($rowm['HomeName'])){
								
								$sql="
								INSERT  INTO matchHDC SET
								LeagueShortName = '".mysql_real_escape_string($leashort)."',
								LeagueEngName = '".mysql_real_escape_string($Result['League'])."',
								MatchID='".mysql_real_escape_string($Result['id_match'])."',
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								HomeName = '".mysql_real_escape_string($Result['local_team_name'])."',
								AwayName = '".mysql_real_escape_string($Result['visitor_team_name'])."',
								ScoreHomeFullTime='".mysql_real_escape_string($Result['local_team_goal'])."',
								ScoreAwayFulltime='".mysql_real_escape_string($Result['visitor_team_goal'])."',
								Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
								AsianHandicap = '0',
								date_save = '".mysql_real_escape_string(date('Y-m-d H:i:s'))."',
								date_create = '".date('Y-m-d H:i:s')."',
								date_update = '".date('Y-m-d H:i:s')."',
								enable = 'Y',
								Predict='N'
								";
								$query=mysql_query($sql) or die(mysql_error());

							}else{
								
								$sql="
								UPDATE  matchHDC  SET
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								ScoreHomeFullTime='".mysql_real_escape_string($Result['local_team_goal'])."',
								ScoreAwayFulltime='".mysql_real_escape_string($Result['visitor_team_goal'])."',
								date_update = '".date('Y-m-d H:i:s')."'
								
								WHERE MatchID = '".$Result['id_match']."' AND Status!='-1' AND Predict='N'
								";
								$query=mysql_query($sql) or die(mysql_error());
							}
				//echo '<pre>';echo $sql;echo '</pre>';
				
				
	$objQuery = mysql_query("select * from soccer_odds where id_match='".$Result['id_match']."' AND handicap_odd_handicap!='' AND handicap_odd_handicap2!='' order by code asc ");
	while($objResult = mysql_fetch_array($objQuery)){
		
		$sum =$objResult['handicap_odd_value']-$objResult['handicap_odd_value2'];
		//echo '<br>'.$objResult['handicap_odd_value'].' - '.$objResult['handicap_odd_value2'].'<br>';
		$handicap = str_replace("", "", $objResult['handicap_odd_handicap2']);
		$handicap = str_replace("+", "", $handicap);
		if($handicap==''){ $handicap=0; }
		$sum  = str_replace("-", "", $sum );
		//echo "###".$sum."###";
		
		if($sum<0.61){
		
	
								
								$sql="
								UPDATE  matchHDC  SET
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								ScoreHomeFullTime='".mysql_real_escape_string($Result['local_team_goal'])."',
								ScoreAwayFulltime='".mysql_real_escape_string($Result['visitor_team_goal'])."',
								AsianHandicap = '".mysql_real_escape_string($handicap)."',
								date_update = '".date('Y-m-d H:i:s')."',
								Predict='Y'
								WHERE MatchID = '".$Result['id_match']."' AND Status!='-1'
								";
								$query=mysql_query($sql) or die(mysql_error());
								
								mysql_query("UPDATE  soccer_match SET FT = '".$status."' where id_match='".$Result['id_match']."' ");
					
				//echo '<pre>';echo $sql;echo '</pre>';
		 break;
		 
			
		}/*else if($sum<0.41){
			
			
			$i++;
		$datetime = strtotime ('+7hours',strtotime($Result['date_match']." ".$Result['time_match']));
echo '<hr>'.$i.': '.$Result['id_match'].'';
		 
		 if($Result['status']!='' and strlen($Result['status'])=='5'){
		 $status = 0;
		 }else if($Result['status']!='' and $Result['status']>=1 and $Result['status']<=45){
		 $status = 1;
		 }else if($Result['status']!='' and $Result['status']=='HT'){
		 $status = 2;
		 	mysql_query("update matchHDC set ScoreHomeHalfTime='".$Result['local_team_goal']."' , ScoreAwayHalfTime='".$Result['visitor_team_goal']."' where MatchID='".$Result['id_match']."' ");
			
			
		}else if($Result['status']!='' and $Result['status']>=45 and $Result['status']<=90){
			$status = 3;
		}else if($Result['status']!='' and $Result['status']=='FT'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='ET'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='AET'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='P'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='Pen.'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='Postp.'){
			$status = '0';
		}else if($Result['status']!='' and $Result['status']=='Cancl.'){
			$status = '-14';
		}else if($Result['status']!='' and $Result['status']=='Aban.'){
			$status = '-13';
		}else if($Result['status']!='' and $Result['status']=='Break Time'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='Int.'){
			$status = '2';
		}
		$leasho = str_replace("-", "", $Result['League']);
		$leasho = explode(" ", $leasho);
		$leasho1 = substr($leasho[0], 0, 1);
		$leasho2 = substr($leasho[1], 0, 1);
		$leasho3 = substr($leasho[2], 0, 1);
		$leasho4 = substr($leasho[3], 0, 1);
		$leasho5 = substr($leasho[4], 0, 1);
		$leasho6 = substr($leasho[5], 0, 1);
		$leasho7 = substr($leasho[6], 0, 1);
		
		$leashort = $leasho1.$leasho2.$leasho3.$leasho4.$leasho5.$leasho6.$leasho7;
		$count=0;
		
		
		$sqlck="SELECT COUNT(code) AS cnt FROM matchHDC  WHERE MatchID = '".$Result['id_match']."' ";
							//echo $sqlck;
							$queryck = mysql_query($sqlck);
							$row=mysql_fetch_array($queryck);
								$count = $row['cnt'];
							 
		 		echo "####".$Result['status']." - ".$status."####";
				if($count == 0){
								
								$sql="
								INSERT  INTO matchHDC SET
								LeagueShortName = '".$leashort."',
								LeagueEngName = '".$Result['League']."',
								MatchID='".$Result['id_match']."',
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								HomeName = '".mysql_real_escape_string($Result['local_team_name'])."',
								AwayName = '".mysql_real_escape_string($Result['visitor_team_name'])."',
								ScoreHomeFullTime='".$Result['local_team_goal']."',
								ScoreAwayFulltime='".$Result['visitor_team_goal']."',
								Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
								AsianHandicap = '".mysql_real_escape_string($handicap)."',
								date_save = '".mysql_real_escape_string(date('Y-m-d H:i:s'))."',
								date_create = '".date('Y-m-d H:i:s')."',
								date_update = '".date('Y-m-d H:i:s')."',
								enable = 'Y'
								";
								$query=mysql_query($sql) or die(mysql_error());

							}else{
								
								$sql="
								UPDATE  matchHDC  SET
								LeagueShortName = '".$leashort."',
								LeagueEngName = '".$Result['League']."',
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								HomeName = '".mysql_real_escape_string($Result['local_team_name'])."',
								AwayName = '".mysql_real_escape_string($Result['visitor_team_name'])."',
								ScoreHomeFullTime='".$Result['local_team_goal']."',
								ScoreAwayFulltime='".$Result['visitor_team_goal']."',
								Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
								AsianHandicap = '".mysql_real_escape_string($handicap)."',
								date_save = '".mysql_real_escape_string(date('Y-m-d H:i:s'))."',
								date_update = '".date('Y-m-d H:i:s')."'
								WHERE MatchID = '".$Result['id_match']."' AND Status!='-1'
								";
								$query=mysql_query($sql) or die(mysql_error());
							}
				echo '<pre>';echo $sql;echo '</pre>';
		 break;
		 
		 
		}else if($sum<0.61){
			
			
			$i++;
		$datetime = strtotime ('+7hours',strtotime($Result['date_match']." ".$Result['time_match']));
echo '<hr>'.$i.': '.$Result['id_match'].'';
		 
		 if($Result['status']!='' and strlen($Result['status'])=='5'){
		 $status = 0;
		 }else if($Result['status']!='' and $Result['status']>=1 and $Result['status']<=45){
		 $status = 1;
		 }else if($Result['status']!='' and $Result['status']=='HT'){
		 $status = 2;
		 	mysql_query("update matchHDC set ScoreHomeHalfTime='".$Result['local_team_goal']."' , ScoreAwayHalfTime='".$Result['visitor_team_goal']."' where MatchID='".$Result['id_match']."' ");
			
			
		}else if($Result['status']!='' and $Result['status']>=45 and $Result['status']<=90){
			$status = 3;
		}else if($Result['status']!='' and $Result['status']=='FT'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='ET'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='AET'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='P'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='Pen.'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='Postp.'){
			$status = '0';
		}else if($Result['status']!='' and $Result['status']=='Cancl.'){
			$status = '-14';
		}else if($Result['status']!='' and $Result['status']=='Aban.'){
			$status = '-13';
		}else if($Result['status']!='' and $Result['status']=='Break Time'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='Int.'){
			$status = '2';
		}
		$leasho = str_replace("-", "", $Result['League']);
		$leasho = explode(" ", $leasho);
		$leasho1 = substr($leasho[0], 0, 1);
		$leasho2 = substr($leasho[1], 0, 1);
		$leasho3 = substr($leasho[2], 0, 1);
		$leasho4 = substr($leasho[3], 0, 1);
		$leasho5 = substr($leasho[4], 0, 1);
		$leasho6 = substr($leasho[5], 0, 1);
		$leasho7 = substr($leasho[6], 0, 1);
		
		$leashort = $leasho1.$leasho2.$leasho3.$leasho4.$leasho5.$leasho6.$leasho7;
		$count=0;
		
		
		$sqlck="SELECT COUNT(code) AS cnt FROM matchHDC  WHERE MatchID = '".$Result['id_match']."' ";
							//echo $sqlck;
							$queryck = mysql_query($sqlck);
							$row=mysql_fetch_array($queryck);
								$count = $row['cnt'];
							 
		 		echo "####".$Result['status']." - ".$status."####";
				if($count == 0){
								
								$sql="
								INSERT  INTO matchHDC SET
								LeagueShortName = '".$leashort."',
								LeagueEngName = '".$Result['League']."',
								MatchID='".$Result['id_match']."',
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								HomeName = '".mysql_real_escape_string($Result['local_team_name'])."',
								AwayName = '".mysql_real_escape_string($Result['visitor_team_name'])."',
								ScoreHomeFullTime='".$Result['local_team_goal']."',
								ScoreAwayFulltime='".$Result['visitor_team_goal']."',
								Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
								AsianHandicap = '".mysql_real_escape_string($handicap)."',
								date_save = '".mysql_real_escape_string(date('Y-m-d H:i:s'))."',
								date_create = '".date('Y-m-d H:i:s')."',
								date_update = '".date('Y-m-d H:i:s')."',
								enable = 'Y'
								";
								$query=mysql_query($sql) or die(mysql_error());

							}else{
								
								$sql="
								UPDATE  matchHDC  SET
								LeagueShortName = '".$leashort."',
								LeagueEngName = '".$Result['League']."',
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								HomeName = '".mysql_real_escape_string($Result['local_team_name'])."',
								AwayName = '".mysql_real_escape_string($Result['visitor_team_name'])."',
								ScoreHomeFullTime='".$Result['local_team_goal']."',
								ScoreAwayFulltime='".$Result['visitor_team_goal']."',
								Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
								AsianHandicap = '".mysql_real_escape_string($handicap)."',
								date_save = '".mysql_real_escape_string(date('Y-m-d H:i:s'))."',
								date_update = '".date('Y-m-d H:i:s')."'
								WHERE MatchID = '".$Result['id_match']."' AND Status!='-1'
								";
								$query=mysql_query($sql) or die(mysql_error());
							}
				echo '<pre>';echo $sql;echo '</pre>';
		 break;
		 
		 
		}else{
			$i++;
		$datetime = strtotime ('+7hours',strtotime($Result['date_match']." ".$Result['time_match']));
echo '<hr>'.$i.': '.$Result['id_match'].'';
		 
		 if($Result['status']!='' and strlen($Result['status'])=='5'){
		 $status = 0;
		 }else if($Result['status']!='' and $Result['status']>=1 and $Result['status']<=45){
		 $status = 1;
		 }else if($Result['status']!='' and $Result['status']=='HT'){
		 $status = 2;
		 	mysql_query("update matchHDC set ScoreHomeHalfTime='".$Result['local_team_goal']."' , ScoreAwayHalfTime='".$Result['visitor_team_goal']."' where MatchID='".$Result['id_match']."' ");
			
			
		}else if($Result['status']!='' and $Result['status']>=45 and $Result['status']<=90){
			$status = 3;
		}else if($Result['status']!='' and $Result['status']=='FT'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='ET'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='AET'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='P'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='Pen.'){
			$status = '-1';
		}else if($Result['status']!='' and $Result['status']=='Postp.'){
			$status = '0';
		}else if($Result['status']!='' and $Result['status']=='Cancl.'){
			$status = '-14';
		}else if($Result['status']!='' and $Result['status']=='Aban.'){
			$status = '-13';
		}else if($Result['status']!='' and $Result['status']=='Break Time'){
			$status = '3';
		}else if($Result['status']!='' and $Result['status']=='Int.'){
			$status = '2';
		}
		$leasho = str_replace("-", "", $Result['League']);
		$leasho = explode(" ", $leasho);
		$leasho1 = substr($leasho[0], 0, 1);
		$leasho2 = substr($leasho[1], 0, 1);
		$leasho3 = substr($leasho[2], 0, 1);
		$leasho4 = substr($leasho[3], 0, 1);
		$leasho5 = substr($leasho[4], 0, 1);
		$leasho6 = substr($leasho[5], 0, 1);
		$leasho7 = substr($leasho[6], 0, 1);
		
		$leashort = $leasho1.$leasho2.$leasho3.$leasho4.$leasho5.$leasho6.$leasho7;
		$count=0;
		
		
		$sqlck="SELECT COUNT(code) AS cnt FROM matchHDC  WHERE MatchID = '".$Result['id_match']."' ";
							//echo $sqlck;
							$queryck = mysql_query($sqlck);
							$row=mysql_fetch_array($queryck);
								$count = $row['cnt'];
							 
		 		echo "####".$Result['status']." - ".$status."####";
				if($count == 0){
								
								$sql="
								INSERT  INTO matchHDC SET
								LeagueShortName = '".$leashort."',
								LeagueEngName = '".$Result['League']."',
								MatchID='".$Result['id_match']."',
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								HomeName = '".mysql_real_escape_string($Result['local_team_name'])."',
								AwayName = '".mysql_real_escape_string($Result['visitor_team_name'])."',
								ScoreHomeFullTime='".$Result['local_team_goal']."',
								ScoreAwayFulltime='".$Result['visitor_team_goal']."',
								Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
								AsianHandicap = '".mysql_real_escape_string($handicap)."',
								date_save = '".mysql_real_escape_string(date('Y-m-d H:i:s'))."',
								date_create = '".date('Y-m-d H:i:s')."',
								date_update = '".date('Y-m-d H:i:s')."',
								enable = 'Y',
								Predict='N'
								";
								$query=mysql_query($sql) or die(mysql_error());

							}else{
								
								$sql="
								UPDATE  matchHDC  SET
								LeagueShortName = '".$leashort."',
								LeagueEngName = '".$Result['League']."',
								Status = '".mysql_real_escape_string($status)."',
								Playtime = '".mysql_real_escape_string($Result['status'])."',
								HomeName = '".mysql_real_escape_string($Result['local_team_name'])."',
								AwayName = '".mysql_real_escape_string($Result['visitor_team_name'])."',
								ScoreHomeFullTime='".$Result['local_team_goal']."',
								ScoreAwayFulltime='".$Result['visitor_team_goal']."',
								Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
								AsianHandicap = '".mysql_real_escape_string($handicap)."',
								date_save = '".mysql_real_escape_string(date('Y-m-d H:i:s'))."',
								date_update = '".date('Y-m-d H:i:s')."',
								Predict='N'
								WHERE MatchID = '".$Result['id_match']."' AND Status!='-1'
								";
								$query=mysql_query($sql) or die(mysql_error());
							}
				echo '<pre>';echo $sql;echo '</pre>';
		 break;
		}*/
		
		
	}
}
mysql_close($conn);

?>
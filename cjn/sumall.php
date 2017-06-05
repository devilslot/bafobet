<?php
//include('config_cronjob.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
/*
$Query = mysql_query("select * from soccer_match");
$i=0;
while($Result = mysql_fetch_array($Query)){

	$objQuery = mysql_query("select * from soccer_odds where id_match='".$Result['id_match']."' order by code desc ");
	while($objResult = mysql_fetch_array($objQuery)){
		
		$sum =$objResult['handicap_odd_value']-$objResult['handicap_odd_value2'];
		if(strlen(number_format($sum,2))=='5'){ $oddshandicap = $objResult['handicap_odd_handicap2']; }else{ $oddshandicap = $objResult['handicap_odd_handicap2']; }
		$sum  = str_replace("-", "", $sum );
		
		if($sum<0.21){
		$i++;
		$datetime = strtotime ('+7hours',strtotime($Result['date_match']." ".$Result['time_match']));
echo '<hr>'.$i.': '.$Result['id_match'].'';

			echo "status = '".$Result['status']."',<br>
			date_match_org = '".$Result['date_match']."',<br>
			time_match_org = '".$Result['time_match']."',<br>
			date_match_+7 = '".date('Y-m-d' , $datetime)."',<br>
			time_match_+7 = '".date('H:i' , $datetime)."',<br>
			static_id = '".$Result['static_id']."',<br>
			fix_id = '".$Result['fix_id']."',<br>
			id_match = '".$Result['id_match']."',<br>
			local_team_name = '".$Result['local_team_name']."',<br>
			local_team_goal = '".$Result['local_team_goal']."',<br>
			local_team_id = '".$Result['local_team_id']."',<br>
			visitor_team_name = '".$Result['visitor_team_name']."',<br>
			visitor_team_goal = '".$Result['visitor_team_goal']."',<br>
			visitor_team_id = '".$Result['visitor_team_id']."',<br>
			ht = '".$Result['ht']."'<br>
			timeUpdate = '".$Result['date_update']."'<br>";
			
			
		 echo '  -  Odds:'.$oddshandicap;
		 echo '<br>  -  Odds Value:'.$objResult['handicap_odd_value'];
		 echo '<br>  -  Odds Value:'.$objResult['handicap_odd_value2'];
		 
		 if($Result['status']!='' and strlen($Result['status'])=='5'){
		 $status = 0;
		 }else if($Result['status']!='' and $Result['status']>=1 and $Result['status']<=45){
		 $status = 1;
		 }else if($Result['status']!='' and $Result['status']=='HT'){
		 $status = 2;
		 	mysql_query("update matchHDC set ScoreHomeHalfTime='".$Result['local_team_goal']."' , ScoreAwayHalfTime='".$Result['visitor_team_goal']."' where MatchID='".$Result['id_match']."' ");
			
			echo "update matchHDC set ScoreHomeHalfTime='".$Result['local_team_goal']."' , ScoreAwayHalfTime='".$Result['visitor_team_goal']."' where MatchID='".$Result['id_match']."' ";
			
			
		}else if($Result['status']!='' and $Result['status']>=45 and $Result['status']<=90){
		$status = 3;
		}else if($Result['status']!='' and $Result['status']=='FT'){
		$status = '-1';
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
		//$handicap = str_replace("-", "", $oddshandicap);
		//$handicap = str_replace("+", "-", $handicap);
		//$handicap = $oddshandicap;
		$handicap = str_replace("+", "", $oddshandicap);
		
		
		$sqlck="SELECT COUNT(code) AS cnt FROM matchHDC  WHERE MatchID = '".$Result['id_match']."' ";
							echo $sqlck;
							$queryck = mysql_query($sqlck);
							$row=mysql_fetch_array($queryck);
								$count = $row['cnt'];
							 
		 		echo "####".$Result['status'].$count.$status."####";
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
		}
	}
}
*/
?>

</body>
</html>

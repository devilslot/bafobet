<?php
date_default_timezone_set("Asia/Bangkok");
include('config_cronjob.php');
$url = "http://www.goalserve.com/getfeed/7633785d0416465f9f8b944b92c30cf2/soccernew/home";
$content =  file_get_contents($url);

  if(!empty ($content)){
    @unlink("xml/match.xml");
	$content = str_replace("\r\n","",$content);
    file_put_contents('xml/match.xml', $content);
    echo 'complete'; 
  }else{
    echo 'fail';
  }
  
 
$xml = json_decode(json_encode(simplexml_load_file('xml/match.xml')), true);
$l=0;
foreach ($xml['category'] as $key => $value) {
$l++;

//if($value['matches']['match']['@attributes']['status']!=''){ $arr_match = $xml['category'][$l]['matches']['match']; }else{ $arr_match = $value['matches']['match']; }
	// echo 'count<pre>';print_r($value['matches']['match']);echo '</pre><hr>';
	 $a=0;
	// echo count($arr_match);
	for($a=0;$a<count($value['matches']['match']);$a++){
	
	//foreach ($arr_match as $key2 => $value2) {
	//$a++;
	
	$League = $value['@attributes']['name'];
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
		
	if($localteamname!='' and (trim($League) != 'Kosovo:Superliga'
		 or trim($League) != 'Burundi:LigueA'
		 or trim($League) != 'Andorra:PrimeraDivisio'
		 or trim($League) != 'Tanzania:LigiKuuBara'
		 or trim($League) != 'Switzerland:1.LigaClassicGroup1'
		 or trim($League) != 'Greece:DivisionC-GroupD'
		 or trim($League) != 'Sweden:Division2-SodraGotaland-Relegation'
		 or trim($League) != 'Germany:JuniorenBundesligaNorth'
		 or trim($League) != 'Ukraine:Division2'
		 or trim($League) != 'Slovakia:DivisonCCentral'
		 or trim($League) != 'Slovakia:DivisonCEast'
		 or trim($League) != 'Mauritius:MaruitianLeague'
		 or trim($League) != 'Germany:OrberligaHamburg'
		 or trim($League) != 'Slovakia:DivisonCWest'
		 or trim($League) != 'Europe:PremierLeague(Crimea)'
		 or trim($League) != 'Greece:DivisionC-GroupB'
		 or trim($League) != 'Lebanon:PremierLeague'
		 or trim($League) != 'Cyprus:Division2'
		 or trim($League) != 'Italy:SerieD-GroupG'
		 or trim($League) != 'Malawi:SuperLeague'
		 or trim($League) != 'BosniaAndHerzegovina:Fbih'
		 or trim($League) != 'Switzerland:1.LigaClassicGroup2'
		 or trim($League) != 'Germany:OrberligaMittelrhein'
		 or trim($League) != 'Serbia:PrvaLiga'
		 or trim($League) != 'Lesotho:PremierLeague'
		 or trim($League) != 'Italy:SerieD-GroupE'
		 or trim($League) != 'Italy:SerieD-GroupD'
		 or trim($League) != 'Italy:SerieD-GroupF'
		 or trim($League) != 'Bulgaria:VtoraLiga'
		 or trim($League) != 'Italy:SerieD-GroupC'
		 or trim($League) != 'Italy:SerieD-GroupB'
		 or trim($League) != 'Italy:SerieD-GroupA'
		 or trim($League) != 'Belgium:SecondAmateurDivisionGroupAcff'
		 or trim($League) != 'Belgium:SecondAmateurDivisionGroupVfvB'
		 or trim($League) != 'Belgium:SecondAmateurDivisionGroupVfvA'
		 or trim($League) != 'Belgium:FirstAmateurDivision'
		 or trim($League) != 'Togo:ChampionnatNational'
		 or trim($League) != 'SanMarino:CampionatoSammarinese'
		 or trim($League) != 'Poland:IiiLiga-GroupIii'
		 or trim($League) != 'Greece:FootballLeague'
		 or trim($League) != 'Germany:OberligaNiederrhein'
		 or trim($League) != 'Mozambique:Mocambola'
		 or trim($League) != 'SouthAfrica:TelkomKnockout'
		 or trim($League) != 'Germany:OberligaBayernSud'
		 or trim($League) != 'Germany:OberligaBayernNord'
		 or trim($League) != 'Slovakia:DivisionCBratislava'
		 or trim($League) != 'Germany:OberligaWestfalen'
		 or trim($League) != 'Germany:OberligaNiedersachsen'
		 or trim($League) != 'Malta:FaTrophy'
		 or trim($League) != 'DrCongo:SuperLigue'
		 or trim($League) != 'CzechRepublic:DivisionA'
		 or trim($League) != 'CzechRepublic:DivisionB'
		 or trim($League) != 'CzechRepublic:DivisionC'
		 or trim($League) != 'Swazliand:MtnPremierLeague'
		 or trim($League) != 'SouthAfrica:FirstDivision'
		 or trim($League) != 'Rwanda:NationalFootballLeague'
		 or trim($League) != 'Montenegro:Division2'
		 or trim($League) != 'Angola:Girabola'
		 )){
	echo '<pre>'.$a.':'.$localteamname.'-'.$visitorteamname;echo '</pre>';
		
		
		
		
		$temp =explode('.', $formatted_date);
		$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
		
		$sqlckm="SELECT MatchID,Predict,AsianHandicap,Status FROM matchHDC  WHERE MatchID = '".$id."' AND MatchID!='' ";
		$queryckm = mysql_query($sqlckm);
		$rowm=mysql_fetch_array($queryckm);
		echo $rowm['Status'];
		if($rowm['Status']!='-1'){
			$datetime = strtotime ('+7hours',strtotime($date." ".$time));
			$datetimeout = strtotime ('+10hours',strtotime($date." ".$time));
			 
			 if($status!='' and strlen($status)=='5'){
				$statusss = 0;
			 }else if($status!='' and $status>=1 and $status<=45){
				$statusss = 1;
			 }else if($status!='' and $status=='HT'){
				$statusss = 2;
				mysql_query("update matchHDC set ScoreHomeHalfTime='".$localteamgoals."' , ScoreAwayHalfTime='".$visitorteamgoals."' where MatchID='".$id."' ");
				
			}else if($status!='' and $status>=45 and $status<=90){
				$statusss = 3;
			}else if($status!='' and $status=='FT'){
				$statusss = '-1';
			}else if($status!='' and $status=='ET'){
				$statusss = '-1';
			}else if($status!='' and $status=='AET'){
				$statusss = '-1';
			}else if($status!='' and $status=='P'){
				$statusss = '-1';
			}else if($status!='' and $status=='Pen.'){
				$statusss = '-1';
			}else if($status!='' and $status=='Postp.'){
				$statusss = '0';
			}else if($status!='' and $status=='Cancl.'){
				$statusss = '-14';
			}else if($status!='' and $status=='Aban.'){
				$statusss = '-13';
			}else if($status!='' and $status=='Break Time'){
				$statusss = '3';
			}else if($status!='' and $status=='Int.'){
				$statusss = '2';
			}
			
			$tout = ($datetimeout-time());
			
			if($tout<0 and $statusss!='-1'){
				$statusss = 'Und';
			}
			$leasho = str_replace("-", "", $League);
			$leasho = explode(" ", $leasho);
			$leasho1 = substr($leasho[0], 0, 3);
			$leasho2 = substr($leasho[1], 0, 2);
			$leasho3 = substr($leasho[2], 0, 1);
			$leasho4 = substr($leasho[3], 0, 1);
			$leasho5 = substr($leasho[4], 0, 1);
			$leasho6 = substr($leasho[5], 0, 1);
			$leasho7 = substr($leasho[6], 0, 1);
			
			$leashort = $leasho1.' '.$leasho2.''.$leasho3.''.$leasho4;
		$sql='';
			if(empty($rowm['MatchID'])){
				$sql="
					INSERT  INTO matchHDC SET
					LeagueShortName = '".mysql_real_escape_string($leashort)."',
					LeagueEngName = '".mysql_real_escape_string($League)."',
					MatchID='".mysql_real_escape_string($id)."',
					Status = '".mysql_real_escape_string($statusss)."',
					Playtime = '".mysql_real_escape_string($status)."',
					HomeName = '".mysql_real_escape_string($localteamname)."',
					AwayName = '".mysql_real_escape_string($visitorteamname)."',
					ScoreHomeFullTime='".mysql_real_escape_string($localteamgoals)."',
					ScoreAwayFulltime='".mysql_real_escape_string($visitorteamgoals)."',
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
			//echo $rowm['Predict']."|".$rowm['MatchID']."|".$id;
			if($rowm['Predict']=='N' and $rowm['MatchID']==$id ){		
				$matchid = $id;
				$objQuery = mysql_query("select * from soccer_odds where id_match='".$matchid."' AND handicap_odd_handicap!='' AND handicap_odd_handicap2!='' order by code asc ");
				while($objResult = mysql_fetch_array($objQuery)){
					//echo "where id_match='".$matchid."'";
					$sum =$objResult['handicap_odd_value']-$objResult['handicap_odd_value2'];
					
					$handicap = str_replace("", "", $objResult['handicap_odd_handicap2']);
					$handicap = str_replace("+", "", $handicap);
					if($handicap==''){ $handicap=0; }
					$sum  = str_replace("-", "", $sum );
					
					//echo "lll:".$sum;
					$sql2='';
					if($sum<0.41){
						$sql2="
							UPDATE  matchHDC  SET
							Status = '".mysql_real_escape_string($statusss)."',
							Playtime = '".mysql_real_escape_string($status)."',
							ScoreHomeFullTime='".mysql_real_escape_string($localteamgoals)."',
							ScoreAwayFulltime='".mysql_real_escape_string($visitorteamgoals)."',
							AsianHandicap = '".mysql_real_escape_string($handicap)."',
							Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
							date_update = '".date('Y-m-d H:i:s')."',
							Predict='Y'
							WHERE MatchID = '".$matchid."' AND Status!='-1'
							";
							$query2=mysql_query($sql2) or die(mysql_error());	
							break;	
					}
					
					
				}
				}
				
				
				
				$sql="
					UPDATE  matchHDC  SET
					Status = '".mysql_real_escape_string($statusss)."',
					Playtime = '".mysql_real_escape_string($status)."',
					ScoreHomeFullTime='".mysql_real_escape_string($localteamgoals)."',
					ScoreAwayFulltime='".mysql_real_escape_string($visitorteamgoals)."',
					Date = '".mysql_real_escape_string(date('Y-m-d H:i' , $datetime))."',
					".$pstat."
					date_update = '".date('Y-m-d H:i:s')."'
					
					WHERE MatchID = '".$id."' AND Status!='-1' 
				";
				$query=mysql_query($sql) or die(mysql_error());
			}
			echo 'sql1<pre>';print_r($sql);echo '</pre><br>';		
			echo 'sql2<pre>';print_r($sql2);echo '</pre><hr>'; 
			$sql ='';
			$sql2='';
		}
		}else{ echo 'ห้าม<hr>'; }
	
	}

	
}
echo "ok";

mysql_close($conn);

?>
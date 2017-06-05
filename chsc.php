<?php
require_once "service/service.php";
require_once "creation/creation.init.php";

$MatchID='2261760';
$ScoreHomeFulltime='0';
$ScoreAwayFulltime='1';

##2261171 สำหรับคนที่เสีย RANK##
$sqlup="UPDATE matchHDC SET ScoreHomeFullTime='".$ScoreHomeFulltime."' , ScoreAwayFulltime='".$ScoreAwayFulltime."' WHERE MatchID='".$MatchID."' ;";
$queryup=mysql_query($sqlup,$conn);

$sql="SELECT * FROM playgame WHERE MatchID = '".$MatchID."';";
$query=mysql_query($sql,$conn);
while($madata=mysql_fetch_assoc($query)){
		
	if($madata['status']=='2'){
		
		##2261171 สำหรับคนที่เสีย RANK##
		if($madata['gametype']=='rank'){
		
			$rankscore = (2*$madata['winloss'])*-1;
			
			$sqlup1="UPDATE members SET rank=rank+".$rankscore."   WHERE code=".$madata['memberID']." ;";
			$queryup=mysql_query($sqlup1,$conn);
			
			$sqlup2="UPDATE members_score SET rank=rank+".$rankscore."  WHERE months=1 AND years=2017 AND memberID=".$madata['memberID']." ;";
			$queryup=mysql_query($sqlup2,$conn);
		
		}
		
		## สำหรับคนที่เสีย POINT##
		if($madata['gametype']=='point'){
		
			$pointscore = ($madata['point']*$madata['winloss']);
			
			$sqlup3="UPDATE members SET score=score+".$pointscore."   WHERE code=".$madata['memberID']." ;";
			$queryup=mysql_query($sqlup3,$conn);
			
			$sqlup4="UPDATE members_score SET point=point+".$pointscore."  WHERE months=1 AND years=2017 AND memberID=".$madata['memberID'].";";
			$queryup=mysql_query($sqlup4,$conn);
			echo $sqlup4.'<br>';
		
		}
		
		
		
	}elseif($madata['status']=='1'){
		##2261171 สำหรับคนที่เสีย RANK##
			if($madata['gametype']=='rank'){
			
				$rankscore = (2*$madata['winloss']);
				
				$sqlup5="UPDATE members SET rank=rank-".$rankscore."   WHERE code=".$madata['memberID']." ;";
				$queryup=mysql_query($sqlup5,$conn);
				
				$sqlup="UPDATE members_score SET rank=rank-".$rankscore."  WHERE months=1 AND years=2017 AND memberID=".$madata['memberID']." ;";
				$queryup=mysql_query($sqlup,$conn);
			
			}
			
			## สำหรับคนที่เสีย POINT##
			if($madata['gametype']=='point'){
			
				$pointscore = ($madata['point']*$madata['winloss']);
				
				$sqlup6="UPDATE members SET score=score-".$pointscore."   WHERE code=".$madata['memberID']." ;";
				$queryup=mysql_query($sqlup6,$conn);
				
				$sqlup="UPDATE members_score SET point=point-".$pointscore."  WHERE months=1 AND years=2017 AND memberID=".$madata['memberID'].";";
				$queryup=mysql_query($sqlup,$conn);
				echo $sqlup6.'<br>';
			
			}
			
	}
	
	$sqlup7="UPDATE playgame SET winloss='0.00', status='Can', cal='1' WHERE code=".$madata['code'].";";
	$queryup=mysql_query($sqlup7,$conn);
	
	echo "<hr>";

}


 
?>
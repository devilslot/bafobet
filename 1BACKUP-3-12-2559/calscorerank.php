<?php
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";
/*
$sql="
SELECT
pg.code,pg.matchID,pg.memberID,pg.bet,pg.hdc,pg.point,mh.Status,mh.ScoreHomeFullTime,mh.ScoreAwayFulltime
FROM
playgamerank pg,matchHDC mh
WHERE
mh.Status = '-1' AND
pg.cal = '0' AND
pg.matchID = mh.MatchID
ORDER BY
pg.code
ASC
;";
*/
$sql="
SELECT playgamerank.code,playgamerank.matchID,playgamerank.memberID,playgamerank.bet,playgamerank.hdc,playgamerank.point,matchHDC.Status,matchHDC.ScoreHomeFullTime,matchHDC.ScoreAwayFulltime,playgamerank.cal
FROM playgamerank
LEFT JOIN matchHDC
ON playgamerank.matchID = matchHDC.MatchID
WHERE playgamerank.cal = '0' AND playgamerank.matchID = matchHDC.MatchID AND matchHDC.Status='-1'
;";

//echo "<br>sql : ".$sql."<br><Br>";
$query=mysql_query($sql);
while($row=mysql_fetch_assoc($query)){
//echo "<br><br><hr><br><br>";

//echo "<br>BET ".$row['bet']."<br>";
//echo "hdc ".$row['hdc']."<br>";
//echo "Score ".$row['ScoreHomeFullTime']." - ".$row['ScoreAwayFulltime']."<br>";

	$hdc = $row['hdc'];
	$win=2.0; 
		
	if(strlen($hdc)=='4'){
		
		$hdc = $hdc;
		$teamA = $row['ScoreHomeFullTime'];
		$teamB = $row['ScoreAwayFulltime'];
		$calctype = 'a';
		
	}else{
		
		$hdc = substr($hdc, 1, 4);
		$teamA = $row['ScoreAwayFulltime'];
		$teamB = $row['ScoreHomeFullTime'];
		$calctype = 'b';
		
	}

	$strres = ($teamA-$teamB);
	
	//echo "<br>".$strres;
	#function Calc 
	#0.00
	if($hdc=='0.00'){
		if($strres>='1'){ $scorerank = '2'; }
		if($strres=='0'){ $scorerank = '0'; }
		if($strres<='-1'){ $scorerank = '-2'; }
	}
	
	#0.25
	if($hdc=='0.25'){
		if($strres>='1'){ $scorerank = '2'; }
		if($strres=='0'){ $scorerank = '-1'; }
		if($strres<='-1'){ $scorerank = '-2'; }
	}
	
	#0.50
	if($hdc=='0.50'){
		if($strres>='1'){ $scorerank = '2'; }
		if($strres<='0'){ $scorerank = '-2'; }
	}
	
	#0.75
	if($hdc=='0.75'){
		if($strres>='2'){ $scorerank = '2'; }
		if($strres=='1'){ $scorerank = '1'; }
		if($strres<='0'){ $scorerank = '-2'; }
	}
	
	#1.00
	if($hdc=='1.00'){
		if($strres>='2'){ $scorerank = '2'; }
		if($strres=='1'){ $scorerank = '0'; }
		if($strres<='0'){ $scorerank = '-2'; }
	}
	
	#1.25
	if($hdc=='1.25'){
		if($strres>='2'){ $scorerank = '2'; }
		if($strres=='1'){ $scorerank = '-1'; }
		if($strres<='0'){ $scorerank = '-2'; }
	}
	
	#1.50
	if($hdc=='1.50'){
		if($strres>='2'){ $scorerank = '2'; }
		if($strres<='1'){ $scorerank = '-2'; }
	}
	
	#1.75
	if($hdc=='1.75'){
		if($strres>='3'){ $scorerank = '2'; }
		if($strres=='2'){ $scorerank = '1'; }
		if($strres<='1'){ $scorerank = '-2'; }
	}
	
	#2.00
	if($hdc=='2.00'){
		if($strres>='3'){ $scorerank = '2'; }
		if($strres=='2'){ $scorerank = '0'; }
		if($strres<='1'){ $scorerank = '-2'; }
	}
	
	#2.25
	if($hdc=='2.25'){
		if($strres>='3'){ $scorerank = '2'; }
		if($strres=='2'){ $scorerank = '-1'; }
		if($strres<='1'){ $scorerank = '-2'; }
	}
	
	#2.50
	if($hdc=='2.50'){
		if($strres>='3'){ $scorerank = '2'; }
		if($strres<='2'){ $scorerank = '-2'; }
	}
	
	#2.75
	if($hdc=='2.75'){
		if($strres>='4'){ $scorerank = '2'; }
		if($strres=='3'){ $scorerank = '1'; }
		if($strres<='2'){ $scorerank = '-2'; }
	}
	#3.00
	if($hdc=='3.00'){
		if($strres>='4'){ $scorerank = '2'; }
		if($strres=='3'){ $scorerank = '0'; }
		if($strres<='2'){ $scorerank = '-2'; }
	}
	
	#3.25
	if($hdc=='3.25'){
		if($strres>='4'){ $scorerank = '2'; }
		if($strres=='3'){ $scorerank = '-1'; }
		if($strres<='2'){ $scorerank = '-2'; }
	}
	
	#3.50
	if($hdc=='3.50'){
		if($strres>='4'){ $scorerank = '2'; }
		if($strres<='3'){ $scorerank = '-2'; }
	}
	
	#3.75
	if($hdc=='3.75'){
		if($strres>='5'){ $scorerank = '2'; }
		if($strres=='4'){ $scorerank = '1'; }
		if($strres<='3'){ $scorerank = '-2'; }
	}
	
	#4.00
	if($hdc=='4.00'){
		if($strres>='5'){ $scorerank = '2'; }
		if($strres=='4'){ $scorerank = '0'; }
		if($strres<='3'){ $scorerank = '-2'; }
	}
	
	#4.25
	if($hdc=='4.25'){
		if($strres>='5'){ $scorerank = '2'; }
		if($strres=='4'){ $scorerank = '-1'; }
		if($strres<='3'){ $scorerank = '-2'; }
	}
	
	#4.50
	if($hdc=='4.50'){
		if($strres>='5'){ $scorerank = '2'; }
		if($strres<='4'){ $scorerank = '-2'; }
	}
	
	#4.75
	if($hdc=='4.75'){
		if($strres>='6'){ $scorerank = '2'; }
		if($strres=='5'){ $scorerank = '1'; }
		if($strres<='4'){ $scorerank = '-2'; }
	}
	
	#5.00
	if($hdc=='5.00'){
		if($strres>='6'){ $scorerank = '2'; }
		if($strres=='5'){ $scorerank = '0'; }
		if($strres<='4'){ $scorerank = '-2'; }
	}
	
	#5.25
	if($hdc=='5.25'){
		if($strres>='6'){ $scorerank = '2'; }
		if($strres=='5'){ $scorerank = '-1'; }
		if($strres<='4'){ $scorerank = '-2'; }
	}
	
	#5.50
	if($hdc=='5.50'){
		if($strres>='6'){ $scorerank = '2'; }
		if($strres<='5'){ $scorerank = '-2'; }
	}
	
	#4.75
	if($hdc=='5.75'){
		if($strres>='7'){ $scorerank = '2'; }
		if($strres=='6'){ $scorerank = '1'; }
		if($strres<='5'){ $scorerank = '-2'; }
	}
	
	#5.00
	if($hdc=='6.00'){
		if($strres>='7'){ $scorerank = '2'; }
		if($strres=='6'){ $scorerank = '0'; }
		if($strres<='5'){ $scorerank = '-2'; }
	}
	
	#6.25
	if($hdc=='6.25'){
		if($strres>='7'){ $scorerank = '2'; }
		if($strres=='6'){ $scorerank = '-1'; }
		if($strres<='5'){ $scorerank = '-2'; }
	}
	
	#6.50
	if($hdc=='6.50'){
		if($strres>='7'){ $scorerank = '2'; }
		if($strres<='6'){ $scorerank = '-2'; }
	}
	
	#6.75
	if($hdc=='6.75'){
		if($strres>='8'){ $scorerank = '2'; }
		if($strres=='7'){ $scorerank = '1'; }
		if($strres<='6'){ $scorerank = '-2'; }
	}
	
	#7.00
	if($hdc=='7.00'){
		if($strres>='8'){ $scorerank = '2'; }
		if($strres=='7'){ $scorerank = '0'; }
		if($strres<='6'){ $scorerank = '-2'; }
	}
	
	#7.25
	if($hdc=='7.25'){
		if($strres>='8'){ $scorerank = '2'; }
		if($strres=='7'){ $scorerank = '-1'; }
		if($strres<='6'){ $scorerank = '-2'; }
	}
	
	#7.50
	if($hdc=='7.50'){
		if($strres>='8'){ $scorerank = '2'; }
		if($strres<='7'){ $scorerank = '-2'; }
	}
	
	#7.75
	if($hdc=='7.75'){
		if($strres>='9'){ $scorerank = '2'; }
		if($strres=='8'){ $scorerank = '1'; }
		if($strres<='7'){ $scorerank = '-2'; }
	}
	
	
	echo $scorerank;

if($calctype=='a'){
	if($row['bet'] == "1"){
		$scorepoint = $scorerank;
	}else if($row['bet'] == "2"){
		$scorepoint = ($scorerank*-1);
	}
}

if($calctype=='b'){
	if($row['bet'] == "1"){
		$scorepoint = ($scorerank*-1);
	}else if($row['bet'] == "2"){
		$scorepoint = $scorerank;
	}
}

if($scorepoint=='0'){ $status='0'; }else if($scorepoint>='1'){ $status='1'; }else if($scorepoint<='-1'){ $status='2';  } 
//echo "<br>".$scorepoint."<br>";	



	$sql2 = " UPDATE playgamerank SET winloss = '".$scorepoint."',status = '".$status."', cal = 1 WHERE code = '".$row['code']."' ";
	//$sql2 = " UPDATE playgamerank SET winloss = '".$scorepoint."',status = '".$status."' WHERE code = '".$row['code']."' ";
	mysql_query($sql2);
//echo "<br>sql2 : ".$sql2;
	$sql3 = " UPDATE members SET rank = rank + '".$scorepoint."' WHERE code = '".$row['memberID']."' ";
	mysql_query($sql3);
//echo "<br>sql3 : ".$sql3;


}






$sql="
SELECT playgame.code,playgame.matchID,playgame.memberID,playgame.bet,playgame.hdc,playgame.point,matchHDC.Status,matchHDC.ScoreHomeFullTime,matchHDC.ScoreAwayFulltime,playgame.cal
FROM playgame
LEFT JOIN matchHDC
ON playgame.matchID = matchHDC.MatchID
WHERE playgame.cal = '0' AND playgame.matchID = matchHDC.MatchID 
;";

echo "<br>sql : ".$sql."<br><Br>";
$query=mysql_query($sql);
while($row=mysql_fetch_assoc($query)){
echo "<br><br><hr><br><br>";

echo "<br>BET ".$row['bet']."<br>";
echo "hdc ".$row['hdc']."<br>";
echo "Score ".$row['ScoreHomeFullTime']." - ".$row['ScoreAwayFulltime']."<br>";

	$hdc = $row['hdc'];
	
	$win=2.0; 
	
	
		
	if(strlen($hdc)=='4'){
		
		$hdc = $hdc;
		$teamA = $row['ScoreHomeFullTime'];
		$teamB = $row['ScoreAwayFulltime'];
		$calctype = 'a';
		
	}else{
		
		$hdc = substr($hdc, 1, 4);
		$teamA = $row['ScoreAwayFulltime'];
		$teamB = $row['ScoreHomeFullTime'];
		$calctype = 'b';
		
	}

	$strres = ($teamA-$teamB);
	
	//echo "<br>".$strres;
	#function Calc 
	#0.00
	if($hdc=='0.00'){
		if($strres>='1'){ $scorerank = '2'; }
		if($strres=='0'){ $scorerank = '0'; }
		if($strres<='-1'){ $scorerank = '-2'; }
	}
	
	#0.25
	if($hdc=='0.25'){
		if($strres>='1'){ $scorerank = '2'; }
		if($strres=='0'){ $scorerank = '-1'; }
		if($strres<='-1'){ $scorerank = '-2'; }
	}
	
	#0.50
	if($hdc=='0.50'){
		if($strres>='1'){ $scorerank = '2'; }
		if($strres<='0'){ $scorerank = '-2'; }
	}
	
	#0.75
	if($hdc=='0.75'){
		if($strres>='2'){ $scorerank = '2'; }
		if($strres=='1'){ $scorerank = '1'; }
		if($strres<='0'){ $scorerank = '-2'; }
	}
	
	#1.00
	if($hdc=='1.00'){
		if($strres>='2'){ $scorerank = '2'; }
		if($strres=='1'){ $scorerank = '0'; }
		if($strres<='0'){ $scorerank = '-2'; }
	}
	
	#1.25
	if($hdc=='1.25'){
		if($strres>='2'){ $scorerank = '2'; }
		if($strres=='1'){ $scorerank = '-1'; }
		if($strres<='0'){ $scorerank = '-2'; }
	}
	
	#1.50
	if($hdc=='1.50'){
		if($strres>='2'){ $scorerank = '2'; }
		if($strres<='1'){ $scorerank = '-2'; }
	}
	
	#1.75
	if($hdc=='1.75'){
		if($strres>='3'){ $scorerank = '2'; }
		if($strres=='2'){ $scorerank = '1'; }
		if($strres<='1'){ $scorerank = '-2'; }
	}
	
	#2.00
	if($hdc=='2.00'){
		if($strres>='3'){ $scorerank = '2'; }
		if($strres=='2'){ $scorerank = '0'; }
		if($strres<='1'){ $scorerank = '-2'; }
	}
	
	#2.25
	if($hdc=='2.25'){
		if($strres>='3'){ $scorerank = '2'; }
		if($strres=='2'){ $scorerank = '-1'; }
		if($strres<='1'){ $scorerank = '-2'; }
	}
	
	#2.50
	if($hdc=='2.50'){
		if($strres>='3'){ $scorerank = '2'; }
		if($strres<='2'){ $scorerank = '-2'; }
	}
	
	#2.75
	if($hdc=='2.75'){
		if($strres>='4'){ $scorerank = '2'; }
		if($strres=='3'){ $scorerank = '1'; }
		if($strres<='2'){ $scorerank = '-2'; }
	}
	#3.00
	if($hdc=='3.00'){
		if($strres>='4'){ $scorerank = '2'; }
		if($strres=='3'){ $scorerank = '0'; }
		if($strres<='2'){ $scorerank = '-2'; }
	}
	
	#3.25
	if($hdc=='3.25'){
		if($strres>='4'){ $scorerank = '2'; }
		if($strres=='3'){ $scorerank = '-1'; }
		if($strres<='2'){ $scorerank = '-2'; }
	}
	
	#3.50
	if($hdc=='3.50'){
		if($strres>='4'){ $scorerank = '2'; }
		if($strres<='3'){ $scorerank = '-2'; }
	}
	
	#3.75
	if($hdc=='3.75'){
		if($strres>='5'){ $scorerank = '2'; }
		if($strres=='4'){ $scorerank = '1'; }
		if($strres<='3'){ $scorerank = '-2'; }
	}
	
	#4.00
	if($hdc=='4.00'){
		if($strres>='5'){ $scorerank = '2'; }
		if($strres=='4'){ $scorerank = '0'; }
		if($strres<='3'){ $scorerank = '-2'; }
	}
	
	#4.25
	if($hdc=='4.25'){
		if($strres>='5'){ $scorerank = '2'; }
		if($strres=='4'){ $scorerank = '-1'; }
		if($strres<='3'){ $scorerank = '-2'; }
	}
	
	#4.50
	if($hdc=='4.50'){
		if($strres>='5'){ $scorerank = '2'; }
		if($strres<='4'){ $scorerank = '-2'; }
	}
	
	#4.75
	if($hdc=='4.75'){
		if($strres>='6'){ $scorerank = '2'; }
		if($strres=='5'){ $scorerank = '1'; }
		if($strres<='4'){ $scorerank = '-2'; }
	}
	
	#5.00
	if($hdc=='5.00'){
		if($strres>='6'){ $scorerank = '2'; }
		if($strres=='5'){ $scorerank = '0'; }
		if($strres<='4'){ $scorerank = '-2'; }
	}
	
	#5.25
	if($hdc=='5.25'){
		if($strres>='6'){ $scorerank = '2'; }
		if($strres=='5'){ $scorerank = '-1'; }
		if($strres<='4'){ $scorerank = '-2'; }
	}
	
	#5.50
	if($hdc=='5.50'){
		if($strres>='6'){ $scorerank = '2'; }
		if($strres<='5'){ $scorerank = '-2'; }
	}
	
	#4.75
	if($hdc=='5.75'){
		if($strres>='7'){ $scorerank = '2'; }
		if($strres=='6'){ $scorerank = '1'; }
		if($strres<='5'){ $scorerank = '-2'; }
	}
	
	#5.00
	if($hdc=='6.00'){
		if($strres>='7'){ $scorerank = '2'; }
		if($strres=='6'){ $scorerank = '0'; }
		if($strres<='5'){ $scorerank = '-2'; }
	}
	
	#6.25
	if($hdc=='6.25'){
		if($strres>='7'){ $scorerank = '2'; }
		if($strres=='6'){ $scorerank = '-1'; }
		if($strres<='5'){ $scorerank = '-2'; }
	}
	
	#6.50
	if($hdc=='6.50'){
		if($strres>='7'){ $scorerank = '2'; }
		if($strres<='6'){ $scorerank = '-2'; }
	}
	
	#6.75
	if($hdc=='6.75'){
		if($strres>='8'){ $scorerank = '2'; }
		if($strres=='7'){ $scorerank = '1'; }
		if($strres<='6'){ $scorerank = '-2'; }
	}
	
	#7.00
	if($hdc=='7.00'){
		if($strres>='8'){ $scorerank = '2'; }
		if($strres=='7'){ $scorerank = '0'; }
		if($strres<='6'){ $scorerank = '-2'; }
	}
	
	#7.25
	if($hdc=='7.25'){
		if($strres>='8'){ $scorerank = '2'; }
		if($strres=='7'){ $scorerank = '-1'; }
		if($strres<='6'){ $scorerank = '-2'; }
	}
	
	#7.50
	if($hdc=='7.50'){
		if($strres>='8'){ $scorerank = '2'; }
		if($strres<='7'){ $scorerank = '-2'; }
	}
	
	#7.75
	if($hdc=='7.75'){
		if($strres>='9'){ $scorerank = '2'; }
		if($strres=='8'){ $scorerank = '1'; }
		if($strres<='7'){ $scorerank = '-2'; }
	}
	
	
	echo $scorerank;

if($calctype=='a'){
	if($row['bet'] == "1"){
		$scorepoint = $scorerank;
	}else if($row['bet'] == "2"){
		$scorepoint = ($scorerank*-1);
	}
}

if($calctype=='b'){
	if($row['bet'] == "1"){
		$scorepoint = ($scorerank*-1);
	}else if($row['bet'] == "2"){
		$scorepoint = $scorerank;
	}
}

if($scorepoint=='0'){ $status='0'; }else if($scorepoint>='1'){ $status='1'; $totalpoint=(($row['point']/2)*$scorepoint);  }else if($scorepoint<='-1'){ $status='2'; $totalpoint=($row['point']/2)*(-$scorepoint);  } 
echo "<br>".$scorepoint."<br>";	



	//$sql2 = " UPDATE playgame SET winloss = '".$scorepoint."',status = '".$status."', cal = 1 WHERE code = '".$row['code']."' ";
	$sql2 = " UPDATE playgame SET winloss = '".$scorepoint."',status = '".$status."' WHERE code = '".$row['code']."' ";
	mysql_query($sql2);
echo "<br>sql2 : ".$sql2;
	$sql3 = " UPDATE members SET score = score + '".$totalpoint."' WHERE code = '".$row['memberID']."' ";
	mysql_query($sql3);
echo "<br>sql3 : ".$sql3;


}


?>
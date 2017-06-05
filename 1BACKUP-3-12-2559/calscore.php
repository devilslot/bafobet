<?php
ini_set('max_execution_time', 0);
@session_start();
require_once "service/service.php";
require_once "creation/creation.init.php";
/*
$sql="
SELECT
pg.code,pg.matchID,pg.memberID,pg.bet,pg.hdc,pg.point,mh.Status,mh.ScoreHomeFullTime,mh.ScoreAwayFulltime
FROM
playgame pg,matchHDC mh
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
SELECT playgame.code,playgame.matchID,playgame.memberID,playgame.bet,playgame.hdc,playgame.point,matchHDC.Status,matchHDC.ScoreHomeFullTime,matchHDC.ScoreAwayFulltime,playgame.cal,playgame.user_create,playgame.date_create,playgame.gametype
FROM playgame
LEFT JOIN matchHDC
ON playgame.matchID = matchHDC.MatchID
WHERE playgame.matchID = matchHDC.MatchID AND matchHDC.Status='-1' AND playgame.cal = '0' 
ORDER BY playgame.date_create asc
;";

echo "<br>sql : ".$sql."<br><Br>";
$query=mysql_query($sql);
while($row=mysql_fetch_assoc($query)){
//echo "<br><br><hr><br><br>";

//echo "<br>BET ".$row['bet']."<br>";
//echo "hdc ".$row['hdc']."<br>";
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
	
	
	//echo $scorerank;

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




if($row['gametype']=='rank' or $row['gametype']=='even' ){
if($scorepoint=='0'){ $status='3'; }else if($scorepoint>='1'){ $status='1'; }else if($scorepoint<='-1'){ $status='2';  } 
//echo "<br>".$scorepoint."<br>";	



	$sql2 = " UPDATE playgame SET winloss = '".($scorepoint/2)."',status = '".$status."', cal = 1 WHERE code = '".$row['code']."' ";
	mysql_query($sql2);
//echo "<br>sql2 : ".$sql2;

	if($row['gametype']=='rank'){
		$sql3 = " UPDATE members SET rank = rank + '".$scorepoint."' WHERE code = '".$row['memberID']."' "; 
		mysql_query($sql3);
	}
//echo "<br>sql3 : ".$sql3;
}else


if($row['gametype']=='point'){

if($scorepoint=='0'){  $status='3'; $totalpoint=$row['point']; }else 
if($scorepoint>='1'){   $status='1'; $totalpoint=(($row['point']*($scorepoint/2))+$row['point']);  }else 
if($scorepoint=='-1'){ $status='2'; $totalpoint=($row['point']/2);  }else 
if($scorepoint=='-2'){  $status='2'; $totalpoint=0;  }
//echo "<br>".$scorepoint."<br>";	






	$sql2 = " UPDATE playgame SET winloss = '".($scorepoint/2)."',status = '".$status."', cal = 1 WHERE code = '".$row['code']."' ";
	//$sql2 = " UPDATE playgame SET winloss = '".$scorepoint."',status = '".$status."' WHERE code = '".$row['code']."' ";
	mysql_query($sql2);
//echo "<br>$status:".$status." | $row['point']:".$row['point']." | $totalpoint:".$totalpoint."<br>";
	$sql3 = " UPDATE members SET score = score + '".$totalpoint."' WHERE code = '".$row['memberID']."' ";
	mysql_query($sql3);
//echo "<br>sql3 : ".$sql3;
	
}

	$yearplay=date('Y',strtotime($row['date_create']));
	$montplay=date('m',strtotime($row['date_create']));
	
	
		
	//echo  $row['date_create']." | yearplay:".$yearplay." | montplay:".$montplay."<br>";
	$sqlm="SELECT * FROM members_score WHERE memberID = '".$row['memberID']."' AND months='".$montplay."' AND years='".$yearplay."';";
  //echo $sqlm;
  $querym=mysql_query($sqlm) or die(mysql_error());
  $num_rows = mysql_num_rows($querym);
	
	
	
	$sqlsr="SELECT * FROM members WHERE code = '".$row['memberID']."' ;";
  	$querysr=mysql_query($sqlsr) or die(mysql_error());
	$rowsr=mysql_fetch_assoc($querysr);
  /*
  print_r($rowsr);*/
  //echo $sqlsr;
	if($num_rows==0){
	$sql4 = " INSERT INTO members_score (point,rank,memberID,months,years,username)VALUES('".mysql_real_escape_string($rowsr['score'])."','".mysql_real_escape_string($rowsr['rank'])."','".$row['memberID']."','".$montplay."','".$yearplay."','".$row['user_create']."') ";
	mysql_query($sql4);
	}else{
	$sql4 = " UPDATE members_score SET rank = '".mysql_real_escape_string($rowsr['rank'])."' , point='".mysql_real_escape_string($rowsr['score'])."' ,date_update ='".date('Y-m-d H:i:s')."' WHERE memberID = '".$row['memberID']."' AND months='".$montplay."' AND years='".$yearplay."' ";
	mysql_query($sql4);
	}
	
	//echo $sql4;
	
	
}




/*

$sql="
SELECT playgame.code,playgame.matchID,playgame.memberID,playgame.bet,playgame.hdc,playgame.point,matchHDC.Status,matchHDC.ScoreHomeFullTime,matchHDC.ScoreAwayFulltime,playgame.cal,playgame.user_create,playgame.date_create
FROM playgame
LEFT JOIN matchHDC
ON playgame.matchID = matchHDC.MatchID
WHERE playgame.matchID = matchHDC.MatchID AND matchHDC.Status='-1' AND playgame.cal = '0' AND playgame.gametype='point'
ORDER BY playgame.date_create asc
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
	
	
	//echo $scorerank;

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

if($scorepoint=='0'){  $status='3'; $totalpoint=$row['point']; }else 
if($scorepoint>='1'){   $status='1'; $totalpoint=(($row['point']*($scorepoint/2))+$row['point']);  }else 
if($scorepoint=='-1'){ $status='2'; $totalpoint=($row['point']/2);  }else 
if($scorepoint=='-2'){  $status='2'; $totalpoint=0;  }
//echo "<br>".$scorepoint."<br>";	






	$sql2 = " UPDATE playgame SET winloss = '".($scorepoint/2)."',status = '".$status."', cal = 1 WHERE code = '".$row['code']."' ";
	//$sql2 = " UPDATE playgame SET winloss = '".$scorepoint."',status = '".$status."' WHERE code = '".$row['code']."' ";
	mysql_query($sql2);
//echo "<br>$status:".$status." | $row['point']:".$row['point']." | $totalpoint:".$totalpoint."<br>";
	$sql3 = " UPDATE members SET score = score + '".$totalpoint."' WHERE code = '".$row['memberID']."' ";
	mysql_query($sql3);
//echo "<br>sql3 : ".$sql3;


	$yearplay=date('Y',strtotime($row['date_create']));
	$montplay=date('m',strtotime($row['date_create']));
	
	$sqlm="
  SELECT
  *
  FROM
  members_score
  WHERE
  memberID = '".$row['memberID']."' AND months='".$montplay."' AND years='".$yearplay."'
  ;";
  //echo $sqlm;
  $ttpoint='';
  $querym=mysql_query($sqlm) or die(mysql_error());
  $rowm=mysql_fetch_assoc($querym);
  $num_rows = mysql_num_rows($querym);
  
	$ttpoint=$totalpoint-$row['point'];
	
	
	if($num_rows==0){
		$fpoint=(1000+$ttpoint);
		$sql4 = " INSERT INTO members_score (point,memberID,months,years,username)VALUES('".$fpoint."','".$row['memberID']."','".$montplay."','".$yearplay."','".$row['user_create']."') ";
		mysql_query($sql4);
	}else{
		$sql4 = " UPDATE members_score SET point = point+'".$ttpoint."',date_update ='".date('Y-m-d H:i:s')."' WHERE memberID = '".$row['memberID']."' AND months='".$montplay."' AND years='".$yearplay."' ";
		mysql_query($sql4);
	}
	
	echo $sql4;

}*/


?>


<?php
/*@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";



$sql="
SELECT
pg.code,pg.matchID,pg.memberID,pg.bet,pg.hdc,pg.point,mh.Status,mh.ScoreHomeFullTime,mh.ScoreAwayFulltime
FROM
playgame pg,matchHDC mh
WHERE
mh.Status = '-1' AND
pg.cal = '0' AND
pg.matchID = mh.MatchID
ORDER BY
pg.code
ASC
;";

echo $sql."<br><Br>";

$query=mysql_query($sql);
while($row=mysql_fetch_object($query)){


	if($row->bet == 1){
		$team_mark ='H';
	}else{
		$team_mark ='A';
	}


	if($row->hdc > 0){
		$convert=$row->hdc;
	}else{
		$convert=$row->hdc * -1;
	}

	if($row->bet == "1"){
		$win=2.0; 
		$bet1 =1;	
	}else if($row->bet == "2"){
		$win=2.0; 
		$bet1 =2;	
	}

	switch($convert) {
		case '0.00': $txt="0+0"; break;
		case '0.25': $txt="0+0.5"; break;
		case '0.50': $txt="0.5+0.5"; break;
		case '0.75': $txt="0.5+1"; break;
		case '1.00': $txt="1+1"; break;
		case '1.25': $txt="1+1.5"; break;
		case '1.50': $txt="1.5+1.5"; break;
		case '1.75': $txt="1.5+2"; break;
		case '2.00': $txt="2+2"; break;
		case '2.25': $txt="2+2.5"; break;
		case '2.50': $txt="2.5+2.5"; break;
		case '2.75': $txt="2.5+3"; break;
		case '3.00': $txt="3+3"; break;
		case '3.25': $txt="3+3.5"; break;
		case '3.50': $txt="3.5+3.5"; break;
		case '3.75': $txt="3.5+4"; break;
		case '4.00': $txt="4+4"; break;
		case '4.25': $txt="4+4.5"; break;
		case '4.50': $txt="4.5+4.5"; break;
		case '4.75': $txt="4.5+5"; break;
		case '5.00': $txt="5+5"; break;
		case '5.25': $txt="5+5.5"; break;
		case '5.50': $txt="5.5+5.5"; break;
		case '5.75': $txt="5.5+6"; break;	
		case '6.00': $txt="6+6"; break;
		case '6.25': $txt="6+6.5"; break;
		case '6.50': $txt="6.5+6.5"; break;
		case '6.75': $txt="6.5+7"; break;	
		case '7.00': $txt="7+7"; break;	
		case '7.25': $txt="7+7.5"; break;	
	}			
	$a= calhdc($txt,$bet1,$row->point,2.0,2.0,$row->ScoreHomeFullTime,$row->ScoreAwayFulltime,$team_mark);
	
	$st=explode("|",$a);

print_r($st);

	$sql2 = " UPDATE playgame SET winloss = '".$st[0]."',status = '".$st[1]."', cal = 1 WHERE code = '".$row->code."' ";
	mysql_query($sql2);

	$sql3 = " UPDATE members SET score = score + '".$st[0]."' WHERE code = '".$row->memberID."' ";
	mysql_query($sql3);

}


$sql="
SELECT
pg.code,pg.matchID,pg.memberID,pg.bet,pg.hdc,pg.point,mh.Status,mh.ScoreHomeFullTime,mh.ScoreAwayFulltime
FROM
playgame pg,matchHDC mh
WHERE
mh.Status = '-1' AND
pg.cal = '0' AND
pg.matchID = mh.MatchID
ORDER BY
pg.code
ASC
;";

echo $sql."<br><Br>";
$query=mysql_query($sql);
while($row=mysql_fetch_object($query)){


	if($row->bet == 1){
		$team_mark ='H';
	}else{
		$team_mark ='A';
	}


	if($row->hdc > 0){
		$convert=$row->hdc;
	}else{
		$convert=$row->hdc * -1;
	}

	if($row->bet == "1"){
		$win=2.0; 
		$bet1 =1;	
	}else if($row->bet == "2"){
		$win=2.0; 
		$bet1 =2;	
	}

	switch($convert) {
		case '0.00': $txt="0+0"; break;
		case '0.25': $txt="0+0.5"; break;
		case '0.50': $txt="0.5+0.5"; break;
		case '0.75': $txt="0.5+1"; break;
		case '1.00': $txt="1+1"; break;
		case '1.25': $txt="1+1.5"; break;
		case '1.50': $txt="1.5+1.5"; break;
		case '1.75': $txt="1.5+2"; break;
		case '2.00': $txt="2+2"; break;
		case '2.25': $txt="2+2.5"; break;
		case '2.50': $txt="2.5+2.5"; break;
		case '2.75': $txt="2.5+3"; break;
		case '3.00': $txt="3+3"; break;
		case '3.25': $txt="3+3.5"; break;
		case '3.50': $txt="3.5+3.5"; break;
		case '3.75': $txt="3.5+4"; break;
		case '4.00': $txt="4+4"; break;
		case '4.25': $txt="4+4.5"; break;
		case '4.50': $txt="4.5+4.5"; break;
		case '4.75': $txt="4.5+5"; break;
		case '5.00': $txt="5+5"; break;
		case '5.25': $txt="5+5.5"; break;
		case '5.50': $txt="5.5+5.5"; break;
		case '5.75': $txt="5.5+6"; break;	
		case '6.00': $txt="6+6"; break;
		case '6.25': $txt="6+6.5"; break;
		case '6.50': $txt="6.5+6.5"; break;
		case '6.75': $txt="6.5+7"; break;	
		case '7.00': $txt="7+7"; break;	
		case '7.25': $txt="7+7.5"; break;	
	}			
	$a= calhdc($txt,$bet1,$row->point,2.0,2.0,$row->ScoreHomeFullTime,$row->ScoreAwayFulltime,$team_mark);
	
	$st=explode("|",$a);

print_r($st);

	$sql2 = " UPDATE playgame SET winloss = '".$st[0]."',status = '".$st[1]."', cal = 1 WHERE code = '".$row->code."' ";
	mysql_query($sql2);

	$sql3 = " UPDATE members SET rank = rank + '".$st[0]."' WHERE code = '".$row->memberID."' ";
	mysql_query($sql3);

}*/
?>
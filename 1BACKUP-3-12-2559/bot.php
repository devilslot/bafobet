<?php
@session_start();
@header("Content-type: text/html; charset=utf-8");

require_once "service/service.php";
require_once "creation/creation.init.php";
$user=array("Season","Yummy","Absolut","hongthong","madoka","ayukawa","KakJung","llnJllSJllSJ","Syona","Eflex");
$point=array("300","500","800","1000","2000","1500");
$date = date('Y-m-d');

## Bot Start ##
$rand_key_user=array_rand($user,4); //Random User ครั้งละ 6 User

for($i=0;$i<=count($rand_key_user);$i++){
	if($user[$rand_key_user[$i]]!=''){
		echo "Username : ".$user[$rand_key_user[$i]]."<br>";
		
		## เริ่มข้อมูล User ##
		$rand_key_point=array_rand($point,1); //Random จำนวน Point ที่ทาย
		$sql="SELECT * FROM members WHERE username = '".$user[$rand_key_user[$i]]."' ;";
		$query=mysql_query($sql,$conn);
		$memberdata=mysql_fetch_assoc($query);
		$fortime = ceil(($memberdata['score']/$point[$rand_key_point])); //หาจำนวนที่ทายผลแต้มได้
		## จบข้อมูล User ##	
		
		
		## GET Point 500 ##
		$dgpt = date('d',strtotime('-12 hours', strtotime(date('Y-m-d H:i:s'))));
		
		if($memberdata['getpoint']!=$dgpt){
			
			$sqlup="UPDATE members SET score='".($memberdata['score']+500)."' , getpoint='".$dgpt."' WHERE code = '".$memberdata['code']."' ;";
			$queryup=mysql_query($sqlup,$conn);
			
			echo $sqlup."<br>";
			
			
			$sqlup2="insert into playgame (matchID,point,winloss,memberID,status,cal,gametype,user_create,user_update,date_create,date_update)value('GETPOINT','500','1.00','".$memberdata['code']."','1','1','point','".$memberdata['username']."','".$memberdata['username']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."') ";
			$queryup2=mysql_query($sqlup2,$conn);
		echo $sqlup2;
			echo "<br> เติม 500 Point สำเร็จ!<br>";
		}
		## GET Point 500 ##
	
	
			
		## ค้นหาคู่บอล ##
		$sql="SELECT * FROM matchHDC WHERE Date >= '".$date." ".date('H:i:s')."' AND unix_timestamp(Date) <= '".$datestop."' AND Status='0' AND Predict='Y' ORDER BY RAND() ";
		$query=mysql_query($sql,$conn);
		$looppoint=0;
		$looprank=0;
		$idat=0;
		while($row=mysql_fetch_assoc($query))
		{
			$idat++;
			$new_time = strtotime($row['Date']);
			$datepost = date('Y-m-d H:i:s',strtotime("-".$idat." minutes"));
			
			
				## ทายผล Point ##
				echo "<br>";
				if($_GET['point']=='Yes' and ($new_time >  time() and $new_time < $datestop))
				{
					## ค้นหาว่าทายผลไปหรือยัง ##
					$sql1="SELECT * FROM playgame WHERE matchID = '".$row['MatchID']."' AND memberID='".$memberdata['code']."' AND gametype='point' ;";
					//echo $sql1;
					$query1=mysql_query($sql1,$conn);
					//$row1=mysql_fetch_assoc($query1);
					$num1=mysql_num_rows($query1);
					## ค้นหาว่าทายผลไปหรือยัง ##
				
					$sql3="SELECT score FROM members WHERE code = '".$memberdata['code']."' ;";
					//echo $sqlm;
					$query3=mysql_query($sql3,$conn) or die(mysql_error());
					$row3=mysql_fetch_assoc($query3);
					  
					  
					if($num1==0)
					{ 
						$looppoint++;  
							
						
						$allpointloop = $allpointloop+$point[$rand_key_point];
						if($row3['score']<=$point[$rand_key_point]){ $scoretry = $row3['score']; }else{ $scoretry = $point[$rand_key_point]; } //คำนวน point ที่ทายผล
						
							if($row3['score']>0)
							{
								$bet = rand(1,2);
								mysql_query("INSERT INTO  playgame (
									matchID, 
									memberID, 
									bet,
									hdc,
									point,
									winloss,
									ip,
									status,
									cal,
									gametype,
									user_create,
									user_update,
									date_create,
									date_update
								) VALUES (
									'".$row['MatchID']."',
									'".$memberdata['code']."',
									'".$bet."',
									'".$row['AsianHandicap']."',
									'".$scoretry."',
									'0.00',
									'".IP()."',
									'0',
									'0',
									'point',
									'".$memberdata['username']."',
									'".$memberdata['username']."',
									'".$datepost."',
									'".$datepost."'
								);");
							
								$sql2 = " UPDATE members SET score = score-'".$scoretry."' WHERE code = '".$memberdata['code']."' ";
								mysql_query($sql2);
						
							}
							else
							{
								echo "Point ไม่เพียงพอในการทายผล | ";
							}
						  
						
					}
					else
					{ 
						echo "ทายผล Point ไปแล้ว | "; 
					}
				}
				else
				{
					echo "ไม่ได้เลือก Type Point หรือหมดเวลา | "; 
				}
				
				
				
				## ทายผล Rank ##
				echo "<br>";
				if($_GET['rank']=='Yes' and ($new_time >  time() and $new_time < $datestop))
				{
					## ค้นหาว่าทายผลไปหรือยัง ##
					$sql2="SELECT * FROM playgame WHERE matchID = '".$row['MatchID']."' AND memberID='".$memberdata['code']."' AND gametype='rank' ;";
					//echo $sql2;
					$query2=mysql_query($sql2,$conn);
					//$row1=mysql_fetch_assoc($query1);
					$num2=mysql_num_rows($query2);
					## ค้นหาว่าทายผลไปหรือยัง ##
				
				
					$sql4="SELECT code FROM playgame WHERE memberID = '".$memberdata['code']."' AND gametype='rank' AND unix_timestamp(date_create) > '".$datestart."' AND unix_timestamp(date_create) < '".$datestop."' ;";
					//echo $sql4;
					$query4=mysql_query($sql4,$conn) or die(mysql_error());
					$num4=mysql_num_rows($query4);
					
					if(($num2==0) and $num4<=5)
					{ 
						$bet = rand(1,2);
						mysql_query("INSERT INTO  playgame (
								matchID, 
								memberID, 
								bet,
								hdc,
								point,
								winloss,
								ip,
								status,
								cal,
								gametype,
								user_create,
								user_update,
								date_create,
								date_update
						) VALUES (
								'".$row['MatchID']."',
								'".$memberdata['code']."',
								'".$bet."',
								'".$row['AsianHandicap']."',
								'0',
								'0.00',
								'".IP()."',
								'0',
								'0',
								'rank',
								'".$memberdata['username']."',
								'".$memberdata['username']."',
								'".$datepost."',
								'".$datepost."'
						);");
						
					}
					else
					{
						if($num4>=5){ echo "ทายผลครบ 5 ครั้งแล้ว | "; }else{ echo "ทายผล Rank ไปแล้ว | "; }
					}
				}
				else
				{
					echo "ไม่ได้เลือก type Rank หรือหมดเวลา |";
				}
			 
			 
			 	
				 if($_GET['point']=='Yes' and $_GET['rank']=='')
				 {
				 	if($looppoint>=$fortime)
					 {
						break;
					 }
				 }
				 else if($_GET['rank']=='Yes' and $_GET['point']=='')
				 {
				 	if($num4>=5 )
					 {
						break;
					 }
				 }
				 else if($_GET['rank']=='Yes' and $_GET['point']=='Yes')
				 {
				 	 if($looppoint>=$fortime and $looprank>=5 )
					 {
						break;
					 }
				 }
				 
				 
				 
			
		}
  
			/*  
			  
			}*/
		//}
	## จบทายผล ##


		echo "<hr />";
	}
}
## Bot Stop ##
?>
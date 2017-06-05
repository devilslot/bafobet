<?php
date_default_timezone_set("Asia/Bangkok");
include('config_cronjob.php');

		$sqlckm="SELECT MatchID,Predict,AsianHandicap,Status,Date FROM matchHDC  WHERE Status='0' AND MatchID!='' ";
		$queryckm = mysql_query($sqlckm);
		while($rowm=mysql_fetch_array($queryckm)){
		
			
			$datetimeout = strtotime ('+3hours',strtotime($rowm['Date']));
			
			$tout = ($datetimeout-time());
			echo $tout."|".$datetimeout."|".$rowm['Date'];
			if($tout<0 and $rowm['Status']!='-1'){
				$statusss = 'Und';
			}else{
				$statusss = '0';
			}

				$sql="
					UPDATE  matchHDC  SET
					Status = '".mysql_real_escape_string($statusss)."',
					date_update = '".date('Y-m-d H:i:s')."'
					WHERE MatchID = '".$rowm['MatchID']."' AND Status!='-1' 
				";
				$query=mysql_query($sql) or die(mysql_error());
			
			echo 'sql1<pre>';print_r($sql);echo '</pre><br>';		
			echo 'sql2<pre>';print_r($sql2);echo '</pre><hr>'; 
		}

mysql_close($conn);

?>
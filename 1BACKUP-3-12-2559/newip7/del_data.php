<?php
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";


$sql="
SELECT id, COUNT( code ) AS cnt, code 
FROM `Tem_league` 
GROUP BY id 
HAVING COUNT( code ) >1 
ORDER BY 2 DESC
;";
$query=@mysql_query($sql);
while($row=mysql_fetch_assoc($query)){
	//echo $row['id'].'<br/>';

	$sql2="
	delete from Tem_league where id = '".$row['id']."' and code <> '".$row['code']."'
	;";
	echo $sql2.'<br/>';
	$query2=@mysql_query($sql2);

}
// พรีเมียร์ลีกอังกฤษ 
@mysql_query(" update Tem_league  SET sort = 10 where id = '36' ;");

@mysql_query(" update Tem_league  SET sort = 11 where id = '67' ;");

@mysql_query(" update Tem_league  SET sort = 12 where id = '103' ;");

@mysql_query(" update Tem_league  SET sort = 13 where id = '113' ;");
@mysql_query(" update Tem_league  SET sort = 14 where id = '109' ;");
@mysql_query(" update Tem_league  SET sort = 15 where id = '650' ;");
@mysql_query(" update Tem_league  SET sort = 16 where id = '648' ;");
@mysql_query(" update Tem_league  SET sort = 17 where id = '652' ;");
@mysql_query(" update Tem_league  SET sort = 18 where id = '651' ;");
@mysql_query(" update Tem_league  SET sort = 19 where id = '653' ;");

// ลาลีก้าสเปน 
@mysql_query(" update  Tem_league  SET sort = 20 where id = '31';");
@mysql_query(" update  Tem_league  SET sort = 21 where id = '88';");
@mysql_query(" update  Tem_league  SET sort = 22 where id = '304';");
// @mysql_query(" update  Tem_league  SET sort = 23 where id = '41';");
@mysql_query(" update  Tem_league  SET sort = 23 where id = '1366';");

// บุนเดสลีก้า เยอรมัน
@mysql_query(" update  Tem_league  SET sort = 30 where id = '8';");
// กัลโช่ เซเรีย อา อิตาลี 
@mysql_query(" update  Tem_league  SET sort = 40 where id = '34';");
// ลีกเอิงฝรั่งเศส
@mysql_query(" update  Tem_league  SET sort = 50 where id = '11';");
// ยูฟ่าแชมป์เปี้ยนลีก
@mysql_query(" update  Tem_league  SET sort = 60 where id = '700';");
//  เอฟเอคัพ 
@mysql_query(" update  Tem_league  SET sort = 70 where id = '90';");
//  แชมเปี้ยนชิพอังกฤษ 
@mysql_query(" update  Tem_league  SET sort = 80 where id = '84';");

@mysql_query(" update  Tem_league  SET sort = 90 where id = '81';");
@mysql_query(" update  Tem_league  SET sort = 100 where id = '51';");
@mysql_query(" update  Tem_league  SET sort = 110 where id = '83';");
@mysql_query(" update  Tem_league  SET sort = 120 where id = '54';");
@mysql_query(" update  Tem_league  SET sort = 130 where id = '37';");
@mysql_query(" update  Tem_league  SET sort = 140 where id = '39';");
@mysql_query(" update  Tem_league  SET sort = 150 where id = '35';");
@mysql_query(" update  Tem_league  SET sort = 160 where id = '33';");
@mysql_query(" update  Tem_league  SET sort = 170 where id = '1413';");
@mysql_query(" update  Tem_league  SET sort = 180 where id = '9';");
@mysql_query(" update  Tem_league  SET sort = 190 where id = '693';");
@mysql_query(" update  Tem_league  SET sort = 200 where id = '40';");
@mysql_query(" update  Tem_league  SET sort = 210 where id = '12';");
@mysql_query(" update  Tem_league  SET sort = 220 where id = '203';");
@mysql_query(" update  Tem_league  SET sort = 230 where id = '78';");
@mysql_query(" update  Tem_league  SET sort = 240 where id = '29';");
@mysql_query(" update  Tem_league  SET sort = 250 where id = '150';");
@mysql_query(" update  Tem_league  SET sort = 260 where id = '59';");
@mysql_query(" update  Tem_league  SET sort = 270 where id = '16';");
@mysql_query(" update  Tem_league  SET sort = 280 where id = '17';");
@mysql_query(" update  Tem_league  SET sort = 290 where id = '70';");
@mysql_query(" update  Tem_league  SET sort = 300 where id = '23';");
@mysql_query(" update  Tem_league  SET sort = 310 where id = '157';");
@mysql_query(" update  Tem_league  SET sort = 320 where id = '108';");
@mysql_query(" update  Tem_league  SET sort = 330 where id = '5';");
@mysql_query(" update  Tem_league  SET sort = 340 where id = '138';");
@mysql_query(" update  Tem_league  SET sort = 350 where id = '22';");
@mysql_query(" update  Tem_league  SET sort = 360 where id = '123';");
@mysql_query(" update  Tem_league  SET sort = 370 where id = '1428';");
@mysql_query(" update  Tem_league  SET sort = 380 where id = '1048';");

?>
<?php
require_once "service/service.php";
require_once "creation/creation.init.php";

$sqls2="SELECT * FROM members";
$querys2=mysql_query($sqls2,$conn);
while($rows2=mysql_fetch_assoc($querys2)){
	mysql_query("INSERT INTO logpoint (memberID,username,point,rank)VALUES( '".$rows2['code']."','".$rows2['username']."','".$rows2['score']."','".$rows2['rank']."' ) ",$conn);
	echo "INSERT INTO logpoint (memberID,username,point,rank)VALUES( '".$rows2['code']."','".$rows2['username']."','".$rows2['score']."','".$rows2['rank']."'";
}
$query=mysql_query("UPDATE members SET score='1000' ,rank='0' ");
?>
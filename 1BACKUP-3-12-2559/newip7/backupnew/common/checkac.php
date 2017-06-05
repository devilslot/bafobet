<?php require('database.class.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

	$conn->query("update member set mactive = 'N' ");

	$sql3 = "select owner from paylogs where types='deposit' and status='confirmed' ";
	$result3 = $conn->query($sql3);
	while($ck = $result3->fetch_assoc()){
		##check active##
		$conn->query("update member set mactive = 'Y' where id=".$ck['owner']." ");
		##check active##
	}
?>
</body>
</html>

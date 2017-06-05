<?
class paylogs {
	function add($owner,$name,$user,$phone,$types,$from,$to,$amount,$status,$add=''){
		if($add == ''){
			$added = time();
		}else{
			$added = $add;
		}	
		$db=Live::core("db");
		$id = $db->Execute("INSERT INTO paylogs (owner,name,username,phone,types,froms,tos,amount,added,status) VALUES (
					'$owner',
					'$name',
					'$user',
					'$phone',
					'$types',
					'$from',
					'$to',
					'$amount',
					'$added',
					'$status')");
		return $id;
	}
	function update($id,$sql){
		$db=Live::core("db");
		$db->Execute("update paylogs set $sql where id = $id");
	}
}
?>
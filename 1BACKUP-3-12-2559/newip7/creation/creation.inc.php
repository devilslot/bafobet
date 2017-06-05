<?php
@session_start();
@header("Content-type: text/html; charset=utf-8");
require_once "../service/service.php";
require_once "../main/main.class.php";
require_once "creation.class.php";



function Register(){
  $table = 'members';
  $data = $_POST['data'];
  $user = $data['firstname'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  $data['ip'] = IP();
  $data['score'] = 1000;
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  

  
  $email = $obj->LoadOne('members',array('email'=>$data['email']));
  if($email){
    $result['success'] = 'EMAIL';
    echo json_encode($result);
    exit;
  }
  
  $username = $obj->LoadOne('members',array('username'=>$data['username']));
  if($username){
    $result['success'] = 'USERNAME';
    echo json_encode($result);
    exit;
  }
  
  
  $result['success'] = 'COMPLETE';
  $result = $obj->Add($table, $data);
  
  //$obj->Log('ADD', $table, $result['code'], $user);
  
  	####login####
    $login = $obj->LoadOne('members',array('username' => $data['username'],'enable'=>'Y'));
    $_SESSION[MEMBER]['LOGIN'] = 'ON';
    $_SESSION[MEMBER]['DATA'] = $login;
    $obj->Edit($table,array('lastIP' => IP(),'lastLogin' => $datenow),array('code'=>$_SESSION[MEMBER]['DATA']['code']));
  	####login####
  
  echo json_encode($result);
}

function ForgetPass(){
  $table = 'member';
  $data = $_POST['data'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  
  $email = $obj->LoadOne('member',array('email'=>$data['email']));
  $username = $obj->LoadOne('member',array('username'=>$data['username']));
  
  if($email){
    $result['success'] = 'COMPLETE';
    $result['password'] = $email['password'];
    echo json_encode($result);
    exit;
  }
  if($username){
    $result['success'] = 'COMPLETE';
    $result['password'] = $username['password'];
    echo json_encode($result);
    exit;
  }
  
  $result['success'] = 'FAIL';
  echo json_encode($result);
}

function Login(){
  $table = 'members';
  $data = $_POST['data'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  
  
  $login = $obj->LoadOne('members',array('username' => $data['user'],'enable'=>'Y'));
  
  $_SESSION[MEMBER]['LOGIN'] = 'OFF';
  $_SESSION[MEMBER]['DATA'] = array();

  if(strcmp($login['password'], $data["pass"])==0){	
    $_SESSION[MEMBER]['LOGIN'] = 'ON';
    $_SESSION[MEMBER]['DATA'] = $login;
	$_SESSION["username"] = $login['username'];
	$_SESSION["password"] = md5($login['password']);
    $obj->Edit($table,array('lastIP' => IP(),'lastLogin' => $datenow),array('code'=>$_SESSION[MEMBER]['DATA']['code']));
    $result['success'] = 'COMPLETE';
  }else{
    $result['success'] = 'FAIL';
  }  
  
  
  echo json_encode($result);
}

function EditProfile(){
  $table = 'members';
  $data = $_POST['data'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  
  $code = $_SESSION[MEMBER]['DATA']['code'];
  
  
  // if($data['password']){
  //   if($data['password'] != $_SESSION[MEMBER]['DATA']['password']){
  //     $result['success'] = 'PASS';
  //     echo json_encode($result);
  //     exit;
  //   }
  // }
  
  // if($data['new_password']){
  //   if($data['new_password'] != $data['new_password2']){
  //     $result['success'] = 'PASSMATCH';
  //     echo json_encode($result);
  //     exit;
  //   }else{
  //     $data['password'] = $data['new_password'];
  //     unset($data['new_password']);
  //     unset($data['new_password2']);
  //   }
  // }
  
  $_SESSION[MEMBER]['DATA']['firstname'] = $data['firstname'];
  $_SESSION[MEMBER]['DATA']['lastname'] = $data['lastname'];
  $_SESSION[MEMBER]['DATA']['tel'] = $data['tel'];

  $result = $obj->Edit($table,$data,array('code'=>$code));

  echo json_encode($result);
}

function ChangePass(){
  $table = 'members';
  $data = $_POST['data'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  
  $code = $_SESSION[MEMBER]['DATA']['code'];
  
  
  if($data['oldpass']){
    if($data['oldpass'] != $_SESSION[MEMBER]['DATA']['password']){
      $result['success'] = 'PASS';
      echo json_encode($result);
      exit;
    }
  }
  
  if($data['newpass']){
    if($data['newpass'] != $data['repass']){
      $result['success'] = 'PASSMATCH';
      echo json_encode($result);
      exit;
    }else{
      $data['password'] = $data['newpass'];
      unset($data['newpass']);
      unset($data['repass']);
      unset($data['oldpass']);
    }
  }
  
  $result = $obj->Edit($table,$data,array('code'=>$code));

  echo json_encode($result);
}


function LoadProfile(){
  $table = 'member';
  $data = $_POST['data'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  
  $code = $_SESSION[MEMBER]['DATA']['code'];
  
  $result['profile'] = $obj->LoadOne($table,array('code'=>$code));
  unset($result['profile']['code']);
  unset($result['profile']['lockuser']);
  unset($result['profile']['password']);
  echo json_encode($result);
}

function SaveDeposit(){
  $table = 'deposit';
  $data = $_POST['data'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  
  $data['member_code'] = $_SESSION[MEMBER]['DATA']['code'];
  $data['ip'] = IP();
  
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $data['bank'] = $_SESSION[MEMBER]['DATA']['bank'];
  $data['account_name'] = $_SESSION[MEMBER]['DATA']['account_name'];
  $data['account_no'] = $_SESSION[MEMBER]['DATA']['account_no'];
  $data['email'] = $_SESSION[MEMBER]['DATA']['email'];
  $data['mobile'] = $_SESSION[MEMBER]['DATA']['mobile'];
  
  $result = $obj->Add($table,$data);

  echo json_encode($result);
}

function SaveWithdraw(){
  $table = 'withdraw';
  $data = $_POST['data'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  
  $data['member_code'] = $_SESSION[MEMBER]['DATA']['code'];
  $data['ip'] = IP();
  
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $data['bank'] = $_SESSION[MEMBER]['DATA']['bank'];
  $data['account_name'] = $_SESSION[MEMBER]['DATA']['account_name'];
  $data['account_no'] = $_SESSION[MEMBER]['DATA']['account_no'];
  $data['email'] = $_SESSION[MEMBER]['DATA']['email'];
  $data['mobile'] = $_SESSION[MEMBER]['DATA']['mobile'];
  
  $result = $obj->Add($table,$data);

  echo json_encode($result);
}

function SaveTransfer(){
  $table = 'transfer';
  $data = $_POST['data'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  
  $data['member_code'] = $_SESSION[MEMBER]['DATA']['code'];
  $data['ip'] = IP();
  
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $data['bank'] = $_SESSION[MEMBER]['DATA']['bank'];
  $data['account_name'] = $_SESSION[MEMBER]['DATA']['account_name'];
  $data['account_no'] = $_SESSION[MEMBER]['DATA']['account_no'];
  $data['email'] = $_SESSION[MEMBER]['DATA']['email'];
  $data['mobile'] = $_SESSION[MEMBER]['DATA']['mobile'];
  
  $result = $obj->Add($table,$data);

  echo json_encode($result);
}


function PlayGame(){

  $table = 'playgame';
  $data = $_POST['data'];
  $user = $_SESSION[MEMBER]['DATA']['username'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  $data['ip'] = IP();
  $data['gametype'] = 'point';
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $data['memberID'] =  $_SESSION[MEMBER]['DATA']['code'];
  //unset($_POST['bet']);
  //$data['bet'] =  $_POST['bethdc'];
  

  
  $match = $obj->LoadOne('playgame',array('matchID'=>$data['matchID'],'memberID' => $data['memberID'],'gametype' => $data['gametype']));
  if($match){
    $result['success'] = 'PLAY';
    echo json_encode($result);
    exit;
  }
  
  //$mdata = $obj->LoadOne('members',array('memberID' => $data['memberID']));
  $sqlm="
  SELECT
  score
  FROM
  members
  WHERE
  code = '".$data['memberID']."' 
  ;";
  //echo $sqlm;
  $querym=mysql_query($sqlm) or die(mysql_error());
  if($rowm=mysql_fetch_assoc($querym)){
    $score = $rowm['score'];
  }
//print_r($rowm);
  mysql_free_result($querym);



  //echo $score.'|'.$data['point'];


  if($score  < $data['point']){
    $result['success'] = 'POINT';
    echo json_encode($result);
    exit;
  }
  
  if('0'  == $data['point']){
    $result['success'] = 'POINT';
    echo json_encode($result);
    exit;
  }

    $sql2 = " UPDATE members SET score = score-'".$data['point']."' WHERE code = '".$data['memberID']."' ";
    mysql_query($sql2);





  $result['success'] = 'COMPLETE';
  $result = $obj->Add($table, $data);  
  //$obj->Log('ADD', $table, $result['code'], $user);

  echo json_encode($result);
}


function PlayGameRank(){

  $table = 'playgame';
  $data = $_POST['data'];
  $user = $_SESSION[MEMBER]['DATA']['username'];
  $datenow = DateNow();
  $obj = new clsCreation($table);
  $data['ip'] = IP();
  $data['gametype'] = 'rank';
  $data['user_create'] = $user;
  $data['user_update'] = $user;
  $data['date_create'] = $datenow;
  $data['date_update'] = $datenow;
  $data['memberID'] =  $_SESSION[MEMBER]['DATA']['code'];
  //unset($_POST['bet']);
  //$data['bet'] =  $_POST['bethdc'];
  

  
  $match = $obj->LoadOne('playgame',array('matchID'=>$data['matchID'],'memberID' => $data['memberID'],'gametype' => $data['gametype']));
  if($match){
    $result['success'] = 'PLAY';
    echo json_encode($result);
    exit;
  }
  
  
  $sqlm="
  SELECT
  code
  FROM
  playgame
  WHERE
  memberID = '".$data['memberID']."' AND gametype='rank' AND date_create LIKE '".date('Y-m-d')."%'
  ;";
  //echo $sqlm;
  $querym=mysql_query($sqlm) or die(mysql_error());  
  $num=mysql_num_rows($querym);

  $num2 = (5-$num);
  //echo "ทายผลไปแล้ว ".$num." ครั้ง เหลือทายผลได้อีก ".$num2." ครั้ง";
  if($num=='5'){
    $result['success'] = 'LIMIT';
    echo json_encode($result);
    exit;
  }
 
  
  //$mdata = $obj->LoadOne('members',array('memberID' => $data['memberID']));
  
 

  $result['success'] = 'COMPLETE';
  $result = $obj->Add($table, $data);  
  //$obj->Log('ADD', $table, $result['code'], $user);

  echo json_encode($result);

}



switch($_REQUEST["mode"]){
  case "ChangeLang" : ChangeLang(); break;
  case "Register" : Register(); break;
  case "EditProfile" : EditProfile(); break;
  case "ChangePass" : ChangePass(); break;
  case "ForgetPass" : ForgetPass(); break;
  case "PlayGame" : PlayGame  (); break;
  case "PlayGameRank" : PlayGameRank  (); break;
  case "Login" : Login(); break;
  case "LoadProfile" : LoadProfile(); break;
  case "SaveDeposit" : SaveDeposit(); break;
  case "SaveWithdraw" : SaveWithdraw(); break;
  case "SaveTransfer" : SaveTransfer(); break;
  default : echo '{"success":"FAIL"}';
}
?>
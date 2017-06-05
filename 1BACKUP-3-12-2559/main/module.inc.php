<?php
/* ==================================================
*  Author : Attaphon Wongbuatong
 *  Created Date : 08/08/2011 14:42
 *  Module : Compile
 *  Description : _FUNCTION_ _MODE_
 *  Involve People : -
 *  Last Updated : 08/08/2011 14:42
  ================================================== */

session_start();
header("Content-type: text/html; charset=utf-8");
require_once "../service/service.php";
  
/* ==================================================
  :: _VARIABLE_ ::
================================================== */

/* ==================================================
  :: _INCLUDE_ ::
================================================== */
require_once "main.class.php";

function FriendPost() {
//  print_r($_POST);
  require_once 'module.class.php';
  $obj = new SubClass();
  $data = $_POST;
  $result = $obj->Add('friends', $data);
  echo json_encode($result);
}

function Login() {
  global $conn;
  global $db;

//  print_r($_POST); exit;
//  $obj = new SubClass($conn, $db, $_GET['mod']);
//  $data['user_pass'] = sha1(md5($_POST['user_pass']));
//  $result = $obj->Edit($_GET['mod'], $data, array('_id'=>new MongoId($_POST['id'])));
  
  $result['success'] = 'COMPLETE';
  echo json_encode($result);
}

/* ==================================================
  :: _FUNCTION_ ::
  ================================================== */

/* ==================================================
  :: _MODE_ ::
================================================== */
switch ($_REQUEST["Mode"]) {
  case "Login" : Login(); break;
  case "FriendPost" : FriendPost(); break;
  default : echo '{"success":"FAIL"}'; break;
}

?>
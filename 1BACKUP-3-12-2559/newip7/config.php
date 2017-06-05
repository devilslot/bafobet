<?php
/**
 * Created by PhpStorm.
 * User: SMART
 * Date: 6/12/2558
 * Time: 12:12
 */

$user = "bafobet_db";
$pass = "=-3.I^+4c&(_";
$host = "localhost";
$db = "bafobet_db";

$con = mysqli_connect($host, $user, $pass, $db) or die(mysqli_error($con));

mysqli_select_db($con, $db);
mysqli_query($con, "SET NAMES UTF8");
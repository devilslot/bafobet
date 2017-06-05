<?php
$servername = "139.162.25.110";
$username = "bafobet_db";
$password = "9IivNTE^08.e";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>
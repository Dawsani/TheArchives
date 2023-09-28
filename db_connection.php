<?php
$allowedIps = ['::1', '172.59.228.65', '64.25.240.19'];
$userIp = $_SERVER['REMOTE_ADDR'];

if (!in_array($userIp, $allowedIps)) {
    exit('You are not whitelisted on this site! DM me your IP so get access.<br>Your IP is: ' . $userIp);
}

$host = "localhost";
$username = "root";
$user_pass = "b5Aw!36Fk%4zVU4N";
$database_in_use = "clips_schema";

$mysqli = new mysqli($host, $username, $user_pass, $database_in_use);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
<?php
//$allowedIps = ['::1', '172.59.228.65', '64.25.240.19', '75.82.190.41', '47.6.109.251', '207.183.239.54', '23.243.29.12', '24.6.73.194'];
//$userIp = $_SERVER['REMOTE_ADDR'];

//if (!in_array($userIp, $allowedIps)) {
    //exit('You are not whitelisted on this site! DM me your IP so get access.<br>Your IP is: ' . $userIp);
//}

session_start();

$currentFile = $_SERVER['SCRIPT_NAME'];

// Check if the user is remember on the browser
if (isset($_COOKIE['remember_me_token'])) {
    // A "Remember Me" cookie exists.
    $token = $_COOKIE['remember_me_token'];

    $_SESSION['username'] = $token;
}
else {
    if ($currentFile != '/register.php' && $currentFile != '/login.php') {
        if (!isset($_SESSION['username'])) {
            // User is not authenticated, redirect to login page or display an error message
            header('Location: login.php');
            exit;
        }
    }
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
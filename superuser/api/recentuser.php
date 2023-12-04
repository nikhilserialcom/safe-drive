<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

if (!isset($_SESSION['user_email'])) {
    $response = array(
        'status_code' => 400,
        'email' => 'your session is expire'
    );
}

$userEmail = $_SESSION['user_email'];
$response = array(
    'status_code' => 200,
    'email' => $userEmail
);

$userListQuery = "SELECT * FROM user WHERE user_status = '1' ORDER BY id DESC";
$userList = mysqli_query($con, $userListQuery);

if (mysqli_num_rows($userList) > 0) {
    $user_list = array();
    while ($row = mysqli_fetch_assoc($userList)) {
        $user_list[] = $row;
    }
    $response = array(
        'status_code' => 200,
        'userList' => $user_list 
    );
} else {
    $response = array(
        'status_code' => 200,
        'message' => 'database empty'
    );
}

echo json_encode($response, JSON_PRETTY_PRINT);

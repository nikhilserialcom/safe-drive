<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

$userEmail = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

if (!isset($_SESSION['user_email'])) {
    $response = array(
        'status_code' => 440,
        'email' => 'your session is expire'
    );
} else {
    // $response = array(
    //     'status_code' => 200,
    //     'email' => $userEmail
    // );

    $userListQuery = "SELECT * FROM user WHERE user_status = '1' ORDER BY id DESC";
    $userList = mysqli_query($con, $userListQuery);
    $drivercount = 0;

    if (mysqli_num_rows($userList) > 0) {
        $user_list = array();
        while ($row = mysqli_fetch_assoc($userList)) {
            $user_list[] = $row;
        }
        foreach($user_list as $driver)
        {
            $drivercount ++;
        }
        $response = array(
            'status_code' => 200,
            'totaldriver' => $drivercount,
            'userList' => $user_list
        );
    } else {
        $response = array(
            'status_code' => 200,
            'message' => 'database empty'
        );
    }
}
echo json_encode($response, JSON_PRETTY_PRINT);

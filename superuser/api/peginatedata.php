<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

if (!isset($_SESSION['user_email'])) {
    $response = array(
        'status_code' => 440,
        'email' => 'your session is expire'
    );
} else {
    $page = isset($_POST['page']) ? $_POST['page'] : 1;

    $offset = ($page - 1) * 5;

    $driverDataQuery = "SELECT * FROM user LIMIT 5 OFFSET $offset";
    $driverData = mysqli_query($con,$driverDataQuery);
    $arr_obj = array();

    if(mysqli_num_rows($driverData) > 0)
    {
        while($row = mysqli_fetch_assoc($driverData))
        {
            $arr_obj[] = $row;
        }

        $response = array(
            'status_code' => "200",
            'driver_data' => $arr_obj
        );
    }
    else
    {
        $response = array(
            'status_code' => "500",
            'message' => 'database empty'
        );
    }
    
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>
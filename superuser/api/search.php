<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

$data = json_decode(file_get_contents('php://input'),true);

if (!isset($_SESSION['user_email'])) {
    $response = array(
        'status_code' => 440,
        'email' => 'your session is expire'
    );
} else {

    $driverName = isset($data['drivername']) ? $data['drivername'] : '';
    $userData = array();
    $searchQuery = "SELECT * FROM user WHERE user_status = '1' AND firstname LIKE '%".$driverName."%' ORDER BY id DESC";
    $search = mysqli_query($con,$searchQuery);
    if(mysqli_num_rows($search) > 0){
        while($row = mysqli_fetch_assoc($search))
        {
            $userData[] = $row;
        }
        $response = array(
            'status_code' => 200,
            'userData' => $userData 
        );
    }
    else
    {
        $response = array(
            'status_code' => 404,
            'message' => "database empty"
        );
    }

}


echo json_encode($response, JSON_PRETTY_PRINT);

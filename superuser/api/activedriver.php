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

    $driverId = isset($data['driverId']) ? $data['driverId'] : '';
    $driverStatus = isset($data['driverStatus']) ? $data['driverStatus'] : '';
    $document_type = isset($data['rejectedReason']) ? $data['rejectedReason'] : '';
    // $response = array(
    //     'status_code' => 200,
    //     'userData' => $driverId,
    //     'driver_status' => $driverStatus,
    // );
    $searchQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $search = mysqli_query($con,$searchQuery);
    if(mysqli_num_rows($search) > 0){
        while($row = mysqli_fetch_assoc($search))
        {
            if($driverStatus == 'rejected')
            {
                $jsonData = json_encode($document_type);
                $rejectDriverQuery = "UPDATE user SET active_status = 'reject', rejection_reason = '$jsonData' WHERE driverId = '$driverId' AND driverstatus = 'offline'";
                $rejectDriver = mysqli_query($con,$rejectDriverQuery);
                if($rejectDriver)
                {
                    $response = array(
                        'status_code' => 200,
                        'message' => 'reject' 
                    );
                }
                else{
                    $response = array(
                        'status_code' => 500,
                        'message' => "ERROR:" . mysqli_error($con)
                    );
                }
            }else{
               
                $activeDriverQuery = "UPDATE user SET driverstatus = 'online' , active_status = 'active' WHERE driverId = '$driverId' AND driverstatus = 'offline'";
                $activeDriver = mysqli_query($con,$activeDriverQuery);
                if($activeDriver)
                {
                    $response = array(
                        'status_code' => 200,
                        'message' => 'active' 
                    );
                }
                else{
                    $response = array(
                        'status_code' => 500,
                        'message' => "ERROR:" . mysqli_error($con)
                    );
                }
            }
        }
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

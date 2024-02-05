<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

function aadhar_card_data($userId){
    global $con;
    $checkUserQuery = "SELECT * FROM adhaarcard WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $aadhar_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while ($row = mysqli_fetch_assoc($checkUser)) {
           $aadhar_data = $row;
        }
    } 

    return $aadhar_data;
}

function police_certificate($userId){
    global $con;
    $checkUserQuery = "SELECT * FROM police_clearance_certificate WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $police_doc_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while ($row = mysqli_fetch_assoc($checkUser)) {
           $police_doc_data = $row;
        }
    } 

    return $police_doc_data;
}

function vehicle_insurance($userId,$vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM vehicle_insurance WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $insurance_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while ($row = mysqli_fetch_assoc($checkUser)) {
           $insurance_data = $row;
        }
    } 

    return $insurance_data;
}

function driving_licese($userId,$vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM driving_licese_info WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $licese_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while ($row = mysqli_fetch_assoc($checkUser)) {
           $licese_data = $row;
        }
    } 

    return $licese_data;
}

function vehicleinfo($userId,$vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM vehicleinfo WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $vehicle_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while ($row = mysqli_fetch_assoc($checkUser)) {
           $vehicle_data = $row;
        }
    } 

    return $vehicle_data;
}


function total_vehicle($driverId){
    global $con;
    $vehicle_arr = array();
    $check_total_vehicle = "SELECT * FROM vehicleinfo WHERE driverId = '$driverId'";
    $total_vehicle = mysqli_query($con,$check_total_vehicle); 

    while($row = mysqli_fetch_assoc($total_vehicle))
    {
        $vehicle_arr[] = $row['vehicle_type']; 
    }
    
    return $vehicle_arr;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($_SESSION['user_email'])) {
    $response = array(
        'status_code' => 400,
        'email' => 'your session is expire'
    );
} else {
    $userId = isset($data['userId']) ? $data['userId'] : '';
    $vehicle_type = isset($data['vehicle_type']) ? $data['vehicle_type'] : '';
    // $response = array(
    //     'status_code' => 200,
    //     'userData' => $userId,
    //     'vehicle_name' => $vehicle_type
    // );

    $checkUserQuery = "SELECT * FROM user WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $dirver_data = array();
    $aadhar_data = aadhar_card_data($userId);
    $police_doc_data = police_certificate($userId);
    $insurance_doc_data = vehicle_insurance($userId,$vehicle_type);
    $licese_data = driving_licese($userId,$vehicle_type);
    $vehicleinfo = vehicleinfo($userId,$vehicle_type);

    if (mysqli_num_rows($checkUser) > 0) {
        while ($row = mysqli_fetch_assoc($checkUser)) {
            $dirver_data = $row;
        }

        $dirver_data['total_vehicle'] = total_vehicle($userId);
        $response = array(
            'status_code' => 200,
            'driverData' => $dirver_data,
            'aadharData' => $aadhar_data,
            'policeData' => $police_doc_data,
            'insuranceData' => $insurance_doc_data,
            'liceseData' => $licese_data,
            'vehicleData' => $vehicleinfo
        );
    } else {

        $response = array(
            'status_code' => 404,
            'message' => 'database empty'
        );
    }
}
echo json_encode($response, JSON_PRETTY_PRINT);

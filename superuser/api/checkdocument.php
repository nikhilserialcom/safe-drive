<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

function aadhar_card_data($userId){
    global $con;
    $checkUserQuery = "SELECT * FROM adhaarcard WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $aadhar_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while ($row = mysqli_fetch_assoc($checkUser)) {
           $aadhar_data = $row['status'];
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
           $police_doc_data = $row['status'];
        }
    } 

    return $police_doc_data;
}

$data = json_decode(file_get_contents('php://input'), true);

$driverId = isset($data['driverId']) ? $data['driverId'] : '';
$vehicle_type = isset($data['vehicle_type'])  ? strtolower($data['vehicle_type'])  : '';

$table_name = ['driving_licese_info', 'vehicleinfo', 'vehicle_insurance'];

$driver_active_query = "SELECT * FROM user WHERE driverId = '$driverId'";
$driver_active = mysqli_query($con, $driver_active_query);
$row = mysqli_fetch_assoc($driver_active);
$active_data = $row['active_status'];

$checkData = array();
foreach ($table_name as $name) {
    $checkDataQuery = "SELECT * FROM $name WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
    $result = mysqli_query($con, $checkDataQuery);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $checkData[$name] = $row['status'];
    } else {
        $checkData[$name] = "database empty";
    }
}
$checkData['adhaarcard'] = aadhar_card_data($driverId);
$checkData['police_clearance_certificate'] = police_certificate($driverId);
$checkData['driver_status'] = $active_data;
$response['status'] = "200";
$response['table'] = $checkData;

echo json_encode($response, JSON_PRETTY_PRINT);

<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

$driverId = isset($data['driverId']) ? $data['driverId'] : '';

$table_name = ['driving_licese_info', 'vehicleinfo', 'police_clearance_certificate', 'adhaarcard', 'vehicle_insurance'];

$driver_active_query = "SELECT * FROM user WHERE driverId = '$driverId'";
$driver_active = mysqli_query($con, $driver_active_query);
$row = mysqli_fetch_assoc($driver_active);
$active_data = $row['active_status'];

$checkData = array();
foreach ($table_name as $name) {
    $checkDataQuery = "SELECT status FROM $name WHERE driverId = '$driverId'";
    $result = mysqli_query($con, $checkDataQuery);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $checkData[$name] = $row['status'];
    } else {
        $checkData[$name] = "database empty";
    }
}
$checkData['driver_status'] = $active_data;
$response['status'] = "200";
$response['table'] = $checkData;

echo json_encode($response, JSON_PRETTY_PRINT);

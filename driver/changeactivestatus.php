<?php

require '../db.php';
header("content-type:application/json");

function update_status_vehicle($driverId,$vehicle_type){
    global $con;

    $table_name = ['driving_licese_info', 'vehicleinfo', 'vehicle_insurance'];
    $result = [];
    foreach($table_name as $table){
        $check_data_query = "UPDATE $table SET status = 'waiting' WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
        $check_data = mysqli_query($con,$check_data_query);

        if($check_data)
        {
            $result[$table][] = "true";
        }
        else{
            $result[$table][] = "false";
        }

    }
    return $result;
}

$driverId = isset($_POST['driverId']) ? $_POST['driverId'] : '';
$vehicle_type = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] :'';

$checkDriverQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
$checkDriver = mysqli_query($con, $checkDriverQuery);

if (mysqli_num_rows($checkDriver) > 0) {

    $update_query = "UPDATE user SET active_status = 'waiting',driverstatus = 'offline',rejection_reason = '' WHERE driverId='$driverId'";
    $update = mysqli_query($con, $update_query);
    $update_status = update_status_vehicle($driverId,$vehicle_type);
    if ($update) {
        $response['status'] = "200";
        $response['update_status'] = $update_status;
        $response['message'] = "status updatede";
    } else {
        $response['status'] = "400";
        $response['message'] = 'ERROR:';
    }
} else {
    $response['status'] = "404";
    $response['message'] = "database empty";
}

echo json_encode($response, JSON_PRETTY_PRINT);

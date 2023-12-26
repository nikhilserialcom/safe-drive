<?php

require '../db.php';
header("content-type:application/json");

$driverId = isset($_POST['driverId']) ? $_POST['driverId'] : '';

$checkDriverQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
$checkDriver = mysqli_query($con, $checkDriverQuery);

if (mysqli_num_rows($checkDriver) > 0) {

    $update_query = "UPDATE user SET active_status = 'pending',rejection_reason = '' WHERE driverId='$driverId'";
    $update = mysqli_query($con, $update_query);
    if ($update) {
        $response['status'] = "200";
        $response['message'] = "status updateed";
    } else {
        $response['status'] = "400";
        $response['message'] = 'ERROR:';
    }
} else {
    $response['status'] = "404";
    $response['message'] = "database empty";
}

echo json_encode($response, JSON_PRETTY_PRINT);

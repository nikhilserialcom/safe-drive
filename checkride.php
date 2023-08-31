<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['driverId']) && isset($_POST['userId']))
{
    $driverId = $_POST['driverId'];
    $userId = $_POST['userId'];
    $status = $_POST['status'];

    $check_ride_query = "SELECT * FROM request WHERE driver_id = '$driverId' AND user_id = '$userId'";
    $check_ride = mysqli_query($con,$check_ride_query);

    if(mysqli_num_rows($check_ride) > 0)
    {
        $response['status'] = "200";
        $response['meassge'] = "accept";
    }
    else
    {
        $response['status'] = "400";
        $response['message'] = "decline";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR: ";
}

echo json_encode($response);
?>
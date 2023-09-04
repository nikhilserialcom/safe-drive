<?php

require '../db.php';
header("content-type:application/json");

if($_POST['driverId'])
{
    $driverId = $_POST['driverId']; 
    $vehicleType = $_POST['vehicleType'];

    $vehicleTypeQuery = "UPDATE user SET vehicleType = '$vehicleType' WHERE driverId = '$driverId'";
    $vehicleType = mysqli_query($con,$vehicleTypeQuery);
    if ($vehicleType) {
        $response['status'] = "200";
        $response['message'] = "vehicle Type add successfully";
    }
    else
    {
        $response['status'] = "400";
        $response['message'] = "something worng";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);
?>
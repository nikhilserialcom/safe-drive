<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['driverId']))
{
    $driverid = $_POST['driverId'];

    $driverinfoQuery = "SELECT * FROM request where driver_id = '$driverid'";
    $driverInfo = mysqli_query($con,$driverinfoQuery);

    if(mysqli_num_rows($driverInfo) > 0)
    {
        while ($row = mysqli_fetch_assoc($driverInfo)) {
            $response['status'] = "200";
            $response['request'][] = $row;
        }
    }
    else {
        $response['status'] = "400";
        $response['message'] = "User Not Found";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR";
}

echo json_encode($response);
?>
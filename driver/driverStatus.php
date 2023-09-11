<?php

require '../db.php';
header("content-type:application/json");

if($_POST['driverId'] && $_POST['driverStatus'])
{
    $driverId = $_POST['driverId'];
    $driverStatus = $_POST['driverStatus'];

    $checkDriverStatusQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $checkDriverStatus = mysqli_query($con,$checkDriverStatusQuery);

    if(mysqli_num_rows($checkDriverStatus) > 0)
    {
        // $row = mysqli_fetch_assoc($checkDriverStatus);
        $driverStatusUpdateQuery = "UPDATE user SET driverstatus = '$driverStatus' WHERE driverId = '$driverId'";
        $driverStatusUpdate = mysqli_query($con,$driverStatusUpdateQuery);

        if($driverStatusUpdate)
        {
            if($driverStatus == "online")
            {
                $response['status'] = "200";
                $response['message'] = "Your request is online";
            }
            else
            {
                $response['status'] = "200";
                $response['message'] = "Your request is offline";
            }
        }
    }
    else
    {
        $response['status'] = "404";
        $response['message'] = "NO data found";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
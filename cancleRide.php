<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId']) && isset($_POST['driverId'])) 
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
 
    
    $deleteRideQuery = "DELETE from book_ride where userId = '$userId' and driverId = '$driverId'";
    $deleteRide = mysqli_query($con,$deleteRideQuery);

    if ($deleteRide) {
        $response['status'] = "200";
        $response['message'] = "cancle the ride";
    }
    else
    {
        $response['status'] = "400";
        $response['message'] = "your ride is not cancle";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
<?php

require 'db.php';
header("content-type:application/json");
function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
{   
    global $response,$con;

    $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE id = '$driverId'");

    if($updateLocation)
    {
        $response['status'] = "true";
        $response['message'] = "update location";
    }

}

if(isset($_POST['amount']) && isset($_POST['pickupLetitude']) && isset($_POST['pickupLongitude']) && isset($_POST['dropLetitude']) && isset($_POST['dropLongitude']))
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $pickupLetitude = $_POST['pickupLetitude'];
    $pickupLongitude = $_POST['pickupLongitude'];
    $dropLetitude = $_POST['dropLetitude'];
    $dropLongitude = $_POST['dropLongitude'];
    $amount = $_POST['amount'];
    $vehicaleType = $_POST['vehicaleType'];

    updateDriverLocation($_POST['driverLatitude'], $_POST['driverLongitude'], $driverId);

    if(isset($_POST['status']) == "accept")
    {
        $passangerName = mysqli_query($con,"SELECT fullname FROM user WHERE id = 'userId'");
        $data = mysqli_fetch_assoc($passangerName);
        
        if(!empty($pickupLetitude) && !empty($pickupLongitude) && !empty($dropLetitude) && !empty($dropLongitude) && !empty($amount))
        {
            $insertRideQuery = "INSERT INTO book_ride(userId,driverId,pickup_letitude,pickup_longitude,drop_letitude,drop_longitude,vehicle_type,amount)VALUES('$userId','$driverId','$pickupLetitude','$pickupLongitude','$dropLetitude','$dropLongitude','$vehicaleType','$amount')";
            $insertRide = mysqli_query($con,$insertRideQuery);
            if($insertRide)
            {
                $response['status'] = "200";
                $response['message'] = "ride booking successfully!";
            }
        }
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
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
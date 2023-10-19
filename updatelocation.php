<?php

require 'db.php';
header("content-type:application/json");

function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
{   
    global $response,$con;

    $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE id= '$driverId' or driverId='$driverId'");

    if($updateLocation)
    {
        $response['status'] = "true";
    }

    return $response;
}

if(isset($_POST['userId']) && $_POST['driverLetitude'] && $_POST['driverLongitude'])
{
    $userId = $_POST['userId'];
    $driverLetitude = $_POST['driverLetitude'];
    $driverLogitude = $_POST['driverLongitude'];
    if(!empty($driverLetitude) && !empty($driverLogitude))
    {
        updateDriverLocation($driverLetitude,$driverLogitude,$userId);
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "Please check your Network is on";
}

echo json_encode($response);
?>
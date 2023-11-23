<?php

require 'db.php';
header("content-type:application/json");

$response = array();

if(isset($_POST['userId']) && isset($_POST['driverId']))
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $fromAddress = $_POST['fromAddress'];
    $toAddress = $_POST['toAddress'];

    $findlocationQuery = mysqli_query($con,"SELECT * FROM user WHERE driverId='$driverId'");
    $data = mysqli_fetch_assoc($findlocationQuery);
    $driverLetitude = $data['driverLetitude'];
    $driverLongitude = $data['driverLongitude'];

    $checkStatusQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId' AND fromAddress = '$fromAddress' AND toAddress = '$toAddress'";
    $checkStatus = mysqli_query($con,$checkStatusQuery);
    if(mysqli_num_rows($checkStatus) > 0)
    {
        while($row = mysqli_fetch_assoc($checkStatus))
        {
            if($row['status'] == 'here')
            {
                $response['status'] = "200";
                $response['id'] = $row['id'];
                $response['message'] = "here";
                $response['driverLetitude'] = $driverLetitude;
                $response['driverLongitude'] = $driverLongitude;
            }
            elseif($row['status'] == 'waiting')
            {
                $response['status'] = "200";
                $response['message'] = "waiting";
                $response['driverLetitude'] = $driverLetitude;
                $response['driverLongitude'] = $driverLongitude;
            } 
            elseif($row['status'] == 'start')
            {
                $response['status'] = "200";
                $response['message'] = "start";
                $response['driverLetitude'] = $driverLetitude;
                $response['driverLongitude'] = $driverLongitude;
            }  
            else
            {
                $response['status'] = "400";
                $response['message'] = "waiting for replay";
                $response['driverLetitude'] = $driverLetitude;
                $response['driverLongitude'] = $driverLongitude;
            }
        }
    }
    else
    {
        $checkFinishRideQuery = "SELECT * FROM completerides WHERE userId = '$userId' AND driverId = '$driverId' AND rideStatus = 'finish' AND fromAddress = '$fromAddress' AND toAddress = '$toAddress'";
        $checkFinishRide = mysqli_query($con,$checkFinishRideQuery);
        if(mysqli_num_rows($checkFinishRide) > 0)
        {
            $response['status'] = "200";
            $response['message'] = "finish";
            $response['driverLetitude'] = $driverLetitude;
            $response['driverLongitude'] = $driverLongitude;
        }
        else
        {
            $response['status'] = "200";
            $response['message'] = "cancel";
            $response['driverLetitude'] = $driverLetitude;
            $response['driverLongitude'] = $driverLongitude;
        }

    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
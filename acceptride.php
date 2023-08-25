<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId']) && isset($_POST['driverId'])) 
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
 
    
    if($_POST['status'] = "accept")
    {
        $acceptRideQuery = "SELECT * from book_ride where  userId ='$userId' and driverId = '$driverId'";
        $acceptRide = mysqli_query($con,$acceptRideQuery);
        $imageQyery = mysqli_query($con,"SELECT photo FROM user where id = '$userId'");
        $profile = mysqli_fetch_assoc($imageQyery);
        if ($row = mysqli_fetch_assoc($acceptRide)) {
            $response['status'] = "200";
            $response['message'] = "cancle the ride";
            $response['passangername'] =  $row['pessangerName'];
            $response['passangerprofile'] = $profile;
            $response['droplocation'] =  $row['drop_letitude'] . "," . $row['drop_longitude'];
            $response['amount'] = $row['amount'];
        }
        else
        {
            $response['status'] = "400";
            $response['message'] = "your ride is not cancle";
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
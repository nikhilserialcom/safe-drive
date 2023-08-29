<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['driverId'])) 
{   
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $amount = $_POST['amount'];

    if($_POST['status'] = "accept")
    {
        $status = $_POST['status'];
        $passangerName = mysqli_query($con,"SELECT firstname FROM user WHERE id = '$userId'");
        $data = mysqli_fetch_assoc($passangerName);
        $passangerName = $data['firstname'];
        if(!empty($pickupLetitude) && !empty($pickupLongitude) && !empty($dropLetitude) && !empty($dropLongitude) && !empty($amount))
        {
            $insertRideQuery = "INSERT INTO book_ride(userId,driverId,pessangerName,pickup_letitude,pickup_longitude,drop_letitude,drop_longitude,vehicle_type,amount,payment_mode,status,fromAddress,toAddress)VALUES('$userId','$driverId','$passangerName','$pickupLetitude','$pickupLongitude','$dropLetitude','$dropLongitude','$vehicaleType','$amount','$paymentMode','$status','$fromaddress','$toaddress')";
            $insertRide = mysqli_query($con,$insertRideQuery);
            if($insertRide)
            {
                $response['status'] = "200";
                $response['message'] = "Ride booking successfully!";
            }
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
<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['userId']) && isset($_POST['driverId']))
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];

    $checkrequestQuery = "SELECT * FROM driver_request WHERE driverId = '$driverId' AND user_id = '$userId'";
    $checkrequest = mysqli_query($con,$checkrequestQuery);

    if(mysqli_num_rows($checkrequest) > 0)
    {
        $deleteRequestQuery = "DELETE FROM driver_request  WHERE driverId = '$driverId' AND user_id = '$userId'";
        $deleteRequest = mysqli_query($con,$deleteRequestQuery);
        if($deleteRequest)
        {
            $updateRequestQuery = mysqli_query($con,"UPDATE request SET status = 'decline'  WHERE driver_id = '$driverId' AND user_id = '$userId'");

            $pickupLetitude = $_POST['pickupLetitude'];
            $pickupLongitude = $_POST['pickupLongitude'];
            $dropLetitude = $_POST['dropLatitude'];
            $dropLongitude = $_POST['dropLongitude'];
            $amount = $_POST['amount'];
            $fromaddress = $_POST['fromAddress'];
            $toaddress = $_POST['toAddress'];
            $paymentMode = $_POST['paymentMode'];
            $vehicaleType = $_POST['vehicaleType'];
            $status = 'decline';
            $passangerName = mysqli_query($con,"SELECT firstname FROM user WHERE id = '$userId'");
            $data = mysqli_fetch_assoc($passangerName);
            $passangerName = $data['firstname'];
            if(!empty($pickupLetitude) && !empty($pickupLongitude) && !empty($dropLetitude) && !empty($dropLongitude) && !empty($amount))
            {
                $insertRideQuery = "INSERT INTO book_ride(userId,driverId,pessangerName,pickup_letitude,pickup_longitude,drop_letitude,drop_longitude,vehicle_type,amount,payment_mode,status,fromAddress,toAddress)VALUES('$userId','$driverId','$passangerName','$pickupLetitude','$pickupLongitude','$dropLetitude','$dropLongitude','$vehicaleType','$amount','$paymentMode','$status','$fromaddress','$toaddress')";
                $insertRide = mysqli_query($con,$insertRideQuery);
                if($insertRide)
                {   
                    $deleterequest = mysqli_query($con,"DELETE FROM book_ride WHERE booking_date <= CURRENT_DATE - INTERVAL 2 minute AND status = 'decline'");
                    if($deleteRequest)
                    {
                        $response['status'] = "200";
                    }
                }
            }
            $response = array(
                'status' => '200',
                'message' => 'decline'
            );
        }
    }
    else
    {
        $response = array(
            'status' => '404',
            'message' => 'No result found'
        );
    }
}
else
{
    $response = array(
        'status' => "500",
        'message' => 'ERROR:'
    );
}
echo json_encode($response);
?>
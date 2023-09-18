<?php

require 'db.php';
header("content-type:application/json");

$response = [];
if($_POST['driverId'])
{
    $driverId = $_POST['driverId'];
    $userId = $_POST['userId'];
    $status = $_POST['status'];

    if($status == 'here')
    {
        $checkStatusQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'accept'";
        $checkStatus = mysqli_query($con,$checkStatusQuery);

        if(mysqli_num_rows($checkStatus) > 0)
        {
            $statusUpdateQuery = "UPDATE book_ride SET status = '$status' WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'accept'";
            $statusUpdate = mysqli_query($con,$statusUpdateQuery);

            if($statusUpdate)
            {
                $response['status'] = "200";
                $response['message'] = "you are arrived at pickup point";
            }
        }
        else
        {
            $response['status'] = "400";
            $response['message'] = "No matching records found";
        }
    }
    elseif($status == 'waiting')
    {
        $checkStatusQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'here'";
        $checkStatus = mysqli_query($con,$checkStatusQuery);

        if(mysqli_num_rows($checkStatus) > 0)
        {
            $statusUpdateQuery = "UPDATE book_ride SET status = '$status' WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'here'";
            $statusUpdate = mysqli_query($con,$statusUpdateQuery);

            if($statusUpdate)
            {
                $response['status'] = "200";
                $response['message'] = "your ride waiting";
            }
        }
        else
        {
            $response['status'] = "400";
            $response['message'] = "No matching records found";
        }
    }
    elseif($status == 'start')
    {
        $checkStatusQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'waiting'";
        $checkStatus = mysqli_query($con,$checkStatusQuery);

        if(mysqli_num_rows($checkStatus) > 0)
        {
            $statusUpdateQuery = "UPDATE book_ride SET status = '$status' WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'waiting'";
            $statusUpdate = mysqli_query($con,$statusUpdateQuery);

            if($statusUpdate)
            {
                $response['status'] = "200";
                $response['message'] = "your ride start";
            }
        }
        else
        {
            $response['status'] = "400";
            $response['message'] = "No matching records found";
        }
    }
    // elseif($status == 'finish')
    // {
    //     $checkStatusQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'start'";
    //     $checkStatus = mysqli_query($con,$checkStatusQuery);

    //     if(mysqli_num_rows($checkStatus) > 0)
    //     {
    //         $statusUpdateQuery = "UPDATE book_ride SET status = '$status' WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'start'";
    //         $statusUpdate = mysqli_query($con,$statusUpdateQuery);

    //         if($statusUpdate)
    //         {
    //             $response['status'] = "200";
    //             $response['message'] = "your ride finish";
    //         }
    //     }
    //     else
    //     {
    //         $response['status'] = "400";
    //         $response['message'] = "No matching records found";
    //     }
    // }
    elseif($status == 'finish')
    {
        $checkStatusQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'start'";
        $checkStatus = mysqli_query($con,$checkStatusQuery);
        $data = mysqli_fetch_assoc($checkStatus);
        if($data)
        {
            $insertCompleteQuery = "INSERT INTO completerides(userId,driverId,pessangerName,pickup_letitude,pickup_longitude,drop_letitude,drop_longitude,vehicle_type,amount,payment_mode,rideStatus,fromAddress,toAddress,booking_date)VALUES('{$data['userId']}','{$data['driverId']}','{$data['pessangerName']}','{$data['pickup_letitude']}','{$data['pickup_longitude']}','{$data['drop_letitude']}','{$data['drop_longitude']}','{$data['vehicle_type']}','{$data['amount']}','{$data['payment_mode']}','$status','{$data['fromAddress']}','{$data['toAddress']}','{$data['booking_date']}')";
            $insertComplete = mysqli_query($con,$insertCompleteQuery);

            if($insertComplete)
            {
                $deleteRideQuery = "DELETE FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'start'";
                $deleteRide = mysqli_query($con,$deleteRideQuery);

                $response['status'] = "200";
                $response['message'] = "your Ride complete";
            }
        }
        else
        {
            $response['status'] = "400";
            $response['message'] = "No matching records found";
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
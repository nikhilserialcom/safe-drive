<?php

require 'db.php';
header("content-type:application/json");


function sendPushNotification($driverId)
{
    global $con;
    $findTokenQuery = "SELECT * FROM user WHERE driverId = '$driverId' or Id = '$driverId'";
    $findToken = mysqli_query($con,$findTokenQuery);
    $token =  mysqli_fetch_assoc($findToken);

    if($token)
    {
        $deviceToken = $token['deviceToken'];
        $serverKey = 'AAAAzpUqMlE:APA91bEXySQ-4aw7rQB6Sloy2WLgyAr4XIEToPk5xo98u-wDOICMTC1ExzysY0SYBBio24gHaFgQlPh0BV3RIL-Ls34Y-d-_v205s79Bxj6MZ-tH2WI7_mlp6jGXtsxB5gNmloxmIIgQ'; // Replace with your Firebase Server Key
        $row = [
            'to' => $deviceToken, // The recipient's FCM token
            'notification' => [
                'title' => 'Safe Drive',
                'body' => 'your ride cancle',
            ],
        ];
        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];
        $ch = curl_init('https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Not recommended for production
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($row));
        $response = curl_exec($ch);
        if ($response === false) {
            die('Error: ' . curl_error($ch));
        }
        curl_close($ch);
        // echo $response;
    }
}

$response = array();

if(isset($_POST['userId']))
{
    $userId = $_POST['userId'];
    $cancleReason = $_POST['cancelReason'];

    $checkRideQuery = "SELECT * FROM book_ride WHERE userId = '$userId'";
    $checkRide = mysqli_query($con,$checkRideQuery);
    if(mysqli_num_rows($checkRide) > 0)
    {
        while($row = mysqli_fetch_assoc($checkRide))
        {
            // $driverId = $row['driverId'];
            // // $response['driverId'] = $driverId;/
            // $deleteUserRideQuery = "DELETE FROM book_ride WHERE userId = '$userId'";
            // $deleteUserRide = mysqli_query($con,$deleteUserRideQuery);

            // if($deleteUserRide)
            // {
            //     $deleteRequestQuery = "DELETE from request where user_id = '$userId'";
            //     $deleteRequest = mysqli_query($con,$deleteRequestQuery);
            //     sendPushNotification($driverId);

            //     $response['status'] = "200";
            //     $response['message'] = "cancle your ride";
            // }

            $insertCompleteQuery = "INSERT INTO completerides(userId,driverId,pessangerName,pickup_letitude,pickup_longitude,drop_letitude,drop_longitude,vehicle_type,amount,payment_mode,status,cancelReason,fromAddress,toAddress,booking_date)VALUES('{$row['userId']}','{$row['driverId']}','{$row['pessangerName']}','{$row['pickup_letitude']}','{$row['pickup_longitude']}','{$row['drop_letitude']}','{$row['drop_longitude']}','{$row['vehicle_type']}','{$row['amount']}','{$row['payment_mode']}','cancel','$cancleReason','{$row['fromAddress']}','{$row['toAddress']}','{$row['booking_date']}')";
            $insertComplete = mysqli_query($con,$insertCompleteQuery);  

            if($insertComplete)
            {
                $deleteUserRideQuery = "DELETE FROM book_ride WHERE userId = '$userId'";
                $deleteUserRide = mysqli_query($con,$deleteUserRideQuery);

                $deleteRequestQuery = "DELETE from request where user_id = '$userId'";
                $deleteRequest = mysqli_query($con,$deleteRequestQuery);

                $response['status'] = "200";
                $response['message'] = "your Ride cancel";
            }
        }
    }
    else{
        $response['status'] = "400";
        $response['message'] = "ERROR:" . mysqli_error($con);
    }

}
elseif(isset($_POST['userId']) && isset($_POST['driverId'])) 
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $cancleReason = $_POST['cancelReason'];
    
    // $deleteRideQuery = "DELETE from book_ride where userId = '$userId' and driverId = '$driverId'";
    // $deleteRide = mysqli_query($con,$deleteRideQuery);

    // if ($deleteRide) {
    //     $deleteRequestQuery = "DELETE from request where user_id = '$userId' and driverId = '$driverId'";
    //     $deleteRequest = mysqli_query($con,$deleteRequestQuery);

    //     sendPushNotification($userId);
    //     $response['status'] = "200";
    //     $response['message'] = "cancle the ride";
    // }

    $checkRideQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId'";
    $checkRide = mysqli_query($con,$checkRideQuery);
    if(mysqli_num_rows($checkRide) > 0)
    {
        while($row = mysqli_fetch_assoc($checkRide))
        {
            $insertCompleteQuery = "INSERT INTO completerides(userId,driverId,pessangerName,pickup_letitude,pickup_longitude,drop_letitude,drop_longitude,vehicle_type,amount,payment_mode,status,cancelReason,fromAddress,toAddress,booking_date)VALUES('{$row['userId']}','{$row['driverId']}','{$row['pessangerName']}','{$row['pickup_letitude']}','{$row['pickup_longitude']}','{$row['drop_letitude']}','{$row['drop_longitude']}','{$row['vehicle_type']}','{$row['amount']}','{$row['payment_mode']}','cancel','$cancleReason','{$row['fromAddress']}','{$row['toAddress']}','{$row['booking_date']}')";
            $insertComplete = mysqli_query($con,$insertCompleteQuery);  

            if($insertComplete)
            {
                $deleteUserRideQuery = "DELETE FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId'";
                $deleteUserRide = mysqli_query($con,$deleteUserRideQuery);

                $deleteRequestQuery = "DELETE from request where user_id = '$userId' and driver_id = '$driverId'";
                $deleteRequest = mysqli_query($con,$deleteRequestQuery);

                $response['status'] = "200";
                $response['message'] = "your Ride cancel";
            }
        }
    }
    else{
        $response['status'] = "400";
        $response['message'] = "ERROR:" . mysqli_error($con);
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
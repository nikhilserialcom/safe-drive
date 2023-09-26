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
        $data = [
            'to' => $deviceToken, // The recipient's FCM token
            'notification' => [
                'title' => 'Safe Drive',
                'body' => 'your ride cancle',
                // 'sound' => '21.mp3',
                'image' => 'https://mcdn.wallpapersafari.com/medium/55/83/Pl6QHc.jpg',
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        if ($response === false) {
            die('Error: ' . curl_error($ch));
        }
        curl_close($ch);
        echo $response;
    }
}

if(isset($_POST['userId']))
{
    $userId = $_POST['userId'];

    $checkRideQuery = "SELECT * FROM book_ride WHERE userId = '$userId'";
    $checkRide = mysqli_query($con,$checkRideQuery);
    if(mysqli_num_rows($checkRide) > 0)
    {
        while($row = mysqli_fetch_assoc($checkRide))
        {
            $driverId = $row['driverId'];
            $response['driverId'] = $driverId;
            $deleteUserRideQuery = "DELETE FROM book_ride WHERE userId = '$userId'";
            $deleteUserRide = mysqli_query($con,$deleteUserRideQuery);

            if($deleteUserRide)
            {
                sendPushNotification($driverId);
                $response['status'] = "200";
                $response['message'] = "cancle your ride";
            }
        }
    }

}
if (isset($_POST['userId']) && isset($_POST['driverId'])) 
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
 
    
    $deleteRideQuery = "DELETE from book_ride where userId = '$userId' and driverId = '$driverId'";
    $deleteRide = mysqli_query($con,$deleteRideQuery);

    if ($deleteRide) {
        sendPushNotification($userId);
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
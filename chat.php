<?php

require 'db.php';
header("content-type:application/json");

date_default_timezone_set('Asia/Kolkata');

function sendPushNotification($userId,$message)
{
    global $con;
    $findTokenQuery = "SELECT * FROM user WHERE driverId = '$userId' or Id = '$userId'";
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
                'body' => $message,
                // 'sound' => '21.mp3',
                // 'image' => 'https://mcdn.wallpapersafari.com/medium/55/83/Pl6QHc.jpg',
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
        // echo $response;
    }

    // return $deviceToken;
}


if(isset($_POST['outgoing_msg_id']) and isset($_POST['incoming_msg_id']))
{
    $outgoing_msg_id = $_POST['outgoing_msg_id'];
    $incoming_msg_id = $_POST['incoming_msg_id'];
    $message = mysqli_real_escape_string($con,$_POST['message']);
    $currenttime = date('h:i A');

    sendPushNotification($incoming_msg_id,$message);
    // echo $currenttime;
    if(!empty($message))
    {
        $messageQuery = "INSERT INTO messages(incoming_msg_id,outgoing_msg_id,messages,chat_time)VALUES('$incoming_msg_id','$outgoing_msg_id','$message','$currenttime')";
        $message = mysqli_query($con,$messageQuery);

        if ($message) {
            $response['status'] = "200";
            $response['message'] = 'send message';
        }
    }
    else
    {
        $response['status'] = '401';
        $response['message'] = "message is empty";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
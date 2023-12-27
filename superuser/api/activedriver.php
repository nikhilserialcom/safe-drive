<?php

require 'db.php';
require_once 'vendor/autoload.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

function sendmail($email)
{
    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
    ->setUsername('1nikhil.serialcominfotech@gmail.com')
    ->setPassword('yltd eqfs jkld dynd')
    ;

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);
    
    $emailTemplate = '<!DOCTYPE html>
            <html>
            <head>
            <title>Email Verification</title>
            <style>
            body{margin: 0;padding: 0;font-family: Arial, sans-serif}.container{max-width: 600px;margin: 0 auto;padding: 20px;background-color: #f7f7f7}.header{background-color: #333;color: #fff;padding: 10px;text-align: center;font-family: "Righteous", cursive}.safe-driver{font-size: 24px;font-weight: 700;text-transform: capitalize;margin: 10px;font-family: "Righteous", cursive;text-align: center}.safe-driver span{color:#c0392b}.footer{background-color: #333;color: #fff;padding: 10px;text-align: center;font-size: 10px}.footer a{color: #fff;margin-right: 10px}h1{margin-bottom: 20px;text-align: center}p{color: #666;line-height: 1.5;margin-bottom: 20px;text-align: center}.button-container{text-align: center;margin-bottom: 20px}.button-container .button{display: inline-block;padding: 10px 20px;background-color: #EF5052;color: #fff;text-decoration: none;border-radius: 4px; font-size: 20px;font-weight: 700;letter-spacing: 5px;}.footer p{margin: 10px 0px;color: #fff}
            </style>
            </head>
            <body>
                    <div class="container">
                        <div class="header">
                            <h1>Email Verification</h1>  
                        </div>
                        <div class="safe-driver">Safe <span>Driver</span></div>
                        <p>Dear nikhil,</p>
                        <p>Thank you for choosing Your Brand. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
                        <div class="button-container">
                            <p class="button">approved</p>
                        </div>
                            <p>If you did not sign up for an account, you can safely ignore this email.</p>
                        <div class="footer">
                            <p>&copy; 2023 Safe Drive Application. All rights reserved.</p>
                        </div>
                    </div>
                    </div>
            </body>
            </html>';
    // Create a message
    $message = (new Swift_Message('Wonderful Subject'))
    ->setFrom(['1nikhil.serialcominfotech@gmail.com' => 'Nikhil Patel'])
    ->setTo($email)
    ->setBody($emailTemplate,'text/html');

    // Send the message
    $mailer->send($message);
    
}

function sendPushNotification($driverId)
{
    global $con;
    $findTokenQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $findToken = mysqli_query($con,$findTokenQuery);

    $deviceToken = array();
    if(mysqli_num_rows($findToken) > 0)
    {
        while($row = mysqli_fetch_assoc($findToken))
        {
            $token = $row['deviceToken'];
            if(!empty($token))
            {
                $deviceToken[] = $token;
                $serverKey = 'AAAAzpUqMlE:APA91bEXySQ-4aw7rQB6Sloy2WLgyAr4XIEToPk5xo98u-wDOICMTC1ExzysY0SYBBio24gHaFgQlPh0BV3RIL-Ls34Y-d-_v205s79Bxj6MZ-tH2WI7_mlp6jGXtsxB5gNmloxmIIgQ'; // Replace with your Firebase Server Key
                $data = [
                    'to' => $token, // The recipient's FCM token
                    'notification' => [
                        'title' => 'Safe Drive',
                        'body' => 'your document are approved',
                        // 'sound' => '21.mp3',
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
        }
    }

    // return $deviceToken;
}

$data = json_decode(file_get_contents('php://input'),true);

if (!isset($_SESSION['user_email'])) {
    $response = array(
        'status_code' => 440,
        'email' => 'your session is expire'
    );
} else {

    $driverId = isset($data['driverId']) ? $data['driverId'] : '';
    $driverStatus = isset($data['driverStatus']) ? $data['driverStatus'] : '';
    $document_type = isset($data['rejectedReason']) ? $data['rejectedReason'] : '';
    // $response = array(
    //     'status_code' => 200,
    //     'userData' => $driverId,
    //     'driver_status' => $driverStatus,
    // );
    $searchQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $search = mysqli_query($con,$searchQuery);
    if(mysqli_num_rows($search) > 0){
        while($row = mysqli_fetch_assoc($search))
        {
            if($driverStatus == 'rejected')
            {
                sendPushNotification($driverId);
                sendmail($row['email']);
                $jsonData = json_encode($document_type);
                $rejectDriverQuery = "UPDATE user SET active_status = 'reject', rejection_reason = '$jsonData' WHERE driverId = '$driverId'";
                $rejectDriver = mysqli_query($con,$rejectDriverQuery);
                if($rejectDriver)
                {
                    $response = array(
                        'status_code' => 200,
                        'message' => 'reject' 
                    );
                }
                else{
                    $response = array(
                        'status_code' => 500,
                        'message' => "ERROR:" . mysqli_error($con)
                    );
                }
            }else{
                sendPushNotification($driverId);
                sendmail($row['email']);
                $activeDriverQuery = "UPDATE user SET driverstatus = 'online' , active_status = 'active' WHERE driverId = '$driverId'";
                $activeDriver = mysqli_query($con,$activeDriverQuery);
                if($activeDriver)
                {
                    $response = array(
                        'status_code' => 200,
                        'message' => 'active' 
                    );
                }
                else{
                    $response = array(
                        'status_code' => 500,
                        'message' => "ERROR:" . mysqli_error($con)
                    );
                }
            }
        }
    }
    else
    {
        $response = array(
            'status_code' => 404,
            'message' => "database empty"
        );
    }

}


echo json_encode($response, JSON_PRETTY_PRINT);

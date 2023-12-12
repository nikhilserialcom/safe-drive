<?php

require('db.php');
require_once 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'),true);

function sendforgotpassword($email,$otp)
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
                            <p class="button">'.$otp.'</p>
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

$userEmail = isset($data['user_email']) ? $data['user_email'] : '';
$otp = rand(1111,9999);

// $response = array(
//     'status_code' => 200,
//     'token' => $token,
//     'message' =>  $userEmail
// );

$checkEmailQuery = "SELECT * FROM superuser WHERE s_email = '$userEmail'";
$checkEmail = mysqli_query($con,$checkEmailQuery);

if(mysqli_num_rows($checkEmail) > 0){
   
    $updateToken = mysqli_query($con,"UPDATE superuser SET otp = '$otp' WHERE s_email = '$userEmail'");
    if($updateToken)
    {
        $response = array(
            'status_code' => 200,
            'message' =>  'true'
        );
        sendforgotpassword($userEmail,$otp);
    }
    else{
        $response = array(
            'status_code' => 500,
            'message' =>  "ERROR:" . mysqli_error($con)
        );
    }
}
else{
    $response = array(
        'status_code' => 404,
        'message' => 'email is not exist'
    );
}

    echo json_encode($response,JSON_PRETTY_PRINT); 
?>
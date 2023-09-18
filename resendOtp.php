<?php

require 'db.php';
header("content-type:application/json");

require 'twilio/vendor/autoload.php';

if(isset($_POST['userId']))
{
    $userId = $_POST['userId'];
    $no = $_POST['number'];

    $checkNumberQuery = "SELECT * FROM user WHERE mobile_number = '$no' AND verified = '0'";
    $checkNumber = mysqli_query($con,$checkNumberQuery);

    if(mysqli_num_rows($checkNumber) > 0)
    {
        $otp = rand(1111,9999);
        // Your Account SID and Auth Token from console.twilio.com
        $sid = "AC9df1a8f5bea5649437e9a9ab191dbbdd";
        $token = "af5825e06ff127d2e228251663bc4ca5";
        $client = new Twilio\Rest\Client($sid, $token);

        $message = $client->messages->create(
            // The number you'd like to send the message to
            $no,
            [
                // A Twilio phone number you purchased at https://console.twilio.com
                'from' => '+18155545270',
                // The body of the text message you'd like to send
                'body' => "Your otp is :" . $otp
            ]
        );

        if($message)
        {
            $response['status'] = "200";
            $response['message'] = "otp has been resend in your mobile number";
          
        }
    }
    else
    {
        $response['status'] = "400";
        $response['message'] = "Your mobile number already verify";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);
?>
<?php

require 'db.php';
header("content-type:application/json");
require 'twilio/vendor/autoload.php';

if(isset($_POST['userId']))
{
    $userId = $_POST['userId'];
    $no = $_POST['mobileNumber'];
    $otp = rand(1111,9999);
    // Your Account SID and Auth Token from console.twilio.com
    $sid = "AC46cc8a9212de70e3e38764a51fae003e";
    $token = "4f6e9e25db54f96a20dbfe258c37cb27";
    $client = new Twilio\Rest\Client($sid, $token);

    $message = $client->messages->create(
        // The number you'd like to send the message to
        $no,
        [
            // A Twilio phone number you purchased at https://console.twilio.com
            'from' => '+18588081143',
            // The body of the text message you'd like to send
            'body' => "Your otp is :" . $otp
        ]
    );

    if($message)
    {
        if(!empty($no))
        {
            $updateNoQuery = "UPDATE user SET mobile_number = '$no',verification_code = '$otp',verified = 0 WHERE id = '$userId'";
            $updateNo = mysqli_query($con,$updateNoQuery);
            if($updateNo)
            {
                $response['status'] = "200";
                $response['message'] = "otp has been send in your mobile number";
            }
            else
            {
                $response['status'] = "400";
                $response['message'] = "please enter the valid number";
            }
        }
        else
        {
            $response['status'] = "404";
            $response['message']= "please enter the number";
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
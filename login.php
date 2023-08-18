<?php

require 'db.php';
header("content-type:application/json");

require 'twilio/vendor/autoload.php';

if(isset($_POST['mobileNumber']))
{
    $no = $_POST['mobileNumber'];

    $checkNoQuery = "SELECT * FROM user WHERE mobile_number = '$no'";
    $checkNo = mysqli_query($con,$checkNoQuery);

    if(mysqli_num_rows($checkNo) > 0)
    {
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
            $updateOTPQuery = "UPDATE user SET verification_code = '$otp' ,verified = 0 WHERE mobile_number = '$no'";
            $updateOTP = mysqli_query($con,$updateOTPQuery);
            if($updateOTP)
            {
                $response['status'] = "200";
                $response['situation'] = "update";
                $response['message'] = "otp has been send in your mobile number";
            }
        }
    }
    else
    {
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
            $insertQuery = "INSERT INTO user(mobile_number,verification_code)VALUES('$no','$otp')";
            $insert = mysqli_query($con,$insertQuery);
            if($insert)
            {
                $response['status'] = "200";
                $response['situation'] = "insert";
                $response['message'] = "otp has been send in your mobile number";
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
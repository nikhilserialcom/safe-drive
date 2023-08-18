<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['otp']))
{   
    $otp = $_POST['otp'];

    $checkOtpQuery = "SELECT * FROM user WHERE verification_code = '$otp' ";
    $checkOtp = mysqli_query($con,$checkOtpQuery);

    if(mysqli_num_rows($checkOtp) > 0) 
    {
        $row = mysqli_fetch_assoc($checkOtp);
        $userId = $row['id'];
        if($row['verification_code'] == $otp)
        {
            $updateStatus = mysqli_query($con,"UPDATE user SET verified = 1 WHERE verification_code = '$otp'");
            if ($updateStatus) {
                $response['status'] ="200";
                $response['userId'] = $userId;
                $response['message'] = "Registration complete";
            }
        }
        else
        {
            $response['status'] = "404";
            $response['message'] = "please enter the valid otp";
        }
    }
    else
    {
        $response['status'] = "400";
        $response['message'] = "database empty";
    }

}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);
?>
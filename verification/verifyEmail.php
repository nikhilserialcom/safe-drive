<?php

require '../db.php';
header("content-type:application/json");

if(isset($_GET['token']))
{
    $token = $_GET['token'];
    $verifyCheckQuery = "SELECT EmailVerifyToken,emailStatus FROM user WHERE EmailVerifyToken = '$token' limit 1";
    $verify = mysqli_query($con,$verifyCheckQuery);

    if(mysqli_num_rows($verify) > 0)
    {
        $row = mysqli_fetch_assoc($verify);
        if($row['emailStatus'] == "0")
        {
            $checkToken = $row['EmailVerifyToken'];
            $updateStatusQuery = "UPDATE user SET emailStatus = '1' WHERE EmailVerifyToken = '$token'";
            $updateStatus = mysqli_query($con,$updateStatusQuery);

            if($updateStatus)
            {
                $response['status'] = '200';
                $response['message'] = 'Your email has been verified!';
            }
        }
        else
        {
            $response['status'] = "404";
            $response['message'] = "Your email Already verify";
        }
    }
    else
    {
        $response['status'] = "404";
        $response['message'] = "Database empty";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
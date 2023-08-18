<?php

require '../db.php';
require 'mailFunction.php';
header("content-type:application/json");

if(isset($_POST['userId']))
{
    $userId = $_POST['userId'];
    $email = $_POST['email'];
    $verifyToken = md5(rand());

    $checkuserQuery = "SELECT * FROM user WHERE id = '$userId' AND email = '$email'";
    $checkuser = mysqli_query($con,$checkuserQuery);

    if(mysqli_num_rows($checkuser) > 0)
    {
        $row = mysqli_fetch_assoc($checkuser);
        $userName = $row['fullname'];
        if(!empty($email))
        {
            $updateEmailQuery = "UPDATE user SET email = '$email',EmailVerifyToken = '$verifyToken' WHERE id = '$userId'";
            $updateEmail = mysqli_query($con,$updateEmailQuery);
            if($updateEmail)
            {
                sendmail("$userName","$email","$verifyToken");
                $response['status'] = "200";
                $response['message'] = "Email update successfully";
            }
        }
    }
    else
    {
        $response['status'] = "404";
        $response['message'] = "Email already exist";
    }

}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);
?>
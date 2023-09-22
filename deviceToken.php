<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $deviceToken = $_POST['fCMToken'];

    $checkUserQuery = "SELECT * FROM user WHERE id = '$userId'";
    $checkUser = mysqli_query($con,$checkUserQuery);
    if(mysqli_num_rows($checkUser) > 0)
    {
        $updateDeiviceTokenQuery = "UPDATE user SET deviceToken = '$deviceToken' WHERE id = '$userId'";
        $updateDeiviceToken = mysqli_query($con,$updateDeiviceTokenQuery);
        if ($updateDeiviceToken) 
        {
            $response['status'] = "200";
            $response['message'] = 'token add successfully';
        }
    }
    else
    {
        $response['status'] = "404";
        $response['message'] = 'user not found';
    }
} 
else 
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}


echo json_encode($response);
?>
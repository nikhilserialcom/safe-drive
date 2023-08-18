<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId']) && $_POST['firstName'] && $_POST['lastName']) 
{
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    $checkUserQuery = "SELECT * FROM user WHERE id = '$userId'";
    $checkUser = mysqli_query($con,$checkUserQuery);
    if(mysqli_num_rows($checkUser) > 0)
    {
        $updateNameQuery = "UPDATE user SET firstname = '$firstName',lastname = '$lastName' WHERE id = '$userId'";
        $updateName = mysqli_query($con,$updateNameQuery);
        if ($updateName) 
        {
            $response['status'] = "200";
            $response['message'] = 'Name add successfully';
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
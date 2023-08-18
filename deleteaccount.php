<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['userId']))
{
    $userID = $_POST['userId'];
    $checkUserQuery = "SELECT * FROM user WHERE id = '$userID'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $deleteUserQuery = "DELETE from USER WHERE id = '$userID'";
        $deleteuser = mysqli_query($con,$deleteUserQuery);

        if($deleteuser)
        {
            $response['status'] = "200";
            $response['message'] ="Delete Your Account Successfully";
        }
    }
    else
    {
        $response['status'] = "404";
        $response['message'] = "User not found";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
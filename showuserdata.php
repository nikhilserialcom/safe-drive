<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['userId']))
{
    $userId = $_POST['userId'];

    $userDataQuery = "SELECT firstname,lastname,city,photo,email,mobile_number FROM user WHERE id = '$userId'";
    $userData = mysqli_query($con,$userDataQuery);

    if(mysqli_num_rows($userData) > 0)
    {
        while($row = mysqli_fetch_assoc($userData))
        {
            $response['status'] = "200";
            $response['userData'] = $row;
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
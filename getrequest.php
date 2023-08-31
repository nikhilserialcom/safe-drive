<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $checkQuery = "SELECT * FROM driver_request WHERE user_id = '$userId'";
    $check = mysqli_query($con,$checkQuery);

    if(mysqli_num_rows($check) > 0)
    {
        while($row = mysqli_fetch_assoc($check))
        {
            $response['status'] ="200";
            $response['requests'][] = $row;
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
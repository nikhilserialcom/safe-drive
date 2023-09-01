<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $checkQuery = "SELECT * FROM book_ride WHERE driverId = '$driverId' AND userId = '$userId'";
    $check = mysqli_query($con,$checkQuery);

    $row = mysqli_fetch_assoc($check);
    if($row)
    {
        $status = $row['status'];
        if($status == "accept")
        {
            $response['status'] = "true";
            $response['message'] = $status;
        }
        else
        {
            $response['status'] = "false";
            $response['message'] = $status;
        } 
    }
    else
    {
        $response['status'] = "400";
        $response['message'] = "waiting for replay";
    }


    
} 
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR: ";
}

echo json_encode($response);
?>
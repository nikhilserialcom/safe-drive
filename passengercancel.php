<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    
    $checkQuery = "SELECT * FROM book_ride WHERE driverId = '$driverId' AND userId = '$userId'";
    $check = mysqli_query($con,$checkQuery);
    if(mysqli_num_rows($check) == 0)
    {
    
        $response['status'] = "true";
        $response['message'] = "cancel";  
    }
    else
    {
        $response['status'] = "false";
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
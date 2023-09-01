<?php

require 'db.php';
header("content-type:application/json");

if($_POST['driverId'])
{
    $driverId = $_POST['driverId'];
    $userId = $_POST['userId'];
    $status = $_POST['status'];

    $checkStatusQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'accept'";
    $checkStatus = mysqli_query($con,$checkStatusQuery);

    if(mysqli_num_rows($checkStatus) > 0)
    {
        $statusUpdateQuery = "UPDATE book_ride SET status = '$status' WHERE userId = '$userId' AND driverId = '$driverId' AND status = 'accept'";
        $statusUpdate = mysqli_query($con,$statusUpdateQuery);

        if($statusUpdate)
        {
            $response['status'] = "200";
            $response['message'] = "your ride start";
        }
    }
    else
    {
        $response['status'] = "400";
        $response['message'] = "No matching records found";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
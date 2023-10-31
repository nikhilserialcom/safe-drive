<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $fromAddress = $_POST['fromAddress'];
    $toAddress = $_POST['toAddress'];
    
    $checkQuery = "SELECT * FROM book_ride WHERE driverId = '$driverId' AND userId = '$userId' AND fromAddress = '$fromAddress' AND toAddress = '$toAddress'";
    $check = mysqli_query($con,$checkQuery);

    // $row = mysqli_fetch_assoc($check);
    // if($row)
    // {
    //     $status = $row['status'];
    //     if($status == "accept" && $row['fromAddress'] == $fromAddress)
    //     {
    //         $response['status'] = "true";
    //         $response['message'] = $status;  
    //         $response['fromAddress'] = $row['formAddress'];
    //     }
    //     else
    //     {
    //         $response['status'] = "false";
    //         $response['message'] = $status;
    //     } 
    // }
    if(mysqli_num_rows($check) > 0)
    {
        while($row = mysqli_fetch_assoc($check))
        {
            $status = $row['status'];
            if($status === "accept")
            {
                $response['status'] = "true";
                $response['message'] = $status;  
                // $response['fromAddress'] = $row['fromAddress'];
                // $response['toAddress'] = $row['toAddress'];
            }
            else
            {
                $response['status'] = "false";
                $response['message'] = $status;
            } 
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
<?php

require 'db.php';
header("content-type:application/json");
// function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
// {   
//     global $response,$con;

//     $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE user_id = '$driverId'");

//     if($updateLocation)
//     {
//         $response['status'] = "true";
//         $response['message'] = "update location";
//     }

// }

if (isset($_POST['userId']) && isset($_POST['amount'])) 
{
    $userId = $_POST['userId'];
    $amount = $_POST['amount'];
    // if(isset($_POST['driverLetitude']) && isset($_POST['driverLongitude']))
    // {
    //    $driverLetitude = $_POST['driverLetitude'];
    //    $driverLogitude = $_POST['driverLongitude'];
    //    if(!empty($driverLetitude) && !empty($driverLogitude))
    //    {
    //        updateDriverLocation($driverLetitude,$driverLogitude,$userId);
    //    }
    // }

    $checkQuery = "SELECT * FROM book_ride WHERE userId = '$userId'";
    $check = mysqli_query($con,$checkQuery);

    if(mysqli_num_rows($check) > 0)
    {
        $updateAmountQuery = "UPDATE book_ride SET amount = '$amount' WHERE userId = '$userId'";
        $updateAmount = mysqli_query($con,$updateAmountQuery);

        if($updateAmount)
        {
            $response['status'] = "200";
            $response['message'] = "amount update successfully";
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
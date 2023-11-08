<?php

require 'db.php';
header("content-type:application/json");
// function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
// {   
//     global $response,$con;

//     $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE id = '$driverId'");

//     if($updateLocation)
//     {
//         $response['status'] = "true";
//         $response['message'] = "update location";
//     }

// }

function softDeleteDriverRequest($userId)
{
    global $con;
    $data = [];
    $checkDriverRequestQuery = "SELECT * FROM driver_request WHERE user_id = '$userId'";
    $checkDriverRequest = mysqli_query($con, $checkDriverRequestQuery);

    if (mysqli_num_rows($checkDriverRequest) > 0) {
        while ($row = mysqli_fetch_assoc($checkDriverRequest)) {
            $insertRequestQuery = "INSERT INTO trash_driver_request(user_id,driverId,firstname,photo,vehicleType,vahicleBrand,rating,amount,time,arrived_status)VALUES('{$row['user_id']}','{$row['driverId']}','{$row['firstname']}','{$row['photo']}','{$row['vehicleType']}','{$row['vehicleBrand']}','{$row['rating']}','{$row['amount']}','{$row['time']}','{$row['arrived_status']}')";
            $insertRequest = mysqli_query($con, $insertRequestQuery);
            if ($insertRequest) {
                $deletedriverRequest = mysqli_query($con, "DELETE FROM driver_request WHERE user_id = '$userId'");
                $response['status'] = "200";
            }
        }
    } else {
        $response['status'] = "404";
        $response['message'] = "Database empty";
    }

    return $response;
}

if (isset($_POST['amount']) && isset($_POST['pickupLetitude']) && isset($_POST['pickupLongitude']) && isset($_POST['dropLatitude']) && isset($_POST['dropLongitude'])) {
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $pickupLetitude = $_POST['pickupLetitude'];
    $pickupLongitude = $_POST['pickupLongitude'];
    $dropLetitude = $_POST['dropLatitude'];
    $dropLongitude = $_POST['dropLongitude'];
    $amount = $_POST['amount'];
    $fromaddress = $_POST['fromAddress'];
    $toaddress = $_POST['toAddress'];
    $paymentMode = $_POST['paymentMode'];
    $vehicaleType = $_POST['vehicaleType'];

    // updateDriverLocation($_POST['driverLatitude'], $_POST['driverLongitude'], $driverId);

    if (isset($_POST['status']) == "accept") {
        $status = $_POST['status'];
        $passangerName = mysqli_query($con, "SELECT firstname FROM user WHERE id = '$userId'");
        $data = mysqli_fetch_assoc($passangerName);
        $passangerName = $data['firstname'];
        if (!empty($pickupLetitude) && !empty($pickupLongitude) && !empty($dropLetitude) && !empty($dropLongitude) && !empty($amount)) {
            $insertRideQuery = "INSERT INTO book_ride(userId,driverId,pessangerName,pickup_letitude,pickup_longitude,drop_letitude,drop_longitude,vehicle_type,amount,payment_mode,status,fromAddress,toAddress)VALUES('$userId','$driverId','$passangerName','$pickupLetitude','$pickupLongitude','$dropLetitude','$dropLongitude','$vehicaleType','$amount','$paymentMode','$status','$fromaddress','$toaddress')";
            $insertRide = mysqli_query($con, $insertRideQuery);
            if ($insertRide) {
                $updateRequestQuery = "UPDATE request SET status = '$status' WHERE driver_id = '$driverId' AND user_id = '$userId'";
                $updateRequest = mysqli_query($con, $updateRequestQuery);

                softDeleteDriverRequest($userId);
                $response['status'] = "200";
                $response['message'] = "Ride booking successfully!";
            }
        }
    } else {

        $response['status'] = "404";
        $response['message'] = "something went worng";
    }
} else {
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);

<?php

require 'db.php';
header("content-type:application/json");

$response = [];

function calculateAverangeRating($driverId)
{
    global $con;

    $findRatingQuery = "SELECT rating,COUNT(*) AS count FROM rating WHERE driverId = '$driverId'";
    $findRaiting = mysqli_query($con,$findRatingQuery);

    $totalRating = 0;
    $totalReviews = 0;

    while($row = mysqli_fetch_assoc($findRaiting))
    {
        $rating = $row['rating'];
        $count = $row['count'];

        $totalReviews += $count;
        $totalRating += ($rating * $count);
    }

    $averangeRating = 0;
    if($totalReviews > 0)
    {
        $averangeRating = ($totalRating / $totalReviews);
    }

    return number_format($averangeRating,1);
}


function driverdata($driverId,$userId,$amount,$arrivedTime)
{
    global $con;

    $checkRequestQuery = "SELECT * FROM driver_request WHERE user_id = '$userId' AND driverId = '$driverId'";
    $checkRequest = mysqli_query($con,$checkRequestQuery);
    if(mysqli_num_rows($checkRequest) > 0)
    {
        $userdata = "SELECT firstname,photo,vehicleType,vehicle_brand_name FROM user INNER JOIN vehicleinfo ON user.driverId = vehicleinfo.driverId WHERE user.driverId = '$driverId'";
        $result = mysqli_query($con, $userdata);
        $row = mysqli_fetch_assoc($result);
        $rating = calculateAverangeRating($driverId);
        $update_query = "UPDATE driver_request SET  user_id = '$userId',driverId = '$driverId',firstname = '{$row['firstname']}',photo = '{$row['photo']}',vehicleType = '{$row['vehicleType']}',vehicleBrand = '{$row['vehicle_brand_name']}',rating = '$rating',amount = '$amount',time = '$arrivedTime' WHERE user_id = '$userId' AND driverId = '$driverId'";
        $update = mysqli_query($con,$update_query);
        if($update)
        {
            $response['update'] = "200";
        }
    }
    else
    {
        $userdata = "SELECT firstname,photo,vehicleType,vehicle_brand_name FROM user INNER JOIN vehicleinfo ON user.driverId = vehicleinfo.driverId WHERE user.driverId = '$driverId'";
        $result = mysqli_query($con, $userdata);
        $row = mysqli_fetch_assoc($result);
        $rating = calculateAverangeRating($driverId);
        $insert_query = "INSERT INTO driver_request(user_id,driverId,firstname,photo,vehicleType,vehicleBrand,rating,amount,time	
        )VALUES('$userId','$driverId','{$row['firstname']}','{$row['photo']}','{$row['vehicleType']}','{$row['vehicle_brand_name']}','$rating','$amount','$arrivedTime')";
        $insert = mysqli_query($con,$insert_query);
    
        if($insert)
        {
            $response['insert'] = "200";
        }
    }


    return $response;
}

if (isset($_POST['driverId'])) 
{   
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $amount = $_POST['amount'];
    $arrivedTime = $_POST['time'];

    if($_POST['status'] = "accept")
    {
        $status = $_POST['status'];
        
        $driver  = driverdata($driverId,$userId,$amount,$arrivedTime);
        $check_booking_query = "SELECT * FROM request WHERE driver_id = '$driverId' AND user_id = '$userId'";
        $check_booking = mysqli_query($con,$check_booking_query);
        
        $response[] = $driver;
        if(mysqli_num_rows($check_booking) > 0)
        {
            // $request = mysqli_fetch_assoc($check_booking);
            $updateRequestQuery = "UPDATE request SET amount = '$amount' , arrived_time = '$arrivedTime' WHERE driver_id = '$driverId' AND user_id = '$userId'";
            $updateRequest = mysqli_query($con,$updateRequestQuery);
    
            if($updateRequest)
            {
                $response['status'] = "200";
                $response['message'] = "Accept successfully";
            }
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
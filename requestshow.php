<?php
require 'db.php';
header("content-type:application/json");

$response = array();

function showRequestHistory($driverId)
{
    global $con,$response;

    $requestHistoryQuery = "SELECT * FROM book_ride WHERE driverId = '$driverId'";
    $requestHistory = mysqli_query($con,$requestHistoryQuery);

    if(mysqli_num_rows($requestHistory) > 0)
    {
        while($row = mysqli_fetch_assoc($requestHistory))
        {
            $response['RequestHistory'][] = $row;
        }
    }
    else
    {
        $response['status'] = "404";
        $response['message'] = "Request not found";
    }

    return $response;
}

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

    $averangeRating = ($totalRating / $totalReviews);

    return round($averangeRating,2);
}

if(isset($_POST['driverId']))
{
    $driverId = $_POST['driverId'];
    $requestHistory = showRequestHistory($driverId);
}
if(isset($_POST['id']))
{
    $user_id = $_POST['id'];
    if(!empty($user_id))
    {
        $userdata = "SELECT driverLetitude,driverLongitude,firstname,mobile_number,photo,vehicleType,vehicle_brand_name,Number_plate FROM user INNER JOIN vehicleinfo ON user.id = vehicleinfo.user_id WHERE user.id = '$user_id'";
        $result = mysqli_query($con, $userdata);
        $rating = calculateAverangeRating($user_id);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $response['driverLetitude'] = $row['driverLetitude'];
                $response['driverLongitude'] = $row['driverLongitude'];
                $response['user'] = $row['firstname'];
                $response['mobile_number'] = $row['mobile_number'];
                $response['profile'] = $row['photo'];
                $response['vehicle'] = $row['vehicle_brand_name'];
                $response['vehicletype'] = $row['vehicleType'];
                $response['time'] = '2 min';
                $response['numberPlate'] = $row['Number_plate'];
                $response['rating'] = $rating;
            }
        } else {
            $response['error'] = "400";
            $response['message'] = "User data not found";
        }   
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "user not found";
}
echo json_encode($response);
?>

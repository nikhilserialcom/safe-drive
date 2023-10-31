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
    $averangeRating = 0;
    if($averangeRating > 0)
    {
        $averangeRating = ($totalRating / $totalReviews);
    }

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
    $fromAddress = $_POST['fromAddress'];
    $toAddress = $_POST['toAddress'];
    if(!empty($user_id))
    {
        $dataQuery = "SELECT driverLetitude,driverLongitude,mobile_number,Number_plate FROM user INNER JOIN vehicleinfo ON user.driverId = vehicleinfo.driverId WHERE user.driverId = '$user_id'";
        $data = mysqli_query($con, $dataQuery);
        $driverdata = mysqli_fetch_assoc($data);
        $mobileNumber = $driverdata['mobile_number'];
        $number_plate = $driverdata['Number_plate'];
        $driverLetitude = $driverdata['driverLetitude'];
        $driverLongitude = $driverdata['driverLongitude'];

        $userdata = "SELECT * FROM driver_request WHERE driverId = '$user_id'";
        $result = mysqli_query($con,$userdata);

        $placeinfoQuery = "SELECT * FROM request where driver_id = '$user_id'";
        $placeinfo = mysqli_query($con,$placeinfoQuery);
        
        $rating = calculateAverangeRating($user_id);
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $response['driverLetitude'] = $driverLetitude;
                $response['driverLongitude'] = $driverLongitude;
                $response['userId'] = $row['user_id'];
                $response['driverId'] = $row['driverId'];
                $response['user'] = $row['firstname'];
                $response['mobile_number'] = $mobileNumber;
                $response['profile'] = $row['photo'];
                $response['vehicle'] = $row['vehicleBrand'];
                $response['vehicleType'] = $row['vehicleType'];
                $response['time'] = $row['time'];
                $response['numberPlate'] = $number_plate;
                $response['rating'] = $rating;
                
            }
            if(mysqli_num_rows($placeinfo))
            {
                while($placeData = mysqli_fetch_assoc($placeinfo))
                {
                    if($placeData['fromAddress'] == $fromAddress)
                    {
                        $response['fromLetitude'] = $placeData['passengerLat'];
                        $response['fromLongitude'] = $placeData['passengerLog'];
                        $response['toLetitude'] = $placeData['dropLat'];
                        $response['toLongitude'] = $placeData['dropLog'];
                    }
                }
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

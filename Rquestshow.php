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
        $userdata = "SELECT firstname,photo,vehicle_brand_name,Number_plate FROM user INNER JOIN vehicleinfo ON user.id = vehicleinfo.user_id WHERE user.id = '$user_id' LIMIT 3";
        $result = mysqli_query($con, $userdata);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $response['user'] = $row['firstname'];
                $response['profile'] = $row['photo'];
                $response['vehicle'] = $row['vehicle_brand_name'];
                $response['numberPlate'] = $row['Number_plate'];
            
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

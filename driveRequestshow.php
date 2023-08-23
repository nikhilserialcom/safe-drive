<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['driverId']))
{
    $driverid = $_POST['driverId'];
    $amount = $_POST['amount'];

    $driverinfoQuery = "SELECT * FROM user INNER JOIN vehicleinfo ON user.id = vehicleinfo.user_id WHERE user.id = '$driverid' LIMIT 3";
    $driverInfo = mysqli_query($con,$driverinfoQuery);

    if(mysqli_num_rows($driverInfo) > 0)
    {
        while ($row = mysqli_fetch_assoc($driverInfo)) {
            $response['status'] = "200";
            $response['user'] = $row['firstname'];
            $response['profile'] = $row['photo'];
            $response['vehicle'] = $row['vehicle_brand_name'];
            $response['numberPlate'] = $row['Number_plate'];
            $response['amount'] = $amount;
        }
    }
    else {
        $response['status'] = "400";
        $response['message'] = "User Not Found";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR";
}

echo json_encode($response);
?>
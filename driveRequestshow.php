<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['driverId']))
{
    $driverid = $_POST['driverId'];
    $checkOnlineQuery  = "SELECT * FROM user WHERE driverId = '$driverid'";
    $checkOnline = mysqli_query($con,$checkOnlineQuery);

    if(mysqli_num_rows($checkOnline) > 0)
    {
        $row = mysqli_fetch_assoc($checkOnline);

        $driverinfoQuery = "SELECT * FROM request where driver_id = '$driverid'";
        $driverInfo = mysqli_query($con,$driverinfoQuery);
    
        if(mysqli_num_rows($driverInfo) > 0)
        {
            while ($row = mysqli_fetch_assoc($driverInfo)) {
                $data[] = $row;
            }
            $response['status'] = "200";
            $response['request'] = $data;
        }
        else
        {
            $response['status'] = "404";
            $response['message'] = "database empty";
        }
    }
    else 
    {
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
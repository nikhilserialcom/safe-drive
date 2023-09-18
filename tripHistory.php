<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $tripStatus = $_POST['tripStatus'];

    if($tripStatus == "past")
    {
        $tripHistoryQuery = "SELECT * FROM completerides WHERE userId = '$userId' OR driverId = '$userId'";
        $tripHistory = mysqli_query($con,$tripHistoryQuery);

        if(mysqli_num_rows($tripHistory) > 0)
        {
            while($row = mysqli_fetch_assoc($tripHistory))
            {
                if($row['userId'] == "$userId")
                {
                    $dirverId = $row['driverId'];
                    $driverDataQuery = "SELECT * FROM user WHERE driverId = '$dirverId'";
                    $driverdata = mysqli_query($con,$driverDataQuery);
                    $driver = mysqli_fetch_assoc($driverdata);
                    $row['drivername'] = $driver['firstname'];
                    $response['status'] = "200";
                    $response['data'][] = $row;
                }
                else
                {
                    $response['status'] = "400";
                    $response['data'][] = $row;
                }
            }
        }
        else
        {
            $response['status'] = "404";
            $response['message'] = "database empty";
        }
    }
    else
    {
        $upcomingTripQuery = "SELECT * FROM book_ride WHERE userId = '$userId' OR driverId = '$userId'";
        $upcomingTrip = mysqli_query($con,$upcomingTripQuery);

        $time = '';

        if(mysqli_num_rows($upcomingTrip) > 0)
        {
            while($upcoming = mysqli_fetch_assoc($upcomingTrip))
            {
                if($upcoming['userId'] == $userId)
                {
                    $dataQuery = mysqli_query($con,"SELECT driverLetitude,driverLongitude,mobile_number,Number_plate FROM user INNER JOIN vehicleinfo ON user.driverId = vehicleinfo.driverId WHERE user.driverId = '{$upcoming['driverId']}'");
                    $data = mysqli_fetch_assoc($dataQuery);

                    $driverdataQuery = "SELECT * FROM driver_request WHERE driverId = '{$upcoming['driverId']}'";
                    $driverdata = mysqli_query($con,$driverdataQuery);
                    $driver = mysqli_fetch_assoc($driverdata);

                    $upcoming['drivername'] = $driver['firstname'];
                    $upcoming['profile'] = $driver['photo'];
                    $upcoming['mobile_number'] = $data['mobile_number'];
                    $upcoming['Number_plate'] = $data['Number_plate'];
                    $upcoming['driverLetitude'] = $data['driverLetitude'];
                    $upcoming['driverLongitude'] = $data['driverLongitude'];
                    $upcoming['vehicleBrand'] = $driver['vehicleBrand'];
                    $upcoming['rating'] = $driver['rating'];
                    $upcoming['time'] = $driver['time'];
                    $response['status'] = "200";
                    $response['data'][] = $upcoming;
                }
                elseif($upcoming['driverId'] == $userId)
                {
                    $driverdataQuery = "SELECT * FROM driver_request WHERE driverId = '{$upcoming['driverId']}'";
                    $driverdata = mysqli_query($con,$driverdataQuery);
                    $driver = mysqli_fetch_assoc($driverdata);

                    $dataQuery = mysqli_query($con,"SELECT * FROM user  WHERE id = '{$upcoming['userId']}'");
                    $data = mysqli_fetch_assoc($dataQuery);
                    $upcoming['profile'] = $data['photo'];
                    $upcoming['mobile_number'] = $data['mobile_number'];
                    $upcoming['time'] = $driver['time'];
                    $response['status'] = "200";
                    $response['data'][] = $upcoming;
                }
                else
                {
                    $response['status'] = "404";
                    $response['message'] = "user not found";
                }
            }
        }
        else
        {
            $response['staus'] = "404";
            $response['message'] = "database empty";
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
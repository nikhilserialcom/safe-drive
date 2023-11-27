<?php

require 'db.php';
header("content-type:application/json");

function Driverdata($dirverId){

    global $con;

    $dataQuery = mysqli_query($con,"SELECT driverLetitude,driverLongitude,mobile_number,Number_plate,firstname FROM user INNER JOIN vehicleinfo ON user.driverId = vehicleinfo.driverId WHERE user.driverId = '$dirverId'");
    $data = mysqli_fetch_assoc($dataQuery);

    $driverdataQuery = "SELECT * FROM trash_driver_request WHERE driverId = '$dirverId'";
    $driverdata = mysqli_query($con,$driverdataQuery);
    $driver = mysqli_fetch_assoc($driverdata);
    $driverdata = array(
        'drivername' => $data['firstname'],
        'profile' => $driver['photo'],
        'mobile_number' => $data['mobile_number'],
        'Number_plate' => $data['Number_plate'],
        'driverLetitude' => $data['driverLetitude'],
        'driverLongitude' => $data['driverLongitude'],
        'vehicleBrand' => $driver['vahicleBrand'],
        'rating' => $driver['rating'],
        'time' => $driver['time'],
    );

    return $driverdata;

}

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $tripStatus = $_POST['tripStatus'];

    if($tripStatus == "cancel")
    {
        $tripHistoryQuery = "SELECT * FROM completerides WHERE userId = '$userId' OR driverId = '$userId'";
        $tripHistory = mysqli_query($con,$tripHistoryQuery);

        if(mysqli_num_rows($tripHistory) > 0)
        {
            while($row = mysqli_fetch_assoc($tripHistory))
            {
                if(($row['userId'] == "$userId" && $row['rideStatus'] == "cancel") || ($row['driverId'] == "$userId" && $row['rideStatus'] == "cancel"))
                {
                    $dirverId = $row['driverId'];
                    $driverDataQuery = "SELECT * FROM user WHERE driverId = '$dirverId'";
                    $driverdata = mysqli_query($con,$driverDataQuery);
                    $driver = mysqli_fetch_assoc($driverdata);
                    $row['drivername'] = $driver['firstname'];
                    $response['status'] = "200";
                    $response['data'][] = $row;
                }
            }
        }
        else
        {
            $response['status'] = "404";
            $response['message'] = "past database empty";
        }
    }
    else
    {
        $upcomingTripQuery = "SELECT * FROM book_ride WHERE userId = '$userId' OR driverId = '$userId'";
        $upcomingTrip = mysqli_query($con,$upcomingTripQuery);
        $upcomingData = [];

        while($upcoming = mysqli_fetch_assoc($upcomingTrip))
        {
            if($upcoming['userId'] == $userId)
            {
                $upcoming['driverdata'] = Driverdata($upcoming['driverId']);
                $upcomingData[] = $upcoming;
            }
            elseif($upcoming['driverId'] == $userId)
            {
                $upcoming['driverdata'] = Driverdata($upcoming['driverId']);
                $upcomingData[] = $upcoming;
            }
        }
        $time = '';

        $pastTripQuery = "SELECT * FROM completerides WHERE userId = '$userId' OR driverId = '$userId'";
        $pastTrip = mysqli_query($con,$pastTripQuery);
        $pastData = [];
        
        while($pastTripData = mysqli_fetch_assoc($pastTrip))
        {
            if($pastTripData['userId'] == $userId && $pastTripData['rideStatus'] == 'finish')
            {
                $pastTripData['driverData'] = Driverdata($pastTripData['driverId']);
                $pastData[] = $pastTripData;
            }
            elseif($pastTripData['driverId'] == $userId && $pastTripData['rideStatus'] == 'finish')
            {
                $pastTripData['driverData'] = Driverdata($pastTripData['driverId']);
                $pastData[] = $pastTripData;
            }
        }


        $totalData = array_merge($upcomingData,$pastData);
        $response['status'] = "200";
        $response['data'] = $totalData; 
    }
    

} 
else 
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}


echo json_encode($response);
?>
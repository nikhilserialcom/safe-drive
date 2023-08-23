<?php

require 'db.php';
header("content-type:application/json");

function findDistance($passengerLat, $passengerLog, $driverLat, $driverLog)
{
    $earthRadius = 6371;  // radius of earth in kilometers

    $dLat = deg2rad($driverLat - $passengerLat);
    $dLog = deg2rad($driverLog - $passengerLog);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($passengerLat)) * cos(deg2rad($passengerLog)) * sin($dLog / 2) * sin($dLog / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c; // Distance in kilometers

    return $distance;
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


function sendRequest($driverId,$passengerLat, $passengerLog,$dropLat,$dropLog,$amount,$vehicleinfo)
{
  
        $message[] = "Sending ride request to Driver ID: " . $driverId;
        $message[] = "Passenger From latitude: " . $passengerLat;
        $message[] = "Passenger From logitude: " . $passengerLog;
        $message[] = "Passenger  amount: " . $amount;
        $message[] = "Passenger selected vehicla: " . $vehicleinfo;
        $message[] = "Passenger to latitude: " . $dropLat;
        $message[] = "Passenger to logitude: " . $dropLog;
        return $message;
}

if (isset($_POST['passengerLat']) && isset($_POST['passengerLog'])) {
    // Passenger's location
    $passengerLat = $_POST['passengerLat']; // Latitude
    $passengerLog = $_POST['passengerLog']; // Longitude
    $dropLat = $_POST['dropLat'];
    $dropLog = $_POST['dropLog'];
    $amount = $_POST['amount'];
    $vehicleinfo = $_POST['vehicleinfo'];

    // Array of potential driver locations
    $drivers = [];
    $select_query = "SELECT id, firstname,photo,driverLetitude, driverLongitude FROM user Where vehicletype = '$vehicleinfo'";
    $data = mysqli_query($con, $select_query);

    if (mysqli_num_rows($data) > 0) {
        while ($row = mysqli_fetch_assoc($data)) {
            $drivers[] = $row;
        }
    }

    $range = 5; // Maximum range in kilometers
    $availableDrivers = [];

    foreach ($drivers as $driver) {
        $driverLat = floatval($driver['driverLetitude']);
        $driverLog = floatval($driver['driverLongitude']);
        $driverId = $driver['id'];

        $distance = findDistance($passengerLat, $passengerLog, $driverLat, $driverLog);
        $rating = calculateAverangeRating($driverId);
        
        if ($distance <= $range) {
            $driver['distance'] = $distance * 1000;
            $driver['rating'] = $rating;
            $availableDrivers[] = $driver;
        }
    }
    
    $response['status'] = "200";
    $response['driver'] = $availableDrivers;
    $response['message'] = "Request send to driver";
    $response['sendmessage'] = array();
    // $response['rating'] = array();

    // Send ride request to drivers within range
    foreach ($availableDrivers as $driver) {
        $driverID = $driver['id'];
        $message = sendRequest($driverID,$passengerLat, $passengerLog,$dropLat,
        $dropLog,$amount,$vehicleinfo);
        $response['sendmessage'][] = $message;
    }
} else {
    $response['status'] = "500";
    $response['message'] = "passenger location not found";
}

echo json_encode($response);
?>

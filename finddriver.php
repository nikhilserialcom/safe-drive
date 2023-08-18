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

function sendRequest($driverId)
{
    global $con;
    $select_query = "SELECT * FROM book_ride ORDER BY id DESC limit 1";
    $data = mysqli_query($con, $select_query);
    
    if (mysqli_num_rows($data)) {
        $message = array();
        while ($row = mysqli_fetch_assoc($data)) {
            $message[] = "Sending ride request to Driver ID: " . $driverId;
            $message[] = "Sending ride request to Passenger NAME: " . $row['pessangerName'];
            $message[] = "Sending ride request to Pickup point: " . $row['pickup_letitude'] ."," . $row['pickup_longitude'];
            $message[] = "Sending ride request to Destination: " . $row['drop_letitude'] ."," . $row['drop_longitude'];
            $message[] = "Sending ride request to Amount: " . $row['amount'] . " " . "RS";
        }

        return $message;
    }

    return "No data found for driver ID: " . $driverId;
}

if (isset($_POST['passengerLat']) && isset($_POST['passengerLog'])) {
    // Passenger's location
    $passengerLat = $_POST['passengerLat']; // Latitude
    $passengerLog = $_POST['passengerLog']; // Longitude

    // Array of potential driver locations
    $drivers = [];
    $select_query = "SELECT id, firstname, driverLetitude, driverLongitude FROM user";
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

        $distance = findDistance($passengerLat, $passengerLog, $driverLat, $driverLog);

        if ($distance <= $range) {
            $driver['distance'] = $distance * 1000;
            $availableDrivers[] = $driver;
        }
    }
    
    $response['status'] = "200";
    $response['driver'] = $availableDrivers;
    $response['message'] = array();

    // Send ride request to drivers within range
    foreach ($availableDrivers as $driver) {
        $driverID = $driver['id'];
        $message = sendRequest($driverID);
        $response['message'][] = $message;
    }
} else {
    $response['status'] = "500";
    $response['message'] = "passenger location not found";
}

echo json_encode($response);
?>

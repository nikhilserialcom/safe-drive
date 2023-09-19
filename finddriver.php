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

    $averangeRating = 0;
    if($averangeRating > 0)
    {
        $averangeRating = ($totalRating / $totalReviews);
    }

    return round($averangeRating,2);
}


function sendRequest($requests)
{
    global $con;
    $successCount = 0;
    // print_r($requests);
    foreach ($requests as $request) {
        
        $driverId =  $request['driverId'];
        $userId =  $request['userId'];
        $checkRequestQuery = "SELECT * FROM request WHERE user_id = '$userId' AND driver_id = '$driverId'";
        $checkRequest = mysqli_query($con,$checkRequestQuery);

        if(mysqli_num_rows($checkRequest) > 0)
        {
            $name =  $request['pessangerName'];
            $mobileNumber = $request['mobile_number'];
            $profile = $request['profile'];
            $passengerLat =  $request['passengerLat'];
            $passengerLog =  $request['passengerLog'];
            $dropLat =  $request['dropLat'];
            $dropLog =  $request['dropLog'];
            $amount =  $request['amount'];
            $fromaddress =  $request['fromAddress'];
            $toaddress =  $request['toAddress'];
            $paymentMode =  $request['paymentMode'];
            $vehicleinfo = $request['vehicleTpye'];
                
            $updateRequestQuery = "UPDATE request SET driver_id = '$driverId', user_id = '$userId',pessangerName = '$name',mobile_number = '$mobileNumber',profile = '$profile', passengerLat = '$passengerLat', passengerLog = '$passengerLog', dropLat = '$dropLat', dropLog = '$dropLog', amount = '$amount', payment_mode = '$paymentMode', vehicleType = '$vehicleinfo', fromAddress = '$fromaddress', toAddress = '$toaddress' WHERE user_id = '$userId' AND driver_id = '$driverId'";
            $updateRequest = mysqli_query($con, $updateRequestQuery);
        
            if ($updateRequest) {
                $response['update'] = "200";
                $successCount++;
            }
           
        }
        else
        {
            $name =  $request['pessangerName'];
            $mobileNumber = $request['mobile_number'];
            $profile = $request['profile'];
            $passengerLat =  $request['passengerLat'];
            $passengerLog =  $request['passengerLog'];
            $dropLat =  $request['dropLat'];
            $dropLog =  $request['dropLog'];
            $amount =  $request['amount'];
            $fromaddress =  $request['fromAddress'];
            $toaddress =  $request['toAddress'];
            $paymentMode =  $request['paymentMode'];
            $vehicleinfo = $request['vehicleTpye'];
                
            $insertRequestQuery = "INSERT INTO request(driver_id, user_id,	pessangerName,mobile_number,profile, passengerLat, passengerLog, dropLat, dropLog, amount, payment_mode, vehicleType, fromAddress, toAddress) VALUES ";
            $values = "('$driverId', '$userId','$name','$mobileNumber','$profile','$passengerLat', '$passengerLog', '$dropLat', '$dropLog', '$amount', '$paymentMode', '$vehicleinfo', '$fromaddress', '$toaddress')";
        
            $insertRequestQuery .= $values;
            $insertRequest = mysqli_query($con, $insertRequestQuery);
        
            if ($insertRequest) {
                $response['insert'] = "200";
                $successCount++;
            }
        }
    }

    return $response;
}

if (isset($_POST['passengerLat']) && isset($_POST['passengerLog'])) {
    // Passenger's location
    $userId = $_POST['userId'];
    $passengerLat = $_POST['passengerLat']; // Latitude
    $passengerLog = $_POST['passengerLog']; // Longitude
    $dropLat = $_POST['dropLat'];
    $dropLog = $_POST['dropLog'];
    $amount = $_POST['amount'];
    $fromaddress = $_POST['fromAddress'];
    $toaddress = $_POST['toAddress'];
    $paymentMode = $_POST['paymentMode'];
    $vehicleinfo = $_POST['vehicleinfo'];

    $name = mysqli_query($con,"SELECT firstname,photo,mobile_number FROM user WHERE id = '$userId'");
    $data = mysqli_fetch_assoc($name);
    $passangerName = $data['firstname'];
    $profile = $data['photo'];
    $mobileNumber = $data['mobile_number'];
    // echo $profile;
    // Array of potential driver locations
    $drivers = [];
    $select_query = "SELECT driverId,firstname,vehicleType,vehicleBrand,photo,driverLetitude,driverLongitude FROM user Where vehicletype = '$vehicleinfo'";
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
        $driverId = $driver['driverId'];

        $distance = findDistance($passengerLat, $passengerLog, $driverLat, $driverLog);
        $rating = calculateAverangeRating($driverId);
        
        if ($distance <= $range) {
            $driver['distance'] = $distance * 1000;
            $driver['rating'] = $rating;
            $driver['amount'] = "500";
            $driver['time'] = "3min";
            $availableDrivers[] = $driver;
        }
    }

    $requestdata = array();
    foreach($availableDrivers as $drRequest)
    {
        $driverid = $drRequest['driverId'];
        $driverRequestQuery = "SELECT * FROM driver_request WHERE driverId = '$driverid' AND user_id = '$userId'";
        $driverRequest = mysqli_query($con,$driverRequestQuery);
        if(mysqli_num_rows($driverRequest))
        {
            while($data = mysqli_fetch_assoc($driverRequest))
            {
                $data['distance'] = $drRequest['distance'];
                $requestdata[] = $data; 
            }
        }
    }
    
    $response['status'] = "200";
    $response['driver'] = $requestdata;
    // $response['driverequest'] = $availableDrivers;
    $response['message'] = "Request send to driver";

    // $response['rating'] = array();

    // Send ride request to drivers within range
    foreach ($availableDrivers as $driver) {
        $driverID = $driver['driverId'];
        $requests = array(
            'driverId' => $driverID,
            'userId' => $userId,
            'pessangerName' => $passangerName,
            'mobile_number' => $mobileNumber,
            'profile' => $profile,
            'passengerLat' =>$passengerLat,
            'passengerLog' => $passengerLog,
            'dropLat' => $dropLat,
            'dropLog' => $dropLog,
            'amount' => $amount,
            'fromAddress' => $fromaddress,
            'toAddress' => $toaddress,
            'paymentMode' => $paymentMode,
            'vehicleTpye' => $vehicleinfo,
        );
        $checkStatusQuery = "SELECT * FROM user WHERE driverId = '$driverID' AND driverstatus = 'online'";
        $checkStatus = mysqli_query($con,$checkStatusQuery);
        if(mysqli_num_rows($checkStatus) > 0)
        {
            $driver_request = sendRequest(array($requests));
        }
        
    }
    $response['driverstatus'] = $driver_request;
} else {
    $response['status'] = "500";
    $response['message'] = "passenger location not found";
}

echo json_encode($response);
?>

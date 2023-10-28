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

function sendPushNotification($driverId)
{
    global $con;
    $findTokenQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $findToken = mysqli_query($con,$findTokenQuery);

    $deviceToken = array();
    if(mysqli_num_rows($findToken) > 0)
    {
        while($row = mysqli_fetch_assoc($findToken))
        {
            $token = $row['deviceToken'];
            if(!empty($token))
            {
                $deviceToken[] = $token;
                $serverKey = 'AAAAzpUqMlE:APA91bEXySQ-4aw7rQB6Sloy2WLgyAr4XIEToPk5xo98u-wDOICMTC1ExzysY0SYBBio24gHaFgQlPh0BV3RIL-Ls34Y-d-_v205s79Bxj6MZ-tH2WI7_mlp6jGXtsxB5gNmloxmIIgQ'; // Replace with your Firebase Server Key
                $data = [
                    'to' => $token, // The recipient's FCM token
                    'notification' => [
                        'title' => 'Safe Drive',
                        'body' => 'you have a new request',
                        // 'sound' => '21.mp3',
                        'image' => 'https://mcdn.wallpapersafari.com/medium/55/83/Pl6QHc.jpg',
                    ],
                ];
                $headers = [
                    'Authorization: key=' . $serverKey,
                    'Content-Type: application/json',
                ];
                $ch = curl_init('https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Not recommended for production
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                $response = curl_exec($ch);
                if ($response === false) {
                    die('Error: ' . curl_error($ch));
                }
                curl_close($ch);
                // echo $response;
            }
        }
    }

    return $deviceToken;
}

function sendRequest($requests)
{
    global $con;
    $successCount = 0;
    foreach ($requests as $request) {
        
        $driverId =  $request['driverId'];
        $userId =  $request['userId'];
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

        $checkRequestQuery = "SELECT * FROM request WHERE driver_id = '$driverId' AND user_id = '$userId' AND toAddress = '$toaddress'";
        $checkRequest = mysqli_query($con,$checkRequestQuery);
        if(mysqli_num_rows($checkRequest) > 0)
        {
            $updateRequestQuery = "UPDATE request SET driver_id = '$driverId', user_id = '$userId',pessangerName = '$name',mobile_number = '$mobileNumber',profile = '$profile', passengerLat = '$passengerLat', passengerLog = '$passengerLog', dropLat = '$dropLat', dropLog = '$dropLog', amount = '$amount', payment_mode = '$paymentMode', vehicleType = '$vehicleinfo', fromAddress = '$fromaddress', toAddress = '$toaddress' WHERE driver_id = '$driverId' AND user_id = '$userId' AND toAddress = '$toaddress'";
            $updateRequest = mysqli_query($con,$updateRequestQuery);
            if($updateRequest)
            {
                $deleteDriverRequest = mysqli_query($con,"DELETE FROM driver_request  WHERE driverId = '$driverId' AND user_id = '$userId'");
                if($deleteDriverRequest)
                {
                    $response['update'] = "200";
                    $successCount ++;
                }
            }
        }
        else
        {

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
    $check = $_POST['checkApiPosition'];

    $name = mysqli_query($con,"SELECT firstname,photo,mobile_number FROM user WHERE id = '$userId'");
    $data = mysqli_fetch_assoc($name);
    $passangerName = $data['firstname'];
    $profile = $data['photo'];
    $mobileNumber = $data['mobile_number'];
    // Array of potential driver locations
    $drivers = [];
    $select_query = "SELECT driverId,firstname,vehicleType,vehicleBrand,photo,driverLetitude,driverLongitude FROM user Where vehicletype = '$vehicleinfo'";
    $data = mysqli_query($con, $select_query);

    if (mysqli_num_rows($data) > 0) {
        while ($row = mysqli_fetch_assoc($data)) {
            $drivers[] = $row;
        }
    }
    else
    {
        $response['status'] = '404';
        $response['message'] = "driver not found";
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
            $availableDrivers[] = $driver;
        }
    }

    if($availableDrivers)
    {
        $response['status'] = "200";
        // $response['driverequest'] = $availableDrivers;
        $response['message'] = "Request send to driver";
    }
    else
    {
        $response['status'] = "404";
        $response['message'] = "No driver found near by you";
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

  

    if($requestdata){
        $response['status'] = "200";
        $response['driver'] = $requestdata;  
    }
   
    
    $notification = array();
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
        $checkStatusQuery = "SELECT * FROM user WHERE driverId = '$driverID' AND vehicletype = '$vehicleinfo' AND driverstatus = 'online'";
        $checkStatus = mysqli_query($con,$checkStatusQuery);
        if(mysqli_num_rows($checkStatus) > 0)
        {
            if($check == "true")
            {
                $driver_request = sendRequest(array($requests));
                $deviceTokens = sendPushNotification($driverId);
                $notification[$driverId] = $deviceTokens; 
            }
        }
        
    }
    // $response['driverstatus'] = $driver_request;
    // $response['notification'] = $notification;
} else {
    $response['status'] = "500";
    $response['message'] = "passenger location not found";
}

echo json_encode($response);
?>

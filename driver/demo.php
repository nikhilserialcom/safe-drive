<?php

require '../db.php';

header("content-type: application/json");

session_start();

function driver_data($userId)
{
    global $con;

    $checkUserQuery = "SELECT * FROM user WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0){
        $dirver_data = "true";
    }
    else{
        $dirver_data = "false";
    }

    return $dirver_data;
}

function aadhar_card_data($userId)
{
    global $con;
    $checkUserQuery = "SELECT * FROM adhaarcard WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    if (mysqli_num_rows($checkUser) > 0) {
        $aadhar_data = "true";
    } else {
        $aadhar_data = "false";
    }

    return $aadhar_data;
}

function police_certificate($userId)
{
    global $con;
    $checkUserQuery = "SELECT * FROM police_clearance_certificate WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    if (mysqli_num_rows($checkUser) > 0) {
        $police_doc_data = "true";
    } else {
        $police_doc_data = "false";
    }

    return $police_doc_data;
}

function vehicle_insurance($userId, $vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM vehicle_insurance WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    if (mysqli_num_rows($checkUser) > 0) {
        $insurance_data = "true";
    } else {
        $insurance_data = "false";
    }

    return $insurance_data;
}

function driving_licese($userId, $vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM driving_licese_info WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    if (mysqli_num_rows($checkUser) > 0) {
        $licese_data = "true";
    } else {
        $licese_data = "false";
    }

    return $licese_data;
}

function vehicleinfo($userId, $vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM vehicleinfo WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    if (mysqli_num_rows($checkUser) > 0) {
        $vehicle_data = "true";
    } else {
        $vehicle_data = "false";
    }

    return $vehicle_data;
}

$userId = isset($_POST['driverId']) ? $_POST['driverId'] : '';
$vehicle_type = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] : '';

$dirver_data = driver_data($userId);
$aadhar_data = aadhar_card_data($userId);
$police_doc_data = police_certificate($userId);
$insurance_doc_data = vehicle_insurance($userId, $vehicle_type);
$licese_data = driving_licese($userId, $vehicle_type);
$vehicleinfo = vehicleinfo($userId, $vehicle_type);

$response = array(
    'status' => "200",
    'driverData' => $dirver_data,
    'aadharData' => $aadhar_data,
    'policeData' => $police_doc_data,
    'insuranceData' => $insurance_doc_data,
    'liceseData' => $licese_data,
    'vehicleData' => $vehicleinfo
);

echo json_encode($response,JSON_PRETTY_PRINT);

// require '../db.php';
// header("content-type:application/json");

// if ($_POST['driverId']) {
//     $driverId = $_POST['driverId'];
//     $vehicle_type = $_POST['vehicle_type'];
//     $dataQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
//     $data = mysqli_query($con, $dataQuery);
//     $driverdata = mysqli_fetch_assoc($data);

//     $table_name = ['user', 'driving_licese_info', 'vehicleinfo', 'police_clearance_certificate', 'adhaarcard', 'vehicle_insurance'];

//     $checkData = array();
//     foreach ($table_name as $name) {
//         $checkDataQuery = "SELECT * FROM $name WHERE driverId = '$driverId'";
//         $result = mysqli_query($con, $checkDataQuery);
//         if (mysqli_num_rows($result) > 0) {
//             while($row = mysqli_fetch_assoc($result)){
//                 if ($row) {
//                     if($name == 'user' && empty($row['email']))
//                     {
//                         $checkData[$name][] = "false";
//                     }
//                     elseif(($name == 'vehicleinfo' && $row['vehicle_type'] != $vehicle_type) || ($name == 'driving_licese_info' && $row['vehicle_type'] != $vehicle_type) || ($name == 'vehicle_insurance' && $row['vehicle_type'] != $vehicle_type)){
//                       $checkData[$name][$row['vehicle_type']][] = "false";
//                     }
//                      elseif(($name == 'vehicleinfo' && $row['vehicle_type'] == $vehicle_type) || ($name == 'driving_licese_info' && $row['vehicle_type'] == $vehicle_type) || ($name == 'vehicle_insurance' && $row['vehicle_type'] == $vehicle_type)){
//                       $checkData[$name][$row['vehicle_type']][] = "true";
//                     }
//                     else{
//                         $checkData[$name][] = "true";
//                     }
//                 } else {
//                     $checkData[$name][] = "false";
//                 }
//             }
//         } else {
//             $checkData[$name][] = "false";
//         }
//     }

//     $checkData['vehicleType'] = $driverdata['vehicleType'];
//     $response['status'] = "200";
//     $response['table'] = $checkData;
// } else {
//     $response['status'] = "500";
//     $response['message'] = "ERROR:";
// }

// echo json_encode($response);
<?php

require '../db.php';
header("content-type:application/json");
function checkonline($driverId){
    global $con;
    $checkDataQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $result = mysqli_query($con,$checkDataQuery);
    $row = mysqli_fetch_assoc($result);
    if($row['active_status'] == 'active')
    {
        $vehicle_name = $row['vehicleType'];
    }
    else{
        $vehicle_name = "false";
    }

    return $vehicle_name;
}

$driverId = $_POST['driverId'];

$vahicle_type = ['bike', 'auto', 'car', 'tempo'];
$table_name = ['driving_licese_info', 'vehicleinfo', 'vehicle_insurance'];


$checkData = $table_status = array();
foreach ($vahicle_type as $vehicle) {
    foreach ($table_name as $table) {
        $checkDataQuery = "SELECT * FROM $table WHERE driverId = '$driverId' AND vehicle_type = '$vehicle'";
        $result = mysqli_query($con, $checkDataQuery);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $checkData[$vehicle]['result'] = "true";
            $checkData[$vehicle]['status'] = $row['status'];
            if($row['status'] == "rejected")
            {
                $checkData[$vehicle]['reason'][] = array(
                    $table => $row['rejection_reason']
                );
                break;
            }
        } 
        else {
            $checkData[$vehicle]['status'] = "";
            $checkData[$vehicle]['result'] = "false";
        }
    }
    
}

$response['status'] = "200";
$response['current_vehicle'] = checkonline($driverId);
$response['table'] = $checkData;


echo json_encode($response, JSON_PRETTY_PRINT);
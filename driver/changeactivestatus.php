<?php

require '../db.php';
header("content-type:application/json");

function update_status_vehicle($driverId,$vehicle_type){
    global $con;

    $table_name = ['driving_licese_info', 'vehicleinfo', 'vehicle_insurance'];
    $result = [];
    foreach($table_name as $table){
        $check_data_query = "UPDATE $table SET status = 'waiting' WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
        $check_data = mysqli_query($con,$check_data_query);

        if($check_data)
        {
            $result[$table][] = "true";
        }
        else{
            $result[$table][] = "false";
        }

    }
    return $result;
}

$driverId = isset($_POST['driverId']) ? $_POST['driverId'] : '';
$doc_arr = isset($_POST['document_name']) ? $_POST['document_name'] : '';
$vehicle_type = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] :'';

foreach($doc_arr as $table_name)
{
    // $update_status_query = "update"
}


echo json_encode($response, JSON_PRETTY_PRINT);

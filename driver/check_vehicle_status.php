<?php

require '../db.php';
header("content-type:application/json");
function checkonline($driverId)
{
    global $con;
    $checkDataQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $result = mysqli_query($con, $checkDataQuery);
    $row = mysqli_fetch_assoc($result);
    if ($row['active_status'] == 'active') {
        $vehicle_name = $row['vehicleType'];
    } else {
        $vehicle_name = "false";
    }

    return $vehicle_name;
}

function check_all_status($vehicleData)
{
    $count = 0;
    foreach ($vehicleData as $value) {
        if ($value == "approved") {
            $count++;
        } elseif ($value == "rejected") {
            $count = 2;
            break;
        } elseif ($value == "waiting") {
            $count = 4;
            break;
        }
    }

    return $count;
}

function check_all_vehicle($data)
{
    $status_data = [];
    foreach ($data as $vehicleName => $vehicleData) {
        if (check_all_status($vehicleData)) {
            $status_data[$vehicleName] = check_all_status($vehicleData);
        }
    }

    return $status_data;
}

function checkAllTrue($vehicleData)
{
    foreach ($vehicleData as $value) {
        if ($value != "true") {
            return false;
        }
    }
    return true;
}
function checkAllVehicles($data)
{
    $status_data = [];
    foreach ($data as $vehicleName => $vehicleData) {
        if (checkAllTrue($vehicleData)) {
            $status_data[$vehicleName] = checkAllTrue($vehicleData);
        } else {
            $status_data[$vehicleName] = false;
        }
    }
    return $status_data;
}

function doc_status_check($driverId)
{
    global $con;

    $table_arr = ['adhaarcard', 'police_clearance_certificate'];

    $doc_arr = $status = $result = array();
    foreach ($table_arr as $name) {
        if ($name == "adhaarcard") {
            $document_name = "adhaarcard";
        } elseif ($name == "police_clearance_certificate") {
            $document_name = "police clearance certificate";
        } else {
            $document_name = '';
        }
        $check_doc_query = "SELECT * FROM $name WHERE driverId = '$driverId'";
        $check_doc = mysqli_query($con, $check_doc_query);

        if (mysqli_num_rows($check_doc) > 0) {
            $row = mysqli_fetch_assoc($check_doc);
            $result[$name] = "true";
            $status[$name] = $row['status'];
            if ($row['status'] == "rejected") {
                $doc_arr['reason'][] = array(
                    'document' => $document_name,
                    'reason' => $row['rejection_reason']
                );
            }
        } else {
            $status[$name] = '';
            $result[$name] = "false";
        }
    }

    foreach($result as $check){
        if($check !== "true"){
            $main_result = "false";
        }
        else{
            $main_result = "true";
        }
    }
    $doc_arr['result'] = $main_result;

    $count = 0;
    foreach ($status as $data) {
        if ($data == "approved") {
            $count++;
        } elseif ($data == "rejected") {
            $count = 1;
            break;
        } elseif ($data == "waiting") {
            $count = 3;
            break;
        } elseif ($data == "pending") {
            $count = 4;
            break;
        }
    }

    if($count == 2){
        $final_status = "approved";
    }elseif($count == 1){
        $final_status = "rejetced";
    }elseif($count == 3){
        $final_status = "waiting";
    }elseif($count == 4){
        $final_status = "pending";
    }else{
        $final_status = "";
    }

    $doc_arr['status']  = $final_status;
    return $doc_arr;
}
$driverId = $_POST['driverId'];

$vahicle_type = ['bike', 'auto', 'car', 'tempo'];
$table_name = ['driving_licese_info', 'vehicleinfo', 'vehicle_insurance'];

$checkData = $table_status = array();
foreach ($vahicle_type as $vehicle) {
    $count = 0;
    foreach ($table_name as $table) {
        if ($table == 'driving_licese_info') {
            $document_name = "driving licese info";
        } elseif ($table == 'vehicleinfo') {
            $document_name = "vehicle info";
        } elseif ($table == 'vehicle_insurance') {
            $document_name = "vehicle insurance";
        } else {
            $document_name = "";
        }
        $checkDataQuery = "SELECT * FROM $table WHERE driverId = '$driverId' AND vehicle_type = '$vehicle'";
        $result = mysqli_query($con, $checkDataQuery);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $table_data[$vehicle][$table] = "true";
            $table_status[$vehicle][$table] = $row['status'];
            if ($row['status'] == "rejected") {
                $checkData[$vehicle]['reason'][] = array(
                    'document' => $document_name,
                    'reason' => $row['rejection_reason']
                );
            }
        } else {
            $table_data[$vehicle][$table] = "false";
            $table_status[$vehicle][$table] = '';
        }
    }
    $final_data = checkAllVehicles($table_data);
    foreach ($final_data as $vehicleName => $status) {
        if ($vehicleName == $vehicle) {
            $checkData[$vehicle]['result'] = $status;
        }
    }
    $final_status = check_all_vehicle($table_status);
    foreach ($final_status as $vehicleName => $doc_status) {
        if ($vehicleName == $vehicle) {
            if ($doc_status == 3) {
                $checkData[$vehicle]['status'] = "approved";
            } elseif ($doc_status == 2) {
                $checkData[$vehicle]['status'] = "rejected";
            } elseif ($doc_status == 4) {
                $checkData[$vehicle]['status'] = "waiting";
            }
        } else {
            $checkData[$vehicle]['status'] = "";
        }
    }
}

$response['status'] = "200";
$response['comman_document'] = doc_status_check($driverId);
$response['current_vehicle'] = checkonline($driverId);
$response['table'] = $checkData;

echo json_encode($response, JSON_PRETTY_PRINT);

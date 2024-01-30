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

function doc_status_check($driverId)
{
    global $con;

    $doc_arr = array();
    $check_doc_query = "SELECT * FROM adhaarcard WHERE driverId = '$driverId'";
    $check_doc = mysqli_query($con, $check_doc_query);

    if (mysqli_num_rows($check_doc) > 0) {
        $row = mysqli_fetch_assoc($check_doc);
        $doc_arr['result'] = "true";
        $doc_arr['status'] = $row['status'];
        if ($row['status'] == 'rejetced') {
            $doc_arr['reason'] = $row['rejection_reason'];
        }
    } else {
        $doc_arr = array(
            'result' => "false",
            'status' => ""
        );
    }
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
            $checkData[$vehicle]['result'] = "true";
            $table_status[$vehicle][$table] = $row['status'];

            if ($table_status[$vehicle][$table] == "approved") {
                $count++;
            } elseif ($table_status[$vehicle][$table] == "rejected") {
                $count = 1;
                $checkData[$vehicle]['reason'][] = array(
                    'document' => $document_name,
                    'reason' => $row['rejection_reason']
                );
            }
        } else {
            $checkData[$vehicle]['status'] = "";
            $checkData[$vehicle]['result'] = "false";
        }
    }
    if ($count == count($table_name)) {
        $allApproved = "approved";
    } elseif ($count == 1) {
        $allApproved = "rejected";
    } else {
        $allApproved = "waiting";
    }

    $checkData[$vehicle]['status'] = $allApproved;
}

$response['status'] = "200";
// $response['data'] = $table_status;
$response['comman_document'] = doc_status_check($driverId);
$response['current_vehicle'] = checkonline($driverId);
$response['table'] = $checkData;

echo json_encode($response, JSON_PRETTY_PRINT);

<?php

require '../db.php';
header("content-type:application/json");

function doc_status_check($driverId)
{
    global $con;

    $table_arr = ['adhaarcard', 'police_clearance_certificate'];
    $doc_arr = array(); // Initialize the array

    foreach ($table_arr as $name) {
        $check_doc_query = "SELECT * FROM $name WHERE driverId = '$driverId'";
        $check_doc = mysqli_query($con, $check_doc_query);
        $row = mysqli_fetch_assoc($check_doc);
        $row['document_name'] = $name;
        $doc_arr[] = $row;
    }

    $final_data = array(); // Initialize the final data array

    foreach ($doc_arr as $data) {
        if ($data['status'] == "rejected") // Fix the comparison here
        {
            $final_data[] = array(
                $data['document_name'] => $data['rejection_reason'],
            );
        }
    }

    return $final_data;
}

$driverId = $_POST['driverId'];

$vahicle_type = ['bike', 'auto', 'car', 'tempo'];
$table_name = ['driving_licese_info', 'vehicleinfo', 'vehicle_insurance'];

$checkData = $table_status = array();
foreach ($vahicle_type as $vehicle) {
    $count = 0;
    foreach ($table_name as $table) {
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
                $checkData[$vehicle]['reason'][] =array( 
                    $table => $row['rejection_reason']
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
        $allApproved = "";
    }

    $checkData[$vehicle]['status'] = $allApproved;
}

$response['status'] = "200";
$response['comman_document'] = doc_status_check($driverId);
$response['table'] = $checkData;

echo json_encode($response, JSON_PRETTY_PRINT);

<?php

require '../db.php';
header("content-type:application/json");

function aadhar_card_data($userId){
    global $con;
    $checkUserQuery = "SELECT * FROM adhaarcard WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $aadhar_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        $change_status_query = "UPDATE adhaarcard SET status = 'waiting',rejection_reason = '' WHERE driverId = '$userId'";
        $change_status = mysqli_query($con,$change_status_query);

        if($change_status)
        {
            $aadhar_data = "true";
        }
        else{
            $aadhar_data = "false";
        }
    } 

    return $aadhar_data;
}

function police_certificate($userId){
    global $con;
    $checkUserQuery = "SELECT * FROM police_clearance_certificate WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $police_doc_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        $change_status_query = "UPDATE police_clearance_certificate SET status = 'waiting',rejection_reason = '' WHERE driverId = '$userId'";
        $change_status = mysqli_query($con,$change_status_query);

        if($change_status)
        {
            $police_doc_data = "true";
        }
        else{
            $police_doc_data = "false";
        }
    } 

    return $police_doc_data;
}

function vehicle_insurance($userId,$vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM vehicle_insurance WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $insurance_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        $change_status_query = "UPDATE vehicle_insurance SET status = 'waiting',rejection_reason = '' WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
        $change_status = mysqli_query($con,$change_status_query);

        if($change_status)
        {
            $insurance_data = "true";
        }
        else{
            $insurance_data = "false";
        }
    } 

    return $insurance_data;
}

function driving_licese($userId,$vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM driving_licese_info WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $licese_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        $change_status_query = "UPDATE driving_licese_info SET status = 'waiting',rejection_reason = '' WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
        $change_status = mysqli_query($con,$change_status_query);

        if($change_status)
        {
            $licese_data = "true";
        }
        else{
            $licese_data = "false";
        }
    } 

    return $licese_data;
}

function vehicleinfo($userId,$vehicle_type)
{
    global $con;
    $checkUserQuery = "SELECT * FROM vehicleinfo WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con, $checkUserQuery);

    $vehicle_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        $change_status_query = "UPDATE vehicleinfo SET status = 'waiting',rejection_reason = '' WHERE driverId = '$userId' AND vehicle_type = '$vehicle_type'";
        $change_status = mysqli_query($con,$change_status_query);

        if($change_status)
        {
            $vehicle_data = "true";
        }
        else{
            $vehicle_data = "false";
        }
    } 

    return $vehicle_data;
}
$driverId = isset($_POST['driverId']) ? $_POST['driverId'] : '';
$doc_arr_json = isset($_POST['document_name']) ? $_POST['document_name'] : '';
$vehicle_type = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] :'';

$doc_arr = json_decode($doc_arr_json);

if (!is_array($doc_arr)) {
    $doc_arr = array($doc_arr);
}
$adhaar_card_data = $policae_certificate_data = $name = array();

foreach($doc_arr as $table_name){
    if($table_name == "adhaarcard")
    {
        $adhaar_card_data = aadhar_card_data($driverId);
    }
    elseif($table_name == "police clearance certificate"){
        $policae_certificate_data = police_certificate($driverId);
    }
    elseif($table_name == "driving licese info"){
        $driving_license_data = driving_licese($driverId,$vehicle_type);
    }
    elseif($table_name == "vehicle info"){
        $vehicle_info_data = vehicleinfo($driverId,$vehicle_type);
    }
    elseif($table_name == "vehicle insurance") {
        $vehicle_insurance = vehicle_insurance($driverId,$vehicle_type);
    }

}

if($adhaar_card_data == "true" || $policae_certificate_data == "true" || $driving_license_data == "true" || $vehicle_info_data == "true" || $vehicle_insurance == "true")
{
    $response = array(
        'status' => "200",
        'message' => "status updated"
    );
}
else{
    $response = array(
        'status' => "404",
        'message' => "ERROR: " . mysqli_error($con)
    );
}

echo json_encode($response, JSON_PRETTY_PRINT);

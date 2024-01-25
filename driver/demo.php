<?php

require '../db.php';

header("content-type: application/json");

session_start();
function vehicle_insurance($userId)
{
    global $con;
    $checkUserQuery = "SELECT * FROM vehicle_insurance WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);
    $insurance_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while($row = mysqli_fetch_assoc($checkUser))
        {
            $row['document_name'] = "insurance";
            $insurance_data[] = $row;
        }
    } 

    return $insurance_data;
}

function driving_licese($userId)
{
    global $con;
    $checkUserQuery = "SELECT * FROM driving_licese_info WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);
    $licese_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while($row = mysqli_fetch_assoc($checkUser))
        {
            $row['document_name'] = "license";
            $licese_data[] = $row;
        }
    } 

    return $licese_data;
}

function vehicleinfo($userId)
{
    global $con;
    $checkUserQuery = "SELECT * FROM vehicleinfo WHERE driverId = '$userId'";
    $checkUser = mysqli_query($con, $checkUserQuery);
    $vehicle_data = array();
    if (mysqli_num_rows($checkUser) > 0) {
        while($row = mysqli_fetch_assoc($checkUser))
        {
            $row['document_name'] = "vehicle";
            $vehicle_data[] = $row;
        }
    } 

    return $vehicle_data;
}

$userId = isset($_POST['driverId']) ? $_POST['driverId'] : '';
$insurance_doc_data = vehicle_insurance($userId);
$licese_data = driving_licese($userId);
$vehicleinfo = vehicleinfo($userId);

$arr_data = array($vehicleinfo,$licese_data,$insurance_doc_data);

$final_arr = array();
foreach($arr_data as $data)
{
    foreach ($data as $row) {
        $vehicle_name = $row['vehicle_type'];
        $final_arr[$vehicle_name][$row['document_name']] = $row['status'];
        if($final_arr[$vehicle_name][$row['document_name']] == "approved")
        {
            $counter[$vehicle_name] = $counter[$vehicle_name] + 1;
        }
        else{
            $counter[$vehicle_name] = 0;
        }
    }
}


$response = array(
    'status' => "200",
    'final_data' => $counter
);

echo json_encode($response,JSON_PRETTY_PRINT);
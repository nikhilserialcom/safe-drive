<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();
$data = json_decode(file_get_contents('php://input'),true);

function aadharApprove($driverId,$status)
{
    global $con;

    $checkUserQuery = "SELECT * FROM adhaarcard WHERE driverId = '$driverId'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE adhaarcard SET status = '$final_status' WHERE driverId = '$driverId'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'message' => $final_status
            );
        }
    }
    else{
        $response = array(
            'status_code' => 404,
            'message' => 'database empty'
        );
    }

    return $response;
}

function licenseapprove($driverId,$status)
{
    global $con;

    $checkUserQuery = "SELECT * FROM driving_licese_info WHERE driverId = '$driverId'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE driving_licese_info SET status = '$final_status' WHERE driverId = '$driverId'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'message' => $final_status
            );
        }
    }
    else{
        $response = array(
            'status_code' => 404,
            'message' => 'database empty'
        );
    }

    return $response;
}

function policecertificationapproval($driverId,$status)
{
    global $con;

    $checkUserQuery = "SELECT * FROM police_clearance_certificate WHERE driverId = '$driverId'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE police_clearance_certificate SET status = '$final_status' WHERE driverId = '$driverId'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'message' => $final_status
            );
        }
    }
    else{
        $response = array(
            'status_code' => 404,
            'message' => 'database empty'
        );
    }

    return $response;
}

function insuranceapproval($driverId,$status)
{
    global $con;

    $checkUserQuery = "SELECT * FROM vehicle_insurance WHERE driverId = '$driverId'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE vehicle_insurance SET status = '$final_status' WHERE driverId = '$driverId'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'message' => $final_status
            );
        }
    }
    else{
        $response = array(
            'status_code' => 404,
            'message' => 'database empty'
        );
    }

    return $response;
}

function vehicleapproval($driverId,$status)
{
    global $con;

    $checkUserQuery = "SELECT * FROM vehicleinfo WHERE driverId = '$driverId'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE vehicleinfo SET status = '$final_status' WHERE driverId = '$driverId'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'message' => $final_status
            );
        }
    }
    else{
        $response = array(
            'status_code' => 404,
            'message' => 'database empty'
        );
    }

    return $response;
}

if(!isset($_SESSION['user_email']))
{
    $response = array(
        'status_code' => 440,
        'email' => 'your session is expire'
    );
}
else
{
    $driverId = isset($data['driverId']) ? $data['driverId'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $docType = isset($data['docType']) ? $data['docType'] : '';
    if($docType == "aadhar")
    {
       $response = aadharApprove($driverId,$status);
    }
    elseif($docType == "license")
    {
        $response = licenseapprove($driverId,$status);
    }
    elseif($docType == "police")
    {
        $response = policecertificationapproval($driverId,$status);
    }
    elseif($docType == "insurance"){
        $response = insuranceapproval($driverId,$status);
    }
    elseif($docType == "vehical"){
        $response = vehicleapproval($driverId,$status);
    }
    else{
        $response = array(
            'status_code' => 500,
            'message' => "ERROR:" . mysqli_error($con)
        );
    }
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>
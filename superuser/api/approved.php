<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();
$data = json_decode(file_get_contents('php://input'),true);

function aadharApprove($driverId,$status,$reason)
{
    global $con;

    $checkUserQuery = "SELECT * FROM adhaarcard WHERE driverId = '$driverId'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE adhaarcard SET status = '$final_status',rejection_reason = '$reason' WHERE driverId = '$driverId'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'doc_name' => 'aadhar',
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

function licenseapprove($driverId,$status,$vehicle_type,$reason)
{
    global $con;

    $checkUserQuery = "SELECT * FROM driving_licese_info WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE driving_licese_info SET status = '$final_status', rejection_reason = '$reason' WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'doc_name' => 'license',
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

function policecertificationapproval($driverId,$status,$reason)
{
    global $con;

    $checkUserQuery = "SELECT * FROM police_clearance_certificate WHERE driverId = '$driverId'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE police_clearance_certificate SET status = '$final_status',rejection_reason = '$reason' WHERE driverId = '$driverId'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'doc_name' => 'police',
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

function insuranceapproval($driverId,$status,$vehicle_type,$reason)
{
    global $con;

    $checkUserQuery = "SELECT * FROM vehicle_insurance WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE vehicle_insurance SET status = '$final_status', rejection_reason = '$reason' WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'doc_name' => 'insurance',
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

function vehicleapproval($driverId,$status,$vehicle_type,$reason)
{
    global $con;

    $checkUserQuery = "SELECT * FROM vehicleinfo WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
    $checkUser = mysqli_query($con,$checkUserQuery);

    if(mysqli_num_rows($checkUser) > 0)
    {
        $final_status = ($status == "accept") ? "approved" : "rejected";

        $updateQuery = "UPDATE vehicleinfo SET status = '$final_status', rejection_reason = '$reason' WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
        $update = mysqli_query($con,$updateQuery);
        if($update)
        {
            $response = array(
                'status_code' => 200,
                'doc_name' => 'vehicale',
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
    $vehicle_type = isset($data['vehicle_type']) ? $data['vehicle_type'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $rejected_resason = isset($data['rejectedReason']) ? $data['rejectedReason'] : '';
    $docType = isset($data['docType']) ? $data['docType'] : '';

    $response = array(
        'driverId' => $driverId,
        'vehicle_type' => $vehicle_type,
        'reason' => $rejected_resason,
        'status' => $status,
        'docType' => $docType,
    );
    // if($docType == "aadhar")
    // {
    //    $response = aadharApprove($driverId,$status,$rejected_resason);
    // }
    // elseif($docType == "license")
    // {
    //     $response = licenseapprove($driverId,$status,$vehicle_type,$rejected_resason);
    // }
    // elseif($docType == "police")
    // {
    //     $response = policecertificationapproval($driverId,$status,$rejected_resason);
    // }
    // elseif($docType == "insurance"){
    //     $response = insuranceapproval($driverId,$status,$vehicle_type,$rejected_resason);
    // }
    // elseif($docType == "vehical"){
    //     $response = vehicleapproval($driverId,$status,$vehicle_type,$rejected_resason);
    // }
    // else{
    //     $response = array(
    //         'status_code' => 500,
    //         'message' => "ERROR:" . mysqli_error($con)
    //     );
    // }
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>
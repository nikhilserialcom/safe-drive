<?php

require '../db.php';
header("content-type:application/json");

// function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
// {   
//     global $response,$con;

//     $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE user_id = '$driverId'");

//     if($updateLocation)
//     {
//         $response['status'] = "true";
//         $response['message'] = "update location";
//     }

// }

if (isset($_POST['driverId'])) {
    $id = $_POST['driverId'];
    // if(isset($_POST['driverLetitude']) && isset($_POST['driverLongitude']))
    // {
    // $driverLetitude = $_POST['driverLetitude'];
    // $driverLogitude = $_POST['driverLongitude'];
    // if(!empty($driverLetitude) && !empty($driverLogitude))
    // {
    //     updateDriverLocation($driverLetitude,$driverLogitude,$userId);
    // }
    // }
    $check_user_query = "SELECT * FROM police_clearance_certificate WHERE driverId = '$id'";
    $check_user = mysqli_query($con, $check_user_query);

    $response = array();

    if (mysqli_num_rows($check_user) > 0) {
        if (isset($_FILES['policeCertificate']) && !empty($_FILES['policeCertificate']['tmp_name'])) {
            $policeCertificate = $_FILES['policeCertificate'];

            $policeCertificateTmpName = $policeCertificate['tmp_name'];
            $policeCertificateName = rand(111111111, 999999999) . ".jpg";
            $policeCertificateFolder = 'uploaded/police_certificate/';
            $policeCertificatePath = $policeCertificateFolder . $policeCertificateName;
            $targetFileType = strtolower(pathinfo($policeCertificate['name'], PATHINFO_EXTENSION));


            if (move_uploaded_file($policeCertificateTmpName, $policeCertificatePath)) {
                $update_query = "UPDATE police_clearance_certificate SET Police_clearance_certificate = '$policeCertificatePath', status = 'pending' WHERE driverId = '$id'";
                $update = mysqli_query($con, $update_query);
                if ($update) {
                    $response['status'] = "200";
                    $response['message'] = "Record UPdated";
                }
            }
        }
    } else {
        if (isset($_FILES['policeCertificate']) && !empty($_FILES['policeCertificate']['tmp_name'])) {
            $policeCertificate = $_FILES['policeCertificate'];

            $policeCertificateTmpName = $policeCertificate['tmp_name'];
            $policeCertificateName = rand(111111111, 999999999) . ".jpg";
            $policeCertificateFolder = 'uploaded/police_certificate/';
            $policeCertificatePath = $policeCertificateFolder . $policeCertificateName;
            $targetFileType = strtolower(pathinfo($policeCertificate['name'], PATHINFO_EXTENSION));


            if (move_uploaded_file($policeCertificateTmpName, $policeCertificatePath)) {
                $insert_query = "INSERT INTO police_clearance_certificate (driverId, Police_clearance_certificate) VALUES ('$id', '$policeCertificatePath')";
                $insert = mysqli_query($con, $insert_query);
                if ($insert) {
                    $response['status'] = "200";
                    $response['message'] = "Record inserted";
                }
            }
        } else {
            $response['error'] = "404";
            $response['message'] = "No file was uploaded.";
        }
    }
} else {
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);

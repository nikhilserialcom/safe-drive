<?php

require '../db.php';
header("content-type:application/json");

if (isset($_POST['driverId'])) {
    $id = $_POST['driverId'];

    $check_user_query = "SELECT * FROM police_clearance_certificate WHERE driverId = '$id'";
    $check_user = mysqli_query($con, $check_user_query);

    $response = array();

    if (mysqli_num_rows($check_user) > 0) {
        $row = mysqli_fetch_assoc($check_user);
        if (isset($_FILES['policeCertificate']) && !empty($_FILES['policeCertificate']['tmp_name'])) {
            $policeCertificate = $_FILES['policeCertificate'];

            $policeCertificateTmpName = $policeCertificate['tmp_name'];
            $police_new_part = explode('.', $policeCertificate['name']);
            $police_extension = end($police_new_part);
            $policeCertificateName = rand(111111111, 999999999) . "." . $police_extension;
            $policeCertificateFolder = 'uploaded/police_certificate/';
            $policeCertificatePath = $policeCertificateFolder . $policeCertificateName;
            $targetFileType = strtolower(pathinfo($policeCertificate['name'], PATHINFO_EXTENSION));

            move_uploaded_file($policeCertificateTmpName, $policeCertificatePath);
            $final_status = "pending";
            $rejection_reason = "";
        }
        else{
            $final_status = $row['status'];
            $rejection_reason = $row['rejection_reason'];
            $policeCertificatePath = $row['Police_clearance_certificate'];
        }
        $update_query = "UPDATE police_clearance_certificate SET Police_clearance_certificate = '$policeCertificatePath', status = '$final_status', rejection_reason = '$rejection_reason' WHERE driverId = '$id'";
        $update = mysqli_query($con, $update_query);
        if ($update) {
            $response['status'] = "200";
            $response['message'] = "Record UPdated";
        }
    } else {
        if (isset($_FILES['policeCertificate']) && !empty($_FILES['policeCertificate']['tmp_name'])) {
            $policeCertificate = $_FILES['policeCertificate'];

            $policeCertificateTmpName = $policeCertificate['tmp_name'];
            $police_new_part = explode('.', $policeCertificate['name']);
            $police_extension = end($police_new_part);
            $policeCertificateName = rand(111111111, 999999999) . "." . $police_extension;
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

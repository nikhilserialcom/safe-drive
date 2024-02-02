<?php

require '../db.php';
header("content-type:application/json");

if (isset($_POST['driverId'])) {
    $driverId = $_POST['driverId'];
    $vehicle_type = $_POST['vehicle_type'];

    $check_user_query = "SELECT * FROM vehicle_insurance WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
    $check_user = mysqli_query($con, $check_user_query);

    $response = array();

    if (mysqli_num_rows($check_user) > 0) {
        $row = mysqli_fetch_assoc($check_user);
        if (isset($_FILES['vehicleInsurance']) && !empty($_FILES['vehicleInsurance']['tmp_name'])) {
            $vehicleInsurance = $_FILES['vehicleInsurance'];

            $vehicleInsuranceTmpName = $vehicleInsurance['tmp_name'];
            $insurance_new_part = explode('.' , $vehicleInsurance['name']);
            $insurance_extension = end($insurance_new_part);
            $vehicleInsuranceName = rand(111111111, 999999999) . "." . $insurance_extension;
            $vehicleInsuranceFolder = 'uploaded/vehicle_insurance/';
            $vehicleInsurancePath = $vehicleInsuranceFolder . $vehicleInsuranceName;
            $targetFileType = strtolower(pathinfo($vehicleInsurance['name'], PATHINFO_EXTENSION));

            move_uploaded_file($vehicleInsuranceTmpName, $vehicleInsurancePath); 
            $final_status = "pending";  
        }
        else{
            $final_status = $row['status'];
            $vehicleInsurancePath = $row['vehicle_insurance'];
        }
        $update_query = "UPDATE vehicle_insurance SET vehicle_insurance = '$vehicleInsurancePath', status = '$final_status', rejection_reason = '' WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
        $update = mysqli_query($con, $update_query);
        if ($update) {
            $response['status'] = "200";
            $response['message'] = "Record Updated";
        }
    } else {
        if (isset($_FILES['vehicleInsurance']) && !empty($_FILES['vehicleInsurance']['tmp_name'])) {
            $vehicleInsurance = $_FILES['vehicleInsurance'];

            $vehicleInsuranceTmpName = $vehicleInsurance['tmp_name'];
            $insurance_new_part = explode('.' , $vehicleInsurance['name']);
            $insurance_extension = end($insurance_new_part);
            $vehicleInsuranceName = rand(111111111, 999999999) . "." . $insurance_extension;
            $vehicleInsuranceFolder = 'uploaded/vehicle_insurance/';
            $vehicleInsurancePath = $vehicleInsuranceFolder . $vehicleInsuranceName;
            $targetFileType = strtolower(pathinfo($vehicleInsurance['name'], PATHINFO_EXTENSION));
            if (!file_exists($vehicleInsuranceFolder)) {
                mkdir($vehicleInsuranceFolder, 0755, true);
            }

                $insert_query = "INSERT INTO vehicle_insurance (driverId,vehicle_type, vehicle_insurance) VALUES ('$driverId','$vehicle_type', '$vehicleInsurancePath')";
                $insert = mysqli_query($con, $insert_query);
                if ($insert) {
                    move_uploaded_file($vehicleInsuranceTmpName, $vehicleInsurancePath);
                    $response['status'] = "200";
                    $response['message'] = "vehicle Insurance uploaded";
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

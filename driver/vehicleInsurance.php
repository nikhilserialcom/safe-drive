<?php

require '../db.php';
header("content-type:application/json");

if(isset($_POST['driverId']))
{
    $driverId = $_POST['driverId'];

    $check_user_query = "SELECT * FROM vehicle_insurance WHERE driverId = '$driverId'";
    $check_user = mysqli_query($con, $check_user_query);

    $response = array();

    if (mysqli_num_rows($check_user) > 0) {
        if (isset($_FILES['vehicleInsurance']) && !empty($_FILES['vehicleInsurance']['tmp_name'])) {
            $vehicleInsurance = $_FILES['vehicleInsurance'];

            $vehicleInsuranceTmpName = $vehicleInsurance['tmp_name'];
            $vehicleInsuranceName = rand(111111111, 999999999) . ".jpg";
            $vehicleInsuranceFolder = 'uploaded/vehicle_insurance/';
            $vehicleInsurancePath = $vehicleInsuranceFolder . $vehicleInsuranceName;
            $targetFileType = strtolower(pathinfo($vehicleInsurance['name'], PATHINFO_EXTENSION));

        
                if (move_uploaded_file($vehicleInsuranceTmpName, $vehicleInsurancePath)) {
                    $update_query = "UPDATE vehicle_insurance SET vehicle_insurance = '$vehicleInsurancePath' WHERE driverId = '$driverId'";
                    $update = mysqli_query($con, $update_query);
                    if ($update) {
                        $response['status'] = "200";
                        $response['message'] = "Record UPdated";
                    }
                } 
        } 
    } else {
        if (isset($_FILES['vehicleInsurance']) && !empty($_FILES['vehicleInsurance']['tmp_name'])) {
            $vehicleInsurance = $_FILES['vehicleInsurance'];

            $vehicleInsuranceTmpName = $vehicleInsurance['tmp_name'];
            $vehicleInsuranceName = rand(111111111, 999999999) . ".jpg";
            $vehicleInsuranceFolder = 'uploaded/vehicle_insurance/';
            $vehicleInsurancePath = $vehicleInsuranceFolder . $vehicleInsuranceName;
            $targetFileType = strtolower(pathinfo($vehicleInsurance['name'], PATHINFO_EXTENSION));
            if (!file_exists($vehicleInsuranceFolder)) {
                mkdir($vehicleInsuranceFolder, 0755, true);
            }

        
                if (move_uploaded_file($vehicleInsuranceTmpName, $vehicleInsurancePath)) {
                    $insert_query = "INSERT INTO vehicle_insurance (driverId, vehicle_insurance) VALUES ('$driverId', '$vehicleInsurancePath')";
                    $insert = mysqli_query($con, $insert_query);
                    if ($insert) {
                        $response['status'] = "200";
                        $response['message'] = "vehicle Insurance uploaded";
                    }
                } 
        } else {
            $response['error'] = "404";
            $response['message'] = "No file was uploaded.";
        }
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);
?>

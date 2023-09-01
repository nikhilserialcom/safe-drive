<?php

require '../db.php';
header("content-type:application/json");

if($_POST['driverId'])
{
    $driverId = $_POST['driverId'];
    $table_name = ['user','driving_licese_info','vehicleinfo','police_clearance_certificate','adhaarcard'];

    foreach($table_name as $name)
    {
        $checkDataQuery = "SELECT driverId FROM $name WHERE driverId = '$driverId'";
        $checkData = mysqli_query($con,$checkDataQuery);
        if (mysqli_num_rows($checkData))
        {
           $response['status'] = "200";
           $response['message'] = "data is exist";
        }
        else
        {
            $response['status'] = "400";
            $response['message'] = "database empty";
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
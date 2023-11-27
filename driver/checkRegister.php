<?php

require '../db.php';
header("content-type:application/json");

if($_POST['driverId'])
{
    $driverId = $_POST['driverId'];
    $dataQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $data = mysqli_query($con, $dataQuery);
    $driverdata = mysqli_fetch_assoc($data);

    $table_name = ['user','driving_licese_info','vehicleinfo','police_clearance_certificate','adhaarcard','vehicle_insurance'];

    $checkData = array();
    foreach($table_name as $name)
    {
        $checkDataQuery = "SELECT driverId FROM $name WHERE driverId = '$driverId'";
        $result = mysqli_query($con,$checkDataQuery);
        if (mysqli_num_rows($result))
        {
           $row = mysqli_fetch_assoc($result);
           if($row)
           {
                $checkData[$name] = "true";
           }
           else
           {
                $checkData[$name] = "false";
           }
        }
        else
        {
           $checkData[$name] = false;
        }
    }

    $checkData['vehicleType'] = $driverdata['vehicleType'];
    $response['status'] = "200";
    $response['table'] = $checkData;
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
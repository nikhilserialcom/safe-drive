<?php

require '../db.php';
header("content-type:application/json");

function checkonline($driverId){
    global $con;
    $checkDataQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $result = mysqli_query($con,$checkDataQuery);
    $row = mysqli_fetch_assoc($result);
    if($row['active_status'] == 'active')
    {
        $response = "true";
    }
    else{
        $response = "false";
    }

    return $response;
}

if($_POST['driverId'])
{
    $driverId = $_POST['driverId'];
    $dataQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $data = mysqli_query($con, $dataQuery);
    $driverdata = mysqli_fetch_assoc($data);

    $table_name = ['driving_licese_info','vehicleinfo','police_clearance_certificate','adhaarcard','vehicle_insurance'];

    $checkData = array();
    foreach($table_name as $name)
    {
        $checkDataQuery = "SELECT driverId,status FROM $name WHERE driverId = '$driverId'";
        $result = mysqli_query($con,$checkDataQuery);
        if (mysqli_num_rows($result) > 0)
        {
           $row = mysqli_fetch_assoc($result);
           if($row['status'] == 'rejected')
           {
                $checkData[$name] = "false";
           }
           else
           {
                $checkData[$name] = "true";
           }
        }
    }

    $checkData['vehicleType'] = $driverdata['vehicleType'];
    $response['status'] = "200";
    $response['empty'] = checkonline($driverId);
    $response['table'] = $checkData;
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
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

function doc_status_check($driverId)
{
    global $con;

    $table_arr = ['adhaarcard','police_clearance_certificate'];
    $doc_arr = array();

    foreach ($table_arr as $name) {
        $check_doc_query = "SELECT * FROM $name WHERE driverId = '$driverId'";
        $check_doc = mysqli_query($con, $check_doc_query);
        $row = mysqli_fetch_assoc($check_doc);
        $row['document_name'] = $name;
        $doc_arr[] = $row;
    }

    $final_data = array();

    foreach ($doc_arr as $data) {
        if ($data['status'] == "rejected") {
            $final_data[] = array(
               $data['document_name'] => 'false'
            );
        }
        else{
            $final_data[] = array(
                $data['document_name'] => 'true'
             );
        }
    }

    return $final_data;
}

if($_POST['driverId'])
{
    $driverId = $_POST['driverId'];
    $vehicle_type = $_POST['vehicle_type'];
    
    $dataQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
    $data = mysqli_query($con, $dataQuery);
    $driverdata = mysqli_fetch_assoc($data);

    $table_name = ['driving_licese_info','vehicleinfo','vehicle_insurance'];

    $checkData = array();
    foreach($table_name as $name)
    {
        $checkDataQuery = "SELECT * FROM $name WHERE driverId = '$driverId' AND vehicle_type = '$vehicle_type'";
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
        else{
             $checkData[$name] = "true";
        }
    }

    
    $checkData['vehicleType'] = $driverdata['vehicleType'];
    $response['status'] = "200";
    $response['empty'] = checkonline($driverId);
    $response['comman_document'] = doc_status_check($driverId);
    $response['table'] = $checkData;
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>
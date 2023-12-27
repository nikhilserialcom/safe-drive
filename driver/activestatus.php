<?php

require '../db.php';
header("content-type:application/json");

$driverId = isset($_POST['driverId']) ? $_POST['driverId'] : '';

$checkDriverQuery = "SELECT * FROM user WHERE driverId = '$driverId'";
$checkDriver = mysqli_query($con,$checkDriverQuery);

if(mysqli_num_rows($checkDriver) > 0){

    while($row = mysqli_fetch_assoc($checkDriver))
    {
        if($row['active_status'] == "active")
        {
            $response['status'] = "200";
            $response['message'] = 'active';
        }
        elseif($row['active_status'] == "reject")
        {
            $arr = json_decode($row['rejection_reason'], true);;
            $rejectedReason = array();
            $rejectedReason = is_array($arr) ? array_map(function($reason) {
                return ["document" => $reason, "reason" => $reason . " detail is not valid"];
            }, $arr) : [];

            $response['status'] = "200";
            $response['message'] = "rejected";
            $response['reason'] = $rejectedReason;
        }
        elseif($row['active_status'] == "pending")
        {
            $response['status'] = "200";
            $response['message'] = 'pending';
        }
        else{
            
            $response['status'] = "200";
            $response['message'] = "waiting";
        }
    }
}
else{ 
    $response['status'] = "404";
    $response['message'] = "database empty";
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>
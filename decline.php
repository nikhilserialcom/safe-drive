<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['userId']) && isset($_POST['driverId']))
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];

    $checkrequestQuery = "SELECT * FROM driver_request WHERE driverId = '$driverId' AND user_id = '$userId'";
    $checkrequest = mysqli_query($con,$checkrequestQuery);

    if(mysqli_num_rows($checkrequest) > 0)
    {
        $updateRequestQuery = mysqli_query($con,"UPDATE request SET status = 'decline'  WHERE driver_id = '$driverId' AND user_id = '$userId'");
        $deleteRequestQuery = "DELETE FROM driver_request  WHERE driverId = '$driverId' AND user_id = '$userId'";
        $deleteRequest = mysqli_query($con,$deleteRequestQuery);
        if($deleteRequest)
        {
            $response = array(
                'status' => '200',
                'message' => 'decline'
            );
        }
    }
    else
    {
        $response = array(
            'status' => '404',
            'message' => 'No result found'
        );
    }
}
else
{
    $response = array(
        'status' => "500",
        'message' => 'ERROR:'
    );
}
echo json_encode($response);
?>
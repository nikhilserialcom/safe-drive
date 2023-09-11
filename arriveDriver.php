<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['userId']) && isset($_POST['driverId']))
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];

    $checkStatusQuery = "SELECT * FROM book_ride WHERE userId = '$userId' AND driverId = '$driverId'";
    $checkStatus = mysqli_query($con,$checkStatusQuery);

    if(mysqli_num_rows($checkStatus) > 0)
    {
        while($row = mysqli_fetch_assoc($checkStatus))
        {
            if($row['status'] == 'here')
            {
                $response['status'] = "200";
                $response['id'] = $row['id'];
                $response['message'] = "here";
            }
            elseif($row['status'] == 'waiting')
            {
                $response['status'] = "200";
                $response['message'] = "waiting";
            }
            else
            {
                $response['status'] = "200";
                $response['message'] = "complete";
            }
        }
    }
    else
    {
        $response['status'] = "400";
        $response['message'] = "No matching records found";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
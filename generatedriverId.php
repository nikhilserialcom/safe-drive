<?php

require 'db.php';
header("content-type:application/json");

if(isset($_POST['userId']))
{
    $userId = $_POST['userId'];
    

    $checkDriverQuery = "SELECT * FROM user WHERE id = '$userId' AND driverId = '0'";
    $checkDriver = mysqli_query($con,$checkDriverQuery);

    if(mysqli_num_rows($checkDriver) > 0)
    {
        // $row = mysqli_fetch_assoc($checkDriver);

        // $response['drivername'] = $row['firstname'];
        $driverId = rand(11111,99999);
    
        $makeDriverQuery = "UPDATE user SET driverId = '$driverId' WHERE id = '$userId'";
        $makeDriver = mysqli_query($con,$makeDriverQuery);
    
        if($makeDriver)
        {
            $response['status'] = "200";
            $response['driverId'] = $driverId;
            $response['message'] = "Successfully";
        }
    }
    else
    {
        $checkDriverQuery = "SELECT * FROM user WHERE id = '$userId'";
        $checkDriver = mysqli_query($con,$checkDriverQuery);
        $driverId = mysqli_fetch_assoc($checkDriver);
        $response['status'] = '200';
        $response['driverId'] = $driverId['driverId'];
        $response['message'] = "Id already generated";
    }
    
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);
?>
<?php
require 'db.php';
header("content-type:application/json");

if(isset($_POST['userId']))
{
    $userId = $_POST['userId'];

    $checkRequestQuery = "SELECT * FROM request WHERE user_id = '$userId'";
    $checkRequest = mysqli_query($con,$checkRequestQuery);

    if(mysqli_num_rows($checkRequest) > 0)
    {
       
        $deleteRequestQuery = "DELETE from request where user_id = '$userId'";
        $deleteRequest = mysqli_query($con,$deleteRequestQuery);
        if($deleteRequest)
        {
            $response['status'] = '200';
            $response['message'] = 'request cancel';
        }    
    }
    else
    {
        $response['status'] = '404';
        $response['message'] = 'database empty';
    }
}
else
{
    $response['status'] = '500';
    $response['message'] = 'ERROR:';
}

echo json_encode($response);
?>
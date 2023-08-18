<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $tripHistoryQuery = "SELECT * FROM book_ride WHERE userId = '$userId'";
    $tripHistory = mysqli_query($con,$tripHistoryQuery);

    if(mysqli_num_rows($tripHistory) > 0)
    {
        while($row = mysqli_fetch_assoc($tripHistory))
        {
            $response['trips'][] = $row;
        }
    }
    else
    {
        $response['status'] = "404";
        $response['message'] = "database empty";
    }

} 
else 
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}


echo json_encode($response);
?>
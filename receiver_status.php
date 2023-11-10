<?php

require 'db.php';
header("content-type:application/json");

if (isset($_POST['receiver_id'])) 
{
    $receiver_id = $_POST['receiver_id'];

    $receiver_status_update_query = "UPDATE messages SET receiver_view = 'true' WHERE incoming_msg_id = '$receiver_id'";
    $receiver_status_update = mysqli_query($con,$receiver_status_update_query);

    if($receiver_status_update)
    {
        $response = array(
            'status' => '200',
            'message' => 'update receiver status done'
        );
    }
    else
    {
        $response = array(
            'status' => '404',
            'message' => 'receiver status not update'
        );
    }
    
} else {
    $response['status'] = "500";
    $response['message'] = "ERROR: Insufficient data provided.";
}

echo json_encode($response);
?>

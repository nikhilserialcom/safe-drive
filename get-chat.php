<?php

require 'db.php';
header("content-type:application/json");

if ($_POST['outgoing_id'] && $_POST['incoming_id']) 
{
    $outgoing_id = $_POST['outgoing_id']; 
    $incoming_id = $_POST['incoming_id']; 

    $chatquery = "SELECT * FROM messages WHERE (outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id') OR (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id') ORDER BY id ASC";
    $chat = mysqli_query($con, $chatquery);

    $response = array(); 

    while ($row = mysqli_fetch_assoc($chat)) {
        $response['status'] = '200';
        $response['chat'][] = $row;
    }
} else {
    $response['status'] = "500";
    $response['message'] = "ERROR: Insufficient data provided.";
}

echo json_encode($response);
?>

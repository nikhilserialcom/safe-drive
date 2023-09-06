<?php

require 'db.php';
header("content-type:application/json");

date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['outgoing_msg_id']) and isset($_POST['incoming_msg_id']))
{
    $outgoing_msg_id = $_POST['outgoing_msg_id'];
    $incoming_msg_id = $_POST['incoming_msg_id'];
    $message = mysqli_real_escape_string($con,$_POST['message']);
    $currenttime = date('h:i A');
    // echo $currenttime;
    if(!empty($message))
    {
        $messageQuery = "INSERT INTO messages(incoming_msg_id,outgoing_msg_id,messages,chat_time)VALUES('$incoming_msg_id','$outgoing_msg_id','$message','$currenttime')";
        $message = mysqli_query($con,$messageQuery);

        if ($message) {
            $response['status'] = "200";
        }
    }
    else
    {
        $response['status'] = '401';
        $response['message'] = "message is empty";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>
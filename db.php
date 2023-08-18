<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "safe-drive";

$con = mysqli_connect($host,$username,$password,$database);

// if (!$con) {
//     $response['error'] = "200";
//     $response['message'] = "connection failed";
// }
// else
// {
//     $response['error'] = "200";
//     $response['message'] = "connection successfully done";
// }

// echo json_encode($response);
?>
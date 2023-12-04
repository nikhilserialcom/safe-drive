<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

// $data = json_decode(file_get_contents('php://input'),true);
if(isset($_SESSION['user_email']))
{
    session_destroy();
    $response = array(
        'status_code' => 200,
        'message' => 'Logout successful!'
    );
    
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>
<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

// $data = json_decode(file_get_contents('php://input'),true);
if(!isset($_SESSION['user_email']))
{
    $response = array(
        'status_code' => 400,
        'email' => 'your session is expire'
    );
    
}

$userEmail = $_SESSION['user_email']; 

$checkUserQuery = "SELECT * FROM superuser WHERE s_email = '$userEmail'";
$checkUser = mysqli_query($con,$checkUserQuery);

if(mysqli_num_rows($checkUser) > 0)
{
    while($row = mysqli_fetch_assoc($checkUser))
    {
        $response = array(
            'status_code' => 200,
            'userData' => $row
        );
    }
}
else
{
    
    $response = array(
        'status_code' => 404,
        'message' => 'database empty'
    );
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>
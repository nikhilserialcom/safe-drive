<?php

require('db.php');
require_once 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'),true);

$userEmail = isset($data['user_email']) ? $data['user_email'] : '';
$otp = isset($data['otp']) ? $data['otp'] : '';

// $response = array(
//     'status_code' => 200,
//     'token' => $token,
//     'message' =>  $otp
// );

$checkEmailQuery = "SELECT * FROM superuser WHERE s_email = '$userEmail'";
$checkEmail = mysqli_query($con,$checkEmailQuery);

if(mysqli_num_rows($checkEmail) > 0){
    $row = mysqli_fetch_assoc($checkEmail);
    if($row['otp'] == $otp)
    {
        $response = array(
            'status_code' => 200,
            'message' =>  'true'
        );
    }
    else
    {
        $response = array(
            'status_code' => 400,
            'message' =>  'false'
        );
    }
}
else{
    $response = array(
        'status_code' => 404,
        'message' => 'email is not exist'
    );
}

    echo json_encode($response,JSON_PRETTY_PRINT); 
?>
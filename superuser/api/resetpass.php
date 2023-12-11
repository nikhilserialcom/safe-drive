<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'),true);

$token = isset($data['token']) ? $data['token'] : '';
$newPassword = isset($data['password']) ? $data['password'] : '';

$response = array(
    'status_code' => 200,
    'message' => $token,
    'password' => $newPassword
);

// $checkuserQuery = "SELECT * FROM superuser WHERE reset_token = '$token'";
// $checkuser = mysqli_query($con,$checkuserQuery);

// if(mysqli_num_rows($checkuser) > 0){
//     $row = mysqli_fetch_assoc($checkuser);
//     $changePassQuery = "UPDATE superuser SET s_password = '$password' WHERE reset_token = '$token'";
//     $changePass = mysqli_query($con,$changePassQuery);

//     if($changePass)
//     {
//         $response = array(
//             'status_code' => 200,
//             'message' => 'change password successfully'
//         );
//     }
//     else{
//         $response = array(
//             'status_code' => 500,
//             'message' => 'ERROR:' . mysqli_error($con)
//         );
//     }
// }
// else{
//     $response = array(
//         'status_code' => 404,
//         'message' => 'user not exist '
//     );
// }


echo json_encode($response, JSON_PRETTY_PRINT);

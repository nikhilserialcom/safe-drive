<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'),true);

$userEmail = isset($data['user_email']) ? $data['user_email'] : '';

// $response = array(
//     'status_code' => 200,
//     'message' => $userEmail,
//     'password' => $newPassword
// );

$checkuserQuery = "SELECT * FROM superuser WHERE s_email = '$userEmail'";
$checkuser = mysqli_query($con,$checkuserQuery);

if(mysqli_num_rows($checkuser) > 0){
    $newPassword = isset($data['password']) ? password_hash($data['password'],PASSWORD_BCRYPT) : '';

    $changePassQuery = "UPDATE superuser SET s_password = '$newPassword' WHERE S_email = '$userEmail'";
    $changePass = mysqli_query($con,$changePassQuery);

    if($changePass)
    {
        $response = array(
            'status_code' => 200,
            'message' => 'change password successfully'
        );
    }
    else{
        $response = array(
            'status_code' => 500,
            'message' => 'ERROR:' . mysqli_error($con)
        );
    }
}
else{
    $response = array(
        'status_code' => 404,
        'message' => 'user not exist '
    );
}


echo json_encode($response, JSON_PRETTY_PRINT);

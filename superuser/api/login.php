<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

$data = json_decode(file_get_contents('php://input'),true);

$email = isset($data['email']) ? $data['email'] : '';
// $password = isset($data['password']) ? password_hash($data['password'],PASSWORD_BCRYPT) : '';
$password = isset($data['password']) ? $data['password'] : '';

// $response = array(
//     'status_code' => 200,
//     'email' => $email,
//     'password' => $password
// );

$check_user_query = "SELECT * FROM superuser WHERE s_email = '$email'";
$check_user = mysqli_query($con,$check_user_query);

if(mysqli_num_rows($check_user) > 0)
{
    $user = mysqli_fetch_assoc($check_user);
    if(password_verify($password,$user['s_password']))
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['s_email'];
        $response = array(
            'status_code' => 200,
            'user_email' => $user['s_email'],
            'message' => 'login successfully!'
        );
    }
    else
    {
        $response = array(
            'status_code' => 400,
            'message' => 'email and password is worng!'
        );
    }
}
else
{
    $response = array(
        'status_code' => 404,
        'message' => 'user done not exist!'
    );
    
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>
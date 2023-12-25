<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

$username = isset($data['username']) ? $data['username'] : '';
$fullName = isset($data['fullName']) ? $data['fullName'] : '';
$email = isset($data['email']) ? $data['email'] : '';
$password = isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : '';
// $password = isset($data['password']) ? $data['password'] : '';

// $response = array(
//     'status_code' => 200,
//     'username' => $username,
//     'fullName' => $fullName,
//     'email' => $email,
//     'password' => $password
// );

$check_user_query = "SELECT * FROM superuser WHERE s_email = '$email'";
$check_user = mysqli_query($con, $check_user_query);

if (mysqli_num_rows($check_user) > 0) {
    $response = array(
        'status_code' => 404,
        'message' => 'email already exist!'
    );
} else {
    $userRegisterQuery = "INSERT INTO superuser(username,full_name,s_email,s_password)VALUES('$username','$fullName','$email','$password')";
    $userRegister = mysqli_query($con, $userRegisterQuery);
    if ($userRegister) {
        $response = array(
            'status_code' => '200',
            'message' => 'Registration successful!'
        );
    } else {
        $response = array(
            'status_code' => '200',
            'message' => "Error: " . mysqli_error($con)
        );
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);

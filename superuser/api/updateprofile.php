<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

if (!isset($_SESSION['user_email'])) {
    $response = array(
        'status_code' => 400,
        'email' => 'your session is expire'
    );
}

$userEmail = $_SESSION['user_email'];

$checkUserQuery = "SELECT * FROM superuser WHERE s_email = '$userEmail'";
$checkUser = mysqli_query($con, $checkUserQuery);

if (mysqli_num_rows($checkUser) > 0) {
    $row = mysqli_fetch_assoc($checkUser);
    $profile = isset($_FILES['profileImage']) ? $_FILES['profileImage'] : $row['profile_img'];
    $profile_tmpName = $_FILES['profileImage']['tmp_name'];
    $profileNewPart = explode('.', $profile['name']);
    $extension = end($profileNewPart);
    $profileNewName = rand(111111111, 999999999) . "." . $extension;
    $filemovedir = "../assets/storage/profile";
    $filedir = "storage/profile/";
    $filePath = $filedir.$profileNewName;

    if (!file_exists($filemovedir)) {
        mkdir($filemovedir, 0755, true);
    }

    $updateProfileQuery = "UPDATE superuser SET profile_img = '$filePath' WHERE s_email = '$userEmail'";
    $updateProfile = mysqli_query($con,$updateProfileQuery);

    if($updateProfile)
    {
        move_uploaded_file($profile_tmpName,$filemovedir . '/' . $profileNewName);
        $response = array(
            'status_code' => 200,
            'message' => 'profile update successfully'
        );
    }
    else{
        $response = array(
            'status_code' => 400,
            'message' => "ERROR:" . mysqli_error($con)
        );
    }
} else {

    $response = array(
        'status_code' => 404,
        'message' => 'database empty'
    );
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
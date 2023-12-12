<?php

require('db.php');
require_once 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'),true);

$userId = isset($data['user_id']) ? $data['user_id'] : '';

$response = array(
    'status_code' => '200',
    'user_id' => $userId
);

$checkuserQuery = "SELECT * FROM superuser WHERE id = '$userId'";
$checkuser = mysqli_query($con,$checkuserQuery);

if($checkuser)
{
    $deleteDataquery = "DELETE FROM superuser WHERE id = '$userId'";
    $deleteData = mysqli_query($con,$deleteDataquery);
    if($deleteData)
    {
        $response = array(
            'status_code' => '200',
            'message' => 'account delete peremently'
        );
    } 
    else
    {
        $response = array(
            'status_code' => '500',
            'message' => 'ERROR:' . mysqli_error($con)
        );
    }
}
else{
    $response = array(
        'status_code' => "404",
        'message' => 'user not found'
    );
}

echo json_encode($response,JSON_PRETTY_PRINT); 
?>
<?php

require 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

$category_name = isset($data['category']) ? $data['category'] : '';

$categorize_data_query = "SELECT * FROM user WHERE user_status = '1'";
if(!empty($category_name))
{
    $categorize_data_query.= " AND active_status = '$category_name'";
}
$categorize_data = mysqli_query($con, $categorize_data_query);
$final_data = array();

if (mysqli_num_rows($categorize_data) > 0) {
    while ($row = mysqli_fetch_assoc($categorize_data)) {
        $final_data[] = $row;
    }
    $response = array(
        'status_code' => '200',
        'final_data' => $final_data
    );
} else {
    $response = array(
        'status_code' => '404',
        'message' => 'no recode found'
    );
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>

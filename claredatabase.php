<?php

require 'db.php';

header("content-type:application/json");

$tables = array("book_ride","driver_request","request","trash_driver_request");

foreach($tables as $table)
{
    $sqlQuery = "TRUNCATE TABLE $table";
    $sql = mysqli_query($con,$sqlQuery);

    if($sql)
    {
        $response = array(
            'status_code' => '200',
            'message' => 'clear database successfully!'
        );
    }
    else
    {
        $response = array(
            'status_code' => '500',
            'message' => 'something went wrong'
        );
    }
}

echo json_encode($response);
?>
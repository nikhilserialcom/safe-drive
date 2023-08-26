<?php

require 'db.php';
header("content-type:application/json");

if($_POST['driverId'])
{
    $driverId = $_POST['driverId'];
    $earingQuery = "SELECT DATE(booking_date) AS bookingDate,SUM(amount) AS totalAmount,fromaddress,toaddress,amount,payment_mode,pessangerName FROM book_ride
                    WHERE driverId = '$driverId' and status = 'finish' 
                    GROUP BY DATE(booking_date)
                    ORDER BY DATE(booking_date) DESC";
    $earing = mysqli_query($con,$earingQuery);
    $data = array();

    while($row = mysqli_fetch_assoc($earing))
    {
        $data[] = $row;
    }
    $response['earingData'] = $data;
    // $earingQuery = "SELECT * FROM book_ride WHERE driverId = '$driverId' and status ='finish'";

    // $earing = mysqli_query($con,$earingQuery);

    // $data = array();
    // while($row = mysqli_fetch_assoc($earing))
    // {
    //     $data[] =$row;
    // }

    // $groupData = array();
    // foreach ($data as $row )
    // {
    //     $booking_date = date("Y-m-d", strtotime($row['booking_date']));
    //     if(!isset($groupData[$booking_date]))
    //     {
    //         $groupData[$booking_date] = array();
    //     }
    //     $groupData[$booking_date][] = $row;
    // }

    // $response['groupedRideData'] = $groupData;
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);
?>




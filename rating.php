<?php

require 'db.php';
header("content-type:application/json");

function showRatingData($driverId)
{
    global $con,$response;

    $ratingDataQuery = "SELECT * FROM rating WHERE driverId = '$driverId'";
    $ratingData = mysqli_query($con,$ratingDataQuery);
    
    $data = array();

    while($row = mysqli_fetch_assoc($ratingData))
    {
       $data[] = $row;
    }
    
    $groupData = array();
    foreach($data as $row)
    {
        $rating_date = date("Y-m-d", strtotime($row['created_at']));
        if(!isset($groupData[$rating_date]))
        {
            $groupData[$rating_date] = array(
                'totalrating' => 0,
                'rating' => array(),
            );
        }
        $groupData[$rating_date]['totalrating']++;
        $groupData[$rating_date]['rating'][] = $row;
    }

    $formatedData = array();

    foreach($groupData as $date => $data)
    {
        $formatedData[] = array(
            "Date" => date("d-m-Y", strtotime($date)),
            "Data" => $data
        );
    }
    $response['rideData'] = $formatedData;

    return $response;
}

function TotalRide($driverId)
{
    global $con;

    $totalRideQuery = "SELECT COUNT(*) AS count FROM completerides WHERE driverId = '$driverId'";
    $totalRide = mysqli_query($con,$totalRideQuery);

    $rides = 0;
    while($row = mysqli_fetch_assoc($totalRide))
    {
        $rides = $row['count'];
    }

    return $rides;
}

function showdriverRating($driverId) 
{
    global $con,$response;
    $response = array();

    // Retrieve the driver reviews data from the database
    $sql = "SELECT rating, COUNT(*) as count FROM rating WHERE driverId = '$driverId' GROUP BY rating ";
    $result = mysqli_query($con, $sql);

    // Calculate the total number of reviews
    $totalReviews = 0;
    $driverReviews = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $rating = $row['rating'];
        $count = $row['count'];

        $totalReviews += $count;
        $driverReviews[$rating] = $count;
    }

    // Calculate the percentage for each category
    $percentageReviews = array();

    foreach ($driverReviews as $rating => $count) {
        $percentage = ($count / $totalReviews) * 100;
        $percentageReviews[$rating] = round($percentage, 2); // Round to 2 decimal places
    }

    $averangeRating = calculateAverangeRating($driverId);
    $totalRide = TotalRide($driverId);

    // Display the percentage reviews
    $response['Totalride'] = $totalRide;
    $response['TotalReviews'] = $totalReviews;
    $response['averangeRating'] = $averangeRating;
    foreach ($percentageReviews as $rating => $percentage) {
        $response['rating'][$rating] = $percentage;
    }

    return $response;
}

function calculateAverangeRating($driverId)
{
    global $con;

    $findRatingQuery = "SELECT rating,COUNT(*) AS count FROM rating WHERE driverId = '$driverId'";
    $findRaiting = mysqli_query($con,$findRatingQuery);

    $totalRating = 0;
    $totalReviews = 0;

    while($row = mysqli_fetch_assoc($findRaiting))
    {
        $rating = $row['rating'];
        $count = $row['count'];

        $totalReviews += $count;
        $totalRating += ($rating * $count);
    }

    $averangeRating = 0;
    if($totalReviews > 0)
    {
        $averangeRating = ($totalRating / $totalReviews);
    }
    return number_format($averangeRating,1);

}

if(isset($_POST['driverId']))
{
    $driverId = $_POST['driverId'];
    $response['status'] = 200;
    $totalRide = TotalRide($driverId);
    $rating = showdriverRating($driverId);
    $ratingData = showRatingData($driverId);
}

if(isset($_POST['userId']) && isset($_POST['rating']))
{
    $userId = $_POST['userId'];
    $driverId = $_POST['driverId'];
    $rating = $_POST['rating'];
    $reviews = $_POST['reviews'];
    $tag = $_POST['tag'];
    $comment = $_POST['comment'];
    
    if(!empty($userId) && !empty($rating))
    {
        $Name = mysqli_query($con,"SELECT firstname FROM user WHERE id = '$userId'");
        $data = mysqli_fetch_assoc($Name);
        $passangerName = $data['firstname'];


        $insertRatingQuery = "INSERT INTO rating(driverId,userId,passengername,rating,reviews,tag,comment)VALUES('$driverId','$userId','$passangerName','$rating','$reviews','$tag','$comment')";
        $insertRaitng = mysqli_query($con,$insertRatingQuery);

        if($insertRaitng)
        {
            $response['status'] = "200";
            $response['message'] = "rating successfully done";
        }
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);
?>

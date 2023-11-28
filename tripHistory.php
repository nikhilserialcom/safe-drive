<?php

require 'db.php';
header("content-type:application/json");

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

function Driverdata($dirverId){

    global $con;

    $dataQuery = mysqli_query($con,"SELECT driverLetitude,driverLongitude,mobile_number,Number_plate,firstname FROM user INNER JOIN vehicleinfo ON user.driverId = vehicleinfo.driverId WHERE user.driverId = '$dirverId'");
    $data = mysqli_fetch_assoc($dataQuery);

    $driverdataQuery = "SELECT * FROM trash_driver_request WHERE driverId = '$dirverId'";
    $driverdata = mysqli_query($con,$driverdataQuery);
    $driver = mysqli_fetch_assoc($driverdata);

    $rating = '5';
    $driverdata = array(
        'drivername' => $data['firstname'],
        'profile' => $driver['photo'],
        'mobile_number' => $data['mobile_number'],
        'Number_plate' => $data['Number_plate'],
        'driverLetitude' => $data['driverLetitude'],
        'driverLongitude' => $data['driverLongitude'],
        'vehicleBrand' => $driver['vahicleBrand'],
        'rating' => $rating,
        'time' => $driver['time'],
    );

    return $driverdata;

}

function passngerData($userId)
{
    global $con;

    $dataQuery = mysqli_query($con,"SELECT * FROM user  WHERE id = '$userId' OR driverId = '$userId'");
    $data = mysqli_fetch_assoc($dataQuery);

    if($data['id'] == $userId)
    {
        $passngerData = array(
            'profile' => $data['photo'],
            'mobile_number' => $data['mobile_number'],
        );
    }
    elseif($data['driverId'] == $userId)
    {
        $passngerData = $data['firstname'];
    }


    return $passngerData;
}

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $tripStatus = $_POST['tripStatus'];

    if($tripStatus == "cancel")
    {
        $tripHistoryQuery = "SELECT * FROM completerides WHERE userId = '$userId' OR driverId = '$userId'";
        $tripHistory = mysqli_query($con,$tripHistoryQuery);

        if(mysqli_num_rows($tripHistory) > 0)
        {
            while($row = mysqli_fetch_assoc($tripHistory))
            {
                if(($row['userId'] == "$userId" && $row['status'] == "cancel") || ($row['driverId'] == "$userId" && $row['status'] == "cancel"))
                {
                    $dirverId = $row['driverId'];
                    $driverDataQuery = "SELECT * FROM user WHERE driverId = '$dirverId'";
                    $driverdata = mysqli_query($con,$driverDataQuery);
                    $driver = mysqli_fetch_assoc($driverdata);
                    $row['drivername'] = $driver['firstname'];
                    $response['status'] = "200";
                    $response['data'][] = $row;
                }
            }
        }
        else
        {
            $response['status'] = "404";
            $response['message'] = "past database empty";
        }
    }
    else
    {
        $upcomingTripQuery = "SELECT * FROM book_ride WHERE userId = '$userId' OR driverId = '$userId'";
        $upcomingTrip = mysqli_query($con,$upcomingTripQuery);
        $upcomingData = [];

        while($upcoming = mysqli_fetch_assoc($upcomingTrip))
        {
            if($upcoming['userId'] == $userId)
            {
                $driverdata = Driverdata($upcoming['driverId']);
                $upcoming['drivername'] = $driverdata['drivername'];
                $upcoming['profile'] = $driverdata['profile'];
                $upcoming['mobile_number'] = $driverdata['mobile_number'];
                $upcoming['Number_plate'] = $driverdata['Number_plate'];
                $upcoming['driverLetitude'] = $driverdata['driverLetitude'];
                $upcoming['driverLongitude'] = $driverdata['driverLongitude'];
                $upcoming['vehicleBrand'] = $driverdata['vehicleBrand'];
                $upcoming['rating'] = $driverdata['rating'];
                $upcoming['time'] = $driverdata['time'];
                $upcomingData[] = $upcoming;
            }
            elseif($upcoming['driverId'] == $userId)
            {
                $finalData = passngerData($upcoming['userId']);
                $driverdata = Driverdata($upcoming['driverId']);
                $upcoming['profile'] = $finalData['profile'];
                $upcoming['mobile_number'] = $finalData['mobile_number'];
                $upcoming['time'] = $driverdata['time'];
                $upcomingData[] = $upcoming;
            }
        }
        $time = '';

        $pastTripQuery = "SELECT * FROM completerides WHERE userId = '$userId' OR driverId = '$userId'";
        $pastTrip = mysqli_query($con,$pastTripQuery);
        $pastData = [];
        
        while($pastTripData = mysqli_fetch_assoc($pastTrip))
        {
            if($pastTripData['userId'] == $userId && $pastTripData['status'] == 'finish')
            {
                $finalData = passngerData($pastTripData['driverId']);
                $pastTripData['drivername'] = $finalData;
                $pastData[] = $pastTripData;
            }
            elseif($pastTripData['driverId'] == $userId && $pastTripData['status'] == 'finish')
            {
                $pastData[] = $pastTripData;
            }
        }


        $totalData = array_merge($upcomingData,$pastData);
        $response['status'] = "200";
        $response['data'] = $totalData; 
    }
    

} 
else 
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}


echo json_encode($response);
?>
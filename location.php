<?php
header("content-type:application/json");
function getAreaAroundCoordinates($latitude, $longitude, $radius) {
    // Earth's radius in kilometers
    $earthRadius = 6371;

    // Convert latitude and longitude from degrees to radians
    $latRad = deg2rad($latitude);
    $lngRad = deg2rad($longitude);

    // Calculate the angular distance
    $angularDistance = $radius / $earthRadius;

    // Calculate the minimum and maximum latitudes
    $minLat = $latRad - $angularDistance;
    $maxLat = $latRad + $angularDistance;

    // Calculate the minimum and maximum longitudes
    $deltaLng = asin(sin($angularDistance) / cos($latRad));
    $minLng = $lngRad - $deltaLng;
    $maxLng = $lngRad + $deltaLng;

    // Convert the results back to degrees
    $minLatDeg = rad2deg($minLat);
    $maxLatDeg = rad2deg($maxLat);
    $minLngDeg = rad2deg($minLng);
    $maxLngDeg = rad2deg($maxLng);

    // Return the area as an array
    $area = [
        'minLat' => $minLatDeg,
        'maxLat' => $maxLatDeg,
        'minLng' => $minLngDeg,
        'maxLng' => $maxLngDeg,
    ];

    return $area;
}

$latitude = $_POST['latitude'];
$longitude = $_POST['longtitude']; 
$radius = 5; // Radius in kilometers

$area = getAreaAroundCoordinates($latitude, $longitude, $radius);
if ($area) {
    $response['Minimum Latitude:'] = $area['minLat'] ;
    $response['Maximum Latitude:'] = $area['maxLat'];
    $response['Minimum Longitude:'] = $area['minLng'];
    $response['Maximum Longitude:'] = $area['maxLng'];  
}
else
{
    $response['failed'] = "false";
    
}

echo json_encode($response);

?>
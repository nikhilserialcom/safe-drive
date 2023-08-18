<?php
require '../db.php';
header("content-type:application/json");

function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
{   
    global $response,$con;

    $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE user_id = '$driverId'");

    if($updateLocation)
    {
        $response['status'] = "true";
        $response['message'] = "update location";
    }

}

if(isset($_POST['userId']))
{
    $id = $_POST['userId'];
    $Vehicle_brand = mysqli_real_escape_string($con, $_POST['VehicleBrand']);
    $number_plat = mysqli_real_escape_string($con, $_POST['numberPlate']);
    $transport_year = mysqli_real_escape_string($con, $_POST['transportYear']);
    if(isset($_POST['driverLetitude']) && isset($_POST['driverLongitude']))
    {
       $driverLetitude = $_POST['driverLetitude'];
       $driverLogitude = $_POST['driverLongitude'];
       if(!empty($driverLetitude) && !empty($driverLogitude))
       {
           updateDriverLocation($driverLetitude,$driverLogitude,$userId);
       }
    }

    $check_user_query = "SELECT * FROM Vehicleinfo WHERE user_id = '$id'";
    $check_user = mysqli_query($con, $check_user_query);

    if (mysqli_num_rows($check_user) > 0) {
        $response['status'] = "false";
        $response['message'] = "User already exists";
    } else {
        if (!preg_match('/^[A-Z]{2}[\\ -]{0,1}[0-9]{2}[\\ ""-]{0,1}[A-Z]{1,2}[\\ -]{0,1}[0-9]{4}$/', $number_plat)) {
            $response['status'] = "false";
            $response['message'] = "Number plate is not valid";
        } elseif (
            (isset($_FILES['frontcar']) && !empty($_FILES['frontcar']['tmp_name'])) &&
            (isset($_FILES['rightcar']) && !empty($_FILES['rightcar']['tmp_name'])) &&
            (isset($_FILES['backcar']) && !empty($_FILES['backcar']['tmp_name'])) &&
            (isset($_FILES['leftcar']) && !empty($_FILES['leftcar']['tmp_name'])) &&
            (isset($_FILES['frontRC']) && !empty($_FILES['frontRC']['tmp_name'])) &&
            (isset($_FILES['backRC']) && !empty($_FILES['backRC']['tmp_name'])) &&
            (isset($_FILES['selfiRC']) && !empty($_FILES['selfiRC']['tmp_name'])) &&
            (isset($_FILES['frontParmit']) && !empty($_FILES['frontParmit']['tmp_name'])) &&
            (isset($_FILES['backParmit']) && !empty($_FILES['backParmit']['tmp_name']))
        ) {
            $frontcarTmpName = $_FILES['frontcar']['tmp_name'];
            $frontcarname = rand(111111111, 999999999) . ".jpg";
            $frontcar_folder = 'uploaded/vehicle/car/';
            $frontcarpath = $frontcar_folder . $frontcarname;

            $rightcarTmpName = $_FILES['rightcar']['tmp_name'];
            $rightcarname = rand(111111111, 999999999) . ".jpg";
            $rightcar_folder = 'uploaded/vehicle/car/';
            $rightcarpath = $rightcar_folder . $rightcarname;

            $backcarTmpName = $_FILES['backcar']['tmp_name'];
            $backcarname = rand(111111111, 999999999) . ".jpg";
            $backcar_folder = 'uploaded/vehicle/car/';
            $backcarpath = $backcar_folder . $backcarname;

            $leftcarTmpName = $_FILES['leftcar']['tmp_name'];
            $leftcarname = rand(111111111, 999999999) . ".jpg";
            $leftcar_folder = 'uploaded/vehicle/car/';
            $leftcarpath = $leftcar_folder . $leftcarname;

            $frontRCTmpName = $_FILES['frontRC']['tmp_name'];
            $frontRCname = rand(111111111, 999999999) . ".jpg";
            $frontRC_folder = 'uploaded/vehicle/RC/';
            $frontRCpath = $frontRC_folder . $frontRCname;

            $backRCTmpName = $_FILES['backRC']['tmp_name'];
            $backRCname = rand(111111111, 999999999) . ".jpg";
            $backRC_folder = 'uploaded/vehicle/RC/';
            $backRCpath = $backRC_folder . $backRCname;

            $selfiRCTmpName = $_FILES['selfiRC']['tmp_name'];
            $selfiRCname = rand(111111111, 999999999) . ".jpg";
            $selfiRC_folder = 'uploaded/vehicle/RC/';
            $selfiRCpath = $selfiRC_folder . $selfiRCname;

            $frontParmitTmpName = $_FILES['frontParmit']['tmp_name'];
            $forntname = rand(111111111, 999999999) . ".jpg";
            $frontParmit_folder = 'uploaded/vehicle/parmit/';
            $frontpath = $frontParmit_folder . $forntname;

            $backParmitTmpName = $_FILES['backParmit']['tmp_name'];
            $backname = rand(111111111, 999999999) . ".jpg";
            $backParmit_folder = 'uploaded/vehicle/parmit/';
            $backpath = $backParmit_folder . $backname;

            $insert_query = "INSERT INTO Vehicleinfo(user_id, vehicle_brand_name, Number_plate, car_photo, rigthside_photo, backside_photo, leftside_photo, transport_year, frontRC, backRC, selfiwithRC, frontParmit, backParmit) VALUES ('$id', '$Vehicle_brand', '$number_plat', '$frontcarpath', '$rightcarpath', '$backcarpath', '$leftcarpath', '$transport_year', '$frontRCpath', '$backRCpath', '$selfiRCpath', '$frontpath', '$backpath')";
            $insert = mysqli_query($con, $insert_query);

            if ($insert) {
                if (move_uploaded_file($frontcarTmpName, $frontcarpath) &&
                    move_uploaded_file($rightcarTmpName, $rightcarpath) &&
                    move_uploaded_file($backcarTmpName, $backcarpath) &&
                    move_uploaded_file($leftcarTmpName, $leftcarpath) &&
                    move_uploaded_file($frontRCTmpName, $frontRCpath) &&
                    move_uploaded_file($backRCTmpName, $backRCpath) &&
                    move_uploaded_file($frontParmitTmpName, $frontpath) &&
                    move_uploaded_file($backParmitTmpName, $backpath)
                ) {
                    $response['status'] = "200";
                    $response['message'] = "Record inserted";
                } 
            } 
        } 
        else 
        {
            $response['status'] = "404";
            $response['message'] = "One or more files are missing";
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

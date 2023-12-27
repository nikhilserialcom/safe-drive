<?php
require '../db.php';
header("content-type:application/json");

// function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
// {   
//     global $response,$con;

//     $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE user_id = '$driverId'");

//     if($updateLocation)
//     {
//         $response['status'] = "true";
//         $response['message'] = "update location";
//     }

// }

$response = array();

if (isset($_POST['driverId'])) {
    $id = $_POST['driverId'];
    $Vehicle_brand = mysqli_real_escape_string($con, $_POST['VehicleBrand']);
    $vehicleModel = mysqli_real_escape_string($con, $_POST['vehicleModel']);
    $number_plat = mysqli_real_escape_string($con, $_POST['numberPlate']);
    $transport_year = mysqli_real_escape_string($con, $_POST['transportYear']);
    // if(isset($_POST['driverLetitude']) && isset($_POST['driverLongitude']))
    // {
    //    $driverLetitude = $_POST['driverLetitude'];
    //    $driverLogitude = $_POST['driverLongitude'];
    //    if(!empty($driverLetitude) && !empty($driverLogitude))
    //    {
    //        updateDriverLocation($driverLetitude,$driverLogitude,$userId);
    //    }
    // }

    $check_user_query = "SELECT * FROM Vehicleinfo WHERE driverId = '$id'";
    $check_user = mysqli_query($con, $check_user_query);

    if (mysqli_num_rows($check_user) > 0) {
        $update_query = "UPDATE user SET active_status = 'pending',rejection_reason = '' WHERE driverId='$id'";
        $update = mysqli_query($con, $update_query);
        if (isset($_POST['VehicleBrand']) || isset($_POST['vehicleModel']) || isset($_POST['numberPlate']) || isset($_POST['transportYear'])) {
            if (!empty($Vehicle_brand) || !empty($vehicleModel) || !empty($number_plat) || !empty($transport_year)) {
                $update_vehicleInfo_query = "UPDATE Vehicleinfo SET vehicle_brand_name = '$Vehicle_brand', modal = '$vehicleModel', Number_plate = '$number_plat', transport_year = '$transport_year', status = 'pending' WHERE driverId = '$id'";
                $update_vehicleInfo = mysqli_query($con, $update_vehicleInfo_query);
                if ($update_vehicleInfo) {
                    $response['status'] = '200';
                    $response['message'] = "vehicla Information updated";
                }
            }
        }
        if ((isset($_FILES['frontcar']) && !empty($_FILES['frontcar']['tmp_name']))) {
            $front = $_FILES['frontcar'];

            if (!empty($front)) {
                $frontcarTmpName = $_FILES['frontcar']['tmp_name'];
                $frontcarname = rand(111111111, 999999999) . ".jpg";
                $frontcar_folder = 'uploaded/vehicle/car/';
                $frontcarpath = $frontcar_folder . $frontcarname;

                $update_image_query = "UPDATE Vehicleinfo SET car_photo = '$frontcarpath' WHERE driverId = '$id'";
                $update_image = mysqli_query($con, $update_image_query);

                if ($update_image) {
                    move_uploaded_file($frontcarTmpName, $frontcarpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla Image updated";
                }
            }
        }
        if (isset($_FILES['rightcar']) && !empty($_FILES['rightcar']['tmp_name'])) {
            $right = $_FILES['rightcar'];

            $rightcarTmpName = $_FILES['rightcar']['tmp_name'];
            $rightcarname = rand(111111111, 999999999) . ".jpg";
            $rightcar_folder = 'uploaded/vehicle/car/';
            $rightcarpath = $rightcar_folder . $rightcarname;

            $update_image_query = "UPDATE Vehicleinfo SET rigthside_photo = '$rightcarpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($rightcarTmpName, $rightcarpath)) {
                    $response['status'] = "200";
                    $response['message'] = "vehicla Image updated";
                }
            }
        }
        if (isset($_FILES['backcar']) && !empty($_FILES['backcar']['tmp_name'])) {
            $back = $_FILES['backcar'];

            $backcarTmpName = $_FILES['backcar']['tmp_name'];
            $backcarname = rand(111111111, 999999999) . ".jpg";
            $backcar_folder = 'uploaded/vehicle/car/';
            $backcarpath = $backcar_folder . $backcarname;

            $update_image_query = "UPDATE Vehicleinfo SET backside_photo = '$backcarpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($backcarTmpName, $backcarpath)) {
                    $response['status'] = "200";
                    $response['message'] = "vehicla Image updated";
                }
            }
        }
        if (isset($_FILES['leftcar']) && !empty($_FILES['leftcar']['tmp_name'])) {
            $left = $_FILES['leftcar'];

            $leftcarTmpName = $_FILES['leftcar']['tmp_name'];
            $leftcarname = rand(111111111, 999999999) . ".jpg";
            $leftcar_folder = 'uploaded/vehicle/car/';
            $leftcarpath = $leftcar_folder . $leftcarname;

            $update_image_query = "UPDATE Vehicleinfo SET leftside_photo = '$leftcarpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($leftcarTmpName, $leftcarpath)) {
                    $response['status'] = "200";
                    $response['message'] = "vehicla Image updated";
                }
            }
        }
        if (isset($_FILES['frontRC']) && !empty($_FILES['frontRC']['tmp_name'])) {
            $frontRC = $_FILES['frontRC'];

            $frontRcTmpName = $_FILES['frontRC']['tmp_name'];
            $frontRCname = rand(111111111, 999999999) . ".jpg";
            $frontRC_folder = 'uploaded/vehicle/RC/';
            $frontRCpath = $frontRC_folder . $frontRCname;

            $update_image_query = "UPDATE Vehicleinfo SET frontRC = '$frontRCpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($frontRcTmpName, $frontRCpath)) {
                    $response['status'] = "200";
                    $response['message'] = "vehicla RC Image updated";
                }
            }
        }
        if (isset($_FILES['backRC']) && !empty($_FILES['backRC']['tmp_name'])) {
            $backRC = $_FILES['backRC'];

            $backRcTmpName = $_FILES['backRC']['tmp_name'];
            $backRCname = rand(111111111, 999999999) . ".jpg";
            $backRC_folder = 'uploaded/vehicle/RC/';
            $backRCpath = $backRC_folder . $backRCname;

            $update_image_query = "UPDATE Vehicleinfo SET backRC = '$backRCpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($backRcTmpName, $backRCpath)) {
                    $response['status'] = "200";
                    $response['message'] = "vehicla RC Image updated";
                }
            }
        }
        if (isset($_FILES['selfiRC']) && !empty($_FILES['selfiRC']['tmp_name'])) {
            $selfiRC = $_FILES['selfiRC'];

            $selfiRcTmpName = $_FILES['selfiRC']['tmp_name'];
            $selfiRCname = rand(111111111, 999999999) . ".jpg";
            $selfiRC_folder = 'uploaded/vehicle/RC/';
            $selfiRCpath = $selfiRC_folder . $selfiRCname;

            $update_image_query = "UPDATE Vehicleinfo SET selfiwithRC = '$selfiRCpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($selfiRcTmpName, $selfiRCpath)) {
                    $response['status'] = "200";
                    $response['message'] = "vehicla RC Image updated";
                }
            }
        }

        if ((isset($_FILES['frontParmit']) && !empty($_FILES['frontParmit']['tmp_name']))) {
            $frontParmit = $_FILES['frontParmit'];

            $frontParmitTmpName = $_FILES['frontParmit']['tmp_name'];
            $forntname = rand(111111111, 999999999) . ".jpg";
            $frontParmit_folder = 'uploaded/vehicle/parmit/';
            $frontParmitpath = $frontParmit_folder . $forntname;

            $update_image_query = "UPDATE Vehicleinfo SET frontParmit = '$frontParmitpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($frontParmitTmpName, $frontParmitpath)) {
                    $response['status'] = "200";
                    $response['message'] = "vehicla Parmit Image updated";
                }
            }
        }
        if ((isset($_FILES['backParmit']) && !empty($_FILES['backParmit']['tmp_name']))) {

            $backParmit = $_FILES['backParmit'];

            $backParmitTmpName = $_FILES['backParmit']['tmp_name'];
            $backname = rand(111111111, 999999999) . ".jpg";
            $backParmit_folder = 'uploaded/vehicle/parmit/';
            $backParmitpath = $backParmit_folder . $backname;

            $update_image_query = "UPDATE Vehicleinfo SET backParmit = '$backParmitpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($backParmitTmpName, $backParmitpath)) {
                    $response['status'] = "200";
                    $response['message'] = "vehicla Parmit Image updated";
                }
            }
        }
    } else {
        if (
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

            $insert_query = "INSERT INTO Vehicleinfo(driverId, vehicle_brand_name, Modal, Number_plate, car_photo, rigthside_photo, backside_photo, leftside_photo, transport_year, frontRC, backRC, selfiwithRC, frontParmit, backParmit) VALUES ('$id', '$Vehicle_brand','$vehicleModel', '$number_plat', '$frontcarpath', '$rightcarpath', '$backcarpath', '$leftcarpath', '$transport_year', '$frontRCpath', '$backRCpath', '$selfiRCpath', '$frontpath', '$backpath')";
            $insert = mysqli_query($con, $insert_query);

            if ($insert) {
                if (
                    move_uploaded_file($frontcarTmpName, $frontcarpath) &&
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
        } else {
            $response['status'] = "404";
            $response['message'] = "One or more files are missing";
        }
    }
} else {
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);

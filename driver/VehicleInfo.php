<?php
require '../db.php';
header("content-type:application/json");

$response = array();
if (isset($_POST['driverId'])) {
    $id = $_POST['driverId'];
    $Vehicle_brand = mysqli_real_escape_string($con, $_POST['VehicleBrand']);
    $vehicleModel = mysqli_real_escape_string($con, $_POST['vehicleModel']);
    $number_plat = mysqli_real_escape_string($con, $_POST['numberPlate']);
    $transport_year = mysqli_real_escape_string($con, $_POST['transportYear']);
    $vehicle_type = mysqli_real_escape_string($con, $_POST['vehicle_type']);

    $check_user_query = "SELECT * FROM vehicleinfo WHERE driverId = '$id' AND vehicle_type = '$vehicle_type' ";
    $check_user = mysqli_query($con, $check_user_query);

    if (mysqli_num_rows($check_user) > 0) {  
            if (!empty($vehicle_type) || !empty($Vehicle_brand) || !empty($vehicleModel) || !empty($number_plat) || !empty($transport_year)) {
                $update_vehicleInfo_query = "UPDATE vehicleinfo SET vehicle_brand_name = '$Vehicle_brand', modal = '$vehicleModel', Number_plate = '$number_plat', transport_year = '$transport_year', status = 'pending' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
                $update_vehicleInfo = mysqli_query($con, $update_vehicleInfo_query);
                if ($update_vehicleInfo) {
                    $response['status'] = '200';
                    $response['message'] = "vehicla Information updated";
                }
            }
            
        if ((isset($_FILES['frontcar']) && !empty($_FILES['frontcar']['tmp_name']))) {
            $front = $_FILES['frontcar'];
                $frontcarTmpName = $_FILES['frontcar']['tmp_name'];
                $car_new_part = explode('.',$front['name']);
                $front_car_extension = end($car_new_part);
                $frontcarname = rand(111111111, 999999999) . "." . $front_car_extension;
                $frontcar_folder = 'uploaded/vehicle/car/';
                $frontcarpath = $frontcar_folder . $frontcarname;

                $update_image_query = "UPDATE Vehicleinfo SET car_photo = '$frontcarpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
                $update_image = mysqli_query($con, $update_image_query);

                if ($update_image) {
                    move_uploaded_file($frontcarTmpName, $frontcarpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla Image updated";
                }
        }
        
        if (isset($_FILES['rightcar']) && !empty($_FILES['rightcar']['tmp_name'])) {
            $right = $_FILES['rightcar'];

            $rightcarTmpName = $_FILES['rightcar']['tmp_name'];
            $right_new_part = explode('.',$right['name']);
            $right_car_extension = end($right_new_part);
            $rightcarname = rand(111111111, 999999999) . "." . $right_car_extension;
            $rightcar_folder = 'uploaded/vehicle/car/';
            $rightcarpath = $rightcar_folder . $rightcarname;

            $update_image_query = "UPDATE vehicleinfo SET rigthside_photo = '$rightcarpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                move_uploaded_file($rightcarTmpName, $rightcarpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla Image updated";
            }
        }
        
        if (isset($_FILES['backcar']) && !empty($_FILES['backcar']['tmp_name'])) {
            $back = $_FILES['backcar'];

            $backcarTmpName = $_FILES['backcar']['tmp_name'];
            $back_new_part = explode('.',$back['name']);
            $back_car_extension = end($back_new_extension);
            $backcarname = rand(111111111, 999999999) . "." . $back_car_extension;
            $backcar_folder = 'uploaded/vehicle/car/';
            $backcarpath = $backcar_folder . $backcarname;

            $update_image_query = "UPDATE vehicleinfo SET backside_photo = '$backcarpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                move_uploaded_file($backcarTmpName, $backcarpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla Image updated";
            }
        }
        
        if (isset($_FILES['leftcar']) && !empty($_FILES['leftcar']['tmp_name'])) {
            $left = $_FILES['leftcar'];

            $leftcarTmpName = $_FILES['leftcar']['tmp_name'];
            $left_new_part = explode('.',$left['name']);
            $left_car_extension = end($left_new_part);
            $leftcarname = rand(111111111, 999999999) . "." . $left_car_extension;
            $leftcar_folder = 'uploaded/vehicle/car/';
            $leftcarpath = $leftcar_folder . $leftcarname;

            $update_image_query = "UPDATE vehicleinfo SET leftside_photo = '$leftcarpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                move_uploaded_file($leftcarTmpName, $leftcarpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla Image updated";
            }
        }
        
        if (isset($_FILES['frontRC']) && !empty($_FILES['frontRC']['tmp_name'])) {
            $frontRC = $_FILES['frontRC'];

            $frontRCTmpName = $_FILES['frontRC']['tmp_name'];
            $rc_front_new_part = explode('.',$frontRC['name']);
            $front_rc_extension = end($rc_front_new_part);
            $frontRCname = rand(111111111, 999999999) . "." . $front_rc_extension;
            $frontRC_folder = 'uploaded/vehicle/RC/';
            $frontRCpath = $frontRC_folder . $frontRCname;

            $update_image_query = "UPDATE vehicleinfo SET frontRC = '$frontRCpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                move_uploaded_file($frontRcTmpName, $frontRCpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla RC Image updated";
            }
        }
        
        if (isset($_FILES['backRC']) && !empty($_FILES['backRC']['tmp_name'])) {
            $backRC = $_FILES['backRC'];

            $backRCTmpName = $_FILES['backRC']['tmp_name'];
            $rc_back_new_part = explode('.',$backRC['name']);
            $back_rc_extension = end($rc_back_new_part);
            $backRCname = rand(111111111, 999999999) . "." . $back_rc_extension;
            $backRC_folder = 'uploaded/vehicle/RC/';
            $backRCpath = $backRC_folder . $backRCname;

            $update_image_query = "UPDATE vehicleinfo SET backRC = '$backRCpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                move_uploaded_file($backRcTmpName, $backRCpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla RC Image updated";
            }
        }
        
        if (isset($_FILES['selfiRC']) && !empty($_FILES['selfiRC']['tmp_name'])) {
            $selfiRC = $_FILES['selfiRC'];
            
            $selfiRCTmpName = $_FILES['selfiRC']['tmp_name'];
            $selfi_rc_new_part = explode('.',$selfiRC['name']);
            $selfi_rc_extension = end($selfi_rc_new_part);
            $selfiRCname = rand(111111111, 999999999) . "." . $selfi_rc_extension;
            $selfiRC_folder = 'uploaded/vehicle/RC/';
            $selfiRCpath = $selfiRC_folder . $selfiRCname;

            $update_image_query = "UPDATE vehicleinfo SET selfiwithRC = '$selfiRCpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                move_uploaded_file($selfiRcTmpName, $selfiRCpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla RC Image updated";
            }
        }
        
        if ((isset($_FILES['frontParmit']) && !empty($_FILES['frontParmit']['tmp_name']))) {
            $frontParmit = $_FILES['frontParmit'];

            $frontParmitTmpName = $_FILES['frontParmit']['tmp_name'];
            $front_parmit_new_part = explode('.',$frontParmit['name']);
            $front_parmit_extension = end($front_parmit_new_part);
            $forntname = rand(111111111, 999999999) . "." . $front_parmit_extension;
            $frontParmit_folder = 'uploaded/vehicle/parmit/';
            $frontParmitpath = $frontParmit_folder . $forntname;

            $update_image_query = "UPDATE vehicleinfo SET frontParmit = '$frontParmitpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                move_uploaded_file($frontParmitTmpName, $frontParmitpath);
                    $response['status'] = "200";
                    $response['message'] = "vehicla Parmit Image updated";
            }
        }
        
        if ((isset($_FILES['backParmit']) && !empty($_FILES['backParmit']['tmp_name']))) {

            $backParmit = $_FILES['backParmit'];

          $backParmitTmpName = $_FILES['backParmit']['tmp_name'];
            $back_parmit_new_part = explode('.',$backParmit['name']);
            $back_parmit_extension = end($back_parmit_new_part);
            $backname = rand(111111111, 999999999) . "." . $back_parmit_extension;
            $backParmit_folder = 'uploaded/vehicle/parmit/';
            $backParmitpath = $backParmit_folder . $backname;

            $update_image_query = "UPDATE vehicleinfo SET backParmit = '$backParmitpath' WHERE driverId = '$id' AND vehicle_type = '$vehicle_type'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
              move_uploaded_file($backParmitTmpName, $backParmitpath) ;
                    $response['status'] = "200";
                    $response['message'] = "vehicla Parmit Image updated";
                
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
            $car_new_part = explode('.',$_FILES['frontcar']['name']);
            $front_car_extension = end($car_new_part);
            $frontcarname = rand(111111111, 999999999) . "." . $front_car_extension;
            $frontcar_folder = 'uploaded/vehicle/car/';
            $frontcarpath = $frontcar_folder . $frontcarname;

            $rightcarTmpName = $_FILES['rightcar']['tmp_name'];
            $right_new_part = explode('.',$_FILES['rightcar']['name']);
            $right_car_extension = end($right_new_part);
            $rightcarname = rand(111111111, 999999999) . "." . $right_car_extension;
            $rightcar_folder = 'uploaded/vehicle/car/';
            $rightcarpath = $rightcar_folder . $rightcarname;

            $backcarTmpName = $_FILES['backcar']['tmp_name'];
            $back_new_part = explode('.',$_FILES['backcar']['name']);
            $back_car_extension = end($back_new_extension);
            $backcarname = rand(111111111, 999999999) . "." . $back_car_extension;
            $backcar_folder = 'uploaded/vehicle/car/';
            $backcarpath = $backcar_folder . $backcarname;

            $leftcarTmpName = $_FILES['leftcar']['tmp_name'];
            $left_new_part = explode('.',$_FILES['leftcar']['name']);
            $left_car_extension = end($left_new_part);
            $leftcarname = rand(111111111, 999999999) . "." . $left_car_extension;
            $leftcar_folder = 'uploaded/vehicle/car/';
            $leftcarpath = $leftcar_folder . $leftcarname;

            $frontRCTmpName = $_FILES['frontRC']['tmp_name'];
            $rc_front_new_part = explode('.',$_FILES['frontRC']['name']);
            $front_rc_extension = end($rc_front_new_part);
            $frontRCname = rand(111111111, 999999999) . "." . $front_rc_extension;
            $frontRC_folder = 'uploaded/vehicle/RC/';
            $frontRCpath = $frontRC_folder . $frontRCname;

            $backRCTmpName = $_FILES['backRC']['tmp_name'];
            $rc_back_new_part = explode('.',$_FILES['backRC']['name']);
            $back_rc_extension = end($rc_back_new_part);
            $backRCname = rand(111111111, 999999999) . "." . $back_rc_extension;
            $backRC_folder = 'uploaded/vehicle/RC/';
            $backRCpath = $backRC_folder . $backRCname;

            $selfiRCTmpName = $_FILES['selfiRC']['tmp_name'];
            $selfi_rc_new_part = explode('.',$_FILES['selfiRC']['name']);
            $selfi_rc_extension = end($selfi_rc_new_part);
            $selfiRCname = rand(111111111, 999999999) . "." . $selfi_rc_extension;
            $selfiRC_folder = 'uploaded/vehicle/RC/';
            $selfiRCpath = $selfiRC_folder . $selfiRCname;

            $frontParmitTmpName = $_FILES['frontParmit']['tmp_name'];
            $front_parmit_new_part = explode('.',$_FILES['frontParmit']['name']);
            $front_parmit_extension = end($front_parmit_new_part);
            $forntname = rand(111111111, 999999999) . "." . $front_parmit_extension;
            $frontParmit_folder = 'uploaded/vehicle/parmit/';
            $frontpath = $frontParmit_folder . $forntname;

            $backParmitTmpName = $_FILES['backParmit']['tmp_name'];
            $back_parmit_new_part = explode('.',$_FILES['backParmit']['name']);
            $back_parmit_extension = end($back_parmit_new_part);
            $backname = rand(111111111, 999999999) . "." . $back_parmit_extension;
            $backParmit_folder = 'uploaded/vehicle/parmit/';
            $backpath = $backParmit_folder . $backname;

            $insert_query = "INSERT INTO vehicleinfo(driverId,vehicle_type, vehicle_brand_name, Modal, Number_plate, car_photo, rigthside_photo, backside_photo, leftside_photo, transport_year, frontRC, backRC, selfiwithRC, frontParmit, backParmit) VALUES ('$id','$vehicle_type','$Vehicle_brand','$vehicleModel', '$number_plat', '$frontcarpath', '$rightcarpath', '$backcarpath', '$leftcarpath', '$transport_year', '$frontRCpath', '$backRCpath', '$selfiRCpath', '$frontpath', '$backpath')";
            $insert = mysqli_query($con, $insert_query);

            if ($insert) {
                    move_uploaded_file($frontcarTmpName, $frontcarpath);
                    move_uploaded_file($rightcarTmpName, $rightcarpath);
                    move_uploaded_file($backcarTmpName, $backcarpath);
                    move_uploaded_file($leftcarTmpName, $leftcarpath);
                    move_uploaded_file($frontRCTmpName, $frontRCpath);
                    move_uploaded_file($backRCTmpName, $backRCpath);
                    move_uploaded_file($frontParmitTmpName, $frontpath); 
                    move_uploaded_file($backParmitTmpName, $backpath);
               
                    $response['status'] = "200";
                    $response['message'] = "Record inserted";
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
?>

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

if (isset($_POST['driverId'])) {
    $id = $_POST['driverId'];
    $DLnumber = $_POST['DLnumber'];
    $expirationDate = $_POST['expirationDate'];
    // if(isset($_POST['driverLetitude']) && isset($_POST['driverLongitude']))
    // {
    // $driverLetitude = $_POST['driverLetitude'];
    // $driverLogitude = $_POST['driverLongitude'];
    // if(!empty($driverLetitude) && !empty($driverLogitude))
    // {
    //     updateDriverLocation($driverLetitude,$driverLogitude,$userId);
    // }
    // }

    $check_user_query = "SELECT * FROM driving_licese_info WHERE driverId = '$id'";
    $check_user = mysqli_query($con, $check_user_query);

    if (mysqli_num_rows($check_user) > 0) {
        $update_query = "UPDATE user SET active_status = 'pending',rejection_reason = '' WHERE driverId='$id'";
        $update = mysqli_query($con, $update_query);
        if (isset($_POST['DLnumber']) || isset($_POST['expirationDate'])) {
            if (!empty($DLnumber) || !empty($expirationDate)) {
                $update_Licese_Query = "UPDATE driving_licese_info SET driving_licese_no = '$DLnumber', expiration_date = '$expirationDate', status = 'pending' WHERE driverId = '$id'";
                $update_Licese = mysqli_query($con, $update_Licese_Query);

                if ($update_Licese) {
                    $response['status'] = '200';
                    $response['message'] = "Driving licese information updated";
                }
            }
        }
        if (isset($_FILES['frontDL']) && !empty($_FILES['frontDL']['tmp_name'])) {
            $frontDL = $_FILES['frontDL'];

            $frontDL_tmpName = $_FILES['frontDL']['tmp_name'];
            $frontname = rand(111111111, 999999999) . ".jpg";
            $frontDL_folder = "uploaded/DrivingLicese/";
            $frontDLpath = $frontDL_folder . $frontname;

            $update_image_query = "UPDATE driving_licese_info SET front_photo_DL = '$frontDLpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($frontDL_tmpName, $frontDLpath)) {
                    $response['status'] = "200";
                    $response['message'] = "Driving licese Image updated";
                }
            }
        }
        if (isset($_FILES['backDL']) && !empty($_FILES['backDL']['tmp_name'])) {
            $backDL = $_FILES['backDL'];

            $backDL_tmpName = $_FILES['backDL']['tmp_name'];
            $backname = rand(111111111, 999999999) . ".jpg";
            $backDL_folder = "uploaded/DrivingLicese/";
            $backDLpath = $backDL_folder . $backname;

            $update_image_query = "UPDATE driving_licese_info SET back_photo_DL = '$backDLpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($backDL_tmpName, $backDLpath)) {
                    $response['status'] = "200";
                    $response['message'] = "Driving licese Image updated";
                }
            }
        }
        if (isset($_FILES['selfiwithDL']) && !empty($_FILES['selfiwithDL']['tmp_name'])) {
            $selfiDL = $_FILES['selfiwithDL'];

            $selfiwithDL_tmpName = $_FILES['selfiwithDL']['tmp_name'];
            $selfiname = rand(111111111, 999999999) . ".jpg";
            $selfiwithDL_folder = "uploaded/DrivingLicese/";
            $selfiDLpath = $selfiwithDL_folder . $selfiname;

            $update_image_query = "UPDATE driving_licese_info SET selfi_with_DL = '$selfiDLpath' WHERE driverId = '$id'";
            $update_image = mysqli_query($con, $update_image_query);

            if ($update_image) {
                if (move_uploaded_file($selfiwithDL_tmpName, $selfiDLpath)) {
                    $response['status'] = "200";
                    $response['message'] = "Driving licese Image updated";
                }
            }
        }
    } else {
        if ((isset($_FILES['frontDL']) && !empty($_FILES['frontDL']['tmp_name'])) && (isset($_FILES['backDL']) && !empty($_FILES['backDL']['tmp_name'])) && (isset($_FILES['selfiwithDL']) && !empty($_FILES['selfiwithDL']['tmp_name']))) {
            $frontDL = $_FILES['frontDL'];
            $backDL = $_FILES['backDL'];
            $selfiwithDL = $_FILES['selfiwithDL'];
            if (!empty($frontDL) && !empty($backDL) && !empty($selfiwithDL)) {
                $frontDL_tmpName = $_FILES['frontDL']['tmp_name'];
                $frontname = rand(111111111, 999999999) . ".jpg";
                $DL_folder = "uploaded/DrivingLicese/";
                $frontpath = $DL_folder . $frontname;

                $backDL_tmpName = $_FILES['backDL']['tmp_name'];
                $backname = rand(111111111, 999999999) . ".jpg";
                $backpath = $DL_folder . $backname;

                $selfiwithDL_tmpName = $_FILES['selfiwithDL']['tmp_name'];
                $selfiname = rand(111111111, 999999999) . ".jpg";
                $selfipath = $DL_folder . $selfiname;

                if (!file_exists($DL_folder)) {
                    mkdir($DL_folder, 0755, true);
                }

                $insert_query = "INSERT INTO driving_licese_info(driverId,driving_licese_no,expiration_date,front_photo_DL,back_photo_DL,selfi_with_DL)VALUES('$id','$DLnumber','$expirationDate','$frontpath','$backpath','$selfipath')";
                $insert = mysqli_query($con, $insert_query);
                if ($insert) {
                    move_uploaded_file($frontDL_tmpName, $frontpath);
                    move_uploaded_file($backDL_tmpName, $backpath);
                    move_uploaded_file($selfiwithDL_tmpName, $selfipath);
                    $response['status'] = "200";
                    $response['message'] = "record inserted";
                }
            }
        } else {
            $response['status'] = "400";
            $response['message'] = "ERROR:" . mysqli_error($con);
        }
    }
} else {
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}

echo json_encode($response);

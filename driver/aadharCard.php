<?php

require '../db.php';
header("content-type:application/json");

if (isset($_POST['driverId'])) {
    $id = $_POST['driverId'];
    $adhaarno = $_POST['adhaarno'];

    $check_user_query = "SELECT * FROM adhaarcard WHERE driverId = '$id'";
    $check_user = mysqli_query($con, $check_user_query);

    if (mysqli_num_rows($check_user) > 0) {
        $update_status = mysqli_query($con,"UPDATE adhaarcard SET status = 'pending' WHERE driverId = '$id'");
        if (!empty($adhaarno)) {
            $update_addhar_query = "UPDATE adhaarcard SET adhaar_no = '$adhaarno', status = 'pending' WHERE driverId = '$id'";
            $update_addhar = mysqli_query($con, $update_addhar_query);
            if ($update_addhar) {
                $response['status'] = "200";
                $response['message'] = "record adhhar number updated";
            }
        }
        if (isset($_FILES['frontadhaar']) && !empty($_FILES['frontadhaar']['tmp_name'])) {
            $front = $_FILES['frontadhaar'];
            if (!empty($front)) {
                $front_tmp = $_FILES['frontadhaar']['tmp_name'];
                $profileNewPart = explode('.', $front['name']);
                $extension = end($profileNewPart);
                $frontname = rand(111111111, 999999999) . "." . $extension;
                $front_folder = 'uploaded/AdhaarCard/';
                $frontpath = $front_folder . $frontname;

                $update_image_query = "UPDATE adhaarcard SET front_photo_adhaar = '$frontpath' WHERE driverId = '$id'";
                $update_image = mysqli_query($con, $update_image_query);

                if ($update_image_query) {
                    move_uploaded_file($front_tmp, $frontpath);
                    $response['status'] = "200";
                    $response['message'] = "record updateded";
                }
            }
        }
        if (isset($_FILES['backadhaar']) && !empty($_FILES['backadhaar']['tmp_name'])) {
            $back = $_FILES['backadhaar'];
            if (!empty($back)) {
                $back_tmp = $_FILES['backadhaar']['tmp_name'];
                $profileNewPart = explode('.', $back['name']);
                $extension = end($profileNewPart);
                $backname = rand(111111111, 999999999) . "." . $extension;
                $back_folder = 'uploaded/AdhaarCard/';
                $backpath = $back_folder . $backname;

                $update_image_query = "UPDATE adhaarcard SET back_photo_adhaar = '$backpath' WHERE driverId = '$id'";
                $update_image = mysqli_query($con, $update_image_query);

                if ($update_image_query) {
                    move_uploaded_file($back_tmp, $backpath);
                    $response['status'] = "200";
                    $response['message'] = "record updateded";
                }
            }
        }
        if (isset($_FILES['selfiwithadhaar']) && !empty($_FILES['selfiwithadhaar']['tmp_name'])) {
            $selfi = $_FILES['selfiwithadhaar'];
            if (!empty($selfi)) {
                $selfi_tmp = $_FILES['selfiwithadhaar']['tmp_name'];
                $profileNewPart = explode('.', $selfi['name']);
                $extension = end($profileNewPart);
                $selfiname = rand(111111111, 999999999) . "." . $extension;
                $selfi_folder = 'uploaded/AdhaarCard/';
                $selfipath = $selfi_folder . $selfiname;

                $update_image_query = "UPDATE adhaarcard SET selfi_with_adhaar = '$selfipath' WHERE driverId = '$id'";
                $update_image = mysqli_query($con, $update_image_query);

                if ($update_image_query) {
                    move_uploaded_file($selfi_tmp, $selfipath);
                    $response['status'] = "200";
                    $response['message'] = "record updateded";
                }
            }
        }
    } else {
        if ((isset($_FILES['frontadhaar']) && !empty($_FILES['frontadhaar']['tmp_name'])) && (isset($_FILES['backadhaar']) && !empty($_FILES['backadhaar'])) && (isset($_FILES['selfiwithadhaar']) && !empty($_FILES['selfiwithadhaar']['tmp_name']))) {
            $front = $_FILES['frontadhaar'];
            $back = $_FILES['backadhaar'];
            $selfi = $_FILES['selfiwithadhaar'];
            if (!empty($front) && !empty($back) && !empty($selfi)) {
              $front_tmp = $_FILES['frontadhaar']['tmp_name'];
                $front_New_Part = explode('.', $front['name']);
                $front_extension = end($front_New_Part);
                $frontname = rand(111111111, 999999999) . "." . $front_extension;
                $front_folder = 'uploaded/AdhaarCard/';
                $frontpath = $front_folder . $frontname;

                $back_tmp = $_FILES['backadhaar']['tmp_name'];
                $back_new_part = explode('.',$back['name']);
                $back_extension = end($back_new_part);
                $backname = rand(111111111, 999999999) . "." . $back_extension;
                $back_folder = 'uploaded/AdhaarCard/';
                $backpath = $back_folder . $backname;

                $selfi_tmp = $_FILES['selfiwithadhaar']['tmp_name'];
                $selfi_new_part = explode('.',$selfi['name']);
                $selfi_extension = end($selfi_new_part);
                $selfiname = rand(111111111, 999999999) . "." . $selfi_extension;
                $selfi_folder = 'uploaded/AdhaarCard/';
                $selfipath = $selfi_folder . $selfiname;

                $insert_query = "INSERT INTO adhaarcard(driverId,adhaar_no,front_photo_adhaar,back_photo_adhaar,selfi_with_adhaar)VALUES('$id','$adhaarno','$frontpath','$backpath','$selfipath')";
                $insert = mysqli_query($con, $insert_query);
                if ($insert) {
                    move_uploaded_file($front_tmp, $frontpath);
                    move_uploaded_file($back_tmp, $backpath);
                    move_uploaded_file($selfi_tmp, $selfipath);
                    $response['status'] = "200";
                    $response['message'] = "record inserted";
                }
            }
        }
    }
} else {
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);

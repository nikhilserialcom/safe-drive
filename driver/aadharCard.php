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

if(isset($_POST['driverId']))
{
    $id = $_POST['driverId'];
    $adhaarno = $_POST['adhaarno'];
    // if(isset($_POST['driverLetitude']) && isset($_POST['driverLongitude']))
    // {
    //     $driverLetitude = $_POST['driverLetitude'];
    //     $driverLogitude = $_POST['driverLongitude'];
    //     if(!empty($driverLetitude) && !empty($driverLogitude))
    //     {
    //         updateDriverLocation($driverLetitude,$driverLogitude,$userId);
    //     }
    // }

    $check_user_query = "SELECT * FROM adhaarcard WHERE driverId = '$id'";
    $check_user = mysqli_query($con,$check_user_query);

    if (mysqli_num_rows($check_user) > 0) {

        if(!empty($adhaarno))
        {
            $update_addhar_query = "UPDATE adhaarcard SET adhaar_no = '$adhaarno' WHERE driverId = '$id'";
            $update_addhar = mysqli_query($con,$update_addhar_query);
            if ($update_addhar) {
                $response['status'] = "200";
                $response['message'] = "record adhhar number updated";    
            }
        }
        if(isset($_FILES['frontadhaar']))
        {
            $front = $_FILES['frontaddhar'];
            if(!empty($front))
            {
                $front_tmp = $_FILES['frontaddhar']['tmp_name'];
                $frontname = rand(111111111,999999999)."jpg";
                $front_folder = 'uploaded/AdhaarCard/';
                $frontpath = $front_folder.$frontname;

                $update_image_query = "UPDATE adhaarcard SET front_photo_adhaar = '$frontpath' WHERE driverId = '$id'";
            }
        }
    }
    else
    { 
        if((isset($_FILES['frontadhaar']) && !empty($_FILES['frontadhaar']['tmp_name'])) && (isset($_FILES['backadhaar']) && !empty($_FILES['backadhaar'])) && (isset($_FILES['selfiwithadhaar']) && !empty($_FILES['selfiwithadhaar']['tmp_name'])))
        {
            $front = $_FILES['frontadhaar'];
            $back = $_FILES['backadhaar'];
            $selfi = $_FILES['selfiwithadhaar'];
            if(!empty($front) && !empty($back) && !empty($selfi))
            {
                $front_tmp = $_FILES['frontadhaar']['tmp_name'];
                $frontname = rand(111111111,999999999).".jpg";
                $front_folder = 'uploaded/AdhaarCard/';
                $frontpath = $front_folder.$frontname;
            
                $back_tmp = $_FILES['backadhaar']['tmp_name'];
                $backname =rand(111111111,999999999).".jpg";
                $back_folder = 'uploaded/AdhaarCard/';
                $backpath = $back_folder.$backname;

                $selfi_tmp = $_FILES['selfiwithadhaar']['tmp_name'];
                $selfiname = rand(111111111,999999999).".jpg";
                $selfi_folder = 'uploaded/AdhaarCard/';
                $selfipath = $selfi_folder.$selfiname;

                $insert_query = "INSERT INTO adhaarcard(driverId,adhaar_no,front_photo_adhaar,back_photo_adhaar,selfi_with_adhaar)VALUES('$id','$adhaarno','$frontpath','$backpath','$selfipath')";
                $insert = mysqli_query($con,$insert_query);
                if ($insert) {
                    move_uploaded_file($front_tmp,$frontpath);
                    move_uploaded_file($back_tmp,$backpath);
                    move_uploaded_file($selfi_tmp,$selfipath);
                    $response['status'] = "200";
                    $response['message'] = "record inserted";    
                }
            }
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
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
    $check_user = mysqli_query($con,$check_user_query);

    if (mysqli_num_rows($check_user) > 0) {
        if((isset($_FILES['frontDL']) && !empty( $_FILES['frontDL']['tmp_name'])) && (isset($_FILES['backDL']) && !empty($_FILES['backDL']['tmp_name'])) && (isset($_FILES['selfiwithDL']) && !empty($_FILES['selfiwithDL']['tmp_name'])))
        {
            $frontDL = $_FILES['frontDL'];
            $backDL = $_FILES['backDL'];
            $selfiwithDL = $_FILES['selfiwithDL'];
            if(!empty($frontDL) && !empty($backDL) && !empty($selfiwithDL))
            {
                $frontDL_tmpName = $_FILES['frontDL']['tmp_name'];
                $frontname = rand(111111111,999999999).".jpg";
                $frontDL_folder = "uploaded/DrivingLicese/";
                $frontpath = $frontDL_folder.$frontname;

                $backDL_tmpName = $_FILES['backDL']['tmp_name'];
                $backname = rand(111111111,999999999).".jpg";
                $backDL_folder = "uploaded/DrivingLicese/";
                $backpath = $backDL_folder.$backname;

                $selfiwithDL_tmpName = $_FILES['selfiwithDL']['tmp_name'];
                $selfiname = rand(111111111,999999999).".jpg";
                $selfiwithDL_folder = "uploaded/DrivingLicese/";
                $selfipath = $selfiwithDL_folder.$selfiname;

                $update_query = "UPDATE driving_licese_info SET driving_licese_no = '$DLnumber', expiration_date = '$expirationDate', front_photo_DL = '$frontDL', back_photo_DL = '$backDL', selfi_with_DL = '$selfiwithDL' WHERE driverId = '$id'";
                $update = mysqli_query($con,$update_query);
                if ($update) {
                    move_uploaded_file($frontDL_tmpName,$frontpath);
                    move_uploaded_file($backDL_tmpName,$backpath);
                    move_uploaded_file($selfiwithDL_tmpName,$selfipath);
                    $response['status'] = "200";
                    $response['message'] = "record inserted";    
                }
            }   
        }

    }
    else
    {
        if((isset($_FILES['frontDL']) && !empty( $_FILES['frontDL']['tmp_name'])) && (isset($_FILES['backDL']) && !empty($_FILES['backDL']['tmp_name'])) && (isset($_FILES['selfiwithDL']) && !empty($_FILES['selfiwithDL']['tmp_name'])))
        {
            $frontDL = $_FILES['frontDL'];
            $backDL = $_FILES['backDL'];
            $selfiwithDL = $_FILES['selfiwithDL'];
            if(!empty($frontDL) && !empty($backDL) && !empty($selfiwithDL))
            {
                $frontDL_tmpName = $_FILES['frontDL']['tmp_name'];
                $frontname = rand(111111111,999999999).".jpg";
                $frontDL_folder = "uploaded/DrivingLicese/";
                $frontpath = $frontDL_folder.$frontname;

                $backDL_tmpName = $_FILES['backDL']['tmp_name'];
                $backname = rand(111111111,999999999).".jpg";
                $backDL_folder = "uploaded/DrivingLicese/";
                $backpath = $backDL_folder.$backname;

                $selfiwithDL_tmpName = $_FILES['selfiwithDL']['tmp_name'];
                $selfiname = rand(111111111,999999999).".jpg";
                $selfiwithDL_folder = "uploaded/DrivingLicese/";
                $selfipath = $selfiwithDL_folder.$selfiname;

                $insert_query = "INSERT INTO driving_licese_info(driverId,driving_licese_no,expiration_date,front_photo_DL,back_photo_DL,selfi_with_DL)VALUES('$id','$DLnumber','$expirationDate','$frontpath','$backpath','$selfipath')";
                $insert = mysqli_query($con,$insert_query);
                if ($insert) {
                    move_uploaded_file($frontDL_tmpName,$frontpath);
                    move_uploaded_file($backDL_tmpName,$backpath);
                    move_uploaded_file($selfiwithDL_tmpName,$selfipath);
                    $response['status'] = "200";
                    $response['message'] = "record inserted";    
                }
            }   
        }
        else
        {
            $response['status'] = "400";
            $response['message'] = "ERROR:". mysqli_error($con);
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
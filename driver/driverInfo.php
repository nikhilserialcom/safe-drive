<?php
require '../db.php';

header("content-type:application/json");

$response = array();

// function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
// {   
//     global $response,$con;

//     $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE id = '$driverId'");

//     if($updateLocation)
//     {
//         $response['status'] = "true";
//         $response['message'] = "update location";
//     }

// }


if(isset($_POST['driverId']))
{
    $userId = $_POST['driverId'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    // if(isset($_POST['driverLetitude']) && isset($_POST['driverLongitude']))
    // {
    //    $driverLetitude = $_POST['driverLetitude'];
    //    $driverLogitude = $_POST['driverLongitude'];
    //    if(!empty($driverLetitude) && !empty($driverLogitude))
    //    {
    //        updateDriverLocation($driverLetitude,$driverLogitude,$userId);
    //    }
    // }

    $check_user_query = "SELECT * FROM user WHERE driverId = '$userId'";
    $check_user = mysqli_query($con,$check_user_query);

    if (mysqli_num_rows($check_user) > 0) 
    {
            if(!empty($firstname) || !empty($lastname) || !empty($dob) || !empty($email))
            {
                    $update_query = "UPDATE user SET firstname = '$firstname',lastname = '$lastname',dob = '$dob',email = '$email',user_status = '1' WHERE driverId='$userId'";
                    $update = mysqli_query($con,$update_query);
                    if ($update) 
                    {
                        $response['status'] = "200";
                        $response['message'] = "record inserted";    
                    }
                    
            }  
            if(isset($_FILES['profile']) && !empty($_FILES['profile']['tmp_name']))
            {
                $image = $_FILES['profile'];
                if(!empty($image))
                {
                    $image_tmp_name = $_FILES['profile']['tmp_name'];
                    $file = rand(111111111,999999999).".jpg";
                    $image_folder = "../profile/";
                    $filepath = "profile/".$file;
                    if (!file_exists($image_folder)) {
                        mkdir($image_folder, 0755, true);
                    }
                    
                        $image_query = "UPDATE user SET photo = '$filepath' WHERE driverId = '$userId'";
                        $updateImage = mysqli_query($con,$image_query); 
                        if($updateImage>0)
                        {
                            move_uploaded_file($image_tmp_name,$filepath);
                            $response['status'] = "200";
                        }       
                }
            }   
    }
    else
    {
        
        $response['status'] = "404";
        $response['message'] = "database empty";
    }
}
else
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}
echo json_encode($response);
?>
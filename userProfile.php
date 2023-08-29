<?php
require 'db.php';

header("content-type:application/json");

$response = array();

function updateDriverLocation($driverLetitude,$driverLogitude,$driverId)
{   
    global $response,$con;

    $updateLocation = mysqli_query($con,"UPDATE user SET driverLetitude = '$driverLetitude',driverLongitude = '$driverLogitude' WHERE id = '$driverId'");

    if($updateLocation)
    {
        $response['status'] = "true";
        $response['message'] = "update location";
    }

}

if (isset($_POST['userId'])) 
{
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $checkUserQuery = "SELECT * FROM user WHERE id = '$userId'";
    $checkUser = mysqli_query($con,$checkUserQuery);

     if(isset($_POST['driverLetitude']) && isset($_POST['driverLongitude']))
     {
        $driverLetitude = $_POST['driverLetitude'];
        $driverLogitude = $_POST['driverLongitude'];
        if(!empty($driverLetitude) && !empty($driverLogitude))
        {
            updateDriverLocation($driverLetitude,$driverLogitude,$userId);
        }
     }

    if (mysqli_num_rows($checkUser) > 0) 
    {
        if (!empty($firstName) || !empty($lastName) || !empty($city) || !empty($email)) 
        {
            $updateProfileQuery = "UPDATE user SET firstname = '$firstName',lastname = '$lastName', city = '$city' ,email = '$email' WHERE id = '$userId'";
            $updateProfile = mysqli_query($con,$updateProfileQuery);
            if($updateProfile > 0)
            {
                $response['status'] = "200";
                $response['message'] = "profile update successfully!";
            } 
            else
            {
                $response['error']="400";
                $response['message']="error". mysqli_error($con);
            }  
        }

        if(isset($_FILES['profile']))
        {
            $photo = $_FILES['profile'];
            if(!empty($photo))
            {
                $profileTmpName = $_FILES['profile']['tmp_name'];
                $fileName = rand(111111111,999999999) . ".jpg";
                $filedir = "profile/";
                $filePath = $filedir.$fileName;

                $profileQuery = "UPDATE user SET photo = '$filePath' WHERE id = '$userId'";
                $profile = mysqli_query($con,$profileQuery);
                if($profile > 0)
                {
                    move_uploaded_file($profileTmpName,$filePath);
                    $response['status'] = "200";
                    $response['message'] = "profile image update successfully";
                }
                else
                {
                    $response['error']="400";
                    $response['message']="error". mysqli_error($con);
                }
            }
        }
        
    } 
    else 
    {
        $response['status'] = "404";
        $response['message'] = "User not found";
    }
       
} 
else 
{
    $response['status'] = "500";
    $response['message'] = "ERROR:";
}


echo json_encode($response);
?>
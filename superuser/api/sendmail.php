<?php

require('db.php');
require_once 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'),true);

function sendforgotpassword($email,$token)
{
    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
    ->setUsername('1nikhil.serialcominfotech@gmail.com')
    ->setPassword('yltd eqfs jkld dynd')
    ;

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);
    
    $resetLink = "http://192.168.1.17/safe-drive/superuser/resetpassword.php?token=$token";
    $emailTemplate = " <html>
        <body>
            <p>Click the following link to reset your password:</p>
            <a href=\"$resetLink\">Reset Password</a>
        </body>
        </html>";
    // Create a message
    $message = (new Swift_Message('Wonderful Subject'))
    ->setFrom(['1nikhil.serialcominfotech@gmail.com' => 'Nikhil Patel'])
    ->setTo($email)
    ->setBody($emailTemplate,'text/html');

    // Send the message
    $result = $mailer->send($message);
    
    return $result ? "true" : "false";
}

$userEmail = isset($data['user_email']) ? $data['user_email'] : '';
$token = md5($userEmail . time());

$checkEmailQuery = "SELECT * FROM superuser WHERE s_email = '$userEmail'";
$checkEmail = mysqli_query($con,$checkEmailQuery);

if(mysqli_num_rows($checkEmail) > 0){
    $result = sendforgotpassword($userEmail,$token);
    $updateToken = mysqli_query($con,"UPDATE superuser SET reset_token = '$token' WHERE s_email = '$userEmail'");
    $response = array(
        'status_code' => 200,
        'message' =>  $result
    );
}
else{
    $response = array(
        'status_code' => 404,
        'message' => 'email is not exist'
    );
}

    echo json_encode($response,JSON_PRETTY_PRINT); 
?>
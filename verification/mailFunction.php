<?php
header("content-type:application/json");

require_once 'vendor/autoload.php';

// Import the necessary classes from SwiftMailer
use Swift_SmtpTransport as SmtpTransport;
use Swift_Message as smtpMessage;
use Swift_Mailer as smtpMailer;

function sendmail($username, $email,$verifyToken)
{
    $date = date("Y");
    // Configure the SMTP transport
    $transport = (new SmtpTransport('smtp.gmail.com', 465, 'ssl'))
        ->setUsername('1nikhil.serialcominfotech@gmail.com')
        ->setPassword('ykdsftjhcgcmczla');
    
           // Disable SSL verification
    $transport->setStreamOptions([
        'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    // Create the Mailer using the configured transport
    $mailer = new smtpMailer($transport);
    $emailTmplate = '<!DOCTYPE html>
                        <html>
                        <head>
                        <title>Email Verification</title>
                        <style>
                        body{margin: 0;padding: 0;font-family: Arial, sans-serif}.container{max-width: 600px;margin: 0 auto;padding: 20px;background-color: #f7f7f7}.header{background-color: #333;color: #fff;padding: 10px;text-align: center;font-family: "Righteous", cursive}.safe-driver{font-size: 24px;font-weight: 700;text-transform: capitalize;margin: 10px;font-family: "Righteous", cursive;text-align: center}.safe-driver span{color:#c0392b}.footer{background-color: #333;color: #fff;padding: 10px;text-align: center;font-size: 10px}.footer a{color: #fff;margin-right: 10px}h1{margin-bottom: 20px;text-align: center}p{color: #666;line-height: 1.5;margin-bottom: 20px;text-align: center}.button-container{text-align: center;margin-bottom: 20px}.button-container .button{display: inline-block;padding: 10px 20px;background-color: #EF5052;color: #fff;text-decoration: none;border-radius: 4px}.footer p{margin: 10px 0px;color: #fff}
                        </style>
                        </head>
                        <body>
                        <div class="container">
                            <div class="header">
                            <h1>Email Verification</h1>  
                            </div>
                            <div class="safe-driver">Safe <span>Driver</span></div>
                            <p>Dear '. $username .',</p>
                            <p>Thank you for signing up. Please click the button below to verify your email address:</p>
                            <div class="button-container">
                            <a href="http://192.168.0.169/safe-drive/verification/verifyEmail.php?token='.$verifyToken.'" class="button" style="color:#fff">Verify Email</a>
                            </div>
                            <p>If you did not sign up for an account, you can safely ignore this email.</p>
                            <div class="footer">
                            <p>&copy; '. $date .' Safe Drive Application. All rights reserved.</p>
                            </div>
                        </div>
                        </body>
                        </html>
                        ';

    // Create a message
    $message = (new smtpMessage('Email verification from safe-drive'))
        ->setFrom(['1nikhil.serialcominfotech@gmail.com' => 'Safe-drive'])
        ->setTo([$email => $username])
        ->setBody($emailTmplate,'text/html');

    // Send the message
    $mailer->send($message);  
}

?>
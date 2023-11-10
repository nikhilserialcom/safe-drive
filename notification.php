<?php

header("content-type:application/json");

$serverKey = 'AAAAzpUqMlE:APA91bEXySQ-4aw7rQB6Sloy2WLgyAr4XIEToPk5xo98u-wDOICMTC1ExzysY0SYBBio24gHaFgQlPh0BV3RIL-Ls34Y-d-_v205s79Bxj6MZ-tH2WI7_mlp6jGXtsxB5gNmloxmIIgQ'; // Replace with your Firebase Server Key
$data = [
    'to' => $_POST['fCMToken'], // The recipient's FCM token
    'notification' => [
        'title' => 'Safe Drive',
        'body' => $_POST['message'],
        // 'sound' => '21.mp3',
        'image' => 'profile/31Cd9UQp6eL._AC_UF1000,1000_QL80_.jpg',
    ],
];
$headers = [
    'Authorization: key=' . $serverKey,
    'Content-Type: application/json',
];
$ch = curl_init('https://fcm.googleapis.com/fcm/send');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Not recommended for production
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
if ($response === false) {
    die('Error: ' . curl_error($ch));
}
curl_close($ch);

echo json_encode($response);

?>
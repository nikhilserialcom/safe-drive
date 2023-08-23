<?php
// Step 1: Require the Faker Library Autoloader
require_once 'vendor/autoload.php';

// Step 2: Connect to the Database
$host = "localhost";
$username = "root";
$password = "";
$database = "safe-drive";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 3: Use Faker to Generate and Insert Dummy Data
$faker = Faker\Factory::create();

for ($i = 1; $i <= 50; $i++) {
    $phoneNumber   = $faker->phoneNumber  ;
    $email = $faker->email;
    $firstname = $faker->firstName;
    $lastname = $faker->lastName;
    $verification_code = rand(1111,9999);                                 ;
    $sql = "INSERT INTO user (firstname,lastname,email,mobile_number,verification_code) VALUES ('$firstname','$lastname', '$email', '$phoneNumber','$verification_code')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

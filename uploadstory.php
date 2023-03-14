<?php

session_start();    //create or retrieve session
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle picture upload
$picture = $_FILES['picture'];
$pictureName = $picture['name'];
$pictureTempName = $picture['tmp_name'];
$pictureError = $picture['error'];
if($pictureError === 0) {
    $pictureData = file_get_contents($pictureTempName); // Convert file data to binary
} else {
    $pictureData = null;
}

// Handle video upload
$video = $_FILES['video'];
$videoName = $video['name'];
$videoTempName = $video['tmp_name'];
$videoError = $video['error'];
if($videoError === 0) {
    $videoData = file_get_contents($videoTempName); // Convert file data to binary
} else {
    $videoData = null;
}

// Save the user input and uploaded file paths to database
// Connect to the database
include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO stories (name, email, title, story, location, picture_data, video_data) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Bind the variables to the statement
$stmt->bind_param("ssssssb", $name, $email, $title, $story, $location, $pictureData, $videoData);

// Execute the statement
if($stmt->execute() === false) {
    echo "Error: " . $stmt->error;
}

// Close the statement and the connection
$stmt->close();
$conn->close();

// Redirect the user to a confirmation page
header('Location: submittedstories.php');
exit();


// if(isset($_POST['submit'])) {
//     // Get the user input values
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $title = $_POST['title'];
//     $story = $_POST['story'];
//     $location = $_POST['location'];

//     // Handle picture upload
//     $picture = $_FILES['picture'];
//     $pictureName = $picture['name'];
//     $pictureTempName = $picture['tmp_name'];
//     $pictureError = $picture['error'];
//     if($pictureError === 0) {
//         $pictureData = file_get_contents($pictureTempName); // Convert file data to binary
//     }

//     // Handle video upload
//     $video = $_FILES['video'];
//     $videoName = $video['name'];
//     $videoTempName = $video['tmp_name'];
//     $videoError = $video['error'];
//     if($videoError === 0) {
//         $videoData = file_get_contents($videoTempName); // Convert file data to binary
//     }

//     // Save the user input and uploaded file paths to database
//     // Connect to the database
//     include_once("connection.php");
//     // Create connection
//     $conn = new mysqli($servername, $username, $password, $dbname);

    

//     // Prepare the SQL statement
//     $stmt = $conn->prepare("INSERT INTO stories (name, email, title, story, location, picture_data, video_data) VALUES (?, ?, ?, ?, ?, ?, ?)");

//     // Bind the variables to the statement
//     $stmt->bind_param("ssssssb", $name, $email, $title, $story, $location, $pictureData, $videoData);

//     // Execute the statement
//     $stmt->execute();

//     // if ($stmt === false) {
//     //     echo $conn->error;
//     //     exit;
//     //  }

//     // Close the statement and the connection
//     $stmt->close();
//     $conn->close();

//     // Redirect the user to a confirmation page
//     header('Location: submittedstories.php');
//     exit();
// }
?>

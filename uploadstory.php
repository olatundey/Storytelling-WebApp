<?php
session_start();    //create or retrieve session
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

if(isset($_POST['submit'])) {
    // Get the user input values
    $source_name = $_POST['source_name'];
    $story_title = $_POST['story_title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $storycategory = $_POST['storycategory'];

    // Handle picture upload
    $picture = $_FILES['picture'];
    $pictureName = $picture['name'];
    $pictureTempName = $picture['tmp_name'];
    $pictureError = $picture['error'];
    if($pictureError === 0) {
        $pictureDestination = 'uploads/pictures/' . $pictureName;
        move_uploaded_file($pictureTempName, $pictureDestination);
    }

    // Handle video upload
    $video = $_FILES['video'];
    $videoName = $video['name'];
    $videoTempName = $video['tmp_name'];
    $videoError = $video['error'];
    if($videoError === 0) {
        $videoDestination = 'uploads/video/' . $videoName;
        move_uploaded_file($videoTempName, $videoDestination);
    }

        // Handle audio upload
        $audio = $_FILES['audio'];
        $audioName = $audio['name'];
        $audioTempName = $audio['tmp_name'];
        $audioError = $audio['error'];
        if($audioError === 0) {
            $audioDestination = 'uploads/audio/' . $audioName;
            move_uploaded_file($audioTempName, $audioDestination);
        }

    // Save the user input and uploaded file paths to database
    // Connect to the database
    include_once("connection.php");
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO stories (source_name, story_title, description, location, latitude, longitude, picture_data, video_data, audio_data, username_st,category) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
// Below properly format user input for insert and indicate the data types of the variables being bound to the placeholders
$stmt->bind_param("ssssddsssss", $source_name, $story_title, $description, $location, $latitude, $longitude, $pictureDestination, $videoDestination, $audioDestination, $user, $storycategory);

// Execute the statement
$stmt->execute();

// Close the connection
// $conn->close();

    // Redirect the user to a confirmation page
    header('Location: submittedstories.php');
    exit();

}
?>


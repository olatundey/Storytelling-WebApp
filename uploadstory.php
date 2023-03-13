<?php
session_start();    //create or retrieve session
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['submit'])) {
    // Get the user input values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $story = $_POST['story'];
    $location = $_POST['location'];

    // Handle picture upload
    $picture = $_FILES['picture'];
    $pictureName = $picture['name'];
    $pictureTempName = $picture['tmp_name'];
    $pictureError = $picture['error'];
    if($pictureError === 0) {
        $pictureDestination = 'uploads/pictures/' . $pictureName;
        move_uploaded_file($pictureTempName, $pictureDestination);
    }

    // Get the uploaded file data
// $imageData = file_get_contents($_FILES['picture']['tmp_name']);
// $imageName = $_FILES['picture']['name'];

// // Encode the image data to base64
// $imageDataEncoded = base64_encode($imageData);

    // Handle video upload
    $video = $_FILES['video'];
    $videoName = $video['name'];
    $videoTempName = $video['tmp_name'];
    $videoError = $video['error'];
    if($videoError === 0) {
        $videoDestination = 'uploads/videos/' . $videoName;
        move_uploaded_file($videoTempName, $videoDestination);
    }

    // Save the user input and uploaded file paths to database
    // Connect to the database
    include_once("connection.php");
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO stories (name, email,title, story, location, picture_path, video_path) VALUES (?,?,?,?,?,?,?)");
// Below properly format user input for insert and indicate the data types of the variables being bound to the placeholders
$stmt->bind_param("sssssss", $name, $email, $story, $title, $location, $pictureDestination, $videoDestination);

// Execute the statement
$stmt->execute();

// Close the connection
// $conn->close();

    // Redirect the user to a confirmation page
    header('Location: submittedstories.php');
    exit();
}
?>

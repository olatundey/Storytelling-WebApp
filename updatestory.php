<?php
// Connect to database
include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


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


// Update story data in database
$stmt = $conn->prepare("UPDATE stories SET name = ?, email = ?, title = ?, story = ?, location = ?, picture_data = ?, video_data = ? WHERE id = ?");
$stmt->bind_param("ssssssb", $_POST['name'], $_POST['email'], $_POST['title'], $_POST['story'], $_POST['location'], $pictureData, $videoData, $_POST['id']);
$stmt->execute();


// Redirect user to confirmation page
header("Location: submittedstories.php");
exit();
?>

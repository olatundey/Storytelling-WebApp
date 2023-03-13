<?php
// Connect to database
include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Update story data in database
$stmt = $conn->prepare("UPDATE stories SET name = ?, email = ?, title = ?, story = ?, location = ?, picture_path = ?, video_path = ? WHERE id = ?");
$stmt->bind_param("ssssssi", $_POST['name'], $_POST['email'], $_POST['title'], $_POST['story'], $_POST['location'], $pictureDestination, $videoDestination, $_POST['id']);
$stmt->execute();

// Redirect user to confirmation page
header("Location: submittedstories.php");
exit();
?>

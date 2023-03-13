<?php
session_start();    //create or retrieve session

error_reporting(E_ALL);
ini_set('display_errors', 1);
$user = ($_SESSION['user']); //get user name into the variable $user
$userType = ($_SESSION['userType']); //get usertype into the variable $usertype

include_once("connection.php");
$conn = new mysqli($servername, $username, $password, $dbname);

// Get the story ID and rating from the form submission
// Retrieve rating data from form submission
$story_id = $_POST['story_id'];
$rating = $_POST['rating'];

// Insert rating into database
$stmt = $conn->prepare("INSERT INTO ratings (story_id, username, rating) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $story_id, $user, $rating);
$stmt->execute();

// Redirect back to view story page
header("Location: viewstory.php?id=$story_id");
echo "success";
exit();
?>

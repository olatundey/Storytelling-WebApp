<?php
session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user
$userType = ($_SESSION['userType']); //get usertype into the variable $usertype

// Retrieve story data from database
$stmt = $conn->prepare("SELECT * FROM stories WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$story = $result->fetch_assoc();

// Retrieve ratings for the story
$stmt = $conn->prepare("SELECT AVG(rating) AS avg_rating FROM ratings WHERE story_id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$rating = $result->fetch_assoc();
$avg_rating = $rating['avg_rating'];

<p><strong>Average Rating:</strong> <?php echo number_format($avg_rating, 1); ?></p>


stmt = $conn->prepare("SELECT s.*, AVG(r.rating) AS average_rating FROM stories s LEFT JOIN ratings r ON s.id = r.story_id WHERE s.id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$story = $result->fetch_assoc();

// <p><strong>Rating:</strong> <?php echo round($story['average_rating'], 1); ?>/5</p>


?>
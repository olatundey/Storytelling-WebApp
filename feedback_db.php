<?php
session_start();    //create or retrieve session
if (Isset($_SESSION["user"])) { //user name must in session to stay here
    $user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
    // header("Location: index.html"); //if not, go back to login page
}  

$fullname = $_POST['full_name'];
$email = $_POST['email'];
$sbj = $_POST['subject'];
$msg = $_POST['message'];

// Connect to database
include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "INSERT INTO feedback_user (full_name,email,subject,message) VALUES ('$fullname','$email','$sbj','$msg')";
if (mysqli_query($conn, $sql)) {
  // echo "Registration successful";
  header("Location: feedback.php"); //send user back to Login page
  exit();

} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

    
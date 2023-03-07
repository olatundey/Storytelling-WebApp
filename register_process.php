<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$usertype=$_POST['UserType'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$user = $_POST['user'];
$psw = $_POST['password'];

$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'TouristApp';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// include("connection.php");

$sql = "INSERT INTO AdminUsers (first_name,last_name,phone_number,email,username,password_key,UserType) VALUES ('$first_name','$last_name','$phone','$email','$user','$psw','$usertype')";
if (mysqli_query($conn, $sql)) {
  // echo "Registration successful";
  header("Location: completed.html"); //send user back to Login page
  exit();

} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
//Close the database connection
mysqli_close($conn);
?>





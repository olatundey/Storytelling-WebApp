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

include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "INSERT INTO users (first_name,last_name,phone_number,email,username,password_key,usertype) VALUES ('$first_name','$last_name','$phone','$email','$user','$psw','$usertype')";
if (mysqli_query($conn, $sql)) {
  // echo "Registration successful";
  header("Location: regcompleted.html"); //send user back to Login page
  exit();

} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
//Close the database connection
mysqli_close($conn);
?>





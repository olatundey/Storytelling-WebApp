<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();   //start a session here in case user login successfully
if (!IsSet($_POST))    //if no $_POST array
{
    session_destroy();   //clear session
    header("Location: login.html");   //send user back to login page
    exit();
}
if (!IsSet($_POST["user"]) || !IsSet($_POST["password"]))  // no username or password submitted
{
    session_destroy();   
    header("Location: login.html"); //send user back to Login page
    exit();
}


$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'TouristApp';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);


// include_once("connection.php");

// Retrieve the submitted email and password
$user = $_POST['user'];
$psw = $_POST['password'];
$usercategory = $_POST['UserType'];

// Query the database to retrieve the user's details
$sql = "SELECT * FROM AdminUsers WHERE username = '$user' and password_key = '$psw' and UserType= '$usercategory'";
$result = mysqli_query($conn, $sql);

// If the user is found, compare the submitted password with the password retrieved from the database
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
      // if ($psw == $row['password']) {
  if ($psw == $row['password_key']) {

    if ($psw == $row['password_key'] && $usercategory == $row['UserType']) {
      header('Location: adminuser.php');
        // Redirect to user home page
  } elseif ($psw == $row['password_key'] && $usercategory == "storyteller") {
      header('Location: storytelleruser.php');
  } elseif ($psw == $row['password_key'] && $usercategory == "storyseeker") {
      header('Location: storyseekeruser.php');
    
  }
  $_SESSION['user'] = $user;
  exit();
  } else {
  
    echo "Invalid password";
}
} else {
  echo "Invalid username or password <br>";
  echo "<a href='login.html'>Return to Sign in</a>";
}
//Close the database connection
mysqli_close($conn);
?>

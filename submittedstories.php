<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user
$userType = ($_SESSION['userType']); //get usertype into the variable $usertype


// if(isset($_POST['name'])){
//     $name = $_POST['name'];
//   } else {
//     $name = "";
//   }
  
//   if(isset($_POST['email'])){
//     $email = $_POST['email'];
//   } else {
//     $email = "";
//   }

//   if(isset($_POST['title'])){
//     $title = $_POST['title'];
//   } else {
//     $title = "";
//   }
//   if(isset($_POST['story'])){
//     $story = $_POST['story'];
//   } else {
//     $story = "";
//   }  if(isset($_POST['location'])){
//     $location = $_POST['location'];
//   } else {
//     $location = "";
//   }  if(isset($_POST['picture'])){
//     $pictureDestination  = $_POST['picture'];
//   } else {
//     $pictureDestination = "";
//   }
//   if(isset($_POST['video'])){
//     $videoDestination  = $_POST['video'];
//   } else {
//     $videoDestination  = "";
//   }

  // Connect to database
include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve list of story IDs and title from database
// $result = $conn->query("SELECT id, story_title FROM stories where us ORDER BY id DESC");
  
$sql4 = "SELECT id, story_title, source_name FROM stories where username_st = ?";
$stmt = $conn->prepare($sql4);
$stmt->bind_param("s", $user);
$stmt->execute();
$result4 = $stmt->get_result();
$stmt->close();

if (isset($_POST['update_story'])) {
  $id = $_POST['storyid'];
  $newtitle = $_POST['newtitle'];
  
  // Update the password in the database
  $update_query = "UPDATE stories SET story_title= ? WHERE id = ?";
  $stmt = $conn->prepare($update_query);
  $stmt->bind_param("si", $newtitle, $id);
  $stmt->execute();
  $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 minimum-scale=1, maximum-scale=1">
        <title>Tourview</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3oeQSbb4oNhgeNqTBrdMlqyFSPD9Hg7s"></script>
    </head>

    <body>
        <header class="container">
            <div class="col-md-12">
                <div id="headerContainer" class="row">
                    <div class="col-md-2">
                        <p>Tourview</p>
                    </div>
                
                    <div class="col-md-10">
                    <nav>
                        <ul class="nav justify-content-end">
                        <li><a href = "storytelleruser.php" class="nav-item">My Account</a></li>   
                            <li><a href = "stories.php" class="nav-item">Stories</a></li>
                            <li><a href = "about.php" class="nav-item">About Us</a></li>
                            <li><a href = "logout.php" class="nav-item">Logout</a></li>   
                        </ul>
                    </nav>
                    </div>
                </div>    
            </div>

        </header>
        <hr>
        <main>
        <p>Welcome StoryTeller, <?php print $user; ?>!</p>
	<h1>Thank you for submitting your story!</h1>
	<p>Your story has been successfully uploaded</p>
  <div>
  <p>Submitted Stories:</p>
  <table>
    <tr>
        <th>Story ID</th>
        <th>Story Title</th>
        <th>Source</th>
    </tr>
                <?php while ($row = $result4->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['story_title']; ?></td>
                    <td><?php echo $row['source_name']; ?></td>
    </tr>
    <?php } ?>
</table>

  </div>
  <h6>Change Story Details</h6>
  <form method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
    <br>
    <label for="newtitle">Story Title:</label>
    <input type="text" name="newtitle" id="newtitle" required>
    <br>
    <input type="submit" name="update_story" value="Change Details">
</form>
</div>

        </main>
<footer>
    <hr>
    <div class="container">
        <li><a href = "contactus.php" class="nav-item">Contact Us</a></li>   

    </div>
</main>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>

<?php
session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
// $userType = ($_SESSION['userType']); //get usertype into the variable $usertype


include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// when form for changing the password is submitted
if (isset($_POST['change_password'])) {
    $userid = $_POST['userid'];
    $newpassword = $_POST['newpassword'];
    
    // Update the password in the database
    $update_query = "UPDATE users SET password_key = ? WHERE uid = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $newpassword, $userid);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT uid, first_name, last_name, phone_number, email, username, password_key, usertype
        FROM users order by uid DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$allusers = $stmt->get_result();
$stmt->close();

$sql2 = "SELECT count(*) as Storiescount FROM stories";
$stmt = $conn->prepare($sql2);
$stmt->execute();
$result2 = $stmt->get_result();
$storiescount = mysqli_fetch_assoc($result2)['Storiescount'];
$stmt->close();

$sql3 = "SELECT count(*) as Tellercount FROM users where usertype = 'storyteller'";
$stmt = $conn->prepare($sql3);
$stmt->execute();
$result3 = $stmt->get_result();
$storytellercount = mysqli_fetch_assoc($result3)['Tellercount'];
$stmt->close();

$sql4 = "SELECT id, story_title, category, username_st FROM stories";
$stmt = $conn->prepare($sql4);
$stmt->execute();
$result4 = $stmt->get_result();
$stmt->close();

// $sql6 = "SELECT id, story_title, category, username_st FROM removed_stories";
// $stmt = $conn->prepare($sql6);
// $stmt->execute();
// $result6 = $stmt->get_result();
// $stmt->close();

// First, retrieve the stories to be removed
$sql = "SELECT * FROM stories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result7 = $stmt->get_result();
$stmt->close();

if (isset($_POST['remove'])) {
    $storyid = $_POST['storyid'];
    // Delete the story with the given storyid from the stories table
    $delete_sql = "DELETE FROM stories WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param('i', $storyid);
    $delete_stmt->execute();

    // // Retrieve the story with the given storyid from the stories table
    // $select_sql = "SELECT * FROM stories WHERE id = ?";
    // $select_stmt = $conn->prepare($select_sql);
    // $select_stmt->bind_param('i', $storyid);
    // $select_stmt->execute();
    // $result = $select_stmt->get_result();

    // // Insert the story into the removed_stories table
    // $row = $result->fetch_assoc();
    // $source_name = $row['source_name'];
    // $story_title = $row['story_title'];
    // $description = $row['description'];
    // $location = $row['location']; 
    // $pictureDestination = $row['picture_data'];
    // $videoDestination = $row['video_data'];
    // $latitude = $row['latitude'];
    // $longitude = $row['longitude'];
    // $username = $row['username_st'];
    // $category = $row['category'];
    // $insert_sql = "INSERT INTO removed_stories (source_name, story_title, description, location, latitude, longitude, picture_data, video_data, username_st, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    // $insert_stmt = $conn->prepare($insert_sql);
    // $insert_stmt->bind_param("ssssddssss", $source_name, $story_title, $description, $location, $latitude, $longitude, $pictureDestination, $videoDestination, $username, $category);
    // $insert_stmt->execute();
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css">
        <link href="https://fonts.googleapis.com/css?family=Hind:400,300|Bangers" rel="stylesheet" type="text/css">
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
                        <li><a href = "adminuser.php" class="nav-item">My Account</a></li>   
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
        <p>Welcome Admin, <?php echo $user; ?>!</p>

        <div>
            <p>Number of stories is: <?php echo $storiescount; ?></p>
        </div>

        <div>
            <p>Number of storyteller(s) is: <?php echo $storytellercount; ?></p>
        </div>

        <div>
            <p>Registered Users:</p>
            <table>
    <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Username</th>
        <th>Password</th>
        <th>User Type</th>
    </tr>
                <?php while ($row = $allusers->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['uid']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['password_key']; ?></td>
                    <td><?php echo $row['usertype']; ?></td>
    </tr>
    <?php } ?>
</table>

        </div>
        <div>
            <br>
  <h6>Change User Password</h6>
  <form method="POST" action="">
    <label for="userid">User ID:</label>
    <input type="text" name="userid" id="userid" required>
    <br>
    <label for="newpassword">New Password:</label>
    <input type="password" name="newpassword" id="newpassword" required>
    <br>
    <input type="submit" name="change_password" value="Change Password">
</form>
</div>

<br>
<div>
            <p>Available Stories:</p>
            <table>
    <tr>
        <th>Story ID</th>
        <th>Story Title</th>
        <th>Category</th>
        <th>StoryTeller Name</th>
    </tr>
                <?php while ($row = $result4->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['story_title']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['username_st']; ?></td>
    </tr>
    <?php } ?>
</table>
        </div>
        <div>
            <br>
  <h6>Remove Story</h6>
  <form method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
    <br>
    <input type="submit" name="remove" value="Remove from Website">
</form>
</div>

        </main>
<hr>
        <footer>
            <div class="container">
                <li><a href = "contactus.php" class="nav-item">Contact Us</a></li>   

            </div>
            
        </footer>
            

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        </body>

</html>
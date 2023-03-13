<?php
session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user

    // Connect to the database
    include_once("connection.php");
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve story data from database
$stmt = $conn->prepare("SELECT * FROM stories WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$story = $result->fetch_assoc();

// Close database connection
// $conn->close();

// Display HTML form pre-populated with existing story data
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 minimum-scale=1, maximum-scale=1">
        <title>Tourview</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="unsemantic-grid-responsive-tablet.css">
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
                            <li><a href = "home.php" class="nav-item active" >Home</a></li>
                            <li><a href = "stories.php" class="nav-item">Stories</a></li>
                            <li><a href = "about.php" class="nav-item">About Us</a></li>
                            <li><a href = "storytelleruser.php" class="nav-item">My Account</a></li>   
                            <li><a href = "logout.php" class="nav-item">Logout</a></li>   
                        </ul>
                    </nav>
                    </div>
                </div>    
            </div>

        </header>

        <main>
        <p>Welcome StoryTeller, <?php print $user; ?>!</p>
	<h1>Edit Your Story</h1>
	<form method="post" action="updatestory.php">
		<label for="name">Userame:</label>
		<input type="text" id="name" name="name" value="<?php echo $story['name']; ?>"><br><br>
		
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" value="<?php echo $story['email']; ?>"><br><br>
		
		<label for="title">Title:</label>
		<input type="text" id="title" name="title" value="<?php echo $story['title']; ?>"><br><br>

		<label for="story">Story:</label>
		<textarea id="story" name="story"><?php echo $story['story']; ?></textarea><br><br>
		
		<label for="location">Location:</label>
		<input type="text" id="location" name="location" value="<?php echo $story['location']; ?>"><br><br>
		
		<label for="picture">Picture:</label>
		<input type="file" id="photo" name="picture" accept="image/*"><br><br>
		
		<label for="video">Video:</label>
		<input type="file" id="video" name="video" accept="video/*"><br><br>
		
		<input type="hidden" name="id" value="<?php echo $story['id']; ?>">
		
		<input type="submit" value="Save Changes">
	</form>
		</main>
<footer>
    <hr>
    <div class="container">
        <li><a href = "contactus.php" class="nav-item">Contact Us</a></li>   

    </div>
    
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>

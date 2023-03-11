<?php
session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user

    // Connect to the database
    $servername = 'localhost';
    $username = 'root';
    $password = 'root';
    $dbname = 'TouristApp';
    
    // Create connection
    // $conn = mysqli_connect($servername, $username, $password, $dbname);
$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve story data from database
$stmt = $conn->prepare("SELECT * FROM stories WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$story = $result->fetch_assoc();

// Close database connection
$conn->close();

// Display HTML form pre-populated with existing story data
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Story</title>
</head>
<body>
	<h1>Edit Your Story</h1>
	<form method="post" action="updatestory.php">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" value="<?php echo $story['name']; ?>"><br>
		
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" value="<?php echo $story['email']; ?>"><br>
		
		<label for="title">Title:</label>
		<input type="text" id="title" name="title" value="<?php echo $story['name']; ?>"><br>

		<label for="story">Story:</label>
		<textarea id="story" name="story"><?php echo $story['story']; ?></textarea><br>
		
		<label for="location">Location:</label>
		<input type="text" id="location" name="location" value="<?php echo $story['location']; ?>"><br>
		
		<label for="picture">Picture:</label>
		<input type="file" id="photo" name="picture" accept="image/*"><br>
		
		<label for="video">Video:</label>
		<input type="file" id="video" name="video" accept="video/*"><br>
		
		<input type="hidden" name="id" value="<?php echo $story['id']; ?>">
		
		<input type="submit" value="Save Changes">
	</form>
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

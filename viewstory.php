<?php
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
// ...


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
                            <li><a href = "index.html" class="nav-item active" >Home</a></li>
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
	<h1><?php echo $story['name']; ?></h1>
	<p><strong>Title:</strong> <?php echo $story['title']; ?></p>
	<!-- <p><strong>Location:</strong> <?php echo $story['location']; ?></p> -->
	<p><strong>Story:</strong> <?php echo $story['story']; ?></p>
	<?php if (!empty($story['photo_path'])): ?>
		<img src="<?php echo $story['picture_path']; ?>" alt="Photo">
	<?php endif; ?>
	<?php if (!empty($story['video_path'])): ?>
		<video src="<?php echo $story['video_path']; ?>" controls></video>
	<?php endif; ?>
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


<!-- 
<?php
// Connect to database
// ...

// Retrieve story data from database
$stmt = $mysqli->prepare("SELECT * FROM stories WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$story = $result->fetch_assoc();

// Close database connection
// ...

// Display story data in HTML format
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Story</title>
</head>
<body>
	<h1><?php echo $story['name']; ?></h1>
	<img src="<?php echo $story['photo_path']; ?>" alt="Photo">
	<p><strong>Email:</strong> <?php echo $story['email']; ?></p>
	<p><strong>Location:</strong> <?php echo $story['location']; ?></p>
	<p><strong>Story:</strong> <?php echo $story['story']; ?></p>
	<?php if (!empty($story['video_path'])): ?>
		<video src="<?php echo $story['video_path']; ?>" controls></video>
	<?php endif; ?>
</body>
</html> -->

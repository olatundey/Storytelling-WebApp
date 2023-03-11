<?php
session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user
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
                            <li><a href = "logout.php" class="nav-item">Logout</a></li>   
                        </ul>
                    </nav>
                    </div>
                </div>    
            </div>

        </header>

        <main>
        <p>Welcome StoryTeller, <?php print $user; ?>!</p>
	<h1>Thank you for submitting your story!</h1>
	<p>Your story has been successfully uploaded</p>
    <p>To edit Story, <a href="editstory.php">Click Here</a></p>
	<p>Here are the details:</p>
	<ul>
		<li><strong>Name:</strong> <?php echo $name; ?></li>
		<li><strong>Email:</strong> <?php echo $email; ?></li>
        <li><strong>Title:</strong> <?php echo $title; ?></li>
		<li><strong>Story:</strong> <?php echo $story; ?></li>
		<li><strong>Location:</strong> <?php echo $location; ?></li>
		<li><strong>Picture Path:</strong> <?php echo $pictureDestination; ?></li>
		<li><strong>Video Path:</strong> <?php echo $videoDestination; ?></li>
	</ul>
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

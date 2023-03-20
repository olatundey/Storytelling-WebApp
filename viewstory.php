<?php
session_start();    //create or retrieve session
error_reporting(E_ALL);
ini_set('display_errors', 1);

// $latitude = $_POST['latitude'];
// $longitude = $_POST['longitude'];

// echo $latitude . $longitude;

include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if (Isset($_SESSION["user"])) { //user name must in session to stay here
    $user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
}

$story_id = $_GET['id'];
$sql = "SELECT latitude, longitude FROM stories WHERE id = $story_id";
$result4 = mysqli_query($conn, $sql);

// Check if the query returned any rows
if (mysqli_num_rows($result4) > 0) {
    // Fetch the latitude and longitude from the result set
    $row = mysqli_fetch_assoc($result4);
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
} else {
    // If no rows were returned, handle the error here
}


$hasRated = false;
if (isset($_SESSION['user'])) {
    $stmt3 = $conn->prepare("SELECT * FROM ratings WHERE story_id = ? AND username = ?");
    $stmt3->bind_param("is", $_GET['id'], $_SESSION['user']);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    if ($result3->num_rows > 0) {
        $hasRated = true;
        $rating = $result3->fetch_assoc();
    }

    $stmt2 = $conn->prepare("SELECT AVG(rating) AS avg_rating FROM ratings WHERE story_id = ?");
    $stmt2->bind_param("i", $_GET['id']);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $avgRating = $result2->fetch_assoc()['avg_rating'];
    
}



// Retrieve story data from database
$stmt = $conn->prepare("SELECT * FROM stories WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$story = $result->fetch_assoc();




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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3oeQSbb4oNhgeNqTBrdMlqyFSPD9Hg7s"></script>

    </head>
    <body>
    <body>
    <header class="container">
        <div class="col-md-12">
            <div id="headerContainer" class="row">
            <div id="title" class="col-md-2">
                        <h1><strong>Tourview</strong></h1>
                             </div>
            
                <div class="col-md-10">
                <nav>
                    <ul class="nav justify-content-end">
                    <?php if (isset($_SESSION["user"])) { ?>
    <li>
        <?php if ($usercategory == "admin"): ?>
            <a href="adminuser.php" class="nav-item">My Account</a>
        <?php elseif ($usercategory == "storyteller"): ?>
            <a href="storytelleruser.php?usercategory=<?php echo $usercategory; ?>" class="nav-item">My Account</a>
        <?php elseif ($usercategory == "storyseeker"): ?>
            <a href="storyseekeruser.php?usercategory=<?php echo $usercategory; ?>" class="nav-item">My Account</a>
        <?php endif; ?>
    </li>
    <li><a href="stories.php" class="nav-item">Stories</a></li>
    <li><a href="about.php" class="nav-item">About Us</a></li>
    <li><a href="logout.php" class="nav-item">Logout</a></li>
<?php } else { ?>
    <li><a href="index.html" class="nav-item active">Home</a></li>
    <li><a href="stories.php" class="nav-item">Stories</a></li>
    <li><a href="about.php" class="nav-item">About Us</a></li>
    <li><a href="login.html" class="nav-item">Register|Login</a></li>
<?php } ?>
</ul>
                </nav>
                </div>
            </div>    
        </div>
        </div>

    </header>
    <main>
    <hr>

<h2><?php echo $story['story_title']; ?></h2>
<?php if(isset($_SESSION['user'])) { ?>
<p><strong>Average Rating:</strong> <?php echo number_format($avgRating, 1); ?> stars</p>
<?php } ?>
<p><strong>Story Source:</strong> <?php echo $story['source_name']; ?></p>
<p><strong>Story Title:</strong> <?php echo $story['story_title']; ?></p>
<p><strong>Location:</strong> <?php echo $story['location']; ?></p>
<p><strong>Story description:</strong> <?php echo $story['description']; ?></p>
<div id="img" style="width: 70%; height: 500px;">
<p>Picture:<?php if (!empty($story['picture_data'])): ?>
    <img src="<?php echo $story['picture_data']; ?>" alt="Photo">
<?php endif; ?></p>
</div>
<div id="vid" style="width: 70%; height: 400px;">
<p>Video:<?php if (!empty($story['video_data'])): ?>
    <video src="<?php echo $story['video_data']; ?>" controls></video>
<?php endif; ?></p>
</div>
<!-- HTML code to display the map -->
<div id="map" style="width: 100%; height: 400px;"></div>

<?php if (isset($_SESSION["user"])) { ?>
<!-- form for rating -->
<?php if (!$hasRated): ?>
<form action="rating.php" method="POST">
    <p><strong>Rate this story:</strong></p>
    <input type="hidden" name="story_id" value="<?php echo $story['id']; ?>">
    <input type="radio" name="rating" value="1"> 1
    <input type="radio" name="rating" value="2"> 2
    <input type="radio" name="rating" value="3"> 3
    <input type="radio" name="rating" value="4"> 4
    <input type="radio" name="rating" value="5"> 5
    <button type="submit">Submit Rating</button>
</form>
<?php else: ?>
<p>You have rated this story, <a href="stories.php">Click Here</a> for more Stories</p>
<?php endif; ?>
<?php } ?>

</main>
<footer>
                <hr>
                <div class="container">
                    <div class="col-md-12" id="footend">
                        <div id="footercontainer" class="row">
                            <section class="col-md-3.5">
                                <h4>Tourview</h4>
                                <p>Copyright &copy; 2023 All rights reserved.</p>
                            </section>
                            <section class="col-md-6">
                            </section>
                            <section class="col-md-2.5">
                            <a href = "contactus.php" class="nav-item">Click Here to Contact Us</a><br>
                            <a href="https://www.facebook.com/profile.php?id=100090483228208" class="fa fa-facebook"></a>
                            <a href="https://twitter.com/Tourview_uk" class="fa fa-twitter"></a>
                            </section>
                        </div>  
                    </div>
                </div>       
            </footer>

<script>
            function initMap() {
                var myLatLng = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};

                var map = new google.maps.Map(document.getElementById('map'), {
                    center: myLatLng,
                    zoom: 16
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: 'Location'
                });
            }
        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3oeQSbb4oNhgeNqTBrdMlqyFSPD9Hg7s&callback=initMap">
        </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>


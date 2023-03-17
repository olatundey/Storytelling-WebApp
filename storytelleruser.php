<?php
session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
// $userType = ($_SESSION['userType']); //get usertype into the variable $usertype



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 minimum-scale=1, maximum-scale=1">
        <title>Tourview</title>
        <title>Tourview</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css">
        <link href="https://fonts.googleapis.com/css?family=Hind:400,300|Bangers" rel="stylesheet" type="text/css">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3oeQSbb4oNhgeNqTBrdMlqyFSPD9Hg7s&callback=initMap"
    async defer></script>
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
        <p><a href="editstory.php">My Stories</a></p>
        <p>Upload Story:</p>
        <form action="uploadstory.php" method="post" enctype="multipart/form-data">
    <label for="name">Story Source:</label>
    <input type="text" id="source_name" name="source_name" required><br>

    <label for="title">Story Title:</label>
    <input type="text" id="story_title" name="story_title" required><br>

    <label for="story">Story Description:</label>
    <textarea id="description" name="description" required></textarea><br>

    <label for="picture">Photo:</label>
    <input type="file" id="picture" name="picture" accept="image/*" required><br>

    <label for="video">Video:</label>
    <input type="file" id="video" name="video" accept="video/*"><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required><br>
    <!-- <button onclick="openMap()">Select location</button> -->

    <label for="latitude">Latitude:</label>
    <input type="number" id="latitude" name="latitude" step="0.00000001" placeholder="Latitude(+N,-S)"><br>

    <label for="longitude">Longitude:</label>
    <input type="number" id="longitude" name="longitude" step="0.00000001" placeholder="Longitude (-W,+E)"><br>

    <label for="category">Category:</label>
    <!-- <input type="radio" name="storycategory" value="Any"> Any -->
        <input type="radio" name="storycategory" value="Places" required> Places
        <input type="radio" name="storycategory" value="Museum" required> Museum
        <input type="radio" name="storycategory" value="Other" required> Other <br>


    <input type="submit" value="Submit" name="submit">
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

    
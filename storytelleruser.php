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

        <main>
        <p>Welcome StoryTeller, <?php print $user; ?>!</p>
        <p>Upload Story:</p>
        <form action="uploadstory.php" method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name"><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br>

    <label for="title">Story Title:</label>
    <input type="text" id="title" name="title"><br>

    <label for="story">Story Details:</label>
    <textarea id="story" name="story"></textarea><br>

    <label for="picture">Photo:</label>
    <input type="file" id="picture" name="picture" accept="image/*"><br>

    <label for="video">Video:</label>
    <input type="file" id="video" name="video" accept="video/*"><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location"><br>
    <!-- <button onclick="openMap()">Select location</button> -->

    <input type="submit" value="Submit" name="submit">
</form>

        </main>

        <footer>
            <hr>
            <div class="container">
                <li><a href = "contactus.php" class="nav-item">Contact Us</a></li>   

            </div>
            
        </footer>
        <script>
//     function openMap() {
//         // Create the map location picker
//         var maplocator = new google.maps.places.Autocomplete(document.getElementById('location'));

//         // When the user selects a location, update the text input field
//         maplocator.addListener('place_changed', function() {
//             var place = maplocator.getPlace();
//             var address = maplocator.formatted_address;
//             document.getElementById('location').value = address;
//         });
//     }
// </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        </body>

</html>

    
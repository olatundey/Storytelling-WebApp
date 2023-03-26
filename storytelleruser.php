<?php
session_start();    //create or retrieve session
if (!isset($_SESSION["user"])) { //user name must in session to stay here
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3oeQSbb4oNhgeNqTBrdMlqyFSPD9Hg7s&callback=initMap"
    async defer></script>
    <style>
        .custom-text {
            position: absolute;
            top: 14%;
            right: 2%;
        }
    </style>
            </head>

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
                                        <a href="adminuser.php" class="nav-link">My Account</a>
                                    <?php elseif ($usercategory == "storyteller"): ?>
                                        <a href="storytelleruser.php?usercategory=<?php echo $usercategory; ?>" class="nav-link">My Account</a>
                                    <?php elseif ($usercategory == "storyseeker"): ?>
                                        <a href="storyseekeruser.php?usercategory=<?php echo $usercategory; ?>" class="nav-link">My Account</a>
                                    <?php endif; ?>
                                </li>
                                <li><a href="stories.php" class="nav-link">Stories</a></li>
                                <li><a href="about.php" class="nav-link">About</a></li>
                                <li><a href="logout.php" class="nav-link">Logout</a></li>   
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>

        </header>
        <main>
        <hr>

        <div class="custom-text">
        <label><strong>Hello, </strong><?php print $user; ?>!</label><br>
        </div>
        <div class="login-register">

        <label><strong>My Stories: <a href="editstory.php">Click Here</a></strong></label>
        <h5>Upload Story</h5>
        <div class="userfeedback">
      
        <form class="contactinfo" action="uploadstory.php" method="post" enctype="multipart/form-data">
    <label for="name">Story Source:</label>
    <input type="text" id="source_name" name="source_name" required><br>

    <!-- <label for="category">Category:</label> -->
        <input type="radio" name="storycategory" value="Places" required> Places
        <input type="radio" name="storycategory" value="Museum" required> Museum
        <input type="radio" name="storycategory" value="Other" required> Other <br>

        <br><label for="title">Story Title:</label>
    <input type="text" id="story_title" name="story_title" required><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required><br>

    <label for="latitude">Latitude:</label>
    <input type="number" id="latitude" name="latitude" step="0.00000001" placeholder="+Latitude (+N,-S)"><br>

    <label for="longitude">Longitude:</label>
    <input type="number" id="longitude" name="longitude" step="0.00000001" placeholder="-Longitude (-W,+E)"><br>

    <label for="picture">Photo:</label>
    <input type="file" id="picture" name="picture" accept="image/*" required><br>

    <label for="video">Video:</label>
    <input type="file" id="video" name="video" accept="video/*"><br>

    <label for="audio">Audio:</label>
    <input type="file" id="audio" name="audio" accept="audio/*"><br>
        
    <label for="story">Story Description:</label>
    <textarea id="description" name="description" rows="5" cols="30" required  wrap="soft" style="width: 100%;"></textarea><br>

    <input type="submit" value="Submit" name="submit">
</form>
</div>
</div>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        </body>

</html>

    
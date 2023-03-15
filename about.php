<?php
session_start();    //create or retrieve session
if (Isset($_SESSION["user"])) { //user name must in session to stay here
    $user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
    // header("Location: index.html"); //if not, go back to login page
}  

// Connect to database
include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$sql2 = "SELECT usertype FROM users";
$stmt = $conn->prepare($sql2);
$stmt->execute();
$result2 = $stmt->get_result();
$user_type = mysqli_fetch_assoc($result2)['usertype'];
$stmt->close();

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

        </header>

        <main>
 <p>ABOUT TOURVIEW</p>

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

    
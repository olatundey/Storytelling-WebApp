<?php
session_start();    //create or retrieve session

if (Isset($_SESSION["user"])) { //user name must in session to stay here
    $user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
}  

// Connect to database
include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve story data from database
$stmt = $conn->prepare("SELECT * FROM stories WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result2 = $stmt->get_result();
$story = $result2->fetch_assoc();


// To determine the current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;


$stmt = $conn->prepare("SELECT s.*, AVG(r.rating) AS average_rating FROM stories s LEFT JOIN ratings r ON s.id = r.story_id GROUP BY s.id HAVING AVG(r.rating) >= 4.5 ORDER BY AVG(r.rating) DESC LIMIT ?");
$stmt->bind_param("i", $perPage);
$stmt->execute();
$result = $stmt->get_result();




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
        <style>

    .contactinfo img {
        width: 100%;
        height: 200px;
        max-width: 100%;
    }


    .contactinfo {
        position: relative;
    }
    .custom-text {
        position: absolute;
        bottom: 2%;
        right: 2%;
    }        
    </style>
    </head>
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

        </header>
<hr>
        <main>
	<h1>Top Rated Stories</h1>
<?php if(isset($_SESSION['user'])) { ?>
<p><strong>Hello!</strong> <?php echo $user; ?></p>
<?php } ?>

<div class="container"> 
        <?php while ($row = $result->fetch_assoc()): ?>

<div class="contactinfo">
    <div id="img">
    <a href="viewstory.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $row['picture_data']; ?>" alt="Photo">
    </div><br>
    <div>
        <a href="viewstory.php?id=<?php echo $row['id']; ?>"><?php echo $row['story_title']; ?><br></a>
        <div class="custom-text">
        <?php if(isset($_SESSION['user'])) { ?>
<p>Read & <img src="assets/images/like.png" alt="Like" style="width: 20px; height: 16px;"></p>
<?php } ?></div>
    </div>
</div>


<br><br>
            <?php endwhile; ?>
    </div>
        

        <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>">Previous Page</a>
    <?php endif; ?>

    <?php if ($result->num_rows === $perPage): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next Page</a>
    <?php endif; ?>
</div>
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
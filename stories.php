<?php
session_start();    //create or retrieve session

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (Isset($_SESSION["user"])) { //user name must in session to stay here
    $user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
}  



// Connect to database
include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve list of story IDs and title from database
$result = $conn->query("SELECT id, story_title, picture_data FROM stories ORDER BY id DESC");

// To determine the current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Retrieve all stories, or only stories that match a keyword search
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $stmt = $conn->prepare("SELECT * FROM stories WHERE story_title LIKE ? OR location LIKE ? OR category LIKE ? ORDER BY id DESC LIMIT ?, ?");
    $searchTerm = "%" . $keyword . "%";
    $stmt->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $offset, $perPage);
} else {
    $stmt = $conn->prepare("SELECT * FROM stories ORDER BY id DESC LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $perPage);
}
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
        <style>
            .sidenav {
  height: 100%;

  width: 160px;
  position: fixed;
  z-index: 1;
  top: 12%;
  bottom: 12%,
  left: 0;
  background-color: grey;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: white;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

        .main {
    width: 100%;
    margin: 0;
    background-image: url('background-picture.png');
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;

    
}
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

        .custom-text2 {
  position: absolute;
  top: 12.4%;
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
                <a href="adminuser.php" class="nav-item">My Account</a>
            <?php elseif ($usercategory == "storyteller"): ?>
                <a href="storytelleruser.php?usercategory=<?php echo $usercategory; ?>" class="nav-item">My Account</a>
            <?php elseif ($usercategory == "storyseeker"): ?>
                <a href="storyseekeruser.php?usercategory=<?php echo $usercategory; ?>" class="nav-item">My Account</a>
            <?php endif; ?>
        </li>
        <li><a href="stories.php" class="nav-item">Stories</a></li>
        <li><a href="about.php" class="nav-item">About</a></li>
        <li><a href="logout.php" class="nav-item">Logout</a></li>
    <?php } else { ?>
        <li><a href="index.html" class="nav-item active">Home</a></li>
        <li><a href="stories.php" class="nav-item">Stories</a></li>
        <li><a href="about.php" class="nav-item">About</a></li>
        <li><a href="login.html" class="nav-item">Register|Login</a></li>
    <?php } ?>
</ul>

                    </nav>
                    </div>
                </div>    
            </div>

        </header>
        <main class="main">
        <hr>
<div class="container"> 
	<h1>Stories</h1>
<?php if(isset($_SESSION['user'])) { ?>
    <div class="custom-text2">
<p><strong>Hello!</strong> <?php echo $user; ?></p>
    </div>
<?php } ?>
<div><p>Top rated Stories: <a href="toprated.php">Click Here</a></p></div>
<div>
    <form class="classinfo" action="stories.php" method="GET">
    <input type="text" name="keyword" placeholder="Enter a keyword...">
    <button type="submit">Search</button>
</form>
</div>
    </div>
<br>
<div class="container">
        <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>">Previous Page</a>
    <?php endif; ?>

    <?php if ($result->num_rows === $perPage): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next Page</a>
    <?php endif; ?>
</div>
    </div>
    <br>
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
    <div class="container">
        <?php if ($result->num_rows === 0): ?>
    <p><?php echo "No results found for '$keyword',";?> <a href="stories.php">Click Here</a> for more Stories</p>
<?php endif; ?>
        </div>

        <br>
<div class="container">
        <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>">Previous Page</a>
    <?php endif; ?>

    <?php if ($result->num_rows === $perPage): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next Page</a>
    <?php endif; ?>
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

    
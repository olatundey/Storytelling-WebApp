<?php
session_start();    //create or retrieve session

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: index.html"); //if not, go back to login page
}  
$user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);


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

// Retrieve list of story IDs and title from database
$result = $conn->query("SELECT id, title FROM stories ORDER BY id DESC");

// To determine the current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Retrieve all stories, or only stories that match a keyword search
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $stmt = $conn->prepare("SELECT * FROM stories WHERE title LIKE ? OR location LIKE ? ORDER BY id DESC LIMIT ?, ?");
    $searchTerm = "%" . $keyword . "%";
    $stmt->bind_param("ssii", $searchTerm, $searchTerm, $offset, $perPage);
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
                        <li>
                        <?php if ($user_type== "admin"): ?>
    <a href="storytelleruser.php" class="nav-item">My Account</a>
<?php elseif ($user_type == "storyteller"): ?>
    <a href="storytelleruser.php?usercategory=<?php echo $user_type; ?>" class="nav-item">My Account</a>
<?php elseif ($user_type == "storyseeker"): ?>
    <a href="storyseekeruser.php?usercategory=<?php echo $user_type; ?>" class="nav-item">My Account</a>
<?php endif; ?>

</li>
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
	<h1>Stories</h1>
    <form action="stories.php" method="GET">
    <input type="text" name="keyword" placeholder="Enter a keyword...">
    <button type="submit">Search</button>
</form>
	<div>
        <?php while ($row = $result->fetch_assoc()): ?>
			<li><a href="viewstory.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?><br></a></li>
		<?php endwhile; ?>
        <?php if ($result->num_rows === 0): ?>
    <p><?php echo "No results found for '$keyword',";?> <a href="stories.php">Click Here</a> for more Stories</p>
<?php endif; ?>
        </div>
        

    <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>">Previous</a>
    <?php endif; ?>

    <?php if ($result->num_rows === $perPage): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next</a>
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

    
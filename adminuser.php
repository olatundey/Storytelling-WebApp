<?php
session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);
// $userType = ($_SESSION['userType']); //get usertype into the variable $usertype


include_once("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT uid, first_name, last_name, phone_number, email, username, usertype
        FROM users order by uid DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$allusers = $stmt->get_result();
$stmt->close();

$sql2 = "SELECT count(*) as Storiescount FROM stories";
$stmt = $conn->prepare($sql2);
$stmt->execute();
$result2 = $stmt->get_result();
$storiescount = mysqli_fetch_assoc($result2)['Storiescount'];
$stmt->close();

$sql3 = "SELECT count(*) as Tellercount FROM users where usertype = 'storyteller'";
$stmt = $conn->prepare($sql3);
$stmt->execute();
$result3 = $stmt->get_result();
$storytellercount = mysqli_fetch_assoc($result3)['Tellercount'];
$stmt->close();

// $sql4 = "SELECT name,email,title,location FROM stories";
// $stmt = $conn->prepare($sql4);
// $stmt->execute();
// $result4 = $stmt->get_result();
// $stmt->close();

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
                        <li><a href = "adminuser.php" class="nav-item">My Account</a></li>   
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
        <p>Welcome Admin, <?php echo $user; ?>!</p>

        <div>
            <p>Number of stories is: <?php echo $storiescount; ?></p>
        </div>

        <div>
            <p>Number of storyteller is: <?php echo $storytellercount; ?></p>
        </div>

        <div>
            <p>Registered Users:</p>
            <table>
    <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Username</th>
        <th>User Type</th>
    </tr>
                <?php while ($row = $allusers->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['uid']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['usertype']; ?></td>
    </tr>
    <?php } ?>
</table>

        </div>

        <!-- <div>
            <p>Manage Stories: $result4</p>

        </div> -->

 
        </main>

        <footer>
            <div class="container">
                <li><a href = "contactus.php" class="nav-item">Contact Us</a></li>   

            </div>
            
        </footer>
            

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        </body>

</html>
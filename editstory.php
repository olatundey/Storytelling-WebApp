<?php
session_start();    //create or retrieve session
if (!Isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user

    // Connect to the database
    include_once("connection.php");
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Retrieve list of story IDs and title from database
  // $result = $conn->query("SELECT id, story_title FROM stories where us ORDER BY id DESC");
    
  $sql4 = "SELECT id, story_title, source_name FROM stories where username_st = ? ORDER BY id DESC";
  $stmt = $conn->prepare($sql4);
  $stmt->bind_param("s", $user);
  $stmt->execute();
  $result4 = $stmt->get_result();
  $stmt->close();
  
  if (isset($_POST['update_story'])) {
    $id = $_POST['storyid'];
    $newtitle = $_POST['newtitle'];
    
    // Update the title in the database
    $update_query = "UPDATE stories SET story_title= ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $newtitle, $id);
    $stmt->execute();
    $stmt->close();
  }

  if (isset($_POST['update_desc'])) {
    $id = $_POST['storyid'];
    $newdesc = $_POST['newdesc'];
    
    // Update the desc in the database
    $update_query2 = "UPDATE stories SET description = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query2);
    $stmt->bind_param("si", $newdesc, $id);
    $stmt->execute();
    $stmt->close();
  }

  if (isset($_POST['remove'])) {
    $storyid = $_POST['storyid'];
    // Delete the story with the given storyid from the stories table
    $delete_sql = "DELETE FROM stories WHERE id = ? and username_st = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param('is', $storyid,$user);
    $delete_stmt->execute();
  }
// Close database connection
// $conn->close();

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
                            <li><a href = "home.php" class="nav-item active" >Home</a></li>
                            <li><a href = "stories.php" class="nav-item">Stories</a></li>
                            <li><a href = "about.php" class="nav-item">About</a></li>
                            <li><a href = "storytelleruser.php" class="nav-item">My Account</a></li>   
                            <li><a href = "logout.php" class="nav-item">Logout</a></li>   
                        </ul>
                    </nav>
                    </div>
                </div>    
            </div>

        </header>
        <main>
        <hr>

        <p>Welcome StoryTeller, <?php print $user; ?>!</p>
        </div>
  <p>Submitted Stories:</p>
  <table>
    <tr>
        <th>Story ID</th>
        <th>Story Title</th>
        <th>Source</th>
    </tr>
                <?php while ($row = $result4->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['story_title']; ?></td>
                    <td><?php echo $row['source_name']; ?></td>
    </tr>
    <?php } ?>
</table>

  </div>
  <div>
    <br>
  <h6>Change Story Title</h6>
  <form method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
    <br>
    <label for="newtitle">Story Title:</label>
    <input type="text" name="newtitle" id="newtitle" required>
    <br>
    <input type="submit" name="update_story" value="Change Details">
</form>
</div>
<br>
<div>
  <h6>Change Story description</h6>
  <form method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
    <br>
    <label for="newdesc">Story Title:</label>
    <input type="text" name="newdesc" id="newdesc" required>
    <br>
    <input type="submit" name="update_desc" value="Change Description">
</form>
</div>
<div>
            <br>
  <h6>Remove Story</h6>
  <form method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
    <br>
    <input type="submit" name="remove" value="Remove from Website">
</form>
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

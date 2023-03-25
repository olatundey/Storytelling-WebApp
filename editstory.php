<?php
session_start();    //create or retrieve session
if (!isset($_SESSION["user"])) { //user name must in session to stay here
    header("Location: login.html");
}  //if not, go back to login page
$user = ($_SESSION['user']); //get user name into the variable $user
$usercategory = ($_SESSION['userType']);


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

  if (isset($_POST['update_location'])) {
    $id = $_POST['storyid'];
    $newloc = $_POST['newloc'];
    
    // Update the desc in the database
    $update_query5 = "UPDATE stories SET location = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query5);
    $stmt->bind_param("si", $newloc, $id);
    $stmt->execute();
    $stmt->close();
  }

  if (isset($_POST['update_map'])) {
    $id = $_POST['storyid'];
    $newlat = $_POST['newlat'];
    $newlng = $_POST['newlng'];
    // Update the desc in the database
    $update_query6 = "UPDATE stories SET latitude = ?, longitude = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query6);
    $stmt->bind_param("ddi", $newlat, $newlng, $id);
    $stmt->execute();
    $stmt->close();
  }
  

  if (isset($_POST['update_picture'])) {
    $id = $_POST['storyid'];
    // Handle picture upload
    $picture = $_FILES['new_pict'];
    $pictureName = $picture['name'];
    $pictureTempName = $picture['tmp_name'];
    $pictureError = $picture['error'];
    if($pictureError === 0) {
        $newpictureDestination = 'uploads/pictures/' . $pictureName;
        move_uploaded_file($pictureTempName, $newpictureDestination);

        // Update the picture in the database
        $update_query4 = "UPDATE stories SET picture_data = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query4);
        $stmt->bind_param("si", $newpictureDestination, $id);
        $stmt->execute();
        $stmt->close();
    }
}

//

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
<div>
        <label><strong>Hello, </strong><?php print $user; ?>!</label>
        </div>
        <br>
        <div class="container">
  <h6>Submitted Stories</h6>
  <table class="table table-bordered">
    <tr class="table-info">
        <th>Story ID</th>
        <th>Story Title</th>
        <th>Source</th>
    </tr>
                <?php while ($row = $result4->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><a href="viewstory.php?id=<?php echo $row['id']; ?>"><?php echo $row['story_title']; ?></td>
                    <td><?php echo $row['source_name']; ?></td>
    </tr>
    <?php } ?>
</table>

  </div>

    <br>
    <div class="container">
  <h6>Remove Story</h6>
  <form class="contactinfo" method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
    
    <input type="submit" name="remove" value="Remove from Website">
</form>
</div>
<br>
    <div class="container">
  <h6>Change Story Title</h6>
  <form class="contactinfo" method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>

    <label for="newtitle">Story Title:</label>
    <input type="text" name="newtitle" id="newtitle" required>
    <input type="submit" name="update_story" value="Change Details">
</form>
</div>
<br>
 <div class="container">
  <h6>Change Story description</h6>
  <form class="contactinfo" method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required><br>
  
    <label for="newdesc">Story Description:</label><br>
    <textarea id="newdesc" name="newdesc" rows="4" cols="60" required></textarea><br>

 
    <input type="submit" name="update_desc" value="Change Description">
</form>
</div>
<br>
<div class="container">
  <h6>Change Story Picture</h6>
  <form class="contactinfo" method="POST" action="" enctype="multipart/form-data">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
  
    <label for="newpict">Story Picture:</label>
    <input type="file" id="picture" name="new_pict" accept="image/*" required>
    <input type="submit" name="update_picture" value="Change Picture">
</form>
</div>

<br>
<br>
 <div class="container">
  <h6>Change Location</h6>
  <form class="contactinfo" method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
  
    <label for="newloc">Story Location:</label>
    <input type="text" name="newloc" id="newloc" required>

 
    <input type="submit" name="update_location" value="Change Story Location">
</form>
</div>
<br>
<div class="container">
  <h6>Change Map View</h6>
  <form class="contactinfo" method="POST" action="">
    <label for="storyid">Story ID:</label>
    <input type="text" name="storyid" id="storyid" required>
<label for="latitude">Latitude:</label>
  <input type="number" id="latitude" name="newlat" step="0.00000001" placeholder="+Latitude (+N,-S)">
  <label for="longitude">Longitude:</label>
  <input type="number" id="longitude" name="newlng" step="0.00000001" placeholder="-Longitude (-W,+E)">
  <input type="submit" name="update_map" value="Change MapView">
</form>
</div>
<br>


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

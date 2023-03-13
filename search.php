<?php
// Retrieve the keyword from the query string
$keyword = $_GET['keyword'];

include_once("connection.php");
$conn = new mysqli($servername, $username, $password, $dbname);


// Perform a database query to search for stories that match the keyword
$stmt = $conn->prepare("SELECT * FROM stories WHERE title LIKE ? OR location LIKE ?");
$searchTerm = "%" . $keyword . "%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Display the search results
// while ($row = $result->fetch_assoc()) {
//     echo "<h2>" . $row['title'] . "</h2>";
//     // etc.
// }
?>

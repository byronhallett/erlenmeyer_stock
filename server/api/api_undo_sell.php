<?php 

//Grab database credentials
include '../credentials.cfg.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  
  die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

//Retrieving ajax posted data
$item_id = $data['item_id'];

if ($item_id == "") {
  echo "Error with undo id!";
  return false;
}

// Find last sale of this item
$sql = "SELECT *
      FROM sale
      WHERE item_id = $item_id
      ORDER BY sale_date DESC
      LIMIT 1";

$undoItem = mysqli_fetch_assoc(mysqli_query($conn,$sql));
$sell = $undoItem['sale_count'];

//Delete the sale in question
$sqlDelete = "DELETE 
        FROM sale
        WHERE item_id = '$item_id'
        ORDER BY sale_date DESC
        LIMIT 1";

if ($conn->query($sqlDelete) === TRUE) {
  echo $sell;
  return true;
} else {
  echo "Error: " . $sqlDelete . "<br>" . $conn->error;
}

?> 
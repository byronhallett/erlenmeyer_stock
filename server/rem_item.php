<?php 

//Grab database credentials
include 'credentials.cfg.php';


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	
	die("Connection failed: " . $conn->connect_error);
} 
//Retrieving ajax posted data
$remItem = $_POST['item-id'];

if ($remItem == "") {
	echo "No items to remove!";
	return false;
}

//First clean up the sale/restock tables of this item
$sql = "DELETE s, r
				FROM sale s
					inner join restock r on s.item_id = r.item_id
				WHERE s.item_id = '$remItem'";

if (!mysqli_query($conn, $sql)) {
   echo "Error deleting record: " . mysqli_error($conn);
} else {
  $sql = "DELETE 
				FROM items
				WHERE item_id = '$remItem'";
	if (!mysqli_query($conn, $sql)) {
  	echo "Error deleting record: " . mysqli_error($conn);
	} else {
		echo "Succesfully Removed.";
	}
}

//remove the categoryfrom table on server




?> 
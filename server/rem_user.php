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
$remCat = $_POST['cat-id'];


if ($remCat == "") {
	echo "No categories to remove!";
	return false;
}

//remove the categoryfrom table on server
$sql = "DELETE 
				FROM categories 
				WHERE category_id = '$remCat'";

if ($conn->query($sql) === TRUE) {
  echo "Succesfully Removed.";
} else {
	if (strpos(jQuery.trim($conn->error), "Cannot delete or update a parent row")) {
		echo "You may not delete a category which contains items.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
  }
}



?> 
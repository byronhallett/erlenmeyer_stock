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
$moveCat = $_POST['move-cat'];
$toCat = $_POST['to-cat'];
$beforeAfter = $_POST['before-after'];


if ($moveCat == "" || $toCat == "") {
	echo "Please fill all fields!";
	return false;
}

if ($beforeAfter == "before") {
	$beforeAfterAlt = -5;
} else {
	$beforeAfterAlt = 5;
}

//Find the 'to' category's index
$sql = "SELECT *
				FROM categories
				WHERE category_id = '$toCat'";
$sqlToCats = mysqli_query($conn,$sql);

while ($sqlToCat = mysqli_fetch_assoc($sqlToCats)) {
	$moveReferenceId = $sqlToCat['ordering'];
}

$nextOrder = $moveReferenceId + $beforeAfterAlt;

//Insert the new category into categories table on server
$sql = "UPDATE categories 
				SET ordering = '$nextOrder'
				WHERE category_id = '$moveCat'";

if ($conn->query($sql) === TRUE) {
	include 'refreshCatOrder.php';
  echo "Succesfully Updated Position.";
} else {
  echo "Error: " . $sql . $conn->error;
}



?>
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
$newCat = htmlspecialchars($_POST['cat-box'], ENT_QUOTES);
$userId = htmlspecialchars($_POST['user-id'], ENT_QUOTES);

if ($newCat == "") {
	echo "Please fill all fields!";
	return false;
}

//Find the highest current index
// $sql = "SELECT
// 				MAX()"
// $sales = mysqli_query($conn,$sql);

//Insert the new category into categories table on server
$sql = "INSERT INTO categories (`category_name`,`created_by`) VALUES ('$newCat','$userId')";

if ($conn->query($sql) === TRUE) {
	include 'refreshCatOrder.php';
  echo "Succesfully added " . $_POST['cat-box'] . ".";

} else {
  echo "Error: " . $sql . $conn->error;
}

?>
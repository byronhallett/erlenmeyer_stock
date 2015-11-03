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
$user = htmlspecialchars($_POST['username'], ENT_QUOTES);
$pass = htmlspecialchars($_POST['password'], ENT_QUOTES);

if ($user == "" || $pass == "") {
	echo "Please fill all fields!";
	return false;
}

//Insert the new category into categories table on server
$sql = "INSERT INTO users (`username`,`password`) VALUES ('$user','$pass')";

if ($conn->query($sql) === TRUE) {
  echo "Succesfully added " . $_POST['username'] . ".";

} else {
  echo "Error: " . $sql . $conn->error;
}

?>
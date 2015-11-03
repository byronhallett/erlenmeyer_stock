<?php 

//Grab database credentials
include 'credentials.cfg.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	
	die("Connection failed: " . $conn->connect_error);
} 

$sql="SET @ordering_inc = 10;
			SET @new_ordering = 0;
			UPDATE categories 
			SET ordering = (@new_ordering := @new_ordering + @ordering_inc) 
			ORDER BY ordering ASC;";
if (!mysqli_multi_query($conn,$sql)) {
  echo "Error: " . $sql . $conn->error;
}
?>
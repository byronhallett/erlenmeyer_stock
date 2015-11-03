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
$sell = $data['sell_amount'];
$item_id = $data['item_id'];

if ($sell == "") {
	echo "Error with sale count!";
	return false;
}

//Insert the new category into categories table on server
$sql = "INSERT INTO sale (`item_id`,`sale_count`) VALUES ('$item_id','$sell')";

if ($conn->query($sql) === TRUE) {
  echo "success";
  return true;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

?> 
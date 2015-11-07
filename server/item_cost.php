<?php

//Grab database credentials
include 'credentials.cfg.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {

	die("Connection failed: ".$conn->connect_error);
}

//Retrieving ajax posted data
$itemId   = $_POST['item-id'];
$itemCost = $_POST['cost-value'];

if ($itemId == "" || $itemCost == "") {
	echo "Please fill all fields!";
	return false;
}

// Set the cost on the item by id
$sql = "UPDATE items
				SET cost = '$itemCost'
				WHERE item_id = '$itemId'";

if ($conn->query($sql) === TRUE) {
	echo "Succesfully updated cost.";
} else {
	echo "Error: ".$sql.$conn->error;
}
?>
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
$itemId    = $_POST['item-id'];
$itemPrice = $_POST['price-value'];

if ($itemId == "" || $itemPrice == "") {
	echo "Please fill all fields!";
	return false;
}

// Set the price on the item by id
$sql = "UPDATE items
				SET price = '$itemPrice'
				WHERE item_id = '$itemId'";

if ($conn->query($sql) === TRUE) {
	echo "Succesfully updated price.";
} else {
	echo "Error: ".$sql.$conn->error;
}
?>
<?php

function addToSetValue($setValue, $columnName, $value) {
	if ($setValue == "") {
		$setValue = $setValue."SET ";
	} else {
		$setValue = $setValue.", ";
	}
	$setValue = $setValue.$columnName." = ".$value;
	return $setValue;
}

// Api script
//
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
$itemCost  = $_POST['cost-value'];

$valuesToChange = "";
if ($itemPrice != "") {
	$valuesToChange = addToSetValue($valuesToChange, "price", $itemPrice);
}
if ($itemCost != "") {
	$valuesToChange = addToSetValue($valuesToChange, "cost", $itemCost);
}

if ($itemId == "" || $valuesToChange == "") {
	echo "Please select an item an set at least price or cost!";
	return false;
}

// Set the cost on the item by id
$sql = "UPDATE items
$valuesToChange
WHERE item_id = '$itemId'";

if ($conn->query($sql) === TRUE) {
	echo "Succesfully updated price / cost.";
} else {
	echo "Error: ".$sql.$conn->error;
}
?>
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
	$restock = $_POST['restockAmount'];
	$item_id = $_POST['item_id'];

	if ($restock == "") {
		echo "Please fill all fields!";
		return false;
	}

	//Insert the new category into categories table on server
	$sql = "INSERT INTO restock (`item_id`,`restock_count`) VALUES ('$item_id','$restock')";

	if ($conn->query($sql) === TRUE) {
    return true;
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	

?> 
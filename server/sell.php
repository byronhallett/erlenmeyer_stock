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
	$sell = $_POST['sellAmount'];
	$item_id = $_POST['item_id'];

	if ($sell == "") {
		echo "Error with sale count!";
		return false;
	}

	//Insert the new category into categories table on server
	$sql = "INSERT INTO sale (`item_id`,`sale_count`) VALUES ('$item_id','$sell')";

	if ($conn->query($sql) === TRUE) {
    return true;
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}	

?> 
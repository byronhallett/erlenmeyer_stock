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
	$newItem = htmlspecialchars($_POST['item'], ENT_QUOTES);
	$catId = htmlspecialchars($_POST['item-cat'], ENT_QUOTES);


	if ($newItem == "" || $catId == "") {
		echo "Please fill all fields!";
		return false;
	}

	//Insert the new category into categories table on server
	$sql = "INSERT INTO items (`category_id`,`item_name`) VALUES ('$catId','$newItem')";

	if ($conn->query($sql) === TRUE) {
    echo "Succesfully added " . $_POST['item'] . ".";
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}

?> 
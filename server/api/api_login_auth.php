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

//Retrieving rest posted data
$username = $data['username'];
$password = $data['password'];

if ($username == "" || $password == "") {
	$returnData = array(
			'error' => 'fill_all_fields',
			'error_message' => 'Please Fill All Fields'
		);
	$jsonReturn = json_encode($returnData);
	echo $jsonReturn;
	return false;
}

//Read the user names table on the server to make sure it's ok
$sql = "SELECT * 
				FROM users
				WHERE username = '$username'
				AND password = '$password'";
$loginResult = mysqli_query($conn,$sql);

if ($loginResult -> num_rows == 0) {
	$returnData = array(
			'error' => 'user_not_found',
			'error_message' => 'User Not Found'
		);
	$jsonReturn = json_encode($returnData);
	echo $jsonReturn;
} else {
	// Return user details
	while ($log = mysqli_fetch_assoc($loginResult)) {
		$returnData = array(
			'user_id' => $log['user_id'],
			'username' => $log['username']
		);
	}
	$jsonReturn = json_encode($returnData);
	echo $jsonReturn;
}
?> 
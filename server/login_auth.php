<?php 
session_start();
//Grab database credentials
include 'credentials.cfg.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
//Retrieving ajax posted data
$username = $_POST['username'];
$password = $_POST['password'];

if ($username == "" || $password == "") {
	echo "Please fill all fields!";
	return false;
}

//Read the user names table on the server to make sure it's ok
$sql = "SELECT * 
				FROM users
				WHERE username = '$username'
				AND password = '$password'";
$loginResult = mysqli_query($conn,$sql);

if ($loginResult -> num_rows == 0) {
	echo "We do not have that username / password combination on our system";
} else {
	//Sign them in to session
	while ($log = mysqli_fetch_assoc($loginResult)) {
		$_SESSION['user_id'] = $log['user_id'];
		$_SESSION['user'] = $log['username'];
	}
	echo "success";
}


// if ($conn->query($sql) === TRUE) {
//   echo "Succesfully added " . $newCat . ".";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }



?> 
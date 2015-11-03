<?php
session_start(); //Start session to place new user, if accepted,
if ($_SESSION['user'] != "Admin" && $_SESSION['user'] != "admin") {
		header("location:index.php");
	}

//Grab database credentials
include 'server/credentials.cfg.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	
	die("Connection failed: " . $conn->connect_error);
} 

include('header.php');?>

<body>

<h2>Enter new user:</h2>

<?php
echo "<form id='new_user' action='edit_user.php' method='post' accept-charset='utf-8'>
		  	User Name: <input type='text' name='username' value='' placeholder=''><br>
		  	Password: <input type='password' name='password' value='' placeholder=''><br>
				<input type='submit' value='Add User'>
	  	</form>";
// $sql = "SELECT * 
// 				FROM users";
// $users = mysqli_query($conn,$sql);
// while ($user = mysqli_fetch_assoc($categories)) {
// 	//Create header for the sub table
//   echo $user["username"];
//   echo "<form id='rem_user' action='edit_user.php' method='post' accept-charset='utf-8'>
// 		  	<input type='hidden' name='user-id' value='' placeholder=''><br>
// 				<input type='submit' value='Remove User'>
// 	  	</form>";
// }

echo "<a href='index.php'>Return Home</a><br>"
?>

</body>


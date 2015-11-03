<?php
session_start(); //Start session to place new user, if accepted,
if ($_SESSION['user'] != "") {
		header("location:index.php");
	}
?>

<?php include('header.php');?>
<body>

<h2>Please log in:</h2>

<?php
echo "<form id='login' action='index.php' method='post' accept-charset='utf-8'>
		  	User Name: <input type='text' name='username' value='' placeholder=''><br>
		  	Password: <input type='password' name='password' value='' placeholder=''><br>
				<input type='submit' value='Log In'>
	  	</form>";
?>

</body>


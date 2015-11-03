<?php
echo "<div id='banner' class='banner'>";
echo "<div id='menu-button'></div>";
echo "<h1>Erlenmeyer Stock</h1>";

//Log in welcome / log out
echo "Welcome, " . $_SESSION['user'] . ".<br>";
echo "<a href='server/logout.php'>Log Out</a><br>";

if ($_SESSION['user'] == "admin" || $_SESSION['user'] == "Admin") {
	echo "<a href='edit_user.php'>Edit Users</a><br>";
}
echo "</div>";
?>
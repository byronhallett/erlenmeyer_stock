<?php session_start();
if ($_SESSION['user'] == "") {
		header("location:login.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include('header.php');?>
	<body>

	<?php 
	include('banner_view.php');
	include('list_view.php');
	include('controls_view.php');
	?>
		
	</body>
</html>
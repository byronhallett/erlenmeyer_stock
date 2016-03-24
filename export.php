<?php
//Import credentials for server:
include 'server/credentials.cfg.php';
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=erlenmeyer_stock.csv');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

//Store the date values for the query, verify dates have been added:
date_default_timezone_set("Australia/Sydney");
$dateFrom = date('Y-m-d H:i:s',strtotime($_POST['date-from']));
$dateTo = date('Y-m-d H:i:s',strtotime($_POST['date-to']."24:00:00"));
$userId = $_POST['user-id'];

if ($dateFrom == "" || $dateTo == "") {
		exit("Please fill all fields!");
}

//OUTPUT and fetch
//// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
//Output date range
fputcsv($output, array('Date From:',$_POST['date-from']));
fputcsv($output, array('Date To:',$_POST['date-to']));

// output the column headings
fputcsv($output, array('Transaction ID', 'Item Name', 'Category Name', 'Sales (reduction)', 'Restock (addition)', 'Overall Change', 'Value', 'Cost', 'Profit / Loss' ,'Time Stamp'));

// fetch the sale data
$sql = "SELECT s.sale_id, i.item_name, c.category_name, s.sale_count, i.price, i.cost ,s.sale_date
				FROM items i
					inner join sale s on i.item_id = s.item_id
					inner join categories c on i.category_id = c.category_id
				WHERE s.sale_date >= '$dateFrom'
				AND s.sale_date <= '$dateTo'
				AND c.created_by = '$userId'
				ORDER BY s.sale_date DESC";
$sales = mysqli_query($conn,$sql);

// loop over the rows, outputting them
while ($row = mysqli_fetch_assoc($sales)) {
	$row['sale_count'] *= -1;
	array_splice($row, 4, 0, '');
	array_splice($row, 5, 0, $row['sale_count']);
	array_splice($row, 8, 0,  -$row['sale_count'] * $row[price]);
	fputcsv($output, $row);
}

// fetch the data for restocking
$sql = "SELECT r.restock_id, i.item_name, c.category_name, r.restock_count, i.price, i.cost, r.restock_date
				FROM items i
					inner join restock r on i.item_id = r.item_id
					inner join categories c on i.category_id = c.category_id
				WHERE r.restock_date >= '$dateFrom'
				AND r.restock_date <= '$dateTo'
				AND c.created_by = '$userId'
				ORDER BY r.restock_date DESC";
$restock = mysqli_query($conn,$sql);

// loop over the rows, outputting them
while ($row = mysqli_fetch_assoc($restock)) {
	$row['cost'] *= -$row['restock_count'];
	array_splice($row, 3, 0, '');
	array_splice($row, 5, 0, $row['restock_count']);
	fputcsv($output, $row);
}

?>

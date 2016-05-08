<?php
//Import credentials for server:
include 'server/credentials.cfg.php';
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=erlenmeyer_stock_levels.csv');


//OUTPUT and fetch
$userId = $_POST['user-id'];
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Item', 'category', 'count', 'value', 'cost', 'asset value'));

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: ".$conn->connect_error);
}

// loop over the rows, outputting them
$sql = "SELECT i.item_id, i.item_name, c.category_name, i.price, i.cost
        FROM items as i
        JOIN categories as c on i.category_id = c.category_id
        -- WHERE c.created_by = '$_SESSION[user_id]'
        WHERE c.created_by = $userId
        ORDER BY c.ordering ASC";

$items = mysqli_query($conn, $sql);

//Now iterate though items in this category to create rows
while ($item = mysqli_fetch_assoc($items)) {
  $currentStock = 0;
  $sql = "SELECT * FROM sale
          WHERE item_id = '$item[item_id]'";
  $sales = mysqli_query($conn, $sql);

  while ($sale = mysqli_fetch_assoc($sales)) {
    $currentStock -= $sale['sale_count'];
  }
  $sql = "SELECT * FROM restock
          WHERE item_id = '$item[item_id]'";
  $restocks = mysqli_query($conn, $sql);

  while ($restock = mysqli_fetch_assoc($restocks)) {
    $currentStock += $restock['restock_count'];
  }

  $assetValue = $item['cost'] * $currentStock;

  // Write this to the file
  fputcsv($output, array($item['item_name'], $item['category_name'],
          $currentStock, $item['price'], $item['cost'], $assetValue));
}
?>

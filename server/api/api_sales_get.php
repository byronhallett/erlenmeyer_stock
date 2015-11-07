<?php

//mySQL settings
include '../credentials.cfg.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: ".$conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

//Arrays for return data
$salesData = array(
);

// Will contain for each entry
//
// array ('itemId' => id,
// 'itemName' => name,
// 'salePrice' => price,
// 'saleCost' => cost)

// query variables
$dateFrom = $data['date_start'];
$dateTo   = $data['date_end'];
$userId   = $data['user_id'];

// prepare query
$sql = "SELECT s.sale_id, i.item_name, i.price, i.cost, c.category_name, s.sale_count, s.sale_date
        FROM sales s
          inner join items i on s.item_id = i.item_id
          inner join categories c on i.category_id = c.category_id
        WHERE s.sale_date >= '$dateFrom'
        AND s.sale_date <= '$dateTo'
        AND c.created_by = '$userId'
        ORDER BY s.sale_date DESC";

// Fetch data
$salesData = mysqli_query($conn, $sql);

// loop over the rows, outputting them
if ($salesData->num_rows > 0) {
	while ($row = mysqli_fetch_assoc($salesData)) {

		$thisSale = array(
			'itemId'    => 0,
			'itemName'  => "",
			'salePrice' => 0,
			'saleCost'  => 0,
		);

		$saleArray['itemId']    = $row['item_id'];
		$saleArray['itemName']  = $row['item_name'];
		$saleArray['salePrice'] = $row['sale_count']*$row['price'];
		$saleArray['saleCost']  = $row['sale_count']*$row['cost'];

		array_push($salesData, $thisSale);
	}

	$jsonReturn = json_encode($salesData);
	echo $jsonReturn;

} else {
	echo "No Sales";
}
?>
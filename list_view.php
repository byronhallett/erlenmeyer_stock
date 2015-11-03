<?php
echo "<div id ='list' class='list'>";
echo "<h2>Stock List</h2>";

//mySQL settings
include 'server/credentials.cfg.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

//Build categories
// individual table per cat
$sql = "SELECT * 
				FROM categories
				WHERE created_by = '$_SESSION[user_id]'
				ORDER BY ordering ASC";
$categories = mysqli_query($conn,$sql);

//Arrays for populating forms
$categoryArray = array(
	'category_id' => array(),
	'category_name' => array()	
	);
$itemArray = array(
	'item_id' => array(),
	'item_name' => array(),
	'category_name' => array()
	);

if ($categories -> num_rows > 0) {
	while ($cat = mysqli_fetch_assoc($categories)) {
		//Create header for the sub table
	  echo "<h3>" . $cat["category_name"] . "</h3>"; 
	  
	  //Add this to an array to populate selects later
	  array_push($categoryArray['category_id'], $cat['category_id']);
	  array_push($categoryArray['category_name'], $cat['category_name']);
	
  	//Collect list of items which beloing to this category
  	$sql = "SELECT * 
  					FROM items	
  					WHERE category_id = '$cat[category_id]'
  					ORDER BY item_name ASC";

		$items = mysqli_query($conn,$sql);

	  //Insert table for item population
	  echo "<table>
		  		<thead>
			  		<tr>
			  			<th class='itemH'>Item</th>
			  			<th class='stockH'>Current Stock</th>
			  			<th class='restockH'>Restock</th>
			  			<th class='sellH'>Sell</th>
			  		</tr>
			  	</thead>
			  	<tbody>";
		//Now iterate though items in this category to create rows
		while ($item = mysqli_fetch_assoc($items)) {
			//Push item in to array for forms later
			array_push($itemArray['item_id'], $item["item_id"]);
			array_push($itemArray['item_name'], $item["item_name"]);
			array_push($itemArray['category_name'], $cat["category_name"]);

			//TODO: Lookup items buy and sells to learn current stock
			$currentStock = 0;
			$sql = "SELECT * FROM sale 
							WHERE item_id = '$item[item_id]'";
			$sales = mysqli_query($conn,$sql);

			while ($sale = mysqli_fetch_assoc($sales)) {
				$currentStock -= $sale['sale_count'];
			}
			$sql = "SELECT * FROM restock 
							WHERE item_id = '$item[item_id]'";
			$restocks = mysqli_query($conn,$sql);

			while ($restock = mysqli_fetch_assoc($restocks)) {
				$currentStock += $restock['restock_count'];
			}
			//Now you have the current stock, place him in the document, 
			//and let js handle him for the rest of the session


  		echo "<tr>";
  		echo "	<td>".$item["item_name"]."</td>
  	  				<td id=count-id".$item['item_id'].">".$currentStock."</td>
		 					<td><button onclick='RestockButton(".$item['item_id'].")')>Restock</button></td> 
		  				<td><button onclick='SellButton(".$item['item_id'].")')>Sell</button></td> 
	  				</tr>";
		}
		echo "</tbody>
					</table>";
	}
} else {
	echo "<br>You have no categories. Please add one from the control panel to get started<br>";
}

echo "</div>";
?>
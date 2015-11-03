<?php

//mySQL settings
include '../credentials.cfg.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

//Arrays for populating forms
$returnData = array (
  'category_array' => array(
  ),
  'item_array' => array(
  )
);

//Build categories
$sql = "SELECT * 
        FROM categories
        WHERE created_by = '$data[user_id]'
        ORDER BY ordering ASC";

$categories = mysqli_query($conn,$sql);

if ($categories -> num_rows > 0) {
  while ($cat = mysqli_fetch_assoc($categories)) {
    
    //Add this to an array to populate selects later
    array_push($returnData['category_array'],array('category_id' => $cat['category_id'],
     'category_name' => $cat['category_name']));
  
    //Collect list of items which beloing to this category
    $sql = "SELECT * 
            FROM items  
            WHERE category_id = '$cat[category_id]'
            ORDER BY item_name ASC";

    $items = mysqli_query($conn,$sql);

    //Now iterate though items in this category to create rows
    while ($item = mysqli_fetch_assoc($items)) {

      //Lookup items buy and sells to learn current stock
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

      //Push item in to array to return
      array_push($returnData['item_array'], array('item_id' => $item['item_id'],
        'item_name' => $item['item_name'],
        'category_id' => $cat['category_id'],
        'current_stock' => $currentStock));
      
      
      
    }
  }
  $jsonReturn = json_encode($returnData);
  echo $jsonReturn;
}
?> 
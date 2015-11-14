<?php

//Begin the control forms to be handled by ajax
echo "<div id='list-controls' class='list-controls'>";
echo "<h2>List Controls</h2>";

//New category form:
echo "<form id='new-cat' action='index.php' method='post' accept-charset='utf-8'>
      <input type='hidden' name='user-id' value='".$_SESSION['user_id']."'>
      New Category: <input type='text' name='cat-box'>
      <input type='submit' tabindex=-1>
      </form>";
//END new category form

//move category form:
echo "<form id='move-cat' action='index.php' method='post' accept-charset='utf-8'>
      Move Category: <select id='move-cat' name='move-cat'>";
for ($i = 0; $i < sizeof($categoryArray['category_id']); $i++) {
	echo "<option value=".$categoryArray['category_id'][$i].">
        ".$categoryArray['category_name'][$i]."</option>";
}
echo "</select><br><br>
      --> <select name='before-after'>
      <option value='before'>before</option>
      <option value='after'>after</option>
      </select>
<select id='to-cat' name='to-cat'>";
for ($i = 0; $i < sizeof($categoryArray['category_id']); $i++) {
	echo "<option value=".$categoryArray['category_id'][$i].">
        ".$categoryArray['category_name'][$i]."</option>";
}
echo "</select>
      <input type='submit' value='Reorder' tabindex=-1>
    </form>";
//END move category form

//Remove category form:
echo "<form id='rem-cat' action='index.php' method='post' accept-charset='utf-8'>
      Remove Category: <select name='cat-id'>";
for ($i = 0; $i < sizeof($categoryArray['category_id']); $i++) {
	echo "<option value=".$categoryArray['category_id'][$i].">
        ".$categoryArray['category_name'][$i]."</option>";
}
echo "</select>
<input type='submit' value='Remove Category' tabindex=-1>
    </form>";
//END remove category form

//New item form:
echo "<form id='new-item' action='index.php' method='post' accept-charset='utf-8'>
      New Item: <input type='text' name='item'>
      <select name='item-cat'>";
for ($i = 0; $i < sizeof($categoryArray['category_id']); $i++) {
	echo "<option value=".$categoryArray['category_id'][$i].">
        ".$categoryArray['category_name'][$i]."</option>";
}
echo "</select>
      <input type='submit' tabindex=-1>
      </form>";
//END new item form

//Edit item price and cost form:
echo "<form id='item-price-cost' action='index.php' method='post' accept-charset='utf-8'>
      For item: <select name='item-id'>";
for ($i = 0; $i < sizeof($itemArray['item_id']); $i++) {
	echo "<option value=".$itemArray['item_id'][$i].">
        ".$itemArray[item_name][$i]." - ".$itemArray[category_name][$i]."</option>";
}
echo "</select>, set:<br>
        price to:
        <input type='text' name='price-value'><br>
        cost to:
        <input type='text' name='cost-value'>
        <input type='submit' value='Set' tabindex=-1>
      </form>";
//END edit item price and cost form

//Remove item form:
echo "<form id='rem-item' action='index.php' method='post' accept-charset='utf-8'>
      Remove Item: <select name='item-id'>";
for ($i = 0; $i < sizeof($itemArray['item_id']); $i++) {
	echo "<option value=".$itemArray['item_id'][$i].">
        ".$itemArray[item_name][$i]." - ".$itemArray[category_name][$i]."</option>";
}
echo "</select>
<input type='submit' value='Remove Item' tabindex=-1>
    </form>";
//END remove item form

//Export form:
date_default_timezone_set("Australia/Sydney");
$today     = date('Y-m-d');
$lastMonth = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));

echo "<form id='export' action='export.php' method='post' accept-charset='utf-8'>
        <input type='hidden' name='user-id' value='".$_SESSION['user_id']."'>
        Export From: <input type='date' name='date-from' value='".$lastMonth."' placeholder=''>
        Until: <input type='date' name='date-to' value='".$today."' placeholder=''>
        <input type='submit' value='EXPORT' tabindex=-1>
      </form>";
//END export form
echo "</div>";
?>
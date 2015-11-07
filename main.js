// wait for the DOM to be loaded 
$(document).ready(function() { 

  $('#new_user').ajaxForm(function() { 
    // create a new user from the admin panel
    $.ajax({
       type: "POST",
       url: "./server/new_user.php",
       data: $('#new_user').serialize(),
       success: function(data)
       {  
          if (jQuery.trim(data) != "") {
            alert(data); // show response from the php script.
            location.reload();
          }
        }
    });
  });

  $('#login').ajaxForm(function() { 
    // Log users in
    $.ajax({
       type: "POST",
       url: "./server/login_auth.php",
       data: $('#login').serialize(),
       success: function(data)
       {  
          if (jQuery.trim(data).indexOf("success") <= -1) {
            alert(data); // show response from the php script.
          } else {
            // alert("success");
            location.reload();
          }
        }
    });
  });

  // Update the price using a small sql update request
  $('#item-price').ajaxForm(function() { 
    $.ajax({
       type: "POST",
       url: "./server/item_price.php",
       data: $('#item-price').serialize(),
       success: function(data)
       {
          if (jQuery.trim(data) != "") {
            alert(data); // show response from the php script.
            location.reload();
          }
        }
    });
  });

  // Update the cost using a small sql update request
  $('#item-cost').ajaxForm(function() { 
    $.ajax({
       type: "POST",
       url: "./server/item_cost.php",
       data: $('#item-cost').serialize(),
       success: function(data)
       {
          if (jQuery.trim(data) != "") {
            alert(data); // show response from the php script.
            location.reload();
          }
        }
    });
  });

  // bind 'myForm' and provide a simple callback function 
  $('#move-cat').ajaxForm(function() { 
    $.ajax({
       type: "POST",
       url: "./server/re_cat.php",
       data: $('#move-cat').serialize(), // serializes the form's elements.
       success: function(data)
       {
           if (jQuery.trim(data) != "") {
              alert(data); // show response from the php script.
              location.reload(); //Since this will require rebuilding of the table, reload
            }
       }
    }); 
  });

  // bind 'myForm' and provide a simple callback function 
  $('#new-cat').ajaxForm(function() { 
		$.ajax({
       type: "POST",
       url: "./server/new_cat.php",
       data: $('#new-cat').serialize(), // serializes the form's elements.
       success: function(data)
       {
           if (jQuery.trim(data) != "") {
              alert(data); // show response from the php script.
              location.reload(); //Since this will require rebuilding of the table, reload
            }
       }
    });	
  });

  $('#new-item').ajaxForm(function() { 
   	$.ajax({
  	   type: "POST",
       url: "./server/new_item.php",
       data: $('#new-item').serialize(), // serializes the form's elements.
       success: function(data)
       {
           if (jQuery.trim(data) != "") {
              alert(data); // show response from the php script.
              location.reload(); //Since this will require rebuilding of the table, reload
            }
       }
    });	
  });

  $('#rem-item').ajaxForm(function() { 
  	$.ajax({
       type: "POST",
       url: "./server/rem_item.php",
       data: $('#rem-item').serialize(), // serializes the form's elements.
       success: function(data)
       {
           if (jQuery.trim(data) != "") {
              alert(data); // show response from the php script.
              location.reload(); //Since this will require rebuilding of the table, reload
            }
       }
    });	
  });

  $('#rem-cat').ajaxForm(function() { 
  	$.ajax({
       type: "POST",
       url: "./server/rem_cat.php",
       data: $('#rem-cat').serialize(), // serializes the form's elements.
       success: function(data)
       {
           if (jQuery.trim(data) != "") {
              alert(data); // show response from the php script.
              location.reload(); //Since this will require rebuilding of the table, reload
            }
       }
    });	
  });

  window.SellButton = function (itemId) {
  	// For now, script assumes that each press of sell is for single sale.
  	var sell = parseInt (prompt("How many sold?",1)); ;
    if (sell > 0) {
      //Trigger a sell action in the database
      $.ajax({
         type: "POST",
         url: "./server/sell.php",
         data: {sellAmount: sell,
                item_id: itemId},
         success: function(data)
         {
            if (jQuery.trim(data) != ""){
             alert(data); // show response from the php script.
            }
         }
      }); 
      //Update front end quickly, assuming that server changes were succesful
      var cellId = "count-id" + itemId;
      var previousInt = parseInt(document.getElementById(cellId).innerHTML);
      document.getElementById(cellId).innerHTML = previousInt - sell;
    }
  }

  window.RestockButton = function (itemId) {
  	//Collects user input about restock volume
  	var restock = parseInt (prompt("How many bought?",1)); 
    if (restock > 0) {
    	//Trigger a restock action in the database
    	$.ajax({
         type: "POST",
         url: "./server/restock.php",
         data: {restockAmount: restock,
                item_id: itemId},
         success: function(data)
         {
            if (jQuery.trim(data) != ""){
             alert(data); // show response from the php script.
            }
          }
      });
    	//Update front end quickly, and assume that server changes were succesful
    	var cellId = "count-id" + itemId;
    	var previousInt = parseInt(document.getElementById(cellId).innerHTML);
    	document.getElementById(cellId).innerHTML = previousInt + restock;
    }
  }
}); 
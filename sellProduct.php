<?php
  require 'config/config.php';

  if(!isset($_SESSION['username'])){
    header('Location: login.php');
  }

  $notifications = array();

  if(isset($_POST['sellProduct'])){
    $productName = mysqli_real_escape_string($connect, htmlspecialchars($_POST['productName']));
    $sellQuantity = mysqli_real_escape_string($connect, htmlspecialchars($_POST['quantity']));
    $customerNumber = mysqli_real_escape_string($connect, htmlspecialchars($_POST['customerPhoneNumber']));
    
    $inventoryQuery = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$productName'");
    $num_results = mysqli_num_rows($inventoryQuery);
    $results = mysqli_fetch_array($inventoryQuery);
    
    $customerQuery = mysqli_query($connect, "SELECT * FROM customers WHERE phone_number = '$customerNumber'");
    $num_customer_results = mysqli_num_rows($customerQuery);
    $customerResults = mysqli_fetch_array($customerQuery);
    
    if($num_results == 0){
      array_push($notifications, "Product does not exist");
    }
    
    elseif($num_customer_results == 0){
      array_push($notifications, "Customer does not exist");
    }
    
    elseif($num_results == 1 && $num_customer_results == 1){
      $inventoryQuantity = $results['quantity'];
      $customerName = $customerResults['customer_name'];
      $customerId = $customerResults['customer_id'];
      $date = new DateTime("now");
      $dateString = $date->format('Y-m-d H:i:s');
      $price = $results['price'];
      $calcPrice = (int) preg_replace("/([^0-9\\.])/i", "", $price);
      $total = $calcPrice * $sellQuantity;
      $displayTotal = "$" . $total . ".00";
      
      if($sellQuantity <= 0){
        array_push($notifications, "Quantity must be a positive number");
      }
      
      elseif($inventoryQuantity <= 0){
        array_push($notifications, "Product is not in stock");
      }
      
      elseif(($inventoryQuantity - $sellQuantity) < 0){
        array_push($notifications, "Not enough product in stock to fill order");
      }
      
      else{
        $saleQuery = mysqli_query($connect, "INSERT INTO sales VALUES ('', '$customerId', '$customerName', '$customerNumber', '$productName', '$sellQuantity', '$dateString', '$displayTotal', 'Sold')");
        
        $newInventoryQuantity = $inventoryQuantity - $sellQuantity;
        
        $updateQuery = mysqli_query($connect, "UPDATE products SET quantity = '$newInventoryQuantity' WHERE product_name = '$productName'");

        array_push($notifications, "Product Sold");
      }
    }
  }
?>

<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>Sell Product</title>
  
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<header>
      <div class="headerdiv">
        <a href="employeeHome.php"><h1 id="headerlogo">Stockify</h1></a>

        <nav class="headerlinks">
          <a href="employeeHome.php"><b>Home</b></a>
          <a href="logout.php"><b>Logout</b></a>
        </nav>
      </div>
	</header>
	
	<main>
	   <div class="container">
        <center>
          <h1 class="title">Sell Product</h1>
          
          <form action="sellProduct.php" method="post" autocomplete="off">
            <input type="text" name="productName" placeholder="Product Name" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <input type="tel" name="customerPhoneNumber" placeholder="Phone Number: 123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" autocomplete="off" required>
            
            <br>
            
            <input type="submit" name="sellProduct" value="Sell Product">
        
            <br>
            
            <?php 
              if(in_array("Product does not exist", $notifications)) {
                echo "<p style='color: white'>Product does not exist</p>";
              }
            
              if(in_array("Customer does not exist", $notifications)) {
                echo "<p style='color: white'>Customer does not exist</p>";
              }
            
              if(in_array("Product Sold", $notifications)) {
                echo "<p style='color: white'>Product Sold</p>";
              }
            
              if(in_array("Product is not in stock", $notifications)) {
                echo "<p style='color: white'>Product is not in stock</p>";
              }
            
              if(in_array("Not enough product in stock to fill order", $notifications)) {
                echo "<p style='color: white'>Not enough product in stock to fill order</p>";
              }
            
              if(in_array("Quantity must be a positive number", $notifications)) {
                echo "<p style='color: white'>Quantity must be a positive number</p>";
              }
            ?>
          </form>
        </center>
      </div>
	</main>
	
	<footer>
	
	</footer>
</body>
</html>

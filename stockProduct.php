<?php
  require 'config/config.php';

  if(!isset($_SESSION['username'])){
    header('Location: login.php');
  }

  $notifications = array();

  if(isset($_POST['stockProduct'])){
    $productName = mysqli_real_escape_string($connect, htmlspecialchars($_POST['productName']));
    $stockQuantity = mysqli_real_escape_string($connect, htmlspecialchars($_POST['quantity']));
    
    $query = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$productName'");
    $num_results = mysqli_num_rows($query);
    $results = mysqli_fetch_array($query);
    $inventoryQuantity = $results['quantity'];
    
    if($num_results == 0){
      array_push($notifications, "Product does not exist");
    }
    
    elseif($num_results == 1){
      if($stockQuantity <= 0){
        array_push($notifications, "Quantity must be a positive number");
      }
      
      else{
        $inventoryQuantity += $stockQuantity;
        $stockQuery = mysqli_query($connect, "UPDATE products SET quantity = '$inventoryQuantity' WHERE product_name = '$productName'");

        array_push($notifications, "Product Stocked");
      }
    }
  }
?>

<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>Stock Product</title>
  
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
          <h1 class="title">Stock Product</h1>
          
          <form action="stockProduct.php" method="post" autocomplete="off">
            <input type="text" name="productName" placeholder="Product Name" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            
            <br>
            
            <input type="submit" name="stockProduct" value="Stock Product">
        
            <br>
            
            <?php 
              if(in_array("Product does not exist", $notifications)) {
                echo "<p style='color: white'>Product does not exist</p>";
              }
            
              if(in_array("Product Stocked", $notifications)) {
                echo "<p style='color: white'>Product Stocked</p>";
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
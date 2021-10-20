<?php
  require 'config/config.php';

  if(!isset($_SESSION['username'])){
      header('Location: login.php');
    }
 
  $notifications = array();

  if(isset($_POST['createProduct'])){
    $productName = mysqli_real_escape_string($connect, htmlspecialchars($_POST['productName']));
    $quantity = mysqli_real_escape_string($connect, htmlspecialchars($_POST['quantity']));
    $bufferStock = mysqli_real_escape_string($connect, htmlspecialchars($_POST['bufferStock']));
    $leadTime = mysqli_real_escape_string($connect, htmlspecialchars($_POST['leadTime']));
    $attributes = mysqli_real_escape_string($connect, htmlspecialchars($_POST['attributes']));
    $dateAdded = new DateTime("now");
    $dateString = $dateAdded->format('Y-m-d H:i:s');
    
    $query = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$productName'");
    $num_results = mysqli_num_rows($query);
    
    if($num_results == 1){
      array_push($notifications, "Product already exists");
    }
    
    elseif($num_results == 0){
      if($leadTime > 5 || $leadTime < 1){
        array_push($notifications, "Lead time must be a value between 1 and 5");
      }
      
      elseif($quantity <= 0){
        array_push($notifications, "Quantity must be a positive number");
      }
      
      else{
        $query2 = mysqli_query($connect, "INSERT INTO products VALUES ('', '$productName', '$quantity', '$bufferStock', '$leadTime', '', '$dateString', '$attributes')");
        
        array_push($notifications, "Product Created");
      }
    }
  }
?>

<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>Create Product</title>
  
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<header>
      <div class="headerdiv">
        <a href="managerHome.php"><h1 id="headerlogo">Stockify</h1></a>

        <nav class="headerlinks">
          <a href="managerHome.php"><b>Home</b></a>
          <a href="logout.php"><b>Logout</b></a>
        </nav>
      </div>
	</header>
	
	<main>
	   <div class="container">
        <center>
          <h1 class="title">Create Product</h1>
          
          <form action="createProduct.php" method="post" autocomplete="off">
            <input type="text" name="productName" placeholder="Product Name" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <input type="number" name="bufferStock" placeholder="Buffer Stock" required>
            
            <br>
            
            <input type="number" name="leadTime" placeholder="Lead Time: Value 1-5" required>
            <input type="text" name="attributes" placeholder="Attributes" required>
            
            <br>
            
            <input type="submit" name="createProduct" value="Create Product">
        
            <br>
            
            <?php 
              if(in_array("Product already exists", $notifications)) {
                echo "<p style='color: white'>Product already exists</p>";
              }
            
              if(in_array("Lead time must be a value between 1 and 5", $notifications)) {
                echo "<p style='color: white'>Lead time must be a value between 1 and 5</p>";
              }
            
              if(in_array("Product Created", $notifications)) {
                echo "<p style='color: white'>Product Created</p>";
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

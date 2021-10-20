<?php
  require 'config/config.php';

  if(!isset($_SESSION['username'])){
    header('Location: login.php');
  }

  $notifications = array();
  
  $productName = mysqli_real_escape_string($connect, htmlspecialchars($_POST['productName']));

  $query = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$productName'");
  $num_results = mysqli_num_rows($query);
  $results = mysqli_fetch_array($query);

  if(isset($_POST['search'])){ 
    $_SESSION['productName'] = $productName;
    
    $productName = '';
    
    if($num_results == 0){
      array_push($notifications, "Product does not exist");
      unset($_SESSION['productName']);
    }
    
    elseif($num_results == 1){
      $productName = $results['product_name'];
      $quantity = $results['quantity'];
      $bufferStock = $results['buffer_stock'];
      $leadTime = $results['lead_time'];
      $attributes = $results['attributes'];
    }
  }

   if(isset($_POST['updateName'])){ 
     if(isset($_SESSION['productName'])){
       $pn = $_SESSION['productName'];
       $q = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$pn'");
       $r = mysqli_fetch_array($q);
       $productId = (int) $r['product_id'];
     }
     
     $newProductName = mysqli_real_escape_string($connect, htmlspecialchars($_POST['newProductName']));
     
     $query = mysqli_query($connect, "UPDATE products SET product_name = '$newProductName' WHERE product_id = '$productId'");
     
     array_push($notifications, "Product Name Updated");
     
     unset($_SESSION['productName']);
   }

   if(isset($_POST['updateQuantity'])){  
     if(isset($_SESSION['productName'])){
       $pn = $_SESSION['productName'];
       $q = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$pn'");
       $r = mysqli_fetch_array($q);
       $productId = (int) $r['product_id'];
     }
     
     $quantity = mysqli_real_escape_string($connect, htmlspecialchars($_POST['quantity']));
     
      if($quantity <= 0){
        array_push($notifications, "Quantity must be a positive number");
      }
     
     else{
      $query = mysqli_query($connect, "UPDATE products SET quantity = '$quantity' WHERE product_id = '$productId'");
     
      array_push($notifications, "Product Quantity Updated");
       
      unset($_SESSION['productName']);
     }
   }

   if(isset($_POST['updateBufferStock'])){   
     if(isset($_SESSION['productName'])){
       $pn = $_SESSION['productName'];
       $q = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$pn'");
       $r = mysqli_fetch_array($q);
       $productId = (int) $r['product_id'];
     }
     
     $bufferStock = mysqli_real_escape_string($connect, htmlspecialchars($_POST['bufferStock']));
     
     $query = mysqli_query($connect, "UPDATE products SET buffer_stock = '$bufferStock' WHERE product_id = '$productId'");
     
     array_push($notifications, "Product Buffer Stock Updated");
     
     unset($_SESSION['productName']);
   }

  if(isset($_POST['updateLeadTime'])){ 
    if(isset($_SESSION['productName'])){
       $pn = $_SESSION['productName'];
       $q = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$pn'");
       $r = mysqli_fetch_array($q);
       $productId = (int) $r['product_id'];
     }
    
     $leadTime = mysqli_real_escape_string($connect, htmlspecialchars($_POST['leadTime']));
     
     if($leadTime > 5 || $leadTime < 1){
        array_push($notifications, "Lead time must be a value between 1 and 5");
      }
    
     else{
       $query = mysqli_query($connect, "UPDATE products SET lead_time = '$leadTime' WHERE product_id = '$productId'");
     
       array_push($notifications, "Product Lead Time Updated");
       
       unset($_SESSION['productName']);
     }
   }

  if(isset($_POST['updateAttributes'])){     
    if(isset($_SESSION['productName'])){
       $pn = $_SESSION['productName'];
       $q = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$pn'");
       $r = mysqli_fetch_array($q);
       $productId = (int) $r['product_id'];
     }
    
     $attributes = mysqli_real_escape_string($connect, htmlspecialchars($_POST['attributes']));
     
     $query = mysqli_query($connect, "UPDATE products SET attributes = '$attributes' WHERE product_id = '$productId'");
     
     array_push($notifications, "Product Attributes Updated");
    
     unset($_SESSION['productName']);
   }
?>

<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>Update Product</title>
  
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
          <h1 class="title">Update Product</h1>
          
          <form action="updateProduct.php" method="post" autocomplete="off">
            <input type="text" name="productName" placeholder="Product Name" value="<?php if(isset($_SESSION['productName'])){echo $_SESSION['productName']; } ?>" required>
            <input type="submit" name="search" value="Product Search">
            
            <br>
            
            <?php 
              if(in_array("Product does not exist", $notifications)) {
                echo "<p style='color: white'>Product does not exist</p>";
              }
            ?>
          </form>
          
          <hr>
          
          <form action="updateProduct.php" method="post" autocomplete="off">
            <input type="text" name="newProductName" placeholder="Product Name" value="<?php if(isset($productName)){echo $productName;} ?>" required <?php if($num_results == 0){echo "disabled";} ?>>
            <input type="submit" name="updateName" value="Update Product Name" <?php if($num_results == 0){echo "disabled";} ?>>
            
            <br>
            
            <?php            
              if(in_array("Product Name Updated", $notifications)) {
                echo "<p style='color: white'>Product Name Updated</p>";
              }
            ?>
          </form>
          
          <form action="updateProduct.php" method="post" autocomplete="off">
            <input type="number" name="quantity" placeholder="Quantity" value="<?php if(isset($quantity)){echo $quantity;} ?>" required <?php if($num_results == 0){echo "disabled";} ?>>
            <input type="submit" name="updateQuantity" value="Update Quantity" <?php if($num_results == 0){echo "disabled";} ?>>
            
            <br>
            
            <?php            
              if(in_array("Product Quantity Updated", $notifications)) {
                echo "<p style='color: white'>Product Quantity Updated</p>";
              }
            
              if(in_array("Quantity must be a positive number", $notifications)) {
                echo "<p style='color: white'>Quantity must be a positive number</p>";
              }
            ?>
          </form>
            
          <form action="updateProduct.php" method="post" autocomplete="off">
            <input type="number" name="bufferStock" placeholder="Buffer Stock" value="<?php if(isset($bufferStock)){echo $bufferStock;} ?>" required <?php if($num_results == 0){echo "disabled";} ?>>
            <input type="submit" name="updateBufferStock" value="Update Buffer Stock" <?php if($num_results == 0){echo "disabled";} ?>>
            
            <br>
            
            <?php              
              if(in_array("Product Buffer Stock Updated", $notifications)) {
                echo "<p style='color: white'>Product Buffer Stock Updated</p>";
              }
            ?>
          </form>
          
          <form action="updateProduct.php" method="post" autocomplete="off">  
            <input type="number" name="leadTime" placeholder="Lead Time: Value 1-5" value="<?php if(isset($leadTime)){echo $leadTime;} ?>" required <?php if($num_results == 0){echo "disabled";} ?>>
            <input type="submit" name="updateLeadTime" value="Update Lead Time" <?php if($num_results == 0){echo "disabled";} ?>>
            
            <br>
            
            <?php             
              if(in_array("Lead time must be a value between 1 and 5", $notifications)) {
                echo "<p style='color: white'>Lead time must be a value between 1 and 5</p>";
              }
            
              if(in_array("Product Lead Time Updated", $notifications)) {
                echo "<p style='color: white'>Product Lead Time Updated</p>";
              }
            ?>
          </form>
          
          <form action="updateProduct.php" method="post" autocomplete="off">
            <input type="text" name="attributes" placeholder="Attributes" value="<?php if(isset($attributes)){echo $attributes;} ?>" required <?php if($num_results == 0){echo "disabled";} ?>>
            <input type="submit" name="updateAttributes" value="Update Attributes" <?php if($num_results == 0){echo "disabled";} ?>>
            
            <br>
            
            <?php   
              if(in_array("Product Attributes Updated", $notifications)) {
                echo "<p style='color: white'>Product Attributes Updated</p>";
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

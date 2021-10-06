<?php
require 'config/config.php';

  $notifications = array();

  if(isset($_POST['deleteProduct'])){
    $productName = mysqli_real_escape_string($connect, htmlspecialchars($_POST['productName']));
    
    $query = mysqli_query($connect, "SELECT * FROM products WHERE product_name = '$productName'");
    $num_results = mysqli_num_rows($query);
    
    if($num_results == 0){
      array_push($notifications, "Product does not exist");
    }
    
    elseif($num_results == 1){
      $deleteQuery = mysqli_query($connect, "DELETE FROM products WHERE product_name = '$productName'");
      
      array_push($notifications, "Product Deleted");
    }
  }
?>

<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>Delete Product</title>
  
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
          <h1 class="title">Delete Product</h1>
          
          <form action="deleteProduct.php" method="post">
            <input type="text" name="productName" placeholder="Product Name" required>
            
            <br>
            
            <input type="submit" name="deleteProduct" value="Delete Product">
        
            <br>
            
            <?php 
              if(in_array("Product does not exist", $notifications)) {
                echo "<p style='color: white'>Product does not exist</p>";
              }
            
              if(in_array("Product Deleted", $notifications)) {
                echo "<p style='color: white'>Product Deleted</p>";
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
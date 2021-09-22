<?php
  require 'config/config.php';

  $inventory = "";

  $inventoryQuery = mysqli_query($connect, "SELECT * FROM products ORDER BY product_name ASC");

  if(mysqli_num_rows($inventoryQuery) > 0){
    while($results = mysqli_fetch_array($inventoryQuery)){
      $productName = $results['product_name'];
      $quantity = $results['quantity'];
      
      $inventory .= "<tr>
                      <td>$productName</td>
                      <td>$quantity</td>
                     </tr>";
    }
  }
?>

<html lang="en-us">
<head>
  <meta charset="UTF-8">
  <title>Manager Home</title>
  
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <header>
    <div class="headerdiv">
      <a href="managerHome.php"><h1 id="headerlogo">Stockify</h1></a>
    
      <nav class="headerlinks">
        <a href="managerHome.php"><b>Home</b></a>
        <a href="login.php"><b>Logout</b></a>
      </nav>
    </div>
  </header>

  <main>
    <div class="pagelinksdiv">
      <nav class="pagelinksnav">
        <center>
          <a href=""><b>Product Analytics</b></a>
          <a href=""><b>Create Product</b></a>
          <a href=""><b>Update Product</b></a>
          <a href=""><b>Delete Product</b></a>
          <a href=""><b>Send Announcement</b></a>
        </center>
      </nav>
    </div>
    
    <div class="inventorydiv">
      <center>
        <table class="inventory">
          <tr>
            <th><b>Product Name</b></th>
            <th><b>Quantity</b></th>
          </tr>
          
          <?php echo $inventory; ?>
        </table>
      </center>
    </div>
  </main>

  <footer>

  </footer>
</body>
</html>

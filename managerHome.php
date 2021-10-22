<?php
  require 'config/config.php';

  if(!isset($_SESSION['username'])){
    header('Location: login.php');
  }

  $inventory = "";

  $inventoryQuery = mysqli_query($connect, "SELECT * FROM products ORDER BY product_name ASC");

  if(mysqli_num_rows($inventoryQuery) > 0){
    while($results = mysqli_fetch_array($inventoryQuery)){
      $productName = $results['product_name'];
      $quantity = $results['quantity'];
      $bufferStock = $results['buffer_stock'];
      $leadTime = $results['lead_time'];
      $dateAdded = $results['date_added'];
      $attributes = $results['attributes'];
      $price = $results['price'];
      
      $dateAddedCalc = date_create($results['date_added']);
      $todaysDate = new DateTime("now");
      $shelfAgeDiff = date_diff($dateAddedCalc, $todaysDate);
      
      $shelfAgeNum = $shelfAgeDiff->format('%a');
      
      if($shelfAgeNum == 1){
        $shelfAge = $shelfAgeDiff->format('%a Day');
        $query = mysqli_query($connect, "UPDATE products SET shelf_age = '$shelfAge' WHERE product_name = '$productName'");
      }
      
      else{
        $shelfAge = $shelfAgeDiff->format('%a Days');
        $query = mysqli_query($connect, "UPDATE products SET shelf_age = '$shelfAge' WHERE product_name = '$productName'");
      }
      
      $inventory .= "<tr>
                      <td>$productName</td>
                      <td>$price</td>
                      <td>$quantity</td>
                      <td>$bufferStock</td>
                      <td>$leadTime</td>
                      <td>$shelfAge</td>
                      <td>$dateAdded</td>
                      <td>$attributes</td>
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
        <a href="logout.php"><b>Logout</b></a>
      </nav>
    </div>
  </header>

  <main>
    <div class="pagelinksdiv">
      <nav class="pagelinksnav">
        <center>
          <a href=""><b>Product Analytics</b></a>
          <a href="createProduct.php"><b>Create Product</b></a>
          <a href="updateProduct.php"><b>Update Product</b></a>
          <a href="deleteProduct.php"><b>Delete Product</b></a>
          <a href="sendAnnouncement.php"><b>Send Announcement</b></a>
        </center>
      </nav>
    </div>
    
    <div class="inventorydiv">
      <center>
        <table class="inventory">
          <tr>
            <th><b>Product Name</b></th>
            <th><b>Price</b></th>
            <th><b>Quantity</b></th>
            <th><b>Buffer Stock</b></th>
            <th><b>Lead Time</b></th>
            <th><b>Total Days Selling Product</b></th>
            <th><b>Date Started Selling Product</b></th>
            <th><b>Attributes</b></th>
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

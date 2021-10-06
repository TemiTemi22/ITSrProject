<?php
  require 'config/config.php';

  if(!isset($_SESSION['username'])){
    header('Location: login.php');
  }

  $inventory = "";
  $announcements = "";

  $inventoryQuery = mysqli_query($connect, "SELECT * FROM products ORDER BY product_name ASC");

  if(mysqli_num_rows($inventoryQuery) > 0){
    while($results = mysqli_fetch_array($inventoryQuery)){
      $productName = $results['product_name'];
      $quantity = $results['quantity'];
      $bufferStock = $results['buffer_stock'];
      $leadTime = $results['lead_time'];
      $dateAdded = $results['date_added'];
      $attributes = $results['attributes'];
      
      $dateAddedCalc = date_create($results['date_added']);
      $todaysDate = new DateTime("now");
      $shelfAgeDiff = date_diff($dateAddedCalc, $todaysDate);
      
      $shelfAgeNum = $shelfAgeDiff->format('%a');
      
      if($shelfAgeNum == 1){
        $shelfAge = $shelfAgeDiff->format('%a Day');
      }
      
      else{
        $shelfAge = $shelfAgeDiff->format('%a Days');
      }
      
      $inventory .= "<tr>
                      <td>$productName</td>
                      <td>$quantity</td>
                      <td>$bufferStock</td>
                      <td>$leadTime</td>
                      <td>$shelfAge</td>
                      <td>$dateAdded</td>
                      <td>$attributes</td>
                     </tr>";
    }
  }

  $announcementsQuery = mysqli_query($connect, "SELECT * FROM messages ORDER BY message_id DESC LIMIT 3");

  if(mysqli_num_rows($announcementsQuery) > 0){
    while($results = mysqli_fetch_array($announcementsQuery)){
      $message = $results['message'];
      
      $announcements .= "<center>$message</center>
                         <br>
                         <hr>
                         <br>";
    }
  }
?>

<html lang="en-us">
<head>
  <meta charset="UTF-8">
  <title>Employee Home</title>
  
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <header class="headerdiv">
    <div>
      <a href="employeeHome.php"><h1 id="headerlogo">Stockify</h1></a>
    
      <nav class="headerlinks">
        <a href="employeeHome.php"><b>Home</b></a>
        <a href="logout.php"><b>Logout</b></a>
      </nav>
    </div>
  </header>

  <main>
    <div class="pagelinksdiv">
      <nav class="pagelinksnav">
        <center>
          <a href=""><b>Create New Customer</b></a>
          <a href=""><b>Sell Product</b></a>
          <a href=""><b>Stock Product</b></a>
        </center>
      </nav>
    </div>
    
    <div class="inventorydivemployee">
      <center>
        <table class="inventory">
          <tr>
            <th><b>Product Name</b></th>
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
    
    <div class="announcementsdiv">
      <center><h1 id="an">Announcements</h1></center>
      
      <?php echo $announcements; ?>
    </div>
  </main>

  <footer>

  </footer>
</body>
</html>

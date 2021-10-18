<?php
  require 'config/config.php';

  if(!isset($_SESSION['username'])){
    header('Location: login.php');
  }

  $notifications = array();

  if(isset($_POST['createNewCustomer'])){
    $customerName = mysqli_real_escape_string($connect, htmlspecialchars($_POST['customerName']));
    $customerPhoneNumber = mysqli_real_escape_string($connect, htmlspecialchars($_POST['customerPhoneNumber']));
    $customerAddress = mysqli_real_escape_string($connect, htmlspecialchars($_POST['customerAddress']));
    
    $query = mysqli_query($connect, "INSERT INTO customers VALUES ('', '$customerName', '$customerPhoneNumber')");
    $query2 = mysqli_query($connect, "INSERT INTO customer_address VALUES ('', '$customerName', '$customerAddress')");
    
    array_push($notifications, "Customer Created");
  }
?>

<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>Create New Customer</title>
  
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
          <h1 class="title">Create New Customer</h1>
          
          <form action="createNewCustomer.php" method="post" autocomplete="off">
            <input type="text" name="customerName" placeholder="Name" autocomplete="off" required>
            <input type="tel" name="customerPhoneNumber" placeholder="Phone Number: 123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" autocomplete="off" required>
            <input type="text" name="customerAddress" placeholder="Address" autocomplete="off" required>
            
            <br>
            
            <input type="submit" name="createNewCustomer" value="Create New Customer">
        
            <br>
            
            <?php 
              if(in_array("Customer Created", $notifications)) {
                echo "<p style='color: white'>Customer Created</p>";
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

<?php
  #configuration file used to connect to the database
  require 'config/config.php';

  #arrays to hold login errors so they can be displayed where we want them to errors1 is for manager errors and errors 2 is for employee errors
  $errors1 = array();
  $errors2 = array();

  #if the manager login button is pressed a query is ran to see if the credentials are in the database
  if(isset($_POST['managerLogin'])) {
    #username and password entered by the user
    $username = mysqli_real_escape_string($connect, htmlspecialchars($_POST['username']));
    $password = hash("sha3-512", mysqli_real_escape_string($connect, htmlspecialchars($_POST['password'])));
    
    #the query to the database that will return 1 if the user exists and 0 if they do not, mysqli_num_rows() is used to see how many results are renturned
    $query = mysqli_query($connect, "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 'manager'");
    $checkQuery = mysqli_num_rows($query);
    
    #if a result is returned redirect to the manager home page
    if($checkQuery == 1) {
      $_SESSION['username'] = $username;
      header("Location: managerHome.php");
    }
    
    #else add an error statement to the error array to be displayed later
    else {
      array_push($errors1, "Username or Password is incorrect");
    }
  }

  #if the employee login button is pressed a query is ran to see if the credentials are in the database
  if(isset($_POST['employeeLogin'])) {
    #username and password entered by the user
    $username = mysqli_real_escape_string($connect, htmlspecialchars($_POST['username']));
    $password = hash("sha3-512", mysqli_real_escape_string($connect, htmlspecialchars($_POST['password'])));
    
    #the query to the database that will return 1 if the user exists and 0 if they do not, mysqli_num_rows() is used to see how many results are renturned
    $query = mysqli_query($connect, "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 'employee'");
    $checkQuery = mysqli_num_rows($query);
    
    #if a result is returned redirect to the manager home page
    if($checkQuery == 1) {
      $_SESSION['username'] = $username;
      header("Location: employeeHome.php");
    }
    
    #else add an error statement to the error array to be displayed later
    else {
      array_push($errors2, "Username or Password is incorrect");
    }
  }
?>

<html lang="en-us">
<head>
  <meta charset="UTF-8">
  <title>Stockify Login</title>
  
  <link rel="stylesheet" type="text/css" href="css/loginStyle.css">
</head>

<body>
  <header>
	<center><h1 id="logo">Stockify</h1></center>
    <center><h2 id="logo2">An Inventory Control System</h2></center>
  </header>
	
  <main>
    <!-- div containing the manager login form-->
    <div class="login" id="mlogin">
      <center><h2 class="lheader">Manager Login</h2>
      
      <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        
        <br>
        
        <input type="password" name="password" placeholder="Password" required>
        
        <br>
        
        <input type="submit" name="managerLogin" value="Manager Login">
        
        <br>
        
        <?php 
          #if the error exists in the error array display it
          if(in_array("Username or Password is incorrect", $errors1)) {
            echo "<p style='color: white'>Username or Password is incorrect</p>";
          }
        ?>
        </form></center>
    </div>
    
    <!-- div containing the employee login form-->
    <div class="login" id="elogin">
      <center><h2 class="lheader">Employee Login</h2>
      
      <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        
        <br>
        
        <input type="password" name="password" placeholder="Password" required>
        
        <br>
        
        <input type="submit" name="employeeLogin" value="Employee Login">
        
        <br>
        
        <?php 
          #if the error exists in the error array display it
          if(in_array("Username or Password is incorrect", $errors2)) {
            echo "<p style='color: white'>Username or Password is incorrect</p>";
          }
        ?>
      </form></center>
    </div>
    
  </main>
	
  <footer>
	
  </footer>
</body>
</html>

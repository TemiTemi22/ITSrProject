<?php
  #configuration file used to connect to the database
  require 'config/config.php';

  #array to hold login errors so they can be displayed where we want them to
  $errors = array();

  #if the manager login is pressed a query is ran to see if the credentials are in the database
  if(isset($_POST['managerLogin'])) {
    #username and password entered by the user
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    #the query to the database that will return 1 if the user exists and 0 if they do not, mysqli_num_rows() is used to see how many results are renturned
    $query = mysqli_query($connect, "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 'manager'");
    $checkQuery = mysqli_num_rows($query);
    
    #if a result is returned redirect to the manager home page
    if($checkQuery == 1) {
      header("Location: managerHome.php");
    }
    
    #else add an error statement to the error array to be displayed later
    else {
      array_push($errors, "Username or Password is incorrect<br>");
    }
  }
?>

<html lang="en-us">
<head>
  <meta charset="UTF-8">
  <title>Stockify Login</title>
</head>

<body>
  <header>
	<center><h1>Stockify</h1></center>
  </header>
	
  <main>
    <!-- div containing the manager login form-->
    <div class="login">
      <h2>Manager Login</h2>
      
      <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        
        <br>
        
        <input type="password" name="password" placeholder="Password" required>
        
        <br>
        
        <input type="submit" name="managerLogin" value="Manager Login">
        
        <br>
        
        <?php 
          #if the error exists in the error array display it
          if(in_array("Username or Password is incorrect<br>", $errors)) {
            echo "Username or Password is incorrect<br>";
          }
        ?>
      </form>
    </div>
    
  </main>
	
  <footer>
	
  </footer>
</body>
</html>
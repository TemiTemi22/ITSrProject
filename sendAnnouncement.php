<?php
  require 'config/config.php';
    
  $notifications = array();

  if(isset($_POST['sendAnnouncement'])){
    $announcement = mysqli_real_escape_string($connect, htmlspecialchars($_POST['announcement']));
    
    $query = mysqli_query($connect, "INSERT INTO messages VALUES ('', '$announcement')");
    
    array_push($notifications, "Annoncement sent to employees");
  }
?>

<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>Send Announcement</title>
  
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
          <h1 class="title">Send Announcement</h1>
          
          <form action="sendAnnouncement.php" method="post">
            <input class="textarea" type="text" name="announcement" placeholder="Enter Announcement..." required>
            
            <br>
            
            <input type="submit" name="sendAnnouncement" value="Send Announcement">
        
            <br>
            
            <?php 
              if(in_array("Annoncement sent to employees", $notifications)) {
                echo "<p style='color: white'>Annoncement sent to employees</p>";
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
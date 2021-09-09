<?php
	#Configuration file for Stockify database 

	# Turn on output buffer for better loading
	ob_start();

	# Start session
	session_start();

	# Set timezone (EST)
	$timezone = date_default_timezone_set("America/New_York");

	# Initialize $connect variable for database connection
	$connect = mysqli_connect("localhost", "root", "", "stockifydb");

	# Error if it can not connect
	if(mysqli_connect_errno()) {
	  echo "Error could not connect: ", mysqli_connect_errno();
	}
?>

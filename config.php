<?php
	#Configuration file for Stockify database 

	# Major functions:
	# Connect to database, return error if unable to
	# Timezone and constructor variable creation
	# Session and output buffer start

	# Turn on output buffer for better loading
	ob_start();

	# Start service
	session_start();

	# Set timezone (EST)
	$timezone = date_default_timezone_set("America/New_York");

	# Initialize $connect constructor variable 
	$connect = mysqli_connect("localhost", "root", "", "stockifydb");

	# Error if it can not connect
	if(mysqli_connect_errno()) {
	  echo "Error could not connect: ", mysqli_connect_errno();
	}
?>
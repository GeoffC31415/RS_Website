<?php
	
	// Set database login details
	$servername = "localhost";
	$username = "root";
	$password = "RoquetteScience";
	$dbname = "RS_Logs";

	// Create connection

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
?>

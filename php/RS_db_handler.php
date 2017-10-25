<?php
	
	// Ensure connection is set up
	require "RS_db_connect.php";
	
	// Get all the connected sensors from the database and place in an array
    $sql = "SELECT SensorName FROM Sensors";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $sensornames = array();
        while($row = mysqli_fetch_assoc($result)) {
            array_push($sensornames, $row['SensorName']);
        }
    }
	
    mysqli_free_result($result);
    mysqli_close($conn);
	
?>
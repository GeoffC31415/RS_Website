<?php
	
	// Ensure connection is set up
	require "RS_db_connect.php";
	
	// Get all the connected sensors from the database and place in an array
    $sql = 	"SELECT SensorReadings.LogTime AS DT, Sensors.SensorName AS SenName, SensorReadings.Reading AS Reading
							FROM SensorReadings INNER JOIN Sensors ON SensorReadings.SensorID = Sensors.ID
						";
						
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $times = array();
        $sensornames = array();
        $data = array();
        
        while($row = mysqli_fetch_assoc($result)) {
            array_push($times, $row['DT']);
			array_push($sensornames, $row['SenName']);
			array_push($data, $row['Reading']);
        }
    }
	
    mysqli_free_result($result);
    mysqli_close($conn);
	
?>

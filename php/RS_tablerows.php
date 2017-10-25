<?php 

// CONNECT

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
	
	
// QUERY AND POPULATE ARRAYS
	
	// Get all the connected sensors from the database and place in an array
    $sql = 	"SELECT SensorReadings.LogTime AS DT, Sensors.SensorName AS SenName, SensorReadings.Reading AS Reading
				FROM SensorReadings INNER JOIN Sensors ON SensorReadings.SensorID = Sensors.ID
			";
			
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
		$times = array();
        $sensornames = array();
		$readings = array();
		
        while($row = mysqli_fetch_assoc($result)) {
			array_push($times, $row['DT']);
			array_push($sensornames, $row['SenName']);
			array_push($readings, $row['Reading']);
        }
    }
	
    mysqli_free_result($result);
    mysqli_close($conn);
	
	
// DISPLAY TABLE ROWS
	
	$readingnum = count($readings);
	
	for($x = 0; $x < $readingnum; $x++) {
		echo "<tr>"
		echo "<td>$times[$x]</td>"
		echo "<td>$sensornames[$x]</td>"
		echo "<td>$readings[$x]</td>"
		echo "</tr>"
	}

?>

<?php 

echo date('Y-m-d H:i:s');

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
	
	
// QUERY
	
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
	
	
// DISPLAY
	
	$sensorcount = count($sensornames);

	for($x = 0; $x < $sensorcount; $x++) {
		echo $sensornames[$x];
		echo "<br>";
	}

	phpinfo(); 

?>

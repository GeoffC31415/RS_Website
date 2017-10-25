<?php

function getTopReadings($sensorcount) {
					
	// Ensure connection is set up
	require "RS_db_connect.php";

	$sql = 	"SELECT SensorReadings.LogTime AS DateTime, Sensors.SensorName AS Sensor, SensorReadings.Reading AS Reading
						FROM SensorReadings INNER JOIN Sensors ON SensorReadings.SensorID = Sensors.ID
						ORDER BY SensorReadings.LogTime DESC LIMIT $sensorcount;
					";
	
	$result = mysqli_query($conn, $sql);
	echo_result_as_table($result);
	if ($result) mysqli_free_result($result);
	mysqli_close($conn);
	
	return 0;
}
	
function getSensorData($num_sensors) {

	// Ensure connection is set up
	require "RS_db_connect.php";

	for ($x=1; $x < $num_sensors+1; $x++) {

		// Get all the connected sensors from the database and place in an array
		$sql = 	"SELECT SensorReadings.LogTime AS DateTime, Sensors.SensorName AS Sensor, SensorReadings.Reading AS Reading
								FROM SensorReadings INNER JOIN Sensors ON SensorReadings.SensorID = Sensors.ID
								WHERE SensorID = $x
								ORDER BY SensorReadings.LogTime DESC LIMIT 100;
				";
							
		$result = mysqli_query($conn, $sql);
		echo_result_as_table($result);
		echo "\n\n";
		if ($result) mysqli_free_result($result);
		
	}
	
	mysqli_close($conn);
	
	return 0;
}

function table_cell($item, $header=false) {
    if (!$item) return '';
    $elemname = ($header) ? 'th' : 'td';
    $escitem = htmlspecialchars($item, ENT_NOQUOTES, 'UTF-8');
    return "<{$elemname}>{$escitem}</{$elemname}>";
}
function table_header_cell($item) {
    return table_cell($item, true);
}
function table_row($items, $header=false) {
    $func = ($header) ? 'table_header_cell' : 'table_cell';
    return "<tr>\n\t".implode("\n\t", array_map($func, $items))."\n</tr>\n";
}

function echo_result_as_table($result) {
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $columnnames = array_keys($row);
        echo "<table>\n", table_row($columnnames, true), "\n";
        do {
            echo table_row($row), "\n";
        } while ($row = mysqli_fetch_assoc($result));
        echo "</table>\n";
    }
}

?>

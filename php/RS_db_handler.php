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

function getGraphData($sensorID) {
	// Ensure connection is set up
	require "RS_db_connect.php";

	// Grab the select query
	$sql = 	"
			SELECT LogTime, Reading 
			FROM SensorReadings
			WHERE SensorID = $sensorID
			ORDER BY LogTime DESC 
			LIMIT 288;
			";
	
	$result = mysqli_query($conn, $sql);
	mysqli_close($conn);
	
	// Write the json column names and types
	$table = array();
	$table['cols'] = array(
							//Labels for the chart, these represent the column titles
							array('id' => '', 'label' => 'DateTime', 'type' => 'datetime'),
							array('id' => '', 'label' => 'Reading', 'type' => 'number')
	);
	
	//Populate the rows of the json
	$rows = array();
	
	foreach ($result as $row){
		
		$time = strtotime($row['LogTime']);
		$jsonDate = "Date(";
		$jsonDate .= date('Y', $time) . ", ";  			//Year
		$jsonDate .= date('n', $time) . ", ";			//Month
		$jsonDate .= date('j', $time) . ", ";			//Day
		$jsonDate .= date('G', $time) . ", ";			//Hours
		$jsonDate .= date('i', $time) . ", ";			//Minutes
		$jsonDate .= date('s', $time) . ", ";			//Seconds
		$jsonDate .= ")";
		
		$temp = array();
		$temp[] = array('v' => $jsonDate);
		$temp[] = array('v' => (float) $row['Reading']); 
		
		$rows[] = array('c' => $temp);
	}
	
	$result->free();
	
	$table['rows'] = $rows;
	
	$jsonTable = json_encode($table, true);
	return $jsonTable;
}
	
function getSensorData($num_sensors) {

	// Ensure connection is set up
	require "RS_db_connect.php";

	for ($x=1; $x < $num_sensors+1; $x++) {

		// Get all the connected sensors from the database and place in an array
		$sql = 	"
				SELECT 	SensorReadings.LogTime AS DateTime, 
						Sensors.SensorName AS Sensor, 
						SensorReadings.Reading AS Reading
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

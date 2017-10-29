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
	//$sql = 	"
	//		SELECT LogTime, Reading 
	//		FROM SensorReadings
	//		WHERE SensorID = $sensorID
	//		ORDER BY LogTime DESC 
	//		LIMIT 288;
	//		";
			
	// Now with built in SQL moving average hardcoded
	$sql =	"
			select LogTime, SensorID, Reading,
				case @i when SensorID then @i:=SensorID else (@i:=SensorID) and (@n:=0) and (@a0:=0) and (@a1:=0) and (@a2:=0) and (@a3:=0) and (@a4:=0) and (@a5:=0) and (@a6:=0) and (@a7:=0) and (@a8:=0) and (@a9:=0) and (@a10:=0) and (@a11:=0) end, 
				case @n when 12 then @n:=12 else @n:=@n+1 end, @a0:=@a1,@a1:=@a2,@a2:=@a3,@a3:=@a4,@a4:=@a5,@a5:=@a6,@a6:=@a7,@a7:=@a8,@a8:=@a9,@a9:=@a10,@a10:=@a11,@a11:=Reading, 
				(@a0+@a1+@a2+@a3+@a4+@a5+@a6+@a7+@a8+@a9+@a10+@a11)/@n as avg 
			from SensorReadings, 
				(select @i:=0, @n:=0, @a0:=0, @a1:=0, @a2:=0, @a3:=0, @a4:=0, @a5:=0, @a6:=0, @a7:=0, @a8:=0, @a9:=0, @a10:=0, @a11:=0) a 
			where SensorID = $sensorID
			order by SensorID, LogTime DESC LIMIT 288
			";
	
	$result = mysqli_query($conn, $sql);
	mysqli_close($conn);
	
	// Write the json column names and types
	$table = array();
	$table['cols'] = array(
							//Labels for the chart, these represent the column titles
							array('id' => '', 'label' => 'DateTime', 'type' => 'datetime'),
							array('id' => '', 'label' => 'Reading', 'type' => 'number'),
							array('id' => '', 'label' => 'Average', 'type' => 'number')
	);
	
	//Populate the rows of the json
	$rows = array();
	
	foreach ($result as $row){
		
		$time = strtotime($row['LogTime']);
		$jsonDate = "Date(";
		$jsonDate .= date('Y', $time) . ", ";  			//Year
		$jsonDate .= date('n', $time)-1 . ", ";			//Month
		$jsonDate .= date('j', $time) . ", ";			//Day
		$jsonDate .= date('G', $time) . ", ";			//Hours
		$jsonDate .= date('i', $time) . ", ";			//Minutes
		$jsonDate .= date('s', $time) . ", ";			//Seconds
		$jsonDate .= ")";
		
		$temp = array();
		$temp[] = array('v' => $jsonDate);
		$temp[] = array('v' => (float) $row['Reading']); 
		$temp[] = array('v' => (float) $row['avg']); 
		
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

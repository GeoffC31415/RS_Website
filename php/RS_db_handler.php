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
			
	// Now with built in SQL moving average hardcoded
	$sql =	"
			select LogTime, SensorID, Reading,
				case @i when SensorID then @i:=SensorID else (@i:=SensorID) and (@n:=0) and (@a0:=0) and (@a1:=0) and (@a2:=0) and (@a3:=0) and (@a4:=0) and (@a5:=0) and (@a6:=0) and (@a7:=0) and (@a8:=0) and (@a9:=0) and (@a10:=0) and (@a11:=0) end, 
				case @n when 12 then @n:=12 else @n:=@n+1 end, 
				@a0:=@a1,@a1:=@a2,@a2:=@a3,@a3:=@a4,@a4:=@a5,@a5:=@a6,@a6:=@a7,@a7:=@a8,@a8:=@a9,@a9:=@a10,@a10:=@a11,@a11:=Reading, 
				(@a0+@a1+@a2+@a3+@a4+@a5+@a6+@a7+@a8+@a9+@a10+@a11)/@n as avg 
			from SensorReadings, 
				(select @i:=0, @n:=0, @a0:=0, @a1:=0, @a2:=0, @a3:=0, @a4:=0, @a5:=0, @a6:=0, @a7:=0, @a8:=0, @a9:=0, @a10:=0, @a11:=0) a 
			where SensorID = $sensorID
			order by SensorID, LogTime DESC LIMIT 376
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
	
function getDHTData($type) {
	// Ensure connection is set up
	require "RS_db_connect.php";
		
	// Get temperature sensor data
	$sql = "SELECT ID, SensorName FROM Sensors WHERE SensorType = '$type'";
	$result = mysqli_query($conn, $sql);
	$sensorIDs = array();
	$sensorNames = array();
	foreach ($result as $row) {
		array_push($sensorIDs,$row['ID']);
		array_push($sensorNames,$row['SensorName']);
		
	};
	$result->free();
	if (count($sensorIDs) > 4) exit('sensorcounterror');
		
	// Write the json column names and types
	$table = array();
	$sensorcount = 4;
	$table['cols'] = array(
							//Labels for the chart, these represent the column titles
							array('id' => '', 'label' => 'DateTime', 'type' => 'datetime'),
							array('id' => '', 'label' => "{$sensorNames[0]}", 'type' => 'number'),
							array('id' => '', 'label' => "{$sensorNames[1]}", 'type' => 'number'),
							array('id' => '', 'label' => "{$sensorNames[2]}", 'type' => 'number'),
							array('id' => '', 'label' => "{$sensorNames[3]}", 'type' => 'number'),
							array('id' => '', 'label' => "Avg {$sensorNames[0]}", 'type' => 'number'),
							array('id' => '', 'label' => "Avg {$sensorNames[1]}", 'type' => 'number'),
							array('id' => '', 'label' => "Avg {$sensorNames[2]}", 'type' => 'number'),
							array('id' => '', 'label' => "Avg {$sensorNames[3]}", 'type' => 'number')
	);	
	
	//Loop through temp array writing the rows of the JSON
	$rows = array();
	foreach ($sensorIDs as $tempsensor) {
		$sql =	"
				SELECT LogTime, SensorID, Reading,
					case @i when SensorID then @i:=SensorID else (@i:=SensorID) and (@n:=0) and (@a0:=0) and (@a1:=0) and (@a2:=0) and (@a3:=0) and (@a4:=0) and (@a5:=0) and (@a6:=0) and (@a7:=0) and (@a8:=0) and (@a9:=0) and (@a10:=0) and (@a11:=0) end, 
					case @n when 12 then @n:=12 else @n:=@n+1 end, 
					@a0:=@a1,@a1:=@a2,@a2:=@a3,@a3:=@a4,@a4:=@a5,@a5:=@a6,@a6:=@a7,@a7:=@a8,@a8:=@a9,@a9:=@a10,@a10:=@a11,@a11:=Reading, 
					(@a0+@a1+@a2+@a3+@a4+@a5+@a6+@a7+@a8+@a9+@a10+@a11)/@n as avg 
				FROM SensorReadings, 
					(select @i:=0, @n:=0, @a0:=0, @a1:=0, @a2:=0, @a3:=0, @a4:=0, @a5:=0, @a6:=0, @a7:=0, @a8:=0, @a9:=0, @a10:=0, @a11:=0) a 
				WHERE SensorID = $tempsensor
				ORDER BY SensorID, LogTime DESC LIMIT 288
				";
		
		$result = mysqli_query($conn, $sql);
		
		// Get which column to write it in
		$num = array_search($tempsensor,$sensorIDs);
		
		//Populate the rows of the json
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
			
			// Record datetime of entry
			$temp = array();
			$temp[] = array('v' => $jsonDate);
			
			// Loop for first null block (start of temps)
			for ($i = 0; $i < $num; $i++) {
				$temp[] = array('v' => 'null'); 
			}
			
			// Write entry
			$temp[] = array('v' => (float) $row['Reading']); 
			
			// Loop for second null block (end of temps and start of avgs)
			for ($i = 0; $i < $sensorcount-1; $i++) {
				$temp[] = array('v' => 'null'); 
			}
			
			// Write average
			$temp[] = array('v' => (float) $row['avg']); 
			
			// Loop for end (end of avgs)
			for ($i = 0; $i < $sensorcount-$num-1; $i++) {
				$temp[] = array('v' => 'null'); 
			}

			$rows[] = array('c' => $temp);
		}
		
		$result->free();
	}
	
	mysqli_close($conn);
	
	$table['rows'] = $rows;
	
	$jsonTable = json_encode($table, true);
	return $jsonTable;
}
	
function getSensorDataTable($num_sensors) {

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
		echo_result_as_table($result, 'readings');
		echo "\n\n";
		if ($result) mysqli_free_result($result);
		
	}
	
	mysqli_close($conn);
	
	return 0;
}

function getNoteTopFive() {

	// Ensure connection is set up
	require "RS_db_connect.php";

	// Get all the connected sensors from the database and place in an array
	$sql = 	"
			SELECT 	Notes.LogTime AS DateTime, 
					Notes.Note AS Note, 
					Notes.Additive AS Additive,
					Notes.Amount AS Amount,
					Notes.Unit AS Unit
			FROM Notes
			ORDER BY Notes.LogTime DESC LIMIT 5;
			";
						
	$result = mysqli_query($conn, $sql);
	echo_result_as_table($result, 'notes');
	echo "\n\n";
	if ($result) mysqli_free_result($result);
	
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
function echo_result_as_table($result, $classname) {
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $columnnames = array_keys($row);
        echo "<table class=\"" . $classname . "\">\n", table_row($columnnames, true), "\n";
        do {
            echo table_row($row), "\n";
        } while ($row = mysqli_fetch_assoc($result));
        echo "</table>\n";
    }
}

?>

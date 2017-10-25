<!DOCTYPE html>
<html>
	<body>

		<table style="width:100%">
		  <tr>
			<th>Date Time</th>
			<th>Sensor</th> 
			<th>Reading</th>
		  </tr>

		  <?php 

			// QUERY AND POPULATE ARRAYS
				
				include "RS_Website/php/RS_db_handler.php";
				
			// DISPLAY TABLE ROWS
				
				$htmlstr = "";
				$readingnum = count($data);
				
				for($x = 0; $x < $readingnum; $x++) {
					$htmlstr .= "<tr>";
					$htmlstr .= "<td>$times[$x]</td>";
					$htmlstr .= "<td>$sensornames[$x]</td>";
					$htmlstr .= "<td>$data[$x]</td>";
					$htmlstr .= "</tr>";
				}
				
				echo $htmlstr;
				
		  ?>
		  
		</table>

	</body>
</html>

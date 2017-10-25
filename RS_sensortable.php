<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="RS_Website/mystyle.css">
</head>

<html>
	<body>
		<?php include "RS_Website/php/RS_db_handler.php"; ?>

		<h1> Current Readings </h1>
		<?php 
			getTopReadings(3);
		?>
		
		<h1> Historical Readings </h1>

		<?php
			getSensorData(3);
		?>
		  
		</table>

	</body>
</html>

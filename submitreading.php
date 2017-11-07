<?php
/*
 * submitreading.php
 * 
 * Copyright 2017  <pi@raspberrypi>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Submit DB</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.29" />
</head>

	<body>
		<?php
			
			// connect to database
			require "php/RS_db_connect.php";

			// Escape the input fields
			$ec = mysqli_real_escape_string($conn, $_POST['ec']);
			$datetime = mysqli_real_escape_string($conn, $_POST['logtime']);

			// prepare the query
			$sql = 	sprintf("INSERT INTO `SensorReadings` 
										(`ID`, 
										`LogTime`, 
										`SensorID`, 
										`Reading`) 
									VALUES 	
										(NULL, 
										'%s', 
										'10', 
										'%d')
							",
							$datetime,	
							$ec
							);

			// insert into database
			$query = $conn->query($sql) or die($conn->error);
			// view ID of last inserted row in the database
			echo ('Note and related info added to database');
			if ($result) mysqli_free_result($result);
			mysqli_close($conn);
			
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		?>
	</body>
</html>

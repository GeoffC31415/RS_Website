<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="RS_Website/newstyle.css">
</head>

<html>
	<title> X-Hydro Hydroponic Condition Monitoring </title>
	<body>
		<?php include "RS_Website/php/RS_db_handler.php"; ?>

		<h1> Current Picture </h1>
		<?php
			// outputs e.g.  somefile.txt was last modified: December 29 2002 22:16:23.

			$filename = "RS_Website/images/image_recent.jpg";
			if (file_exists($filename)) {
				echo "Image was last recorded: " . date ("F d Y H:i:s.", filemtime($filename));
			}
		?>
		<br>
		<img src="RS_Website/images/image_recent.jpg" alt="Current Snapshot">

		<iframe src="RS_Website/add_note.html" height="450" width="500" style="border:none;"></iframe>

		<h1 height=30px> Historical Graphs </h1>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
				
				var jsonData1 = $.ajax({
					url: "RS_Website/php/getJSON_Sensor1.php",
					dataType: "json",
					async: false
					}).responseText;
				var jsonData2 = $.ajax({
					url: "RS_Website/php/getJSON_Sensor2.php",
					dataType: "json",
					async: false
					}).responseText;
				var jsonData3 = $.ajax({
					url: "RS_Website/php/getJSON_Sensor3.php",
					dataType: "json",
					async: false
					}).responseText;
					
				// Create our data table out of JSON data loaded from server.
				var data1 = new google.visualization.DataTable(jsonData1);
				var data2 = new google.visualization.DataTable(jsonData2);
				var data3 = new google.visualization.DataTable(jsonData3);
				
				var options1 = {
					title: 'Humidity in the Tray',
					vAxis: {title: 'Percent Humidity'},
					legend: 'none',
					colors: ['black', '#ff3a25'],
					chartArea: { backgroundColor : '#f6f6f6' },
					series: {
								// series 0 is the data points
								0: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 }
								},
								// series 1 is the moving average
								1: {
									lineWidth: 3,
									pointSize: 0

								}
							}
				};
				var options2 = {
					title: 'Temperature in the Tray',
					vAxis: {title: 'Degrees Celsius'},
					legend: 'none',
					colors: ['black', '#ff3a25'],
					chartArea: { backgroundColor : '#f6f6f6' },
					series: {
								// series 0 is the data points
								0: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 }
								},
								// series 1 is the moving average
								1: {
									lineWidth: 3,
									pointSize: 0

								}
							}
				};
				var options3 = {
					title: 'Reservoir pH',
					vAxis: {title: 'pH'},
					legend: 'none',
					colors: ['black', '#ff3a25'],
					chartArea: { backgroundColor : '#f6f6f6' },
					series: {
								// series 0 is the data points
								0: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 }
								},
								// series 1 is the moving average
								1: {
									lineWidth: 3,
									pointSize: 0

								}
							}
				};

				var chart1 = new google.visualization.ScatterChart(document.getElementById('humidity_chart'));
				var chart2 = new google.visualization.ScatterChart(document.getElementById('temp_chart'));
				var chart3 = new google.visualization.ScatterChart(document.getElementById('ph_chart'));

				chart1.draw(data1, options1);
				chart2.draw(data2, options2);
				chart3.draw(data3, options3);
			}
		</script>
		<div id="humidity_chart" style="height: 440px"></div>
		<div id="temp_chart" style="height: 440px"></div>
		<div id="ph_chart" style="height: 440px"></div>
	</body>
</html>

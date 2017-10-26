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
					hAxis: {title: 'Time'},
					vAxis: {title: 'Percent Humidity'},
					legend: 'none'
				};
				var options2 = {
					title: 'Temperature in the Tray',
					hAxis: {title: 'Time'},
					vAxis: {title: 'Degrees Celsius'},
					legend: 'none'
				};
				var options3 = {
					title: 'Reservoir pH',
					hAxis: {title: 'Time'},
					vAxis: {title: 'pH'},
					legend: 'none'
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
